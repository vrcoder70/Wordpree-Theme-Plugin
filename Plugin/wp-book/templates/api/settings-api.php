<?php

/**
 * The file defines Modular settings api
 *
 * @link       
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/api
 */

/**
 * This file define all the necessary code for using wordpress built in settings api.
 *
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/api
 * @author     Vraj Rana vrcoder1998@gmail.com
 */

class SettingApi{

    /**
	 * Array for Register Settings.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $settings    array for register_settings() function
	 */
    private $settings = array();

    /**
	 * Array for Adding setting section.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $sections   array for add_settings_section() function
	 */
    private $sections = array();

    /**
	 * Array for Adding settigs field.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $fields    array for add_settings_field() function
	 */
    private $fields = array();

    /**
	 * Instantiate settings array and return instance of this class
	 *
	 * @since    1.0.0
	 */
    public function set_settings(array $settings){

        $this->settings = $settings;
        return $this;
    
    }

    /**
	 * Instantiate sections array and return instance of this class
	 *
	 * @since    1.0.0
	 */
    public function set_sections(array $sections){

        $this->sections = $sections;
        return $this;
    
    }

    /**
	 * Instantiate fields array and return instance of this class
	 *
	 * @since    1.0.0
	 */
    public function set_fields(array $fields){

        $this->fields = $fields;
        return $this;
    
    }

    /**
	 * Using wordpress function register_setting(),add_settings_section() and add_settings_field()
	 * for using settings api
	 * @since    1.0.0
	 */
    public function register_settings_api(){

        if( !empty($this->settings)){
            foreach($this->settings as $setting){
                register_setting( $setting['option_group'], 
                                  $setting['option_name'], 
                                  (isset( $setting['sanitize_callback'] ) )? $setting['sanitize_callback'] : '' 
                );
            }
        }

        if( !empty($this->sections)){
            foreach($this->sections as $section){
                add_settings_section( $section['id'],
                                      $section['title'] , 
                                      (isset($section['callback'])) ? $section['callback'] : '',
                                      $section['page']
                );    
            }
        } 
        
        if( !empty($this->fields)){
            foreach($this->fields as $field){
                add_settings_field( $field['id'],
                                    $field['title'] ,
                                    isset($field['callback']) ? $field['callback'] : '',
                                    $field['page'], 
                                    $field['section'],
                                    isset($field['args'] ) ? $field['args'] : '',
                );
            }
        } 
    }

}