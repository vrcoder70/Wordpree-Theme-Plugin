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

<form method="post" action="#" id="sunset-contact-form" class="sunset-contact-form" data-url=<?php echo admin_url('admin-ajax.php'); ?>>

    <!-- <div class="text-center send-image-contact-form"></div> -->

    <div class="form-group">
        <input type="text" name="name" id="name" class="form-control sunset-form-control" placeholder="Name" required="required">
        <small class="text-danger form-control-msg">Your Name is Required</small>
    </div>

    <div class="form-group">
        <input type="email" name="email" id="email" class="form-control sunset-form-control" placeholder="Email" required="required">
        <small class="text-danger form-control-msg">Your Email is Required</small>
    </div>

    <div class="form-group">
        <textarea type="text" name="message" id="message" class="form-control sunset-form-control" placeholder="Message" required="required"></textarea>
        <small class="text-danger form-control-msg">Your Message is Required</small>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-default btn-lg btn-sunset-form">Submit</button>
        <small class="text-info form-control-msg js-form-submission">Submission in process, Please wait...</small>    
        <small class="text-success form-control-msg js-form-success">Message submitted successfully, Thank You!</small>    
        <small class="text-danger form-control-msg js-form-error">There was some error in contact form, Please try again.</small>    
    </div>
        
</form>
