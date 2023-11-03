<?php

/**
 * This file contain html template of custom admin settings page.
 *
 * @link      
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/html
 */

/**
 * This file contain html template of custom admin settings page.
 *
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/html
 * @author     Vraj Rana vrcoder1998@gmail.com
 */


?>
<div>
    <h1>Book Post Type Details</h1>
    <?php settings_errors();?>
    <form action="options.php" method="post">
        <?php 
            settings_fields( 'wp_book_plugin_group' );
            do_settings_sections( 'books_menu' );
            submit_button();
        ?>
    </form>

</div>