<?php 

/**
 * Gallery Post Type.
 * php version 7.4.10
 *
 * @category Content_Gallery
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/Cyber-Vrcoder
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('sunset-format-gallery'); ?>>

    <header class="entry-header text-center">
        <?php 
        if (sunsetGetAttachment()) : 
            ?>
            <div id="post-gallery-<?php the_ID(); ?>" class="carousel slide sunset-carousel-thumb" data-ride="carousel">

                <div class="carousel-inner" role="listbox">

                    <?php
                    $attachments = sunsetGetBsSlides(sunsetGetAttachment(3));

                    foreach ($attachments as $attachment) :

                        ?>

                        <div class="carousel-item <?php echo $attachment['class']; ?> background-image standard-featured" 
                        style="background-image: url( <?php echo $attachment['url']; ?> );">
                            <div class="hide next-image-preview" data-image="<?php echo $attachment['next_image']; ?>"></div>
                            <div class="hide prev-image-preview" data-image="<?php echo $attachment['prev_image']; ?>"></div>
                            <div class="entry-excerpt image-caption text-center">
                               <p><?php echo $attachment['caption']; ?></p>
                            </div> 
                        </div>
                        
                        <?php 
                    endforeach; ?>

                </div><!-- .carousel-inner -->

                <a class="left carousel-control carousel-control-prev" href="#post-gallery-<?php the_ID(); ?>" role="button" data-slide="prev">
                    <div class="table">
                        <div class="table-cell">

                            <div class="preview-container">
                                <span class="thumbnail-container background-image"></span>
                                <span class="sunset-icon sunset-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </div> <!-- preview-container--> 
                        
                        </div><!-- table-cell -->
                    </div><!-- table -->
                </a>
                <a class="right carousel-control carousel-control-next" href="#post-gallery-<?php the_ID(); ?>" role="button" data-slide="next">
                    <div class="table">
                        <div class="table-cell">

                            <div class="preview-container">
                                <span class="thumbnail-container background-image"></span>                                
                                <span class="sunset-icon sunset-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </div> <!-- preview-container--> 

                        </div><!-- table-cell -->
                    </div><!-- table -->
                </a>

            </div><!-- .carousel -->
        <?php endif; ?>
        
        <?php the_title('<h1 class="entry-title"><a href="' . esc_url(get_permalink()) .'" rel="bookmark">', '</a></h1>'); ?>
        
        <div class="entry-meta">
            <?php echo sunsetPostMeta(); ?>
        </div><!-- .entry-meat -->

    </header><!-- entry-header -->

    <div class="entry-content">
        
        

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