<?php

/**
 * This file contain code of callback variable of settings page
 *
 * @link      
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/callback
 */

/**
 * This file implement sanitize callback,section call back and fields callback of settings api
 * with Ui callback of settings page class.
 *
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 * @author     Vraj Rana vrcoder1998@gmail.com
 */

class AdminSettingPageCallback{

    /**
     * Sanitixe_callback 
     *
     * @param array $input
     * @return array of $output
     */
    public function sanitize_callback($input){
        
        $output = $input;
        // sanitize output
        return $output;
    }

    /**
     * section callack
     *
     * Conatin details about settings section
     * @return void
     */
    public function section_callback(){
        echo '<p>Settings related custom post type</p>';
    }

    /**
     * Callback for select type input
     *
     * @param array $args
     * @return void
     */
    public function select_callback($args){
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $select = get_option( $option_name );
        $selected = isset($select[$name]) ? $select[$name] : null;
        $options = $args['options'];
        echo '<select id="' . $name . '" name="' . $option_name . '[' . $name . ']">';
        foreach($options as $option){
            if( $option === $selected ){
                echo '<option selected>'. $option .'</option>';
            }else{
                echo '<option>'. $option .'</option>';
            }
        }
        echo '</select>';
    }

    /**
     * Callback for checkbox input
     *
     * @param array $args
     * @return void
     */
    public function checkbox_callback($args){
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $checkbox = get_option( $option_name );
        $checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;
        echo '<input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ($checked ? 'checked' : '') . '>';
    }

    /**
     * Callback for text,number input as per $args 
     *
     * @param array $args
     * @return void
     */
    public function textfield_callback($args){

        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
        $value = isset($input[$name]) ? $input[$name] : null ;
        echo '<input type="'.$args['type'].'" id="' . $name . '" name="' . $option_name .'[' . $name . ']" value="' . $value . '" placeholder="'.$args['placeholder'].'">';
    }

    /**
     * Settings page callback
     *
     * @return void
     */
    public function page_callback(){
        require_once WP_BOOK_PLUGIN_PATH . 'templates/html/adminpage.php';
    }

}