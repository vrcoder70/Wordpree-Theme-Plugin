<?php

/**
 * The file defines custom taxonomy.
 *
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 */

/**
 * This file define all the necessary code for defining custom hierarchical and non-hierarchical taxonomy.
 * 
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 * @author     Vraj Rana vrcoder1998@gmail.com
 */

class CustomTaxonomyController{

    /**
	 * Varriable for instantiate custom taxonomy.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array   $taxonomies  
	 */
    public $taxonomies = array();

    /**
     * Function callled from wp-loader class
     *
     * @return void
     */
    public function register(){
        $this->setTaxonomy();
        $this->customTaxonomy();
    }

    /**
     * Instantiate taxonomies array
     *
     * @return void
     */
    public function setTaxonomy(){

        $options = [
            [
                'singular_name'      => 'Book Category',
                'hierarchical'       => true,
                'show_ui'            => true,
                'show_admin_column'  => true,
                'query_var'          => true,
                'rewrite'            => ['slug' => 'book_category'],
                'post_types'         => ['book'],
                'show_in_rest'       => 'true'
            ],
            [
                'singular_name'      => 'Book Tag',
                'hierarchical'       => false,
                'show_ui'            => true,
                'show_admin_column'  => true,
                'query_var'          => true,
                'rewrite'            => ['slug' => 'book_tag'],
                'post_types'         => ['book'],
                'show_in_rest'       => 'true'
            ],
        ];

        foreach($options as $option){
    
            $labels = [
                'name'              => $option['singular_name'],
                'singular_name'     => $option['singular_name'],
                'search_items'      => 'Search ' . $option['singular_name'],
                'all_items'         => 'All ' . $option['singular_name'],
                'parent_item'       => 'Parent ' . $option['singular_name'],
                'parent_item_colon' => 'Parent ' . $option['singular_name'] . ':',
                'edit_item'         => 'Edit ' . $option['singular_name'],
                'update_item'       => 'Update ' . $option['singular_name'],
                'add_new_item'      => 'Add New ' . $option['singular_name'],
                'new_item_name'     => 'New ' . $option['singular_name'] . ' Name',
                'menu_name'         => $option['singular_name'],
            ];

            $this->taxonomies[] = [
                'hierarchical'      => $option['hierarchical'],
                'labels'            => $labels,
                'show_ui'           => $option['show_ui'],
                'show_admin_column' => $option['show_admin_column'],
                'query_var'         => $option['query_var'],
                'rewrite'           => $option['rewrite'],
                'post_types'        => $option['post_types'],
                'show_in_rest'      => $option['show_in_rest']
            ];
        }
    }

    /**
     * Register Taxonomy through wordpress function.
     *
     * @return void
     */
    public function customTaxonomy(){

        if( empty($this->taxonomies) ){
            return;
        }
        foreach($this->taxonomies as $taxonomy){
            $post_types = $taxonomy['post_types'];
            register_taxonomy( $taxonomy['rewrite']['slug'], $post_types, $taxonomy );
        }
    }

}