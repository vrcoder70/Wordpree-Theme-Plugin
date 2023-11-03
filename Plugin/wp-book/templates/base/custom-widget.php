<?php

/**
 * Custom widget
 *
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 */

/**
 * This file define all the necessary code for adding custom widget.
 * 
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 * @author     Vraj Rana vrcoder1998@gmail.com
 */

class CustomWidget extends WP_Widget{

    /**
	 * The ID of widget
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $widget_Id   Unique Id of widget.
	 */
    public $widget_Id;
    
    /**
	 * The Name of widget
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $widget_name  Name of widget.
	 */
    public $widget_name;

    /**
	 * The Options of widget
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $widget_options  Options of widget.
	 */
    public $widget_options;

    /**
	 * The controlls of widget
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $control_options  controlls of widget.
	 */
    public $control_options;

    /**
     * Constructor for instantiate ID,name,options and controls of Widget.
     */
    public function __construct(){
        $this->widget_Id = 'select_category';
        $this->widget_name = 'Select Category';
        $this->widget_options = [
            'classname' => $this->widget_Id,
            'description' => $this->widget_name,
            'customize_selective_refresh' => true
        ];
        $this->control_options = [
            'width' => 200,
            'height' => 200,
        ]; 
    }

    /**
     * Register Widget and calling parent Construstor.
     *
     * @return void
     */
    public function register(){
        parent::__construct($this->widget_Id,$this->widget_name,$this->widget_options,$this->control_options);
        register_widget($this);
    }

    /**
     * Widget method for implemeting Custom widget
     *
     * @param array $args
     * @param array $instance
     * @return void
     */
    public function widget($args,$instance){

        $book_categories = [];
        $taxonomy = '';
        $terms = get_terms( ['taxonomy' => 'book_category', 'hide_empty' => false] );
        foreach($terms as $term){ 
            if(isset($instance[$term->slug])){
                array_push($book_categories,$term->slug);   
                $taxonomy = $term->taxonomy;       
            }
        }


        $books = get_posts([
                'showposts' => -1,
                'post_type' => 'book',
                'tax_query' => [
                    [
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => $book_categories,
                    ]
                ]
            ]
        );

        echo $args['before_widget'];
        echo '<h6><b>Books<b></h6>';
        foreach ($books as $book) {
            echo $book->post_title . '<br/><hr>';
        }

        echo $args['after_widget'];
             
    }

     /**
     * form method for implemeting Custom widget UI
     *
     * @param array $instance
     * @return void
     */
    public function form($instance){

        // All the terms of book_category taxonomy.
        $terms = get_terms( ['taxonomy' => 'book_category', 'hide_empty' => false] );
        foreach($terms as $term){ 
                $checked = isset($instance[$term->slug]) ? ($instance[$term->slug] ? true:false):false ;
                //var_dump($checked);
               ?>
                <p>
                    <input class="checkbox" type="checkbox" <?php echo ($checked ? 'checked' : '') ?>  id="<?php echo $this->get_field_id( $term->slug ); ?>" name="<?php echo $this->get_field_name( $term->slug ); ?>" /> 
                    <label for="<?php echo $this->get_field_id( $term->slug ); ?>"><?php echo $term->name; ?></label>
                </p>
               <?php
        } 
        

    }

     /**
     * Update  method for implemeting Custom widget to update database
     *
     * @param array $new_instance
     * @param array $old_instance
     * @return void
     */
    public function update($new_instance,$old_instance){
        $instance = $old_instance;
        $terms = get_terms( ['taxonomy' => 'book_category', 'hide_empty' => false] );
        foreach($terms as $term){
            $instance[ $term->slug ] = $new_instance[ $term->slug ];
        }
        return $instance;
    }

}
?>

