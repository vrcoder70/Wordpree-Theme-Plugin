<?php

/**
 * The file defines admin settings page addition code
 *
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/api
 */

/**
 * This file define all the necessary code for using wordpress admin settings page, subpages and options subpages.
 *
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/api
 * @author     Vraj Rana vrcoder1998@gmail.com
 */


class SettingPage{

    /**
	 * Array for Add Menu Page.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $pages    array for add_menu_page() function
	 */
    private $pages = array();

    /**
	 * Array for Add Submenu Page.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $subpages    array for add_submenu_page() function
	 */
    private $subpages = array();

    /**
	 * Array for Add Option Page.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $optionpages    array for add_options_page() function
	 */
    private $optionpages = array();

    /**
	 * Instantiate $pages array and return instance of this class
	 *
	 * @since    1.0.0
	 */
    public function set_pages(array $pages){
        $this->pages = $pages;
        return $this;
    }

    /**
	 * Instantiate $subpages array and return instance of this class
	 *
	 * @since    1.0.0
	 */
    public function set_subpages(array $subpages){
        $this->subpages = array_merge($this->subpages, $subpages);
        return $this;
    }

    /**
	 * Instantiate $optionpages array and return instance of this class
	 *
	 * @since    1.0.0
	 */
    public function set_option_pages(array $optionpages){
        $this->optionpages = array_merge($this->optionpages, $optionpages);
        return $this;
    }

    /**
	 * Using wordpress function add_menu_page to add pages 
	 *
	 * @since    1.0.0
	 */
    public function add_page(){
        if(!empty($this->pages)){
            foreach($this->pages  as $page){
                add_menu_page( $page['page_title'],
                               $page['menu_title'], 
                               $page['capability'], 
                               $page['menu_slug'],
                               $page['callback'], 
                               $page['icon_url'], 
                               $page['position'] 
                );  
            }
        }
    }

    /**
	 * Using wordpress function add_submenu_page to add subpages 
	 *
	 * @since    1.0.0
	 */
    public function add_sub_page(){
        if(!empty($this->subpages)){
            foreach($this->subpages  as $subpage){
                add_submenu_page( $subpage['parent_slug'], 
                                  $subpage['page_title'], 
                                  $subpage['menu_title'],
                                  $subpage['capability'],
                                  $subpage['menu_slug'],
                                  $subpage['callback']
                );
            }
        }
    }

    /**
	 * Change the name of first subpage of admin settings page 
	 *
	 * @since    1.0.0
	 */
    
    public function with_subpage( string $title = null ) {
		if ( empty($this->pages) ) {
			return $this;
		}

		$admin_page = $this->pages[0];

		$subpage = array(
			array(
				'parent_slug' => $admin_page['menu_slug'], 
				'page_title' => $admin_page['page_title'], 
				'menu_title' => ($title) ? $title : $admin_page['menu_title'], 
				'capability' => $admin_page['capability'], 
				'menu_slug' => $admin_page['menu_slug'], 
				'callback' => $admin_page['callback']
			)
		);

		$this->subpages = $subpage;

		return $this;
	}

    /**
	 * Using wordpress function add_options_page to add optionpages 
	 *
	 * @since    1.0.0
	 */
    public function add_opt_page(){
        if(!empty($this->pages)){
            foreach($this->pages as $page){
                add_options_page( $page['page_title'],
                                  $page['menu_title'], 
                                  $page['capability'], 
                                  $page['menu_slug'],
                                  $page['callback'],
                );
            }
        }
    }

}