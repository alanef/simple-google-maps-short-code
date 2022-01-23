<?php

/*
 * creates the settings page for the plugin
*/

use AlanEFPluginDonation\PluginDonation;

class pw_map_settings {
	public function __construct() {

		if ( is_admin() ) {
			add_action( 'admin_menu', array(
				$this,
				'add_plugin_page'
			) );
		}
		$this->donation = new PluginDonation(
			'simple-google-maps-short-code',
			'settings_page_simple-google-maps-settings',
			'simple-google-maps-short-code/simple-google-map-short-code.php',
			admin_url( 'options-general.php?page=simple-google-maps-settings' ),
			'Simple Shortcode for Google Maps'
		);
	}

	public function add_plugin_page() {

		// This page will be under "Settings".
		add_options_page(
			esc_html__( 'Simple Google Maps Settings', 'simple-google-maps-short-code' ),
			esc_html__( 'Simple Google Maps', 'simple-google-maps-short-code' ),
			'manage_options',
			'simple-google-maps-settings',
			array(
				$this,
				'create_admin_page',
			)
		);
	}

	public function create_admin_page() {
		?>
        <h2><?php esc_html_e( 'Simple Google Maps Settings', 'simple-google-maps-short-code' ); ?></h2>
        <div style="float:left;padding:20px; max-width: 1200px;margin-right: 10%;" class="postbox">
            <table class="form-table">
                <tbody>
				<?php $this->donation->display(); ?>
                <tr>
                    <th>
						<?php esc_html_e( 'How to use', 'simple-google-maps-short-code' ); ?>
                    </th>
                    <td>
                        <p><?php esc_html_e( 'Maps are displayed with the [pw_map] shortcode:', 'simple-google-maps-short-code' ); ?></p>
                        <p>
                            <code><?php esc_html_e( '[pw_map address="New York City" key="YOUR API KEY"]', 'simple-google-maps-short-code' ); ?></code>
                        </p>
                        <p><?php
							esc_html_e( 'Google now requires that new accounts use an API key. You can register a free API key', 'simple-google-maps-short-code' );
							?> <a target="_blank" href="
                        https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key"
                            ><?php esc_html_e( 'Use this link to Google to get an API key', 'simple-google-maps-short-code' ); ?></a>
                        </p>
                        <p><?php esc_html_e( 'The plugin is Block Editor compatible, just use the shortcode block e.g. ', 'simple-google-maps-short-code' ); ?></p>
                        <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/shortcode-block.png'; ?>">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
		<?php
	}
}
