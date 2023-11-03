<?php

/**
 * Header Navigation menu
 * php version 7.4.10
 *
 * @category Header_Navigation_Menu
 * @package  Sunset_Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */


$menu_class = \SUNSET_THEME\Inc\Menus::getInstance();
$header_menu_id = $menu_class->getMenuId('sunset-header-menu');
$header_menus = wp_get_nav_menu_items($header_menu_id);
//var_dump($header_menus);
//die();

?>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    
    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> -->
    <?php 
    if (function_exists('the_custom_logo')) {
        the_custom_logo();
    }
    ?>
  
    <div class="collapse navbar-collapse ml-1" id="navbarSupportedContent">

      <?php

        if (! empty($header_menus) && is_array($header_menus)) {  
            ?>
          
            <ul class="navbar-nav mr-auto">
      
            <?php
            
            foreach ( $header_menus as $menu_item ) {
                if (! $menu_item->menu_item_parent ) {
              
                    $child_menu_items = $menu_class->getChildMenuItem($header_menus, $menu_item->ID);
                    $has_children = ! empty($child_menu_items) && is_array($child_menu_items);
                    $has_sub_menu_class = ! empty($has_children) ? 'has-submenu' : '';
                    if (! $has_children ) {
                        ?>
                        <li class="nav-item active">
                          <a class="nav-link" href="<?php echo esc_url($menu_item->url);?>">
                            <?php echo esc_html($menu_item->title); ?> 
                          </a>
                        </li>
                        <?php 
                    } else {
                        ?>
                    <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="<?php echo esc_url($menu_item->url);?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo esc_html($menu_item->title); ?>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php 
                            foreach ( $child_menu_items as $child_menu_item ) {
                                ?>
                                  <a class="dropdown-item" href="<?php echo esc_url($child_menu_item->url);?>">
                                    <?php echo esc_html($child_menu_item->title);?>
                                  </a>
                                <?php 
                            }
                            ?>
                          </div>
                    </li>
                        <?php
                    } 
                }
            }
        } 
      
        ?>
          </ul>
      <?php //get_search_form(); ?>
    </div>
  </div>
  <a class="js-toggleSidebar sidebar-open">
    <span class="sunset-icon sunset-menu"></span>
  </a>
</nav>


        
