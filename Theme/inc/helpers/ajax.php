<?php 
/**
 * Ajax class used for dynamic loading. 
 * php version 7.4.10
 *
 * @category Ajax
 * @package  Sunset-theme
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */


/**
 * This function is used for trigger ajax load button.
 * 
 * @return null
 */
function sunsetLoadMore()
{
    $paged = $_POST["page"]+1;
    $prev = $_POST["prev"];
    $archive = $_POST["archive"];

    //echo $prev;

    if ($prev == 1 && $_POST["page"] != 1) {
        $paged = $_POST["page"]-1;
    }
    
    $args = [
        'post_type'   => 'post',
        'post_status' => 'publish',
        'paged'       => $paged
    ];

    if ($archive != '0') {
        
        $archVal = explode('/', $archive);
        //print_r($archVal);

        $flipped = array_flip($archVal);

        switch (isset($flipped)) {

        case $flipped["category"] :
            $type = "category_name";
            $key = "category";
            break;

        case $flipped["tag"] :
            $type = "tag";
            $key = $type;
            break;

        case $flipped["author"] :
            $type = "author";
            $key = $type;
            break;

        }
        
        $currKey = array_keys($archVal, $key);
        $nextKey = $currKey[0]+1;
        $value = $archVal[ $nextKey ];
        
        $args[ $type ] = $value;

        // // Check if Category
        // if (in_array('category', $archVal)) {
        //     $type = 'category_name';
        //     $current_key = array_keys($archVal, 'category');
        //     //var_dump($current_key);
        //     $next_key = $current_key[0]+1;
        //     $value = $archVal[$next_key];

        //     $args[$type] = $value;
        // }   

        // // Check if Tag
        // if (in_array('tag', $archVal)) {
        //     $type = 'tag';
        //     $current_key = array_keys($archVal, 'tag');
        //     //var_dump($current_key);
        //     $next_key = $current_key[0]+1;
        //     $value = $archVal[$next_key];

        //     $args[$type] = $value;
        // }   

        // // Check if Author
        // if (in_array('author', $archVal)) {
        //     $type = 'author';
        //     $current_key = array_keys($archVal, 'author');
        //     //var_dump($current_key);
        //     $next_key = $current_key[0]+1;
        //     $value = $archVal[$next_key];

        //     $args[$type] = $value;
        // }   

        
        //check page trail and remove "page" value
        if (in_array("page", $archVal)) {
            $pageVal = explode('page', $archive);
            $page_trail = $pageVal[0];
        } else {
            $page_trail = $archive;
        }
        
        // $type = ($archVal[1] == 'category' ) ? 'category_name' : $archVal[1];
        // $args[$type] = $archVal[2];
        // $page_trail = '/' . $archVal[1] . '/' . $archVal[2] . '/';


    } else {
        $page_trail = '/';
    }

    $query = new WP_Query($args);
        
    if ($query->have_posts()) :

        echo '<div class="page-limit" data-page=" ' . $page_trail . 'page/'. $paged .'/">';
                        
        while( $query->have_posts() ): $query->the_post();
        
            get_template_part('template-parts/content', get_post_format());
        
        endwhile;
        
        echo '</div>';

    else :
            echo '0';
    endif;
        
    wp_reset_postdata();

    // Always remeber to put die() in the end of ajax function.
    die();
}

add_action('wp_ajax_nopriv_sunsetLoadMore', 'sunsetLoadMore');
add_action('wp_ajax_sunsetLoadMore', 'sunsetLoadMore');

/**
 * This function is used for trigger ajax load button.
 *  
 * @param $num 
 * 
 * @return $output
 */
function sunsetCheckPaged($num = null)
{
    $output = '';

    if (is_paged()) {
        $output = 'page/' . get_query_var('paged');
    }

    if ($num == 1) {
        $paged = (get_query_var('paged') == 0 ? 1 : get_query_var('paged'));
        return $paged;
    } else {
        return $output;
    }

}   


add_action('wp_ajax_nopriv_sunsetSaveContactForm', 'sunsetSaveContactForm');
add_action('wp_ajax_sunsetSaveContactForm', 'sunsetSaveContactForm');

/**
 * This function is used for trigger ajax Save contact form.
 * 
 * @return null
 */
function sunsetSaveContactForm()
{
    $name = wp_strip_all_tags($_POST["name"]);
    $email = wp_strip_all_tags($_POST["email"]);
    $message = wp_strip_all_tags($_POST["message"]);

    //echo $name . $email . $message;

    $post_args = [
        'post_title' => $name,
        'post_content' => $message,
        'post_author' => 1,
        'post_status' => 'publish',
        'post_type' => 'sunset-contact',
        'meta_input' => ['_email_key' => $email,],
    ];

    // Use WP_ERROR on second arguments in Development mode.
    $post_id =  wp_insert_post($post_args, $wp_error);

    if ($post_id !== 0) {
        
        $to = get_bloginfo('admin_email');
        $subject = 'Sunset Contact Form :- ' . $name;
        $headers[] = 'From: ' . get_bloginfo('name') . '<' . $to . '>';
        $headers[] = 'Replay-To: ' . $name . '<' . $email . '>';
        $headers[] = 'Content-Type: text/html: charset=UTF-8';

        wp_mail($to, $subject, $message, $headers);
        echo $post_id;
    } else {
        echo 0;
    }

    die();
    
}
