<?php
/**
 * Code Genesis Child.
 *
 * This file adds functions to the Code Genesis Child Theme.
 *
 * @package Code Genesis Child
 * @author  LongViet
 * @license GPL-2.0-or-later
 * @link    https://longvietweb.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Child themes info
define( 'CHILD_THEME_HANDLE', sanitize_title_with_dashes( wp_get_theme()->get( 'Name' ) ) );
define( 'CHILD_THEME_VERSION', wp_get_theme()->get( 'Version' ) );

add_action( 'after_setup_theme', 'genesis_child_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_child_localization_setup() {

	load_child_theme_textdomain( 'genesis-child', get_stylesheet_directory() . '/languages' );

}
// Add Featured Posts List.
include_once( get_stylesheet_directory() . '/lib/featured-posts.php' );

// Add Function.
include_once( get_stylesheet_directory() . '/lib/functions.php' );

// Add Hook.
include_once( get_stylesheet_directory() . '/lib/hook.php' );

// Enqueue required fonts, scripts, and styles.
add_action( 'wp_enqueue_scripts', 'genesis_child_enqueue_scripts' );
function genesis_child_enqueue_scripts() {
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Roboto:300,400|Raleway:400,500,900', array(), CHILD_THEME_VERSION );
	wp_enqueue_script( 'genesis-child', get_stylesheet_directory_uri() . '/assets/js/genesis-child.js', array( 'jquery' ), CHILD_THEME_VERSION );
	wp_enqueue_script( 'theia-sticky-sidebar', get_stylesheet_directory_uri() . '/assets/js/theia-sticky-sidebar.js', array( 'jquery' ), CHILD_THEME_VERSION );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'genesis_child-responsive-menu', get_stylesheet_directory_uri() . '/assets/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'genesis_child-responsive-menu',
		'genesis_responsive_menu',
		genesis_child_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function genesis_child_responsive_menu_settings() {

	$settings = array(
		'mainMenu'    => __( 'Menu', 'genesis_child' ),
		'subMenu'     => __( 'Submenu', 'genesis_child' ),
		'menuClasses' => array(
			'combine' => array(
				'.nav-primary',
				'.nav-secondary',
			),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add image sizes.
add_image_size( 'sidebar-thumbnail', 100, 100, true );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'default-text-color' => '000000',
	'flex-height'        => true,
	'header-selector'    => '.site-title a',
	'header-text'        => false,
	'height'             => 180,
	'width'              => 760,
) );

// Rename menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Before Header Menu', 'genesis_child' ), 'secondary' => __( 'After Header Menu', 'genesis_child' ) ) );

// Remove skip link for primary navigation.
add_filter( 'genesis_skip_links_output', 'genesis_child_skip_links_output' );
function genesis_child_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}

	$new_links = $links;
	array_splice( $new_links, 1 );

	if ( has_nav_menu( 'secondary' ) ) {
		$new_links['genesis-nav-secondary'] = __( 'Skip to secondary menu', 'genesis_child' );
	}

	return array_merge( $new_links, $links );

}

// Add ID to secondary navigation.
add_filter( 'genesis_attr_nav-secondary', 'genesis_child_add_nav_secondary_id' );
function genesis_child_add_nav_secondary_id( $attributes ) {

	$attributes['id'] = 'genesis-nav-secondary';

	return $attributes;

}

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

add_filter( 'genesis_author_box_gravatar_size', 'genesis_child_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 1.0
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_child_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_child_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 1.0
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_child_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}
// Updates theme settings on reset.
add_filter( 'genesis_theme_settings_defaults', 'genesis_child_theme_defaults' );
function genesis_child_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 5;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 380;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['image_size']                = 'thumbnail';
	$defaults['posts_nav']                 = 'prev-next';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}
// Updates theme settings on activation.
add_action( 'after_switch_theme', 'genesis_child_theme_setting_defaults' );
function genesis_child_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 5,
			'content_archive'           => 'full',
			'content_archive_limit'     => 380,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignleft',
			'image_size'                => 'thumbnail',
			'posts_nav'                 => 'prev-next',
			'site_layout'               => 'content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 5 );

}