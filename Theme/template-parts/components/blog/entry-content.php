<?php 
/**
 * Entry content in Wordpress the Loop
 *  php version 7.4.10
 *
 * @category Content
 * @package  Vrcoder
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */
?>
<div class="entry-content">
    <?php if (is_single()) {
        the_content( 
            sprintf(
                wp_kses(
                    __('Continue reading %s <span class="meta-nav">&rarr</span>', 'vrcoder'),
                    [
                        'span' => [
                            'class' => []
                        ]
                    ]
                ),
                the_title('<span class="screen-reader-text">"', '"</span>', false)
            ), 
        );
        wp_link_pages( 
            [
            'before' => '<div class="page-links">'. esc_html__('Pages: ', 'vrcoder'),
            'after'  => '</div>',
            ] 
        );
    } else {
        sunsetExcerpt(100);
        printf('<br>');
        echo sunsetExcerptMore();
    }
    
    ?>
</div>
