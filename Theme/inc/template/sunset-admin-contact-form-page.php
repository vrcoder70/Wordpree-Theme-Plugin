<?php

/**
 * File is used for Defining HTML Structure for admin page.
 * php version 7.4.10
 *
 * @category Settings_Page
 * @package  Vrcoder
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

?>
<h1>Sunset Contact Form</h1>
<?php settings_errors(); ?>

<p> Use <strong>Shortcode :- "[contact_form]"</strong> for printing contant form on front page.</p> 

<form method="post" action="options.php" class="sunset-general-form">
    <?php settings_fields('sunset-contact-options'); ?>
    <?php do_settings_sections('vrcoder_sunset_contact_form'); ?>
    <?php submit_button();?>
</form>