<?php 

/**
 * Standard Post Type.
 * php version 7.4.10
 *
 * @category Content
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/Cyber-Vrcoder
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('mb-5'); ?>>

    <?php 
        // get_template_part('template-parts/components/blog/entry-header');
        // get_template_part('template-parts/components/blog/entry-meta');
        // get_template_part('template-parts/components/blog/entry-content');
        // get_template_part('template-parts/components/blog/entry-footer');
    ?>

    <header class="entry-header text-center">

        <?php the_title('<h1 class="entry-title"><a href="' . esc_url(get_permalink()) .'" rel="bookmark">', '</a></h1>'); ?>
        
        <div class="entry-meta">
            <?php echo sunsetPostMeta(); ?>
        </div><!-- .entry-meat -->

    </header><!-- entry-header -->

    <div class="entry-content">
        
        <?php if (sunsetGetAttachment()) : 
            $featured_image = sunsetGetAttachment();
            ?>
            <a href="<?php the_permalink(); ?>" class="standard-featured-link">
                <div class="standard-featured background-image" style="background-image: url(<?php echo $featured_image; ?>);"></div>
            </a>
        <?php endif; ?>

        <div class="entry-excerpt text-center">
            <?php the_excerpt(); ?>
        </div> 

        <div class="button-container text-center">
            <a href="<?php the_permalink(); ?>" class="btn btn-sunset"><?php _e('Read More', 'vrcoder'); ?></a>
        </div>

    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php echo sunsetPostFooter(); ?>
    </footer><!-- .entry-footer -->

</article>