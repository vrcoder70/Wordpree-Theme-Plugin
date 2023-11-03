<?php 

/**
 * Comments
 * php version 7.4.10
 *
 * @category Comments.
 * @package  Sunset-Theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/Cyber-Vrcoder
 */

if (post_password_required()) {
    return;
}

?>

<div class="comments-area" id="comments">

    <?php if (have_comments()) : // We have comments.?>
        <h2 class="comment-title">
            <?php 

                //_nx( $single:string, $plural:string, $number:integer, $context:string, $domain:string )
                printf(
                    esc_html(_nx('On comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'vrcoder')),
                    number_format_i18n(get_comments_number()),
                    '<span>' . get_the_title() . '</span>'
                );

            ?> 
        </h2>

        <?php sunsetGetCommentNavigation(); ?>

        <ol class="comments-list">
            <?php 
            $args = [
                'walker'            => null,
                'max_depth'         => '',
                'style'             => 'ol',
                'callback'          => null,
                'end-callback'      => null,
                'type'              => 'all',
                'reply_text'        => 'Reply',
                'page'              => '',
                'per_page'          => '',
                'avatar_size'       => 50,
                'reverse_top_level' => null,
                'reverse_children'  => '',
                'format'            => 'html5',
                'short_ping'        => false,
                'echo'              => true,
            ];
            wp_list_comments($args);
            ?>
        </ol>

        <?php sunsetGetCommentNavigation(); ?>

        <?php if (comments_open() && get_comments_number()) :?>
                <p class="no-comments"> <?php esc_html_e('Comments Are Closed.', 'vrcoder'); ?> </p>
        <?php endif; ?>
            
    <?php endif; ?>
    
    <?php 
    
    $fields = [
        'author' =>
            '<div class="form-group"><label for="author">' . __('Name', 'domainreference') . '</label> <span class="required">*</span> <input id="author" name="author" type="text" class="form-control" value="' . esc_attr($commenter['comment_author']) . '" required="required" /></div>',
            
        'email' =>
            '<div class="form-group"><label for="email">' . __('Email', 'domainreference') . '</label> <span class="required">*</span><input id="email" name="email" class="form-control" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" required="required" /></div>',
            
        'url' =>
            '<div class="form-group last-field"><label for="url">' . __('Website', 'domainreference') . '</label><input id="url" name="url" class="form-control" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" /></div>'
    ];

    $args = [
        'class_submit'  => 'btn btn-block btn-lg btn-outline-primary',
        'label_submit'  => __('Comment on Post', 'vrcoder'),
        'comment_field' =>'<div class="form-group"><label for="comment">' . _x('Comment', 'noun') . '</label> <span class="required">*</span><textarea id="comment" class="form-control" name="comment" rows="4" required="required"></textarea></p>',
        'fields'        => apply_filters('comment_form_default_fields', $fields),
    ];
    
    comment_form($args); 
    
    ?>
</div><!-- .comments-area -->