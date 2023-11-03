<?php 

/**
 * Audio Post Type.
 * php version 7.4.10
 *
 * @category Content_Audio
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/Cyber-Vrcoder
 */

 // Add $class to post_class to add this class.
 //$class = get_query_var('post-class');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('sunset-format-audio'); ?>>
    
    <header class="entry-header">

        <?php the_title('<h1 class="entry-title"><a href="' . esc_url(get_permalink()) .'" rel="bookmark">', '</a></h1>'); ?>
        
        <div class="entry-meta">
            <?php echo sunsetPostMeta(); ?>
        </div><!-- .entry-meat -->

    </header><!-- entry-header -->

    <div class="entry-content">
        <?php 
            echo sunsetGetEmbeddedMedia(['audio','iframe']);
        ?>
        
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php echo sunsetPostFooter(); ?>
    </footer><!-- .entry-footer -->

</article>