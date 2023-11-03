<?php

/**
 * The file defines custom post type.
 *
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 */

/**
 * This file define all the necessary code for defining custom post type,submenu page and short codes.
 * 
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 * @author     Vraj Rana vrcoder1998@gmail.com
 */

require_once WP_BOOK_PLUGIN_PATH . 'templates/api/settings-page.php';

require_once WP_BOOK_PLUGIN_PATH . 'templates/callback/cpt-callback.php';

class CustomPostTypeController{

	/**
	 * Varriable for instantiate setting page
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Object   $setting_page  Object of SettingPage class.
	 */
	private $setting_page;

	/**
	 * Varriable for instantiate callback class.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Object   $setting_page  Object of AdminSettingPageCallback class.
	 */
	private $callback;

	/**
	 * Varriable for instantiate custom post type array.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array   $custom_post_types  
	 */
    public $custom_post_types = array();

	/**
	 * Array for Add Submenu Page.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $pages    array for add_submenu_page() function
	 */
	private $subpage = array();

	/**
	 * Construct method
	 * Instantiate setting_page,callback variables and adding shortcodes.
	 */
	public function __construct(){

		$this->setting_page = new SettingPage();
		
		$this->callback = new CPTCallback();

		add_shortcode( 'book', [$this,'shortcode_book'] );
	}

	/**
	 * Short callback function shortcode_book
	 *
	 * @param array $attr
	 * @param String $content
	 * @param string $tag
	 * @return void
	 */
	public function shortcode_book( $attr, $content = null, $tag = '' ){
	
		$post_id = get_the_ID();
		$data = get_post_meta($post_id,'_book_details_key',true);

        $author        = isset($data['author']) ? $data['author'] : '';
        $publisher     = isset($data['publisher']) ? $data['publisher'] : '';
        $publish_year  = isset($data['publish_year']) ? $data['publish_year'] : '';

		$args = [
			'id' 		  => 'short-code',
			'author_name' => $author,
			'year' 		  => $publish_year,
			'category' 	  => 'Book Category',
			'tag' 		  => 'Book Tag',
			'publisher'   => $publisher,	
		];
		$attributes = shortcode_atts( $args, $attr );

		ob_start();
		?>
			<div id=<?php echo $attributes['id']; ?>>
				<!--<tabel>
					<?php 
						// foreach($attributes as $key => $value){
						// 	echo '<tr>';
						// 	echo '<td>'. $key .':' . $value .'</td>';
						// 	echo '</tr>';
						// }
					?>
				</tabel> -->
				<h5>Author       :<?php echo $attributes['author_name']?></h5>
				<h6>Publisher     :<?php echo $attributes['publisher']?></h6>
				<h6>Published Year:<?php echo $attributes['year']?></h6>
				<h6>Category      :<?php echo $attributes['category']?></h6>
				<h6>Tag           :<?php echo $attributes['tag']?></h6>
			</div>

		<?php return ob_get_clean();
	}

	/**
	 * Instantiate subpage array to hold list of subpages
	 *
	 * @return void
	 */
	public function set_subpage(){
		$this->subpage = [
			[
				'parent_slug' => 'edit.php?post_type=book',
				'page_title'  => 'Shortcodes',
				'menu_title'  => 'Shortcodes',
				'capability'  => 'manage_options',
				'menu_slug'   => 'short_codes',
				'callback' 	  => [$this->callback,'subpage_callback']
			],
		];
		$this->setting_page->set_subpages($this->subpage)->add_sub_page();
	}

	/**
	 * Register fuction which is being called by wp-loader file
	 *
	 * @return void
	 */
    public function register(){
        $this->setPostType();
        $this->customPostType();
    }

	/**
	 * Instantiate custom_post_type array
	 *
	 * @return void
	 */
    public function setPostType(){

        $this->custom_post_types = [
            [
                'post_type'             => 'book',
                'name'                  => 'Books',
                'singular_name'         => 'Book',
                'supports'              => array( 'title', 'editor', 'thumbnail' ),
                'show_in_rest'          => true,
                'taxonomies'            => array('category'),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => true,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'menu_icon'             => 'dashicons-book-alt',
            ],
        ];

    }

	/**
	 * Register post type through wordpress function
	 *
	 * @return void
	 */
    public function customPostType(){

		if (  empty( $this->custom_post_types ) ) {
            return;
        }

        foreach ($this->custom_post_types as $post_type) {
			register_post_type( $post_type['post_type'],
				array(
					'labels' => array(
						'name'                  => $post_type['name'],
						'singular_name'         => $post_type['singular_name'],
						'menu_name'             => $post_type['name'],
						'name_admin_bar'        => $post_type['singular_name'],
						'archives'              => $post_type['singular_name'] . ' Archives',
						'attributes'            => $post_type['singular_name'] . ' Attributes', 
						'parent_item_colon'     => 'Parent '. $post_type['singular_name'],
						'all_items'             => 'All ' . $post_type['name'],
						'add_new_item'          => 'Add new' . $post_type['singular_name'],
						'add_new'               => 'Add new',
						'new_item'              => 'New ' . $post_type['singular_name'],
						'edit_item'             => 'Edit ' . $post_type['singular_name'],
						'update_item'           => 'Update' . $post_type['singular_name'],
						'view_item'             => 'View' .$post_type['singular_name'],
						'view_items'            => 'View' . $post_type['name'],
						'search_items'          => 'Search' . $post_type['name'],
						'not_found'             => 'No' . $post_type['singular_name'] . ' Found',
						'not_found_in_trash'    => 'No' . $post_type['singular_name'] . ' Found in Trash',
						'featured_image'        => 'Featured Image',
						'set_featured_image'    => 'Set Featured Image',
						'remove_featured_image' => 'Remove Featured Image',
						'use_featured_image'    => 'Use Featured Image',
						'insert_into_item'      => 'Insert into' . $post_type['singular_name'],
						'uploaded_to_this_item' => 'Upload to this' . $post_type['singular_name'],
						'items_list'            => $post_type['name'] . ' List',
						'items_list_navigation' => $post_type['name'] . ' List Navigation',
						'filter_items_list'     => 'Filter' . $post_type['name'] . ' List'
					),
					'label'                     => $post_type['singular_name'],
					'description'               => $post_type['name'] . ' Custom Post Type',
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
				)
			);
		}

    }

}