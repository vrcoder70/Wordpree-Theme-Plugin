<?php 

/**
 * Quote Post Type.
 * php version 7.4.10
 *
 * @category Content_Quote
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/Cyber-Vrcoder
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('sunset-format-quote'); ?>>

    <header class="entry-header text-center">

        <div class="row">
            <div class="col-sm-10 col-md-8 offset-sm-1 offset-md-2">
                <h1 class="quote-content"><a rel="bookmark" href="<?php the_permalink(); ?>"/><?php echo get_the_content(); ?></a></h1>
                <?php the_title('<h2 class="quote-author">', '</h2>'); ?>
            </div><!-- col-md-8 --> 
        </div><!-- row -->
        
        
    </header><!-- entry-header -->

    <footer class="entry-footer">
        <?php echo sunsetPostFooter(); ?>
    </footer><!-- .entry-footer -->

</article>