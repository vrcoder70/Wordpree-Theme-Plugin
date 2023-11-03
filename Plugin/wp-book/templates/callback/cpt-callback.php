<?php

/**
* The file contain callback for custom post type.
*
* @since      1.0.0
*
* @package    WP_BOOK
* @subpackage WP_BOOK/templates/callback
*/

/**
* It is callback of subpage for  custom post type.
*
* @since      1.0.0
* @package    WP_BOOK
* @subpackage WP_BOOK/templates/base
* @author     Vraj Rana vrcoder1998@gmail.com
*/
class CPTCallback{

    public function subpage_callback(){
        ?>
            <h1>Books Shortcodes</h1>

            <p><code>[book id="Eg 1" author_name="Eg Vraj Rana" year="Eg 1998" category="Eg Sci-fi" tag="Eg power" publisher="Eg Vrcoder"]</code></p>

        <?php
    }
}