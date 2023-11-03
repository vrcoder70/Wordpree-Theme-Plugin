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
 * Fuction to remove version numbers.
 * 
 * @param $src 
 * 
 * @return custom_thumbnail
 */
function sunsetRemoveWPVersionStrings($src)
{
    global $wp_version;

    parse_str(parse_url($src, PHP_URL_QUERY), $query);

    if (!empty($query['ver']) && $query['ver'] === $wp_version) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

add_filter('script_loader_src', 'sunsetRemoveWPVersionStrings');
add_filter('style_loader_src', 'sunsetRemoveWPVersionStrings');


/**
 * Fuction to remove Meta tag Generators.
 * 
 * @return custom_thumbnail
 */
function sunsetRemoveMetaVersion()
{
    return '';
}
add_filter('the_generator', 'sunsetRemoveMetaVersion');