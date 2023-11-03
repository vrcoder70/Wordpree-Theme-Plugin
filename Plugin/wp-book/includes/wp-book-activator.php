<?php
/**
 * Fired during plugin activation
 *
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/includes
 * @author     Vraj Rana vrcoder1998@gmail.com
 */
class WP_BOOK_Activator {

	/**
	 * 
	 * Update wp_options when it's empty.
	 * @since    1.0.0
	 */
	public static function activate(){

		flush_rewrite_rules();
		
		$default = array();
		
		if( ! get_option( 'wp_book_plugin_name' ) ){
			
			update_option( 'wp_book_plugin_name', $default );
		
		}

	}

}
