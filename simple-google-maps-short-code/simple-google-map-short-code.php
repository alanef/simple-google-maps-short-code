<?php
/*
Plugin Name: Simple Shortcode for Google Maps
Plugin URI: https://wordpress.org/plugins/simple-google-maps-short-code/
Description: Adds a simple Google Maps shortcode to any post, page or widget.
Version: 1.7
Requires at least: 4.6
Requires PHP: 5.6
Author: Alan Fuller
Author URI: https://fullworks.net
Text Domain: simple-google-maps-short-code
License:           GPL-2.0+
License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
Domain Path: /languages
*/


if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pw-map-settings.php';

//create the settings page
$settings = new pw_map_settings();

/**
 * Loads the plugin textdomain
 *
 * @access      private
 * @return      void
 * @since       1.2
 */
function pw_map_textdomain() {

	// Set filter for plugin's languages directory
	$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$lang_dir = apply_filters( 'pw_map_languages_directory', $lang_dir );

	// Load the translations
	load_plugin_textdomain( 'simple-google-maps-short-code', false, $lang_dir );
}

add_action( 'init', 'pw_map_textdomain' );


/**
 * Displays the map
 *
 * @access      private
 * @return      string
 * @since       1.0
 */
function pw_map_shortcode( $atts ) {

	$atts = shortcode_atts(
		array(
			'address'           => false,
			'width'             => '100%',
			'height'            => '400px',
			'enablescrollwheel' => 'true',
			'zoom'              => 15,
			'disablecontrols'   => 'false',
			'key'               => '',
            'geokey'            => '',
			'force'             => 'false',
			'zoomcontrol'       => 'true',
			'nozoom'            => 'false',
			'gesturehandling'   => 'auto',  // auto, greedy,cooperative, none
			'maptypeid'         => 'roadmap',  // roadmap, satellite, hybrid, terrain
		),
		$atts
	);

    if (empty($atts['key'])) {
        $atts['key'] = $atts['geokey'];
    }

	if ( 'true' === $atts['force'] ) {
		$force = true;
	} else {
		$force = false;
	}


	$atts = apply_filters( 'sgmsc_atts', $atts );


	$address_array = explode( ';', $atts['address'] );
// remove special characters
	$address_array = array_map( function ( $string ) {
		return preg_replace( "/[^A-Za-z0-9,\- ]/", '', $string );
	}, $address_array );


	if ( $address_array[0] ) {
		$coordinates_array = array();
		for ( $i = 0; $i < count( $address_array ); $i ++ ) {
			$coordinates_array[ $i ] = pw_map_get_coordinates( $address_array[ $i ], $force, sanitize_text_field( $atts['geokey'] ) );
			if ( ! is_array( $coordinates_array[ $i ] ) ) {
				$response = '';
				if ( current_user_can( 'manage_options' ) ) {
					$response .= '<div style="background: white;color:red;font-weight:bold; padding: 2rem;"><p style="color:#777;font-weight:normal">';
					$response .= esc_html__( 'This notice from Simple Google Maps Shortcode plugin is only shown to admins!', 'simple-google-maps-short-code' );
					$response .= '</p><p>';
					$response .= esc_html( $coordinates_array[ $i ] );
					$response .= '</p></div>';
				}

				return $response;
			}
		}


		$map_id = uniqid( 'pw_map_' ); // generate a unique ID for this map

		$map_options = array(
			'zoom'             => $atts['zoom'],
			'scrollwheel'      => ( 'true' === strtolower( $atts['enablescrollwheel'] ) ) ? '1' : '0',
			'disableDefaultUI' => ( 'true' === strtolower( $atts['disablecontrols'] ) ) ? '1' : '0',
			'zoomControl'      => ( 'true' === strtolower( $atts['zoomcontrol'] ) ) ? '1' : '0',
			'mapTypeId'        => strtolower( $atts['maptypeid'] ),
			'gestureHandling'  => strtolower( $atts['gesturehandling'] ),
		);
		if ( 'true' === strtolower( $atts['nozoom'] ) ) {
			$map_options['minZoom'] = $atts['zoom'];
			$map_options['maxZoom'] = $atts['zoom'];
		}
        ob_start(); ?>

        <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo esc_attr( $atts['key'] ); ?>"
                type="text/javascript"></script>
        <div class="pw_map_canvas" id="<?php echo esc_attr( $map_id ); ?>"
             style="height: <?php echo esc_attr( $atts['height'] ); ?>; width: <?php echo esc_attr( $atts['width'] ); ?>"></div>
        <script type="text/javascript">
            var map_<?php echo esc_attr( $map_id ); ?>;

            function pw_run_map_<?php echo esc_attr( $map_id ); ?>() {
                var center = new google.maps.LatLng("<?php echo esc_html( $coordinates_array[0]['lat'] ); ?>", "<?php echo esc_html( $coordinates_array[0]['lng'] ); ?>");
                var map_options = <?php echo wp_json_encode( apply_filters( 'sgmsc_map_options', $map_options ), JSON_NUMERIC_CHECK|JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS );?>;
                map_options['center'] = center;
                console.log(map_options)
                map_<?php echo esc_attr( $map_id ); ?> = new google.maps.Map(document.getElementById("<?php echo esc_attr( $map_id ); ?>"), map_options);
				<?php for ( $i = 0; $i < count( $address_array ); $i ++ ) {
				if ( ! is_array( $coordinates_array[ $i ] ) ) {
					continue;
				} ?>
                var location_<?php echo (int) $i; ?> = new google.maps.LatLng("<?php echo esc_html( $coordinates_array[ $i ]['lat'] ); ?>", "<?php echo esc_html( $coordinates_array[ $i ]['lng'] ); ?>");
                var marker_<?php echo (int) $i; ?> = new google.maps.Marker({
                    position: location_<?php echo (int) $i; ?>,
                    map: map_<?php echo esc_attr( $map_id ); ?>
                });
				<?php } ?>
            }

            pw_run_map_<?php echo esc_attr( $map_id ); ?>();
        </script>
		<?php
		return ob_get_clean();
	} else {
		$response = '';
		if ( current_user_can( 'manage_options' ) ) {
			$response .= '<div style="background: white;color:red;font-weight:bold; padding: 2rem;"><p style="color:#777;font-weight:normal">';
			$response .= esc_html__( 'This notice from Simple Google Maps Shortcode plugin is only shown to admins!', 'simple-google-maps-short-code' );
			$response .= '</p><p>';
			$response .= esc_html__( 'You do not seem to have provided any addresses!', 'simple-google-maps-short-code' );
			$response .= '</p></div>';
		}

		return $response;
	}
}

add_shortcode( 'pw_map', 'pw_map_shortcode' );

/**
 * Retrieve coordinates for an address
 *
 * Coordinates are cached using transients and a hash of the address
 *
 * @access      private
 * @return      mixed
 * @since       1.0
 */
function pw_map_get_coordinates( $address, $force_refresh = false, $api_key = '' ) {

	$address_hash = md5( $address );

	$coordinates = get_transient( $address_hash );

	if ( $force_refresh || $coordinates === false ) {

		$args     = apply_filters( 'pw_map_query_args', array(
			'key'     => $api_key,
			'address' => urlencode( $address )
		) );
		$url      = add_query_arg( $args, 'https://maps.googleapis.com/maps/api/geocode/json' );
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			return esc_html__( 'Google maps not accessible.', 'simple-google-maps-short-code' );
		}

		$data = wp_remote_retrieve_body( $response );

		if ( is_wp_error( $data ) ) {
			return esc_html__( 'Google returned bad data.', 'simple-google-maps-short-code' );;
		}

		if ( $response['response']['code'] == 200 ) {

			$data = json_decode( $data );

			if ( $data->status === 'OK' ) {

				$coordinates = $data->results[0]->geometry->location;

				$cache_value['lat']     = $coordinates->lat;
				$cache_value['lng']     = $coordinates->lng;
				$cache_value['address'] = (string) $data->results[0]->formatted_address;

				// cache coordinates for 3 months
				set_transient( $address_hash, $cache_value, 3600 * 24 * 30 * 3 );
				$data = $cache_value;

			} elseif ( $data->status === 'ZERO_RESULTS' ) {
				return esc_html__( 'No location found for the entered address:', 'simple-google-maps-short-code' ) . ' ' . $address;
			} elseif ( $data->status === 'INVALID_REQUEST' ) {
				return esc_html__( 'Invalid request. Did you enter an address?', 'simple-google-maps-short-code' ) . ' ' . $address . ' ' . esc_html__( 'Google Msg:', 'simple-google-maps-short-code' ) . ' ' . $data->error_message;
			} else {
				return esc_html__( 'Something went wrong while retrieving your map, please ensure you have entered the short code correctly. Address:', 'simple-google-maps-short-code' ) . ' ' . $address
				       . ' ' . esc_html__( 'Status:', 'simple-google-maps-short-code' ) . ' ' . $data->status . ' ' . esc_html__( 'Google Msg:', 'simple-google-maps-short-code' ) . ' ' . $data->error_message;
			}

		} else {
			return esc_html__( 'Unable to contact Google API service.', 'simple-google-maps-short-code' );
		}

	} else {
		// return cached results
		$data = $coordinates;
	}

	return $data;
}


/**
 * Fixes a problem with responsive themes
 *
 * @access      private
 * @return      void
 * @since       1.0.1
 */

function pw_map_css() {
	echo '<style type="text/css">/* =Responsive Map fix
-------------------------------------------------------------- */
.pw_map_canvas img {
	max-width: none;
}</style>';

}

add_action( 'wp_head', 'pw_map_css' );

function pw_map_set_strings( $strings ) {
	$strings = array(
		esc_html__( 'Gift a Donation', 'simple-google-maps-short-code' ),
		// 0
		esc_html__( 'Hi, I\'m Alan and I maintain this free plugin, and I hope it solves your problems.', 'simple-google-maps-short-code' ),
		// 1
		esc_html__( 'It would really help me know that others find it useful and a great way of doing this is to gift me a small donation', 'simple-google-maps-short-code' ),
		// 2
		esc_html__( 'Gift a donation: select your desired option', 'simple-google-maps-short-code' ),
		// 3
		esc_html__( 'My Bitcoin donation wallet', 'simple-google-maps-short-code' ),
		// 4
		esc_html__( 'Gift a donation via PayPal', 'simple-google-maps-short-code' ),
		// 5
		esc_html__( 'My Bitcoin Cash address', 'simple-google-maps-short-code' ),
		// 6
		esc_html__( 'My Ethereum address', 'simple-google-maps-short-code' ),
		// 7
		esc_html__( 'My Dogecoin address', 'simple-google-maps-short-code' ),
		// 8
		esc_html__( 'Contribute', 'simple-google-maps-short-code' ),
		// 9
		esc_html__( 'Contribute to the Open Source Project in other ways', 'simple-google-maps-short-code' ),
		// 10
		esc_html__( 'Submit a review', 'simple-google-maps-short-code' ),
		// 11
		esc_html__( 'Translate to your language', 'simple-google-maps-short-code' ),
		// 12
		esc_html__( 'SUBMIT A REVIEW', 'simple-google-maps-short-code' ),
		// 13
		esc_html__( 'If you are happy with the plugin then we would love a review. Even if you are not so happy feedback is always useful, but if you have issues we would love you to make a support request first so we can try and help.', 'simple-google-maps-short-code' ),
		// 14
		esc_html__( 'SUPPORT FORUM', 'simple-google-maps-short-code' ),
		// 15
		esc_html__( 'Providing some translations for a plugin is very easy and can be done via the WordPress system. You can easily contribute to the community and you don\'t need to translate it all.', 'simple-google-maps-short-code' ),
		// 16
		esc_html__( 'TRANSLATE INTO YOUR LANGUAGE', 'simple-google-maps-short-code' ),
		// 17
		esc_html__( 'As an open source project you are welcome to contribute to the development of the software if you can. The development plugin is hosted on GitHub.', 'simple-google-maps-short-code' ),
		// 18
		esc_html__( 'CONTRIBUTE ON GITHUB', 'simple-google-maps-short-code' ),
		// 19
		esc_html__( 'Get Support', 'simple-google-maps-short-code' ),
		// 20
		esc_html__( 'WordPress SUPPORT FORUM', 'simple-google-maps-short-code' ),
		// 21
		esc_html__( 'Hi I\'m Alan and I support the free plugin', 'simple-google-maps-short-code' ),
		// 22
		esc_html__( 'for you.  You have been using the plugin for a while now and WordPress has probably been through several updates by now. So I\'m asking if you can help keep this plugin free, by donating a very small amount of cash. If you can that would be a fantastic help to keeping this plugin updated.', 'simple-google-maps-short-code' ),
		// 23
		esc_html__( 'Donate via this page', 'simple-google-maps-short-code' ),
		// 24
		esc_html__( 'Remind me later', 'simple-google-maps-short-code' ),
		// 25
		esc_html__( 'I have already donated', 'simple-google-maps-short-code' ),
		// 26
		esc_html__( 'I don\'t want to donate, dismiss this notice permanently', 'simple-google-maps-short-code' ),
		// 27
		esc_html__( 'Hi I\'m Alan and you have been using this plugin', 'simple-google-maps-short-code' ),
		// 28
		esc_html__( 'for a while - that is awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help spread the word and boost my motivation..', 'simple-google-maps-short-code' ),
		// 29
		esc_html__( 'OK, you deserve it', 'simple-google-maps-short-code' ),
		// 30
		esc_html__( 'Maybe later', 'simple-google-maps-short-code' ),
		// 31
		esc_html__( 'Already done', 'simple-google-maps-short-code' ),
		// 32
		esc_html__( 'No thanks, dismiss this request', 'simple-google-maps-short-code' ),
		// 33
		esc_html__( 'Donate to Support', 'simple-google-maps-short-code' ),
		// 34
		esc_html__( 'Settings', 'simple-google-maps-short-code' ),
		// 35
		esc_html__( 'Help Develop', 'simple-google-maps-short-code' ),
		// 36
		esc_html__( 'Buy Me a Coffee makes supporting fun and easy. In just a couple of taps, you can donate (buy me a coffee) and leave a message. You don’t even have to create an account!', 'simple-google-maps-short-code' ),
		// 37
	);

	return $strings;
}

add_filter( 'plugindonation_lib_strings_simple-google-maps-short-code', 'pw_map_set_strings' );


