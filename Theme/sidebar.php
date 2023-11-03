<?php 

/**
 * Sidebar file is used for dynamic right sunset sidebar. 
 * php version 7.4.10
 *
 * @category Sidebar.
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/Cyber-Vrcoder
 */

if (! is_active_sidebar('sunset-sidebar')) {
    return;
}

?>
<aside id="secondary" class="widget-area" role="complementary">
    <div class="hidden-sm hidden-md hidden-lg">
        <?php 
            wp_nav_menu(
                [
                    'theme_location' => 'sunset-header-menu',
                    'container'      => false,
                    'menu_class'     => 'nav navbar-nav navbar-collapse',
                ]
            );
            ?>
    </div>
    <?php dynamic_sidebar('sunset-sidebar'); ?>
</aside>