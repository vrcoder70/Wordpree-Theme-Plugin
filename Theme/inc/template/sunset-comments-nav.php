<?php 
/**
 * Comments Section Navigatin Templates.
 * php version 7.4.10
 *
 * @category Comments_Navigation.
 * @package  Vrcoder
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */
?>

<nav class="comment-navigation" role="navigation">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="post-link-nav">
                <span class="sunset-icon sunset-chevron-left" aria-hidden="true"></span>
                <?php previous_comments_link(esc_html__('Older Comments', 'vrcoder')); ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 text-right">
            <div class="post-link-nav">
                <?php next_comments_link(esc_html__('Newer Comments', 'vrcoder')); ?>
                <span class="sunset-icon sunset-chevron-right" aria-hidden="true"></span>
            </div>
        </div>
    </div><!-- .row -->
</nav>
