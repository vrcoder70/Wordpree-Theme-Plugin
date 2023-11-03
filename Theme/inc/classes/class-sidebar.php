<?php
/**
 * Sidebar class for registering differents sidebars of this theme.
 * php version 7.4.10
 *
 * @category Sidebar
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

namespace SUNSET_THEME\Inc;

use SUNSET_THEME\Inc\Traits\Singleton;
/**
 * Trait-Signleton For instantiate any class only once.
 * 
 * @category Sidebar
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com
 */
class Sidebar
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
        add_action('widgets_init', [ $this, 'sunsetSidebar' ]);
       
    }

    /**
     * This function used for register sidebars.
     * 
     * @return null
     */
    public function sunsetSidebar()
    {
        $args = [
            'name'          => __('Sunset Sidebar', 'vrcoder'),
            'id'            => 'sunset-sidebar',
            'description'   => __('Dynamic right sidebar', 'vrcoder'),
            'before_widget' => '<section id="%1$s" class="sunset-widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="sunset-widget-title">',
            'after_title'   => '</h2>',
        ];
        register_sidebar($args);
    }   

}