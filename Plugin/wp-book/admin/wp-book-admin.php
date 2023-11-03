<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/admin
 * @author     Vraj Rana vrcoder1998@gmail.com
 */
class WP_BOOK_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $WP_BOOK    The ID of this plugin.
	 */
	private $WP_BOOK;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $WP_BOOK       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $WP_BOOK, $version ) {

		$this->WP_BOOK = $WP_BOOK;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->WP_BOOK, WP_BOOK_PLUGIN_URL . 'admin/css/wp-book-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->WP_BOOK, WP_BOOK_PLUGIN_URL . 'admin/js/wp-book-admin.js', array( 'jquery' ), $this->version, false );

	}

}
