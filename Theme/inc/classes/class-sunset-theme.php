<?php
/**
 * SUNSET_THEME class is used for bootstrap whole Vrcoder Theme.
 * php version 7.4.10
 *
 * @category Theme_Setup
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
 * @category Theme_Setup
 * @package  Vrcoder
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com
 */
class SUNSET_THEME
{
    use Singleton;
    /**
     * Constructor of SUNSET_THEME
     * 
     * @return null
     */
    protected function __construct()
    {
        //Load Class
        Admin_Setting_Page::getInstance();
        Assets::getInstance();
        Post_Type::getInstance();
        Metabox::getInstance();
        Menus::getInstance();
        Shortcodes::getInstance();
        Sidebar::getInstance();
        Widgets::getInstance();
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
        add_action('after_setup_theme', [ $this, 'setupTheme' ]);
       
    }

    /**
     * Setup theme.
     *
     * @return void  
     */
    public function setupTheme()
    {
        /**
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
        */
        add_theme_support('title-tag');

        /**
         * Custom logo.
         *
         * @see  Adding custom logo
         * @link https://developer.wordpress.org/themes/functionality/custom-logo/#adding-custom-logo-support-to-your-theme
        */
        add_theme_support(
            'custom-logo',
            [
                'header-text' => [
                    'site-title',
                    'site-description',
                ],
                'height'      => 100,
                'width'       => 400,
                'flex-height' => true,
                'flex-width'  => true,
            ]
        );
        
        /**
         * Enable support for Post Thumbnails on posts and pages.
         *
         * Adding this will allow you to select the featured image on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
        
        add_theme_support('post-thumbnails');

        add_image_size('featured-thumbnail', 350, 233, true);

        /**
         * Register image sizes.
         */
        add_image_size('featured-thumbnail', 350, 233, true);


        // Add theme support for selective refresh for widgets.
        /**
         * WordPress 4.5 includes a new Customizer framework called selective refresh
         *
         * Selective refresh is a hybrid preview mechanism that has the performance benefit of not having to refresh the entire preview window.
         *
         * @link https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
        */
        add_theme_support('customize-selective-refresh-widgets');

        //Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /**
         * Switch default core markup for search form, comment form, comment-list, gallery, caption, script and style
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'script',
                'style',
            ]
        );

        // Gutenberg theme support.

        /**
         * Some blocks in Gutenberg like tables, quotes, separator benefit from structural styles (margin, padding, border etc…)
         * They are applied visually only in the editor (back-end) but not on the front-end to avoid the risk of conflicts with the styles wanted in the theme.
         * If you want to display them on front to have a base to work with, in this case, you can add support for wp-block-styles, as done below.
         *
         * @see  Theme Styles.
         * @link https://make.wordpress.org/core/2018/06/05/whats-new-in-gutenberg-5th-june/, https://developer.wordpress.org/block-editor/developers/themes/theme-support/#default-block-styles
        */
        add_theme_support('wp-block-styles');

        /**
         * Some blocks such as the image block have the possibility to define
         * a “wide” or “full” alignment by adding the corresponding classname
         * to the block’s wrapper ( alignwide or alignfull ). A theme can opt-in for this feature by calling
         * add_theme_support( 'align-wide' ), like we have done below.
         *
         * @see  Wide Alignment
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#wide-alignment
        */
        add_theme_support('align-wide');

        /**
         * Loads the editor styles in the Gutenberg editor.
         *
         * Editor Styles allow you to provide the CSS used by WordPress’ Visual Editor so that it can match the frontend styling.
         * If we don't add this, the editor styles will only load in the classic editor ( tiny mice )
         *
         * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#editor-styles
         */
        add_theme_support('editor-styles');

        // Remove the core block patterns
        remove_theme_support('core-block-patterns');

        /**
         * Set the maximum allowed width for any content in the theme,
         * like oEmbeds and images added to posts
         *
         * @see  Content Width
         * @link https://codex.wordpress.org/Content_Width
         */
        global $content_width;
        if (! isset($content_width)) {
            $content_width = 1240;
        }

        //User Activation 
        /**
         * Adds Custom background panel to customizer.
         *
         * @see  Enable Custom Backgrounds
         * @link https://developer.wordpress.org/themes/functionality/custom-backgrounds/#enable-custom-backgrounds
        */
        $background = get_option('custom_background');
        if (@$background == 1) {
            add_theme_support(
                'custom-background',
                [
                    'default-color' => 'ffffff',
                    'default-image' => '',
                    'default-repeat' => 'no-repeat',
                ]
            );
        }

        /** 
         * Adds Custom header panel to customizer.
         *
         * @see Enable Custom Backgrounds
         */
        $header = get_option('custom_header');
        if (@$header == 1) {
            add_theme_support(
                'custom-header'
            );
        }

        /** 
         * Adds Post formats to post type
         */
        $options =  get_option('post_formats');
        $formats = ['aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'];
        $output = [];
        foreach ($formats as $format) {
            $output[] = (@$options[$format] == 1 ? $format : '');
        }
        if (! empty($options)) {
            add_theme_support('post-formats', $output);
        }
    }

    /**
     * Check if Custom navigation menus activated.
     * 
     * @return boolean
     */ 
    // public function isNavMenusActivated()
    // {
    //     $contact = get_option('custom_nav_menus');
    //     if (@$contact == 1) { 
    //         return true;
    //     }
    //     return false;
    // }


}