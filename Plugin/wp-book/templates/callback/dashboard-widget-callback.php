<?php

/**
 * The file defines callback for dashboard widget
 *
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/callback
 */

/**
 * This file define all the necessary code for UI of Dashboard Widgets.
 * 
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/callback
 * @author     Vraj Rana vrcoder1998@gmail.com
 */


class DashboardWidgetCallback{
    
    public function dashboard_ui(){
        global $wpdb;
        $results = $wpdb->get_results("SELECT t.name 
                                       FROM wp_terms AS t 
                                       JOIN(
                                           SELECT DISTINCT term_id 
                                           FROM wp_term_taxonomy
                                           ORDER BY count DESC
                                           LIMIT 5
                                        ) AS tt ON t.term_id = tt.term_id");
        
        $wpdb->show_errors(); 
        $wpdb->hide_errors(); 
        echo '<h1>Top 5 Book Categories</h1>';

        foreach($results as $result){
            echo '<p>'. $result->name .'</p>';
        }
    }
}