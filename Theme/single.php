<?php 

/**
 * Single Post with full content.
 * php version 7.4.10
 *
 * @category Single_File
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/Cyber-Vrcoder
 */

get_header();

?>

    <div id="primary" class="content-area">
        
        <main class="site-main" id="main" role="main">

            <div class="container">
                
                <div class="row">
                    
                    <div class="col-xs-12 col-md-10 col-lg-8 offset-lg-2 offset-md-1">

                        <?php
                        if (have_posts()) :
                            sunsetSavePostViews(get_the_ID());
                            while(have_posts()): the_post();

                                get_template_part('template-parts/single', get_post_format());

                                echo sunsetpostNavigation();

                                if (comments_open()) :
                                    comments_template();
                                endif;

                            endwhile;

                        endif;
                        ?>

                    </div><!-- .col-lg-9 -->
                
                </div><!-- .row -->
            
            </div><!--.container-->

        </main>

    </div><!-- #primary -->

<?php get_footer(); ?>