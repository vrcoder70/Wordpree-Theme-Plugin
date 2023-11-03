<?php

/**
 * Assignment theme's Teplates parts functions which are used in various classes.
 * php version 7.4.10
 *
 * @category Template_Parts
 * @package  Vrcoder
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */


/**
 * Fuction to get custom Thumbnails
 * 
 * @param $post_id              :- It is the id of the Post
 * @param $size                 :- register size of featured image 
 * @param $addtional_attributes :- Addition attributes provided by programmer while using this functions 
 * 
 * @return custom_thumbnail
 */
function Get_The_Post_Custom_thumbnail( $post_id, $size = 'featured-thumbnail', $addtional_attributes = [] )
{

    $custom_thumbnail = '';

    if (null === $post_id) {
        $post_id = get_the_ID();
    }

    if (has_post_thumbnail($post_id)) {
        $default_attributes = [
            'loading' => 'lazy',
        ];
        
        $attributes = array_merge($addtional_attributes, $default_attributes);
        
        $custom_thumbnail = wp_get_attachment_image( 
            get_post_thumbnail_id($post_id),
            $size, 
            false,
            $attributes 
        );
    }
    return $custom_thumbnail;   
}

/**
 * Fuction is used to call "Get_The_Post_Custom_thumbnail" function and echo out the thumbnail to front end
 * 
 * @param $post_id              :- It is the id of the Post
 * @param $size                 :- register size of featured image 
 * @param $addtional_attributes :- Addition attributes provided by programmer while using this functions 
 * 
 * @return null
 */
function The_Post_Custom_thumbnail( $post_id, $size = 'featured-thumbnail', $addtional_attributes = [] )
{
    echo Get_The_Post_Custom_thumbnail($post_id, $size, $addtional_attributes);
}

/**
 * Fuction is used to get meta infromation like time and date of post when it posted, update time and
 * 
 * @return null
 */
function sunsetPostMeta() 
{
    $posted_on = human_time_diff(get_the_time('U'), current_time('timestamp'));

    $categories = get_the_category();
    $separator = ', ';
    $output = '';
    $i = 1;

    if(!empty($categories) ) :
        foreach ($categories as $category) :
            if ($i > 1) : $output .= $separator; 
            endif;
            $output .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" alt="' . esc_attr('View all posts in%s', $category->name) .'">' . esc_html__($category->name, 'vrcoder') .'</a>';
             $i++; 
        endforeach;
    endif;

    return '<span class="posted-on">Posted <a href="'. esc_url(get_permalink()) .'">' . $posted_on . '</a> ago</span>
     / <span class="posted-in">' . $output . '</span>';


}

/**
 * Fuction is used get and echo out author information.
 *   
 * @return null
 */
function sunsetPostedBy()
{

    $byline = sprintf(
        esc_html_x(' by %s', 'post author', 'vrcoder'),
        '<span class="author vcard"><a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) .'">' . esc_html(get_the_author()). '</a></spna>'
    );

    return '<span class="byline text-secondary">' . $byline . '</span>';

}

/**
 * Fuction is used to get meta infromation like time and date of post when it posted, update time and
 * 
 * @return null
 */
function sunsetPostedOn() 
{
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

    //post is modifed.
    if (get_the_time('U') !== get_the_modified_time('U')) {

        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>. <time class="updated" datetime="%3$s">%4$s</time>';

    }

    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date('DATE_W3C')), 
        esc_attr(get_the_date()),
        esc_attr(get_the_modified_date('DATE_W3C')),
        esc_attr(get_the_modified_date()),
    );
    
    $post_on = sprintf( 
        esc_html_x('Posted on %s', 'post date', 'vrcoder'),
        '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
    );
    echo '<span class="post-on text-secondary">' . $post_on . '</span>';
}

/**
 * Fuction echo out excerpt with [...] (read more) and strip out half words from display.
 * 
 * @param $trim_character_count :- if author want to show whole excerpt() instead of strips 
 *                              out some word it can pass or number, that how many words user 
 *                              wants to display.  
 *   
 * @return null
 */
function sunsetExcerpt( $trim_character_count = 0 )
{

    if (! has_excerpt() || 0 === $trim_character_count ) {
        the_excerpt();
        return;
    }

    $excerpt = wp_strip_all_tags(get_the_excerpt());
    $excerpt = substr($excerpt, 0, $trim_character_count);
    $excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));

    return $excerpt . ' [...]';

}

/**
 * Fuction is used display button on home of read more after the excerpt(), which will lead to single 
 * post page
 * 
 * @param $more :- It is used for storeing link to single page for display whole single post.
 *   
 * @return more
 */
function sunsetExcerptMore( $more = '' )
{
    if (! is_single()) {
        $more = sprintf(
            '<a class="vrcoder-read-more text-white" href="%1$s"><button class="mt-3 btn btn-info">%2$s</button></a>',
            get_permalink(get_the_ID()),
            __('Read more', 'vrcoder'),
        );
    }
    return $more;
}

/**
 * Fuction is used for pagination.
 *   
 * @return more
 */
function Vrcoder_pagination()
{

    $allowed_tags = [
        'span' => [
            'class' => []
        ],
        'a' => [
            'class' => [],
            'href'  => [],
        ]
    ];

    $args =[
        'before_page_number' => '<span class="btn border border-secondary mr-2 mb-2" >',
        'after_page_number'  => '</span>'
    ];

    printf(
        '<nav class="vrcoder-pagination clearfix">%s</nav>',
        wp_kses(paginate_links($args), $allowed_tags)
    );

}

/**
 * Fuction is return entry-footer content.
 * 
 * @param $onlycomments Upgraded for sidebars.  
 * 
 * @return null
 */
function sunsetPostFooter($onlycomments = false)
{

    $comments_number = get_comments_number();

    if (comments_open()) {
        if ($comments_number ===  0) {
            $comments = __('No Comments', 'vrcoder');
        } elseif ($comments_number > 1) {
            $comments = $comments_number . __('Comments', 'vrcoder');
        } else {
            $comments = __('1 Comment', 'vrcoder');
        }
        $comments = '<a class="comments-link" href="' . get_comments_link() . '">' . $comments . ' <span class="sunset-icon sunset-comment"></span></a>';

    } else {
        $comments = __('Comments are Closed', 'vrcoder');
    }

    if ($onlycomments) {
        return $comments;
    }

    return '<div class="post-footer-container"><div class="row">
        <div class="col-xs-12 col-sm-6">' . get_the_tag_list('<div class="tag-list"><span class="sunset-icon sunset-tag"></span>', ' ', '</div>'). '</div>
        <div class="col-xs-12 col-sm-6 text-right">' . $comments . '</div>
    </div></div>';
}

/**
 * Fuction is return Image attachments content.
 * 
 * @param $num     Number of attachement to get back.  
 * @param $post_id It is post id of ost
 * 
 * @return attachment Image
 */
function sunsetGetAttachment( $num = 1, $post_id= '' )
{
    // Reprogramm it before interview.

    $post_id = ($post_id == '' ? get_the_ID() : $post_id );

    $output = '';
    if (has_post_thumbnail() && $num == 1) : 
        $output = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
    else:
        $attachments = get_posts(
            [
            'post_type'      => 'attachment',
            'posts_per_page' => $num,
            'post_parent'    => $post_id
            ] 
        );
        if ($attachments && $num == 1) :
            foreach ($attachments as $attachment):
                $output = wp_get_attachment_url($attachment->ID);
            endforeach;
        elseif($attachments && $num > 1) :
            $output = $attachments;
        endif;

        wp_reset_postdata();
        
    endif;

    return $output;

}

/**
 * Fuction is return Image attachments content.
 *   
 * @param $type Array of media type
 * 
 * @return Media.
 */
function sunsetGetEmbeddedMedia( $type = [] )
{
    $content = do_shortcode(apply_filters('the_content', get_the_content()));
    $embed = get_media_embedded_in_content($content, $type);
    
    if (in_array('audio', $type)) :
        $output = str_replace('?visual=true', '?visual=false', $embed[0]);
    else :
        $output = $embed[0];
    endif;
    
    return $output;
}

/**
 * Fuction is return slides
 *   
 * @param $attachments Array of media type
 * 
 * @return Media.
 */
function sunsetGetBsSlides( $attachments )
{
    $output = [];

    $count = count($attachments) - 1; 
    for( $i = 0; $i <= $count; $i++ ): 
        $active = ( $i == 0 ? 'active' : '' );
        
        $n = ( $i == $count ? 0 : $i+1 );
        $nextImg = wp_get_attachment_thumb_url($attachments[$n]->ID);
        $p = ( $i == 0 ? $count : $i-1 );
        $prevImg = wp_get_attachment_thumb_url($attachments[$p]->ID);

        $output[$i] = [
            'class'      => $active,
            'url'        =>  wp_get_attachment_url($attachments[$i]->ID),
            'next_image' => $nextImg,
            'prev_image' => $prevImg,
            'caption'    => $attachments[$i]->post_excerpt,
        ];
    endfor; 

    return $output;
}

/**
 * Fuction is return Image attachments content.
 * 
 * @return URL
 */
function sunsetGrabUrl()
{
    if (! preg_match('/<a\s[^>]*?href=[\'"](.+?)[\'"]/i', get_the_content(), $links)) {
        return false;
    }
    return esc_url_raw($links[1]);

}

/**
 * Fuction is return Image attachments content.
 * 
 * @return whole site url.
 */
function sunsetGrabCurrentUrl()
{
    $http = ( isset($_SERVER["HTTPS"]) ? 'https://' : 'http://' );
    $referer = $http . $_SERVER["HTTP_HOST"];
    $archive_url = $referer . $_SERVER["REQUEST_URI"];

    return $archive_url;
}

/**
 * Sigle Post Custom Functions.
 * ============================
 */

/**
 * Fuction is used for Navigation on single.php
 * 
 * @return nav
 */
function sunsetpostNavigation()
{
    $nav ='<div class="row">';

    $prev = get_previous_post_link('<div class="post-link-nav"><span class="sunset-icon sunset-chevron-left" aria-hidden="true"></span> %link</div>', '%title');
    $nav .= '<div class="col-xs-12 col-sm-6">' . $prev . '</div>';

    $next = get_next_post_link('<div class="post-link-nav">%link <span class="sunset-icon sunset-chevron-right" aria-hidden="true"></span></div>', '%title');
    $nav .= '<div class="col-xs-12 col-sm-6 text-right">' . $next . '</div>';

    $nav .= '</div>';

    return $nav;
}

/**
 * Fuction is used for Navigation on single.php
 * 
 * @param $content It is content of single post page.
 * 
 * @return nav
 */
function sunsetShareIt($content)
{
    if (is_single()) {
        $content .= '<div class="sunset-shareThis"><h4>Share It</h4>';

        $title = get_the_title(); 
        $permalink = get_the_permalink();
    
        $twitter_handle = ( get_option('twitter_handler') ? '&amp;via=' . esc_attr(get_option('twitter_handler')) : '' );
        $twitter = 'https://twitter.com/intent/tweet?text= Hey! Check This Post:' . $title . '&amp;url=' . $permalink . $twitter_handle;
        $facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . $permalink;
        //$google = 'https://plus.google.com/share?url=' . $permalink;
    
        $content .= '<ul>';
        $content .= '<li><a href="' . $twitter . '" rel="nofollow" target="_blank"><span class="sunset-icon sunset-twitter"></span></a></li>';
        $content .= '<li><a href="' . $facebook . '" rel="nofollow" target="_blank"><span class="sunset-icon sunset-facebook"></span></a></li>';
        $content .= '</ul>';
        $content .= '</div><!-- .sunset-shareThis -->';
        
        return $content;
    } else {
        return $content;
    }
}
add_filter('the_content', 'sunsetShareIt');

/**
 * Fuction is used for Navigation on single.php for comments
 * 
 * @return navigation of comments Section
 */
function sunsetGetCommentNavigation()
{
    if (get_comment_pages_count() > 1 && get_option('page_comments')) :
        get_template_part('inc/template/sunset-comments-nav');
    endif;

}

// Edit Default Widgets.

/**
 * Fuction is used for Edit Default Widgets. Tag Cloud Font Size
 * 
 * @param $args 
 * 
 * @return tags arguments
 */
function sunsetTagCloudFontChange($args)
{
    $args['smallest'] = 8;
    $args['largest'] = 8;

    return $args;
}

add_filter('widget_tag_cloud_args', 'sunsetTagCloudFontChange');

/**
 * Fuction is used for Edit Default Widgets. Categories Count structure.
 * 
 * @param $links Links passed in ul>li in count of categories.
 * 
 * @return links of categories in widgets section but customized.
 */
function sunsetListCategoriesOutputChange($links)
{
    $links = str_replace('</a> (', '</a> <span>', $links);
    $links = str_replace(')', '</span>', $links);

    return $links;
}
add_filter('wp_list_categories', 'sunsetListCategoriesOutputChange');

/**
 * Fuction is used for saving Post views of perticulart post.
 * 
 * @param $postID Id of the perticular Post.
 * 
 * @return null
 */
function sunsetSavePostViews($postID)
{
    $meta_key = '_sunset_post_view';

    $views = get_post_meta($postID, $meta_key, true);

    $count = (empty($views) ? 0 : $views);
    $count++;

    update_post_meta($postID, $meta_key, $count);
    //echo $views;
}

remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

/**
 * Fuction is used for retrieving posts
 * 
 * @param $number Id of the perticular Post.
 * 
 * @return Custom Query. 
 */
function sunsetPostQuery($number)
{
    $posts_args = [
        'post_type'      => 'post',
        'posts_per_page' => $number,
        'meta_key'       => '_sunset_post_view',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC'
    ];

    $posts_query = new WP_Query($posts_args);

    return $posts_query;
}