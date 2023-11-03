<?php

/**
 * SUNSET_THEME class is used for Defining HTML Structure for admin page.
 * php version 7.4.10
 *
 * @category Settings_Page
 * @package  Vrcoder
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

?>
<h1>Sunset Sidebar Options</h1>
<?php 
    settings_errors(); 
    $picture =  esc_attr(get_option('profile_picture'));
    $firstName =  esc_attr(get_option('first_name'));
    $lastName  =  esc_attr(get_option('last_name'));
    $fullName  =  $firstName . ' ' . $lastName;
    $user_description =  esc_attr(get_option('user_description'));
    
    $twitter_icon = esc_attr(get_option('twitter_handler'));
    $facebook_icon = esc_attr(get_option('facebook_handler'));

?>

<div class="sunset-sidebar-preview">
    <div class="sunset-sidebar">
        <div class="image-container">
            <div id="profile-picture-preview" class="profile-picture" style="background-image: url(<?php print $picture; ?>);"></div>
        </div>
        <h1 class="sunset-username"><?php print $fullName; ?></h1>
        <h2 class="sunset-description"><?php print $user_description; ?></h2>
        <div class="icons-wrapper">
            <?php 
            if (!empty($twitter_icon)) : ?>
                <span class="sunset-icon-sidebar dashicons-before dashicons-twitter"></span>
            <?php endif; 
            if (!empty($facebook_icon)) : ?>
                <span class="sunset-icon-sidebar dashicons-before dashicons-facebook-alt"></span>
            <?php endif; ?> 
        </div>
    </div>
</div>

<form method="post" action="options.php" class="sunset-general-form">
    <?php settings_fields('sunset-sidebar-group'); ?>
    <?php do_settings_sections('vrcoder_sunset'); ?>
    <?php submit_button('Save Changes', 'primary', 'btnSubmit');?>
</form>