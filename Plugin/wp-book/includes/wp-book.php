<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/includes
 * @author     Vraj Rana vrcoder1998@gmail.com
 */
class WP_BOOK {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WP_BOOK_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $WP_BOOK    The string used to uniquely identify this plugin.
	 */
	protected $WP_BOOK;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WP_BOOK_VERSION' ) ) {
			$this->version = WP_BOOK_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->WP_BOOK = 'wp-book';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

		$this->define_post_type_hooks();
		$this->define_taxonomy_hooks();
		$this->define_metabox_hooks();
		$this->define_admin_setting_page_hooks();
		$this->define_widget_hooks();
		$this->define_dashboard_widget_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WP_BOOK_Loader. Orchestrates the hooks of the plugin.
	 * - WP_BOOK_i18n. Defines internationalization functionality.
	 * - WP_BOOK_Admin. Defines all hooks for the admin area.
	 * - WP_BOOK_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once WP_BOOK_PLUGIN_PATH . 'includes/wp-book-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once WP_BOOK_PLUGIN_PATH . 'includes/wp-book-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once WP_BOOK_PLUGIN_PATH . 'admin/wp-book-admin.php';

		/**
		 * The class responsible for defining all custom post types of wp-book plugin. 
		 */
		require_once WP_BOOK_PLUGIN_PATH . 'templates/base/custom-post-type.php';

		/**
		 * The class responsible for defining all custom hierarchical and non hierarchical
		 * taxonomies of wp-book plugin. 
		 */
		require_once WP_BOOK_PLUGIN_PATH . 'templates/base/custom-taxonomy.php';

		/**
		 * The class responsible for defining all custom meta boxes of wp-book plugin. 
		 */
		require_once WP_BOOK_PLUGIN_PATH . 'templates/base/custom-metabox.php';

		/**
		 * The class responsible for defining all custom admin setting pages of wp-book plugin. 
		 */
		require_once WP_BOOK_PLUGIN_PATH . 'templates/base/custom-admin-setting-page.php';

		/**
		 * The class responsible for defining all custom widgets of wp-book plugin. 
		 */
		require_once WP_BOOK_PLUGIN_PATH . 'templates/base/custom-widget.php';

		/**
		 * The class responsible for defining all custom dashboard widgets of wp-book plugin. 
		 */
		require_once WP_BOOK_PLUGIN_PATH . 'templates/base/dashboard-widget.php';

		if( ! class_exists('WP_BOOK_Loader') ){
			var_dump("Loader WP_BOOK_Loader class is not present");
			exit();
		}
		
		$this->loader = new WP_BOOK_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WP_BOOK_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		if( !class_exists('WP_BOOK_i18n') ){
			return;
		}

		$plugin_i18n = new WP_BOOK_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		if( !class_exists('WP_BOOK_Admin') ){
			return;
		}

		$plugin_admin = new WP_BOOK_Admin( $this->get_WP_BOOK(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the custom post types and subpages of custom post type 
	 * functionality of the wp-book plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_post_type_hooks(){

		if( !class_exists('CustomPostTypeController') ){
			return;
		}

		$post_type = new CustomPostTypeController();
		
		$this->loader->add_action('init', $post_type, 'register');
		$this->loader->add_action('admin_menu', $post_type, 'set_subpage');
	
	}

	/**
	 * Register all of the hooks related to the custom taxonomies functionality
	 * of the wp-book plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_taxonomy_hooks(){

		if( !class_exists('CustomTaxonomyController') ){
			return;
		}

		$taxonomy = new CustomTaxonomyController();

		$this->loader->add_action('init',$taxonomy,'register');
	
	}

	/**
	 * Register all of the hooks related to the custom metabox boxes functionality
	 * of the wp-book plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_metabox_hooks(){

		if( !class_exists('CustomMetaboxController') ){
			return;
		}

		$metabox = new CustomMetaboxController();

		$this->loader->add_action('add_meta_boxes',$metabox,'register');
		$this->loader->add_action('save_post',$metabox,'save_cutsom_meta_box');

	}

	/**
	 * Register all of the hooks related to the custom admin setting pages functionality
	 * of the wp-book plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_setting_page_hooks(){

		if( !class_exists('CustomAdminSettingPageController') ){
			return;
		}

		$page = new CustomAdminSettingPageController();
	
		$this->loader->add_action('admin_menu',$page,'register_page');
		$this->loader->add_action('admin_init',$page,'register_setting');
	
	}

	/**
	 * Register all of the hooks related to the custom widgets functionality
	 * of the wp-book plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_widget_hooks(){

		if( !class_exists('CustomWidget') ){
			return;
		}

		$widget = new CustomWidget();
	
		$this->loader->add_action('widgets_init',$widget,'register');
	
	}

	/**
	 * Register all of the hooks related to the custom dashboard widgets functionality
	 * of the wp-book plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_dashboard_widget_hooks(){

		if( !class_exists('DashboardWidget') ){
			return;
		}

		$widget = new DashboardWidget();
		
		$this->loader->add_action('wp_dashboard_setup',$widget,'register');
	
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_WP_BOOK() {
		return $this->WP_BOOK;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WP_BOOK_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
