<?php 

/**
 * Header file is used for defining header of sunset theme 
 * php version 7.4.10
 *
 * @category Header
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/Cyber-Vrcoder
 */
 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <title><?php bloginfo('title'); wp_title(); ?></title>
        <meta name="description" content="<?php bloginfo('description'); ?>">
        <meta charset="<?php bloginfo(); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <?php if (is_singular() && pings_open(get_queried_object()) ) :?>
            <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php endif; ?>
        <?php 
        $custom_css = esc_attr(get_option('sunset_css'));
        if (! empty($custom_css)) :
            echo '<style>' . $custom_css . '</style>';
        endif;
        ?>
        <?php wp_head();?>
    </head>
    <body <?php body_class(); ?>>
        <?php 
        if (function_exists('wp_body_open')) {
            wp_body_open();
        }
        ?>

        <div class="sunset-sidebar sidebar-closed">

            <div class="sunset-sidebar-container ">

                <a class="js-toggleSidebar sidebar-close">
                    <span class="sunset-icon sunset-close"></span>
                </a>
                
                <div class="sidebar-scroll">

                    <?php get_sidebar(); ?>

                </div><!-- sidebar-scroll -->

            </div><!-- .sunset-sidebar-container -->

        </div><!-- sunset-sidebar -->

        <div class="sidebar-overlay js-toggleSidebar"></div>

        <div class="site container-fluid">
            
            <header class="header-container background-image text-center"  style="background-image: url(<?php header_image(); ?>);">
                <?php get_template_part('template-parts/header/nav'); ?>
            </header><!-- #masthead -->
                        
        </div>
    