<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/includes
 * @author     Vraj Rana vrcoder1998@gmail.com
 */
class WP_BOOK_Deactivator {

	/**
	 * 
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
		flush_rewrite_rules();

	}

}
