<?php
/**
 *
 *
 * @package           wp-book
 *
 * @wordpress-plugin
 * Plugin Name:       WP Book 
 * Plugin URI:        
 * Description:       RT Camp plugin Assignment.
 * Version:           1.0.0
 * Author:            Vraj Rana
 * Author URI:        
 * License:           
 * License URI:       
 * Text Domain:       wp-book
 * Domain Path:       
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
//Define Constants
define('WP_BOOK_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

define('WP_BOOK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define('WP_BOOK_PLUGIN', plugin_basename( __FILE__ ) );

/**
 * Currently plugin version.
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_BOOK_VERSION', '1.0.0' );

//The code that runs during plugin activation.
function activate_WP_BOOK() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/wp-book-activator.php';
	if( class_exists( 'WP_BOOK_Activator' ) ){
		WP_BOOK_Activator::activate();
	}
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_WP_BOOK() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/wp-book-deactivator.php';
	if( class_exists( 'WP_BOOK_Deactivator' ) ){
		WP_BOOK_Deactivator::deactivate();
	}
}

register_activation_hook( __FILE__, 'activate_WP_BOOK' );
register_deactivation_hook( __FILE__, 'deactivate_WP_BOOK' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/wp-book.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_WP_BOOK() {

	if( class_exists( 'WP_BOOK' ) ){
		$plugin = new WP_BOOK();
		$plugin->run();
	}

}
run_WP_BOOK();


