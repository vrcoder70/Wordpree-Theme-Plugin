<?php 

/**
 * Aside Post Type.
 * php version 7.4.10
 *
 * @category Content_Aside
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/Cyber-Vrcoder
 */

//$class = get_query_var('post-class');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(['sunset-format-aside']); ?>>
    <div class="aside-container">
        <div class="row">

            <div class="col-xs-12 col-sm-3 col-md-2">

                <?php if (sunsetGetAttachment()) : 
                    $featured_image = sunsetGetAttachment();
                    ?>
                    <div class="aside-featured background-image" style="background-image: url(<?php echo $featured_image; ?>);"></div>
                <?php endif; ?>

            </div> <!--.col-md-3 -->
            <div class="col-xs-12 col-sm-9 col-md-10">

                <header class="entry-header">
                    <div class="entry-meta">
                        <?php echo sunsetPostMeta(); ?>
                    </div><!-- .entry-meat -->
                </header><!-- entry-header -->

                <div class="entry-content">
                    <div class="entry-excerpt text-center">
                        <?php the_content(); ?>
                    </div> 
                </div><!-- .entry-content -->
                    
            </div> <!-- .col-md-9 -->

        </div> <!-- row -->

        <footer class="entry-footer">
            <div class="row">
                <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                    <?php echo sunsetPostFooter(); ?>
                </div>
            </div>
        </footer><!-- .entry-footer -->
    </div> <!-- .aside-container -->
</article>