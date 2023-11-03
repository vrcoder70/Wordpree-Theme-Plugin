<?php

/**
 * This file define all the necessary code for defining custom post type,submenu page and short codes.
 * php version 7.4.10
 * 
 * @category Custom_Post_Type
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

namespace SUNSET_THEME\Inc;

use SUNSET_THEME\Inc\Traits\Singleton;
/**
 * Trait-Signleton For instantiate any class only once.
 * 
 * @category Custom_Post_Type
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com
 */
class Post_Type
{
    use Singleton;
    /**
     * Varriable for instantiate custom post type array.
     *
     * @since  1.0.0
     * @access private
     * @var    array   $custom_post_types :- It is for Storing custom post type array. 
     */
    public $custom_post_types = array();

    /**
     * Constructor of SUNSET_THEME
     * 
     * @return null
     */
    protected function __construct() 
    {
        
        $this->setPosttype();
        $this->setupHooks();
    }

    /**
     * Used for after_setuo_theme hook for enabling some features.
     * 
     * @return null
     */
    protected function setupHooks() 
    {

        /**
         * Actions.
         */
        add_action('init', [ $this, 'customPostType' ]);


        if ($this->isContactFormActivated()) {
            add_filter('manage_sunset-contact_posts_columns', [ $this, 'sunsetSetContactColumns']);
            add_action('manage_sunset-contact_posts_custom_column', [ $this, 'sunsetContactCustomColumns'], 10, 2);
        }
    }

    /**
     * Assign Custm Columns data.
     * 
     * @param $column  It is default column list of WordPress.
     * @param $post_id It is post id.
     * 
     * @return $newColumns
     */ 
    public function sunsetContactCustomColumns($column, $post_id)
    {
        switch ($column) {
        case 'message' :
            echo get_the_excerpt();
            break;
        case 'email' :
            $email = get_post_meta($post_id, '_email_key', true);
            echo '<a href="mailto:'.$email .'">'.$email.'</a>';
            break;
        }
    }

    /**
     * Edit Column Visiblity.
     * 
     * @param $columns It is default column list of WordPress.
     * 
     * @return $newColumns
     */ 
    public function sunsetSetContactColumns($columns)
    {
        $newColumns = [];
        $newColumns['title'] = 'Full Name';
        $newColumns['message'] = 'Message';
        $newColumns['email'] = 'Email';
        $newColumns['date'] = 'Date';
        return $newColumns;
    }


    /**
     * Check is Contact form activated.
     * 
     * @return boolean
     */ 
    public function isContactFormActivated()
    {
        $contact = get_option('activate_contact_form');
        if (@$contact == 1) { 
            return true;
        }
        return false;
    }

    /**
     * Instantiate custom_post_type array
     *
     * @return void
     */
    public function setPosttype()
    {        
        $this->custom_post_types = [
            [
                'post_type'             => 'portfolio',
                'name'                  => 'PortFolio',
                'singular_name'         => 'PortFolio',
                'supports'              => ['title', 'editor', 'author', 'thumbnail'],
                'show_in_rest'          => true,
                'taxonomies'            => [],
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 6,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => true,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'menu_icon'             => 'dashicons-universal-access-alt',
            ],
        ];

        if ($this->isContactFormActivated()) {
            $message = [
                'post_type'             => 'sunset-contact',
                'name'                  => 'Messages',
                'singular_name'         => 'Message',
                'supports'              => ['title','editor','author'],
                'show_in_rest'          => true,
                'taxonomies'            => [],
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 26,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => true,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'menu_icon'             => 'dashicons-email-alt',
            ]; 
            $this->custom_post_types[] = $message;
        } 
    }

    /**
     * Register post type through wordpress function
     *
     * @return void
     */
    public function customPostType()
    {

        if (empty($this->custom_post_types)) {
            return;
        }

        foreach ($this->custom_post_types as $post_type) {
            register_post_type(
                $post_type['post_type'],
                [
                    'labels' => [
                    'name'                  => __($post_type['name'], 'vrcoder'),
                    'singular_name'         => __($post_type['singular_name'], 'vrcoder'),
                    'menu_name'             => __($post_type['name'], 'vrcoder'),
                    'name_admin_bar'        => __($post_type['singular_name'], 'vrcoder'),
                    'archives'              => __($post_type['singular_name'] . ' Archives', 'vrcoder'),
                    'attributes'            => __($post_type['singular_name'] . ' Attributes', 'vrcoder'), 
                    'parent_item_colon'     => __('Parent ' . $post_type['singular_name'], 'vrcoder'),
                    'all_items'             => __('All ' . $post_type['name'], 'vrcoder'),
                    'add_new_item'          => __('Add new ' . $post_type['singular_name'], 'vrcoder'),
                    'add_new'               => __('Add new', 'vrcoder'),
                    'new_item'              => __('New ' . $post_type['singular_name'], 'vrcoder'),
                    'edit_item'             => __('Edit ' . $post_type['singular_name'], 'vrcoder'),
                    'update_item'           => __('Update' . $post_type['singular_name'], 'vrcoder'),
                    'view_item'             => __('View' . $post_type['singular_name'], 'vrcoder'),
                    'view_items'            => __('View' . $post_type['name'], 'vrcoder'),
                    'search_items'          => __('Search' . $post_type['name'], 'vrcoder'),
                    'not_found'             => __('No' . $post_type['singular_name'] . ' Found', 'vrcoder'),
                    'not_found_in_trash'    => __('No' . $post_type['singular_name'] . ' Found in Trash', 'vrcoder'),
                    'featured_image'        => __('Featured Image', 'vrcoder'),
                    'set_featured_image'    => __('Set Featured Image', 'vrcoder'),
                    'remove_featured_image' => __('Remove Featured Image', 'vrcoder'),
                    'use_featured_image'    => __('Use Featured Image', 'vrcoder'),
                    'insert_into_item'      => __('Insert into' . $post_type['singular_name'], 'vrcoder'),
                    'uploaded_to_this_item' => __('Upload to this' . $post_type['singular_name'], 'vrcoder'),
                    'items_list'            => __($post_type['name'] . ' List', 'vrcoder'),
                    'items_list_navigation' => __($post_type['name'] . ' List Navigation', 'vrcoder'),
                    'filter_items_list'     => __('Filter' . $post_type['name'] . ' List', 'vrcoder'),
                    ],
                    'label'                     => __($post_type['singular_name'], 'vrcoder'),
                    'description'               => __($post_type['name'] . ' Custom Post Type', 'vrcoder'),
                    'supports'                  => $post_type['supports'],
                    'show_in_rest'              => $post_type['show_in_rest'],
                    'taxonomies'                => $post_type['taxonomies'],
                    'hierarchical'              => $post_type['hierarchical'],
                    'public'                    => $post_type['public'],
                    'show_ui'                   => $post_type['show_ui'],
                    'show_in_menu'              => $post_type['show_in_menu'],
                    'menu_position'             => $post_type['menu_position'],
                    'show_in_admin_bar'         => $post_type['show_in_admin_bar'],
                    'show_in_nav_menus'         => $post_type['show_in_nav_menus'],
                    'can_export'                => $post_type['can_export'],
                    'has_archive'               => $post_type['has_archive'],
                    'exclude_from_search'       => $post_type['exclude_from_search'],
                    'publicly_queryable'        => $post_type['publicly_queryable'],
                    'capability_type'           => $post_type['capability_type'],
                    'menu_icon'                 => $post_type['menu_icon']
                ]
            );
        }

    }

}
