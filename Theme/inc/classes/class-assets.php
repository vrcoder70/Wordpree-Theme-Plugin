<?php
/**
 * Assests class is used for enqueue all the js and css files.
 * php version 7.4.10
 *
 * @category Assets
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
 * @category Assets
 * @package  Vrcoder
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com
 */
class Assets
{
    use Singleton;

    /**
     * Constructor of Assets: used calling setup_hooks() function.
     * 
     * @return null
     */
    protected function __construct() 
    {
        $this->setupHooks();
    }

    /**
     * Setup_hooks() function initiate all WordPress hooks used in this class.
     * 
     * @return null
     */
    protected function setupHooks() 
    {

        /**
         * Actions.
         */
        add_action('wp_enqueue_scripts', [ $this, 'registerStyles' ]);
        add_action('wp_enqueue_scripts', [ $this, 'registerScripts' ]);
        add_action('admin_enqueue_scripts', [ $this, 'registerStylesAdmin']);
        add_action('admin_enqueue_scripts', [ $this, 'registerScriptAdmin']);
    }

    /**
     * This function Register and Enqueue all the css file when it needed.
     * 
     * @return null
     */
    public function registerStyles()
    {
        // Register styles.
        wp_register_style('bootstrap-css', SUNSET_DIR_URI . '/assets/library/css/bootstrap.min.css', [], false, 'all');
        wp_register_style('sunset-css', SUNSET_DIR_URI . '/assets/css/sunset.css', ['bootstrap-css'], filemtime(SUNSET_DIR_PATH . '/assets/css/sunset.css'), 'all');

        // Enqueue Styles.
        wp_enqueue_style('bootstrap-css');
        wp_enqueue_style('sunset-css');
        wp_enqueue_style('raleway', 'https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400&display=swap');
    }

    /**
     * This function Register and Enqueue all the css file when it needed for admin area.
     * 
     * @param $hook $hook is variable that's give name of page.
     * 
     * @return null
     */
    public function registerStylesAdmin($hook)
    {
        
        // Register styles.
        wp_register_style('admin-css', SUNSET_DIR_URI . '/assets/css/sunset.admin.css', [], filemtime(SUNSET_DIR_PATH . '/assets/css/sunset.admin.css'), 'all');
        wp_register_style('sunset-custom-css', SUNSET_DIR_URI . '/assets/css/sunset.ace.css', [], filemtime(SUNSET_DIR_PATH . '/assets/css/sunset.ace.css'), 'all');
        
        //echo $hook;
        // Enqueue Styles.
        if ('toplevel_page_vrcoder_sunset' == $hook || 'sunset_page_vrcoder_sunset_contact_form' == $hook || 'sunset_page_vrcoder_sunset_theme' == $hook) {
            wp_enqueue_style('admin-css');
        } else if ('sunset_page_vrcoder_sunset_css' == $hook) {
            wp_enqueue_style('sunset-custom-css');
        }
    }

    /**
     * This function Register and Enqueue all the js file when it needed.
     * 
     * @return null
     */
    public function registerScripts()
    {
        // Deregister Jquery
        //wp_deregister_script('jquery');
        
        // Register scripts.
        //wp_register_script('jquery', SUNSET_DIR_URI . '/assets/library/js/jquery/jquery.js', false, false, true);
        wp_register_script('bootstrap-js', SUNSET_DIR_URI . '/assets/library/js/bootstrap/bootstrap.min.js', ['jquery'], false, true);
        wp_register_script('popper-js', SUNSET_DIR_URI . '/assets/library/js/popper/popper.js', ['jquery'], false, true);
        wp_register_script('sunset-js', SUNSET_DIR_URI . '/assets/js/sunset.js', ['jquery'], filemtime(SUNSET_DIR_PATH . '/assets/js/sunset.js'), true);
        

        // Enqueue Scripts.
        //wp_enqueue_script('jquery');
        wp_enqueue_script('popper-js');
        wp_enqueue_script('bootstrap-js');
        wp_enqueue_script('sunset-js');
    }

    /**
     * This function Register and Enqueue all the js file when it needed for admin area.
     * 
     * @param $hook $hook is variable that's give name of page.
     * 
     * @return null
     */
    public function registerScriptAdmin($hook)
    {
        
        // Register styles.
        wp_register_script('admin-js', SUNSET_DIR_URI . '/assets/js/sunset.admin.js', ['jquery'], filemtime(SUNSET_DIR_PATH . '/assets/js/sunset.admin.js'), true);
        
        //ace
        wp_register_script('ace-js', SUNSET_DIR_URI . '/assets/library/js/ace/ace.js', ['jquery'], false, true);
        wp_register_script('custom-css-js', SUNSET_DIR_URI . '/assets/js/sunset.custom.css.js', ['jquery'], filemtime(SUNSET_DIR_PATH . '/assets/js/sunset.custom.css.js'), true);
        
        // Enqueue Styles.
        wp_enqueue_script('admin-js');
        wp_enqueue_media();
        if ('sunset_page_vrcoder_sunset_css' == $hook) {
            wp_enqueue_script('ace-js');
            wp_enqueue_script('custom-css-js');
        }
        
    }
}