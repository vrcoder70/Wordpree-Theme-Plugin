<?php

/**
 * Entry Header in Wordpress the Loop
 *  php version 7.4.10
 *
 * @category Entry-Header
 * @package  Vrcoder
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */
$the_post_id = get_the_ID();
$has_post_thumbnail = get_the_post_thumbnail($the_post_id);
?>

<header class="entry-header">
    <?php
        //Featured Image
    if ($has_post_thumbnail) {
        ?>
        <div class="entry-image mb-3">
            <a href="<?php echo esc_url(get_the_permalink());?>">
                <?php 
                    The_Post_Custom_thumbnail( 
                        $the_post_id, 
                        'featured-thumbnail', 
                        [
                            'sizes' => '(max-width: 350px) 350px, 233px',
                            'class' => 'attachment-featured-large size-featured-image'
                        ]    
                    );
                ?>
            </a>
        </div>
        <?php
    }
    if (is_single() || is_page() ) {
            printf(
                '<h1 class="page-title text-dark">%1$s</h1>',
                wp_kses_post(get_the_title())
            );
    } else {
            printf(
                '<h2 class="entry-title mb-3"><a class="text-dark" href="%1$s">%2$s</a></h2>',
                esc_url(get_the_permalink()),
                wp_kses_post(get_the_title())
            );  
    }
    ?>
</header>