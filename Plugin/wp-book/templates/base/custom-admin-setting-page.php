<?php

/**
 * This file contain code for custom admin settings page.
 *
 * @link      
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 */

/**
 * This conatin code for calling settings api, setting-page and callback for adfding actual custom
 * admin setttings page.
 *
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 * @author     Vraj Rana vrcoder1998@gmail.com
 */

require_once WP_BOOK_PLUGIN_PATH . 'templates/api/settings-page.php';

require_once WP_BOOK_PLUGIN_PATH . 'templates/api/settings-api.php';

require_once WP_BOOK_PLUGIN_PATH . 'templates/callback/admin-setting-page.php';

class CustomAdminSettingPageController{

    /**
	 * Varriable for instantiate setting page
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Object   $setting_page  Object of SettingPage class.
	 */
    private $setting_page;

     /**
	 * Varriable for instantiate setting api
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Object   $setting_page  Object of SettingApi class.
	 */
    private $setting_api;

    /**
	 * Varriable for instantiate callback class.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Object   $setting_page  Object of AdminSettingPageCallback class.
	 */
    private $callback;

    /**
	 * Array for Register Settings.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $setting   array for register_settings() function
	 */
    private $setting = [];

    /**
	 * Array for Adding setting section.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $sections   array for add_settings_section() function
	 */
    private $section = [];

    /**
	 * Array for Adding settigs field.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $fields    array for add_settings_field() function
	 */
    private $field = [];

    /**
	 * Array for Add Menu Page.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $pages    array for add_menu_page() function
	 */
    private $page = [];

    /**
	 * Construct method
	 * Instantiate setting_api,setting_page,callback variables
	 */
    public function __construct(){
        
        $this->setting_api = new SettingApi();

        $this->setting_page = new SettingPage();

        $this->callback = new AdminSettingPageCallback();
    
    }

    /**
	 * Register Page through settings-page.
	 */
    public function register_page(){
        
        $this->set_page();

        $this->setting_page->add_page();
    }

    /**
	 * Register settings through settings-api.
	 */
    public function register_setting(){

        $this->set_setting();
        $this->set_section();
        $this->set_field();

        $this->setting_api->register_settings_api();
    }

    /**
	 * Inatantiate setting array.
	 */
    public function set_setting(){

        $this->setting = [
            [
                'option_group'      => 'wp_book_plugin_group',
                'option_name'       => 'wp_book_plugin_name',
                'sanitize_callback' => [$this->callback,'sanitize_callback']
            ],
        ];

        $this->setting_api->set_settings($this->setting);
    }

     /**
	 * Inatantiate section array.
	 */
    public function set_section(){
        $this->section = [
            [
                'id'        => 'wp_book_plugin_id',
                'title'     => 'Books Menu',
                'callback'  => [$this->callback, 'section_callback'],
                'page'      => 'books_menu'
            ],
        ];
        $this->setting_api->set_sections($this->section);
    }

     /**
	 * Inatantiate field array.
	 */
    public function set_field(){
        $this->field = [
            [
                'id' => 'currency',
                'title' => 'Currency',
                'callback' => [$this->callback, 'select_callback'],
                'page' => 'books_menu',
                'section' => 'wp_book_plugin_id',
                'args' => [
                    'option_name' => 'wp_book_plugin_name',
                    'label_for' => 'currency',
                    'type' => 'text',
                    'placeholder' => 'Dolor',
                    'options' => ['Rupess','Dolor','Franc','Euro','Pound']
                ]
            ],
            [
                'id' => 'post_per_page',
                'title' => 'Number of Books displayed per page',
                'callback' => [$this->callback, 'textfield_callback'],
                'page' => 'books_menu',
                'section' => 'wp_book_plugin_id',
                'args' => [
                    'option_name' => 'wp_book_plugin_name',
                    'label_for' => 'post_per_page',
                    'type'  => 'number',
                    'placeholder' => '5',
                ]
            ],
            [
                'id' => 'publish',
                'title' => 'Publish',
                'callback' => [$this->callback, 'checkbox_callback'],
                'page' => 'books_menu',
                'section' => 'wp_book_plugin_id',
                'args' => [
                    'option_name' => 'wp_book_plugin_name',
                    'label_for' => 'publish',
                ]
            ],
        ];
        $this->setting_api->set_fields($this->field);
    }

     /**
	 * Inatantiate pages array.
	 */
    public function set_page(){
        $this->page = [
            [
                'page_title' => 'Books Menu',
                'menu_title' => 'Books Menu',
                'capability' => 'manage_options',
                'menu_slug'  => 'books_menu',
                'callback'   =>  [$this->callback,'page_callback'],
                'icon_url'   => 'dashicons-book',
                'position'   => 110
            ],
        ];
        $this->setting_page->set_pages($this->page);
    }

}