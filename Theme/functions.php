<?php
/**
 * Vrcoder theme's functions and definitions
 * php version 7.4.10
 *
 * @category Defination
 * @package  Vrcoder
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

if (! defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

if (! defined('SUNSET_DIR_PATH') ) {
    define('SUNSET_DIR_PATH', untrailingslashit(get_template_directory()));
}

if (! defined('SUNSET_DIR_URI') ) {
    define('SUNSET_DIR_URI', untrailingslashit(get_template_directory_uri()));
}

require_once SUNSET_DIR_PATH . '/inc/helpers/cleanup.php';
require_once SUNSET_DIR_PATH . '/inc/helpers/autoloader.php';
require_once SUNSET_DIR_PATH . '/inc/helpers/template-tags.php';
require_once SUNSET_DIR_PATH . '/inc/helpers/ajax.php';

/**
 *  Function used to load all the features of Vrcoder theme
 * 
 * @return null
 */
function Vrcoder_Get_Theme_instance() 
{
    \SUNSET_THEME\Inc\SUNSET_THEME::getInstance();
}

Vrcoder_Get_Theme_instance();