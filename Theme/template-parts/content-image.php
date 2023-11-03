<?php 

/**
 * Image Post Type.
 * php version 7.4.10
 *
 * @category Content
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/Cyber-Vrcoder
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('sunset-format-image'); ?>>

    <header class="entry-header text-center background-image" style="background-image: url(<?php echo sunsetGetAttachment(); ?>);">
       
        <?php the_title('<h1 class="entry-title"><a href="' . esc_url(get_permalink()) .'" rel="bookmark">', '</a></h1>'); ?>
        
        <div class="entry-meta">

            <?php echo sunsetPostMeta(); ?>

        </div><!-- .entry-meat -->

        <div class="entry-excerpt image-caption text-center">

            <?php the_excerpt(); ?>
            
        </div> 

    </header><!-- entry-header -->

    <footer class="entry-footer">
        <?php echo sunsetPostFooter(); ?>
    </footer><!-- .entry-footer -->
</article>
