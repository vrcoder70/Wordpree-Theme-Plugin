<?php 

/**
 * Define Custom Widget Popular Posts
 * php version 7.4.10
 *
 * @category Custom_Widget_Popular_Posts
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */
namespace SUNSET_THEME\Inc;
use WP_Widget;

/**
 * Define Custom Widget Popular Posts
 * php version 7.4.10
 *
 * @category Custom_Widget_Popular_Posts
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

class Popular_Post_Widget extends WP_Widget
{
    /**
     * Constructor of SUNSET_THEME
     * 
     * @return null
     */
    public function __construct() 
    {
        $wdiget_options = [
            'classname' => 'sunset-popular-posts-widget',
            'description' => 'Popular Posts Widget',
        ];

        parent::__construct('sunset_popular_posts', 'Sunset Popular Posts', $wdiget_options);

    }

    /**
     * Widget method for implemeting Custom widget. It's prints on frontend
     *
     * @param $args     It is array of all arguments passed in defination section of sidebar section.
     * @param $instance It is instance of all optionts used in frontend.
     * 
     * @return void
     */
    public function widget($args,$instance)
    {
        $tot = absint($instance['tot']);

        $posts_query = sunsetPostQuery($tot);

        echo $args['before_widget'];
        if (!empty($instance['title'])) :
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];

        endif;
        if ($posts_query->have_posts()) : 
            // echo '<ul>';
            while($posts_query->have_posts()) : $posts_query->the_post();
                $post_format = (get_post_format() ? get_post_format() : 'standard' );
                echo '<div class="media mb-4">';
                echo '<div class="media-left mr-4"><img class="media-object" src="'. SUNSET_DIR_URI .'/assets/img/post-' . $post_format . '.png" alt="'. get_the_title() .'"/> </div>';
                echo '<div class="media-body">';
                echo '<a href="' .get_the_permalink(). '" title="' . get_the_title() . '">'. get_the_title() .'</a>';
                echo '<div class="row"><div class="col-xs-12 mt-2">' . sunsetPostFooter(true) . '</div></div>';
                echo '</div>';
                echo '</div>';
            endwhile;
            // echo '</ul>';
        endif;
        echo $args['after_widget'];
        //wp_reset_query();
    }

    /**
     * Form method for implemeting Custom widget UI. It's prits on backend. Admin area.
     *
     * @param $instance It is instance of all optionts used in frontend.
     * 
     * @return void
     */
    public function form($instance)
    {
        $title = (!empty($instance['title']) ? $instance['title'] : 'Popular Posts');  
        $tot = (!empty($instance['tot']) ? absint($instance['tot']) : 4);  

        $output = '<p>';
        $output .= '<label for="'. esc_attr($this->get_field_id('title')) .'">Title: </label>';
        $output .= '<input type="text" class="widefat" id="'. esc_attr($this->get_field_id('title')) .'" 
                    name="'. esc_attr($this->get_field_name('title')) .'" value="'. esc_attr($title) .'"/>';
        $output .= '</p>';

        $output .= '<p>';
        $output .= '<label for="'. esc_attr($this->get_field_id('tot')) .'">Number Of Posts: </label>';
        $output .= '<input type="number" class="widefat" id="'. esc_attr($this->get_field_id('tot')) .'" 
                    name="'. esc_attr($this->get_field_name('tot')) .'" value="'. esc_attr($tot) .'"/>';
        $output .= '</p>';

        echo $output;
    }

    /**
     * Update  method for implemeting Custom widget to update database
     *
     * @param $new_instance 
     * @param $old_instance 
     *
     * @return $instance Updated one that's store in database.
     */
    public function update($new_instance,$old_instance)
    {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title']) ? strip_tags($new_instance['title']) : '');
        $instance['tot'] = (!empty($new_instance['tot']) ? absint(($new_instance['tot'])) : 0);  
        return $instance;
    }

}
