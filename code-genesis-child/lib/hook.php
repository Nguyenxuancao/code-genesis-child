<?php
/**
 * Code Genesis Child.
 *
 * This file adds Hook to the Code Genesis Child Theme.
 *
 * @package Code Genesis Child
 * @author  LongViet
 * @license GPL-2.0-or-later
 * @link    https://longvietweb.com/
 */

// Reposition the primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Add primary-nav class if primary navigation is used.
add_filter( 'body_class', 'genesis_child_no_nav_class' );

// Customize search form input box text.
add_filter( 'genesis_search_text', 'genesis_child_search_text' );

// Remove entry meta in entry footer.
add_action( 'genesis_before_entry', 'genesis_child_remove_entry_meta' );

// Relocate after entry widget.
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_entry_footer', 'genesis_after_entry_widget_area' );

// Home breadcrumb icon.
add_filter ( 'genesis_home_crumb', 'genesis_child_breadcrumb_home_icon' ); 

//* Modify breadcrumb arguments.
add_filter( 'genesis_breadcrumb_args', 'genesis_child_breadcrumb_args' );

// Remove navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'genesis_child_remove_genesis_metaboxes' );

// Display author box on single posts.
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );
add_action( 'genesis_entry_footer', 'genesis_do_author_box_single', 21 );

// Replace h4 with h3 for all widget titles
add_filter( 'genesis_register_sidebar_defaults', 'genesis_child_register_sidebar_defaults' );

// Wrap first word of widget title into a span tag.
add_filter ( 'widget_title', 'genesis_child_add_span_widgets' );

// Main function to diplay on front end
add_action( 'genesis_before_content', 'featuredpostsList' );

// Create theiaStickySidebar .
add_action( 'genesis_before_sidebar_widget_area', 'theiaStickySidebar_before' );
add_action( 'genesis_after_sidebar_widget_area', 'theiaStickySidebar_after' );

// Add Previous & Next Links in Genesis Single Post Page.
add_action('genesis_entry_footer', 'genesis_post_navigation', 20 );

// Create Social Share Buttons .
add_action( 'genesis_entry_footer', 'socialshare_buttons', 18 );
add_action( 'genesis_entry_footer', 'related_post_category', 40 );