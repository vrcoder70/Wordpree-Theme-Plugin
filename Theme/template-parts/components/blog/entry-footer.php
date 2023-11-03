<?php 
/**
 * Entry Footer in Wordpress the Loop
 *  php version 7.4.10
 *
 * @category Footer
 * @package  Vrcoder
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

$the_post_id = get_the_ID();
$article_terms = wp_get_post_terms($the_post_id, ['category','post_tag'], []);

if (empty($article_terms) || ! is_array($article_terms)) {
    return;
}

?>
<div class="mt-4 entry-footer">
    <?php 
    foreach ($article_terms as $article_term) {
        ?>
            <button class="btn border border-secondary mr-2 mb-2">
                <a class="entry-footer-link text-black-50" href="<?php echo esc_url(get_term_link($article_term)); ?>">
                    <?php echo esc_html($article_term->name); ?>
                </a>
            </button>
        <?php
    } 
    ?>
</div>