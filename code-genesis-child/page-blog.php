<?php
/**
 * Code Genesis Child.
 *
 * Template Name: Blog Grid
 *
 * @package Code Genesis Child
 * @author  LongViet
 * @license GPL-2.0-or-later
 * @link    https://longvietweb.com/
 */

add_filter( 'body_class', 'blog_add_body_class' );
function blog_add_body_class( $classes ) {
	$classes[] = 'blog-page';
	return $classes;
}
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
genesis();