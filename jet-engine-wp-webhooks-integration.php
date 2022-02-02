<?php
/**
 * Plugin Name: JetEngine - WP Webhooks integration
 * Plugin URI:
 * Description: Allow to send JetEngine specific data with WP Webhooks.
 * Version:     1.0.0
 * Author:      Crocoblock
 * Author URI:
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

define( 'JET_ENGINE_WPWH_VERSION', '1.0.0' );

define( 'JET_ENGINE_WPWH__FILE__', __FILE__ );
define( 'JET_ENGINE_WPWH_PLUGIN_BASE', plugin_basename( JET_ENGINE_WPWH__FILE__ ) );
define( 'JET_ENGINE_WPWH_PATH', plugin_dir_path( JET_ENGINE_WPWH__FILE__ ) );
define( 'JET_ENGINE_WPWH_URL', plugins_url( '/', JET_ENGINE_WPWH__FILE__ ) );

add_action( 'plugins_loaded', 'jet_engine_wpwh_init' );

function jet_engine_wpwh_init() {
	require JET_ENGINE_WPWH_PATH . 'includes/plugin.php';
}
