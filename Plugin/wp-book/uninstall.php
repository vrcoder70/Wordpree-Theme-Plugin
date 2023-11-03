<?php

/**
 * @package  wp-book
 * 
 * Fired when the plugin is uninstalled.
 *
 * Check Authority and clear database and delete database.
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

//clear Database.
global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type='book'" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN ( SELECT id FROM wp_posts )");
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN ( SELECT id FROM wp_posts )"); 
$wpdb->query( "DELETE FROM wp_options WHERE option_name = 'wp_book_plugin_name' ");
$wpdb->query( "DELETE FROM wp_terms WHERE term_id IN ( SELECT term_id FROM wp_term_taxonomy WHERE taxonomy='book_category OR taxonomy='book_tag')");
$wpdb->query( "DELETE FROM wp_term_taxonomy WHERE taxonomy='book_category' OR taxonomy='book_tag'");
