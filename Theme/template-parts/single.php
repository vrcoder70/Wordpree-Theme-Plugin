<?php 

/**
 * Standard Single Post Type.
 * php version 7.4.10
 *
 * @category Single_Post_Type
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/Cyber-Vrcoder
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('mb-5'); ?>>

    <header class="entry-header text-center">

        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
        
        <div class="entry-meta">
            <?php echo sunsetPostMeta(); ?>
        </div><!-- .entry-meat -->

    </header><!-- entry-header -->

    <div class="entry-content clearfix">
        <?php the_content(); ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php echo sunsetPostFooter(); ?>
    </footer><!-- .entry-footer -->

</article>
