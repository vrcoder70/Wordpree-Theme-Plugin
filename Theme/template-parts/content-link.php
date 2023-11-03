<?php 

/**
 * Link Post Type.
 * php version 7.4.10
 *
 * @category Content_Link
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/Cyber-Vrcoder
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('sunset-format-link'); ?>>
    <header class="entry-header text-center">

        <?php
            $link = sunsetGrabUrl(); 
            the_title(
                '<h1 class="entry-title"><a href="' . $link. '" target="_blank">', 
                '<div class="link-icon"><span class="sunset-icon sunset-link"></span></div></a></h1>'
            ); 
            ?>
        
    </header><!-- entry-header -->

</article>