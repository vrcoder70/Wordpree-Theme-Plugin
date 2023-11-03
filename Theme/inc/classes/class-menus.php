<?php 

/**
 * Register menus
 * php version 7.4.10
 *
 * @category Custom_Nav_Menus
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

namespace SUNSET_THEME\Inc;

use SUNSET_THEME\Inc\Traits\Singleton;

/**
 * Register menus
 * php version 7.4.10
 *
 * @category Custom_Nav_Menus
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

class Menus
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
        /**
         * Actions.
         */
        add_action('init', [ $this, 'registerMenu' ]);
    }

    /**
     * Register Menu
     * 
     * @return null
     */
    public function registerMenu()
    {
        register_nav_menus( 
            [
                'sunset-header-menu' => esc_html__('Header Menu', 'vrcoder'),
                'sunset-footer-menu' => esc_html__('Footer Menu', 'vrcoder'),
            ]
        );
    }

    /**
     * Get the menu id from the loop in nav in header.
     * 
     * @param $location It is get location nav menu(Header-Footer)
     * 
     * @return null
     */
    public function getMenuId( $location )
    {

        $locations = get_nav_menu_locations();
    
        $menu_id = ! empty($locations[$location]) ? $locations[$location] : '';
    
        return ! empty($menu_id) ? $menu_id : '';
    }

    /**
     * Get the child menu of main menu item.
     * 
     * @param $menu_array It's for getting menu items array.
     * @param $parent_id  It's for getting menu item's parent id. 
     * 
     * @return null
     */
    public function getChildMenuItem( $menu_array, $parent_id )
    {
        
        $child_menus = [];

        if (! empty($menu_array) && is_array($menu_array)) {
            foreach ( $menu_array as $menu ) {
                if (intval($menu->menu_item_parent) === $parent_id) {
                    array_push($child_menus, $menu);
                }
            }
        }
        return $child_menus;
    }
}