<?php
/**
 * Fired when the plugin is deleted.
 *
 * The bundled opt-in library stores its status in an option and, since
 * library 1.3.0, leaves removing it to the host plugin. The plugin stores no
 * settings of its own; geocoding results are transients that expire.
 */

// Exit if not called by WordPress during uninstall.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

\Fullworks_Free_Plugin_Lib\Main::plugin_uninstall( 'SSFGM-Free' );
