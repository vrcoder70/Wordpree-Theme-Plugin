<?php 

/**
 * Basic Page.php
 * php version 7.4.10
 *
 * @category Page
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
                <?php
                if (have_posts()) :
 
                    while(have_posts()): the_post();

                        get_template_part('template-parts/content', 'page');

                    endwhile;

                endif;
                ?>
            </div><!--.container-->

        </main>

    </div><!-- #primary -->

<?php get_footer(); ?>