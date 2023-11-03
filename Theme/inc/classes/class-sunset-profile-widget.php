<?php 

/**
 * Define Custom Widget Profile
 * php version 7.4.10
 *
 * @category Custom_Widget_Profile
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */
namespace SUNSET_THEME\Inc;
use WP_Widget;

/**
 * Define Custom Widget Profile
 * php version 7.4.10
 *
 * @category Custom_Widget_Profile
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

class Sunset_Profile_Widget extends WP_Widget
{
    /**
     * Constructor of SUNSET_THEME
     * 
     * @return null
     */
    public function __construct() 
    {
        $wdiget_options = [
            'classname' => 'sunset-profile-widget',
            'description' => 'Custom Sunset Profile Widget',
        ];

        parent::__construct('sunset_profile', 'Sunset Profile', $wdiget_options);

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
        $picture =  esc_attr(get_option('profile_picture'));
        $firstName =  esc_attr(get_option('first_name'));
        $lastName  =  esc_attr(get_option('last_name'));
        $fullName  =  $firstName . ' ' . $lastName;
        $user_description =  esc_attr(get_option('user_description'));
        
        $twitter_icon = esc_attr(get_option('twitter_handler'));
        $facebook_icon = esc_attr(get_option('facebook_handler'));
        echo $args['before_widget'];
        ?>
            <div class="text-center">
                <div class="image-container">
                    <div id="profile-picture-preview" class="profile-picture" style="background-image: url(<?php print $picture; ?>);"></div>
                </div>
                <h1 class="sunset-username"><?php print $fullName; ?></h1>
                <h2 class="sunset-description"><?php print $user_description; ?></h2>
                <div class="icons-wrapper">
                    <?php 
                    if (!empty($twitter_icon)) : ?>
                        <a href="http://www.twitter.com/<?php echo $twitter_icon;?>" target="_blank" rel="noopener noreferrer">
                            <span class="sunset-icon-sidebar sunset-icon sunset-twitter"></span>
                        </a>
                    <?php endif; 
                    if (!empty($facebook_icon)) : ?>
                        <a href="http://www.facebook.com/<?php echo $facebook_icon;?>" target="_blank" rel="noopener noreferrer">
                            <span class="sunset-icon-sidebar sunset-icon sunset-facebook"></span>
                        </a>
                    <?php endif; ?> 
                </div>
            </div>
        <?php
        echo $args['after_widget'];
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
        echo '<p><strong>No Options for this widgets</strong><br>You can control the fields of this widgets from <a href="./admin.php?page=vrcoder_sunset">This Page</a>.</p>';
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
    }

}
