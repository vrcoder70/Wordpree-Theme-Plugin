<?php
/**
 * SUNSET_THEME class is used for Defining Settings and sub pages.
 * php version 7.4.10
 *
 * @category Settings_Page
 * @package  Vrcoder
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

namespace SUNSET_THEME\Inc;

use SUNSET_THEME\Inc\Traits\Singleton;
/**
 * Trait-Signleton For instantiate any class only once.
 * 
 * @category Settings_Page
 * @package  Vrcoder
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com
 */
class Admin_Setting_Page
{
    use Singleton;
    /**
     * Constructor of SUNSET_THEME
     * 
     * @return null
     */
    protected function __construct()
    {
        
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
         add_action('admin_menu', [ $this, 'adminSettingPage' ]);
    }

    /**
     * Used for register custom admin settings page.
     * 
     * @return null
     */
    public function adminSettingPage()
    {
        // Generate Admin Settings Page
        add_menu_page('Sunset Theme Options', 'Sunset', 'manage_options', 'vrcoder_sunset', [ $this, 'adminPage' ], SUNSET_DIR_URI . '/assets/img/sunset-icon.png', 110);
    
        // Generate Admin Settings submenu page for Sidebar
        add_submenu_page('vrcoder_sunset', 'Sunset Sidebar Options', 'Sidebar', 'manage_options', 'vrcoder_sunset', [ $this, 'adminPage' ], 1);
    
        // Generate Admin Settings submenu page for Theme Options
        add_submenu_page('vrcoder_sunset', 'Sunset Theme Options', 'Theme Options', 'manage_options', 'vrcoder_sunset_theme', [ $this, 'adminThemePage' ], 2);

        // Generate Admin Settings submenu page for Theme Options
        add_submenu_page('vrcoder_sunset', 'Sunset Contact Form', 'Contact Form', 'manage_options', 'vrcoder_sunset_contact_form', [ $this, 'adminContactForm' ], 2);

        // Generate Admin Settings submenu page for Css options
        add_submenu_page('vrcoder_sunset', 'Sunset Css Options', 'Custom Css', 'manage_options', 'vrcoder_sunset_css', [ $this, 'adminCustomCssPage' ], 3);

        //Activate Settings Api
        add_action('admin_init', [ $this, 'sunsetCustomSettings' ]);
    }

    /**
     * Used for Activate Settings api.
     * 
     * @return null
     */
    public function sunsetCustomSettings()
    {
        //Sidebar
        register_setting('sunset-sidebar-group', 'profile_picture');
        register_setting('sunset-sidebar-group', 'first_name');
        register_setting('sunset-sidebar-group', 'last_name');
        register_setting('sunset-sidebar-group', 'user_description');
        
        register_setting('sunset-sidebar-group', 'twitter_handler', [ $this, 'sunsetTwitterSanitize' ]);
        register_setting('sunset-sidebar-group', 'facebook_handler');
        //register_setting('sunset-sidebar-group', 'google_handler');

        
        add_settings_section('sunset-sidebar-options', 'Sidebar Options', [ $this, 'sunsetSidebarOptions' ], 'vrcoder_sunset');
        
        add_settings_field('sidebar-profile-picture', 'Profile Picture', [ $this, 'sunsetSidebarProfilePicture' ], 'vrcoder_sunset', 'sunset-sidebar-options');
        add_settings_field('sidebar-name', 'Full Name', [ $this, 'sunsetSidebarName' ], 'vrcoder_sunset', 'sunset-sidebar-options');
        add_settings_field('sidebar-description', 'User Description', [ $this, 'sunsetSidebarDescription' ], 'vrcoder_sunset', 'sunset-sidebar-options');
        
        add_settings_field('sidebar-twitter', 'Twitter Handler', [ $this, 'sunsetSidebarTwitter' ], 'vrcoder_sunset', 'sunset-sidebar-options');
        add_settings_field('sidebar-facebook', 'Facebook handler', [ $this, 'sunsetSidebarFacebook' ], 'vrcoder_sunset', 'sunset-sidebar-options');
        //add_settings_field('sidebar-google', 'Google+ Handler', [ $this, 'sunsetSidebarGoogle' ], 'vrcoder_sunset', 'sunset-sidebar-options');
    
        // Theme Support 
        register_setting('sunset-theme-support', 'post_formats', [ $this, 'sunsetPostFormatSanitize' ]);
        register_setting('sunset-theme-support', 'custom_header');
        register_setting('sunset-theme-support', 'custom_background');
        //register_setting('sunset-theme-support', 'custom_nav_menus');
        
        add_settings_section('sunset-theme-options', 'Theme Options', [ $this, 'sunsetThemeOptions' ], 'vrcoder_sunset_theme');

        add_settings_field('post-formats', 'Post Formats', [ $this, 'sunsetPostFormats' ], 'vrcoder_sunset_theme', 'sunset-theme-options');
        add_settings_field('custom-header', 'Activate Custom Header', [ $this, 'sunsetCustomHeadr' ], 'vrcoder_sunset_theme', 'sunset-theme-options');
        add_settings_field('custom-background', 'Activate Custom Background', [ $this, 'sunsetCustomBackground' ], 'vrcoder_sunset_theme', 'sunset-theme-options');
        //add_settings_field('custom-nav-menus', 'Activate Custom Navigation Menus', [ $this, 'sunsetCustomNavMenus' ], 'vrcoder_sunset_theme', 'sunset-theme-options');
    
        // Contact Form
        register_setting('sunset-contact-options', 'activate_contact_form');

        add_settings_section('sunset-contact-section', 'Contact Form', [ $this, 'sunsetContactForm' ], 'vrcoder_sunset_contact_form');

        add_settings_field('activate-form', 'Activate Contact Form', [ $this, 'sunsetActivateContactForm' ], 'vrcoder_sunset_contact_form', 'sunset-contact-section');

        // Custom Css
        register_setting('sunset-custom-css-options', 'sunset_css', [$this, 'sunsetSanitizeCustomCss']);

        add_settings_section('sunset-custom-css-section', 'Custom Css', [ $this, 'sunsetCustomCss' ], 'vrcoder_sunset_css');
 
        add_settings_field('custom-css', 'Insert your Custom css', [ $this, 'sunsetInsertCustomCss' ], 'vrcoder_sunset_css', 'sunset-custom-css-section');
 
    }

    // Custom Css
    // Settings Sanitize Functions.
    /**
     * Used for Sanitize Custom Css
     * 
     * @param $input Input enter by user
     * 
     * @return null
     */
    public function sunsetSanitizeCustomCss($input)
    {
        $output = esc_textarea($input);
        return $output;
    }

    // Settings Sections
    /**
     * Used for Settings Section
     * 
     * @return null
     */
    public function sunsetCustomCss()
    {
        echo 'Customize Sunset Theme with your creative css';
    }

    // Settings Fields
    /**
     * Used for Settings Field Custom Header
     * 
     * @return null
     */
    public function sunsetInsertCustomCss()
    {
        $css =  get_option('sunset_css');
        $css = (empty($css) ? '/* Sunset Theme Custom Css*/' : $css);
        echo '<div id="customCss">'. $css .'</div>
        <textarea style="display:none; visibility: hidden;" id="sunset_css" name="sunset_css">'. $css .'</textarea>';
    }

    // Contact Form

    // Settings Sections
    /**
     * Used for Settings Section
     * 
     * @return null
     */
    public function sunsetContactForm()
    {
        echo 'Activate and Deactivate Contact Form.';
    }

    // Settings Fields
    /**
     * Used for Settings Field Custom Header
     * 
     * @return null
     */
    public function sunsetActivateContactForm()
    {
        
        $options =  get_option('activate_contact_form');

        $checked = ( @$options == 1 ? 'checked' : '' );

        echo '<label class="switch"><input type="checkbox" id="activate_contact_form" name="activate_contact_form" value="1" '.$checked.'/><span class="slider round"></span></label>';

    }

    // Theme Support

    // Settings Sanitize Functions.
    /**
     * Used for Sanitize Twitter
     * 
     * @param $input Input enter by user
     * 
     * @return null
     */
    public function sunsetPostFormatSanitize($input)
    {
        //var_dump($input);
        //wp_die();
        return $input;
    }

    // Settings Sections
    /**
     * Used for Settings Section
     * 
     * @return null
     */
    public function sunsetThemeOptions()
    {
        echo 'Activate and Deactivate Speficied Theme Support';
    }

    // Settings Fields
    /**
     * Used for Settings Field Postformats
     * 
     * @return null
     */
    public function sunsetPostFormats()
    {
        $formats = ['aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'];
        
        $output = '';

        $options =  get_option('post_formats');

        foreach ($formats as $format) {

            $checked = (@$options[$format] ? 'checked' : '');

            $output .= '<label><input type="checkbox" id="' . $format .'" name="post_formats['. $format .']" value="1" '.$checked.'/>' . $format . '</label><br>';
        }

        echo $output;

    }

    /**
     * Used for Settings Field Custom Header
     * 
     * @return null
     */
    public function sunsetCustomHeadr()
    {
        
        $options =  get_option('custom_header');

        $checked = ( @$options == 1 ? 'checked' : '' );

        echo '<label class="switch"><input type="checkbox" id="custom_header" name="custom_header" value="1" '.$checked.'/><span class="slider round"></label>';

    }

    /**
     * Used for Settings Field Custom Background
     * 
     * @return null
     */
    public function sunsetCustomBackground()
    {
        
        $options =  get_option('custom_background');

        $checked = ( @$options == 1 ? 'checked' : '' );

        echo '<label class="switch"><input type="checkbox" id="custom_background" name="custom_background" value="1" '.$checked.'/><span class="slider round"></label>';

    }

    /**
     * Used for Settings Field Custom Navigation Activation.
     * 
     * @return null
     */
    // public function sunsetCustomNavMenus()
    // {
        
    //     $options =  get_option('custom_nav_menus');

    //     $checked = ( @$options == 1 ? 'checked' : '' );

    //     echo '<label class="switch"><input type="checkbox" id="custom_nav_menus" name="custom_nav_menus" value="1" '.$checked.'/><span class="slider round"></label>';

    // }

    // Sidebar

    // Settings Sanitize Functions.
    /**
     * Used for Sanitize Twitter
     * 
     * @param $input Input enter by user
     * 
     * @return null
     */
    public function sunsetTwitterSanitize($input)
    {
        $output = sanitize_text_field($input);
        $output = str_replace('@', '', $output);
        return $output;
    }

    // Settings Sections
    /**
     * Used for Settings Section
     * 
     * @return null
     */
    public function sunsetSidebarOptions()
    {
        echo 'Customize your Sidebar Information';
    }

    // Settings Fields

    /**
     * Used for Settings Field Description
     * 
     * @return null
     */
    public function sunsetSidebarProfilePicture()
    {
        $picture =  esc_attr(get_option('profile_picture'));
        
        if (empty($picture)) {
            echo '<input class="button button-secondary" type="button" value="Upload Profile Picture" id="upload-button"/><input type="hidden" id="profile-picture" name="profile_picture" value="" /> ';
        } else {
            echo '<input class="button button-secondary" type="button" value="Replace Profile Picture" id="upload-button"/>
            <input type="hidden" id="profile-picture" name="profile_picture" value="' . $picture . '" />
            <input class="button button-primary" type="button" value="Remove" id="remove-button"/>';
        }
    }

    /**
     * Used for Settings Field Description
     * 
     * @return null
     */
    public function sunsetSidebarDescription()
    {
        $user =  esc_attr(get_option('user_description'));
        
        echo '<input type="text" id="user_description" name="user_description" value="' . $user . '" placeholder="User Description"/> <p>
        Write something that\'s describe you.</p>';
    }

    /**
     * Used for Settings Field Fullname
     * 
     * @return null
     */
    public function sunsetSidebarName()
    {
        $firstName =  esc_attr(get_option('first_name'));
        $lastName =  esc_attr(get_option('last_name'));

        echo '<input type="text" id="first_name" name="first_name" value="' . $firstName . '" placeholder="First Name"/> 
              <input type="text" id="last_name" name="last_name" value="' . $lastName . '" placeholder="Last Name"/>';
    }

    /**
     * Used for Settings Field Twiiter
     * 
     * @return null
     */
    public function sunsetSidebarTwitter()
    {
        $twitter =  esc_attr(get_option('twitter_handler'));

        echo '<input type="text" id="twitter_handler" name="twitter_handler" value="' . $twitter . '" placeholder="Twitter Hanlder"/><p>
        Enter twitter handler without @ symbol.</p> ';
    }

    /**
     * Used for Settings Field Google
     * 
     * @return null
     */
    // public function sunsetSidebarGoogle()
    // {
    //     $google =  esc_attr(get_option('google_handler'));

    //     echo '<input type="text" id="google_handler" name="google_handler" value="' . $google . '" placeholder="Google Hanlder"/> ';
    // }

    /**
     * Used for Settings Field Facebook
     * 
     * @return null
     */
    public function sunsetSidebarFacebook()
    {
        $facebook =  esc_attr(get_option('facebook_handler'));

        echo '<input type="text" id="facebook_handler" name="facebook_handler" value="' . $facebook . '" placeholder="Facebook Hanlder"/> ';
    }


    // Template Pages.

    /**
     * Used for define HTML struture custom admin settings subpages. It is for sidebar
     * 
     * @return null
     */
    public function adminPage()
    {
        get_template_part('inc/template/sunset-admin-sidebar-page');
    }

    /**
     * Used for define HTML struture custom admin settings subpages. It is for theme options
     * 
     * @return null
     */
    public function adminThemePage()
    {
        get_template_part('inc/template/sunset-admin-theme-support-page');
    }

    /**
     * Used for define HTML struture custom admin settings subpages. It is for theme options
     * 
     * @return null
     */
    public function adminContactForm()
    {
        get_template_part('inc/template/sunset-admin-contact-form-page');
    }

    /**
     * Used for define HTML struture custom admin settings submenu page.
     * 
     * @return null
     */
    public function adminCustomCssPage()
    {
        get_template_part('inc/template/sunset-custom-css-page');   
    }
  
}