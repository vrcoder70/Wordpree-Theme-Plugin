<?php 

/**
 * Register Custom Widgets
 * php version 7.4.10
 *
 * @category Custom_Widgets
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

namespace SUNSET_THEME\Inc;

use SUNSET_THEME\Inc\Traits\Singleton;

/**
 * Register Custom Widgets
 * php version 7.4.10
 *
 * @category Custom_Custom_Widgets
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

class Widgets
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
     * Setup Hooks for registering menus.
     * 
     * @return null
     */
    protected function setupHooks() 
    {
        add_action('widgets_init', [ $this, 'registerSunsetProfileWidget']);
        add_action('widgets_init', [ $this, 'registerPopularPostsWidget']);
    }

    /**
     * Register Sunset Profile Widget.
     * 
     * @return null
     */
    public function registerSunsetProfileWidget()
    {
        register_widget(new \SUNSET_THEME\Inc\Sunset_Profile_Widget); 
    }

    /**
     * Register Sunset Popular Posts
     * 
     * @return null
     */
    public function registerPopularPostsWidget()
    {
        register_widget(new \SUNSET_THEME\Inc\Popular_Post_Widget); 
    }

}
