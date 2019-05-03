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
 
// Remove navigation meta box.
function genesis_child_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}
// Add primary-nav class if primary navigation is used.
function genesis_child_no_nav_class( $classes ) {

	$menu_locations = get_theme_mod( 'nav_menu_locations' );

	if ( ! empty( $menu_locations['primary'] ) ) {
		$classes[] = 'primary-nav';
	}

	return $classes;

}

// Customize search form input box text.
function genesis_child_search_text( $text ) {
	return esc_attr( __( 'Search the site ...', 'genesis_child' ) );
}

// Remove entry meta in entry footer.
function genesis_child_remove_entry_meta() {

	// Remove if not single post.
	if ( ! is_single() ) {
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
	}

}

// Create theiaStickySidebar .
if ( ! function_exists( 'theiaStickySidebar_before' ) ):
function theiaStickySidebar_before() {
	?><div class="theiaStickySidebar"><?php
}
endif;
if ( ! function_exists( 'theiaStickySidebar_after' ) ):
function theiaStickySidebar_after() {
	?></div><?php
}
endif;

// Replace h4 with h3 for all widget titles
function genesis_child_register_sidebar_defaults( $defaults ) {
	$defaults['before_title'] = '<div class="genesis-child-widget-title"><h3 class="widgettitle widget-title">';
	$defaults['after_title'] = '</h3></div>';
	return $defaults;
}

// Wrap first word of widget title into a span tag.
function genesis_child_add_span_widgets( $old_title ) {
  
  $title = explode( " ", $old_title, 2 );
	
	if ( isset( $title[0] ) && isset( $title[1] ) ) {
		$titleNew = "<span>$title[0]</span> $title[1]";
	}
	else {
		return;
	}
	
	return $titleNew;
}

// Home breadcrumb icon.
function genesis_child_breadcrumb_home_icon( $crumb ) {
     $crumb = '<a href="' . home_url() . '" title="' . get_bloginfo('name') . '"><i class="dashicons dashicons-admin-home"></i> Home</a>';
     return $crumb;
}
//* Modify breadcrumb arguments.
function genesis_child_breadcrumb_args( $args ) {
	$args['home'] = 'Home';   // Can be changed by adding text in quotation marks ' '
	$args['sep'] = ' / ';     // Can be changed by adding text in quotation marks ' '
	$args['list_sep'] = ', '; // Can be changed by adding text in quotation marks ' '
	$args['prefix'] = '<div class="breadcrumb"><div class="wrap">'; // Can be changed by adding text in quotation marks ' '
	$args['suffix'] = '</div></div>';
	$args['heirarchial_attachments'] = true; // Can be changed by adding text in quotation marks ' ' Genesis 1.5 and later
	$args['heirarchial_categories'] = true;  // Can be changed by adding text in quotation marks ' ' Genesis 1.5 and later
	$args['display'] = true;
	$args['labels']['prefix'] = '';  // Can be changed by adding text in quotation marks ' '
	$args['labels']['author'] = 'Archives for ';   // Can be changed by adding text in quotation marks ' '
	$args['labels']['category'] = 'Archives for '; // Can be changed by adding text in quotation marks ' ' Genesis 1.6 and later
	$args['labels']['tag'] = 'Archives for ';      // Can be changed by adding text in quotation marks ' '
	$args['labels']['date'] = 'Archives for ';     // Can be changed by adding text in quotation marks ' '
	$args['labels']['search'] = 'Search for ';     // Can be changed by adding text in quotation marks ' '
	$args['labels']['tax'] = 'Archives for ';      // Can be changed by adding text in quotation marks ' '
	$args['labels']['post_type'] = 'Archives for ';// Can be changed by adding text in quotation marks ' '
	$args['labels']['404'] = 'Not found: ';        // Can be changed by adding text in quotation marks ' ' Genesis 1.5 and later
return $args;
}

// Add Previous & Next Links in Genesis Single Post Page.
function genesis_post_navigation() {
    if ( is_single ( ) ) {
	    ?>
        <div class="adjacent-entry-pagination pagination">
            <div class="pagination-previous alignleft">
				<span class="prev"><?php _e( 'Previous Post', 'favorite-pro' ); ?></span><br><?php previous_post_link('%link', '%title'); ?>
            </div>
            <div class="pagination-next alignright">
				<span class="next"><?php _e( 'Next Post', 'favorite-pro' ); ?></span><br><?php next_post_link('%link', '%title'); ?>
            </div>
        </div>
        <?php
    } 
}

// Select posts in the same categories as the current post.
if ( ! function_exists( 'related_post_category' ) ):
function related_post_category() {
	if ( is_single ( ) ) {
		// Get a list of the current post's categories
		global $post;
		$categories = get_the_category($post->ID);
		if ($categories) {
			$category_ids = array();
			foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
	 
			$args=array(
				'category__in' => $category_ids,
				'post__not_in' => array($post->ID), // Ensure that the current post is not displayed
				'posts_per_page' => 3, // Number of related posts to display
				'orderby' => 'rand', // Randomize the results
			);
			$my_query = new wp_query($args);
			if( $my_query->have_posts() ): $i = 0; ?>
				<div class="related-posts-container"><div class="related-posts-title-block"><h3 class="related-posts-title"><?php _e( 'Related Articles', 'longviet' );?></h3></div>
					<div class="related-posts-inner"><ul class="related-posts-blook">
					<?php while ($my_query->have_posts()):$my_query->the_post();  ?>
						<li class="related-posts-<?php echo $i; ?>">
							<div class="related-posts-img"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
								<span class="entry-time"><?php echo esc_html( get_the_date() ) ?></span></div>
							<div class="item-details">
								<h4 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
							</div>
						</li> <?php $i ++; ?>
					<?php endwhile;  ?>
				<?php else : ?>
				<p><?php _e( 'Sorry, no related articles to display', 'longviet' );?></p>
				</ul></div></div>
			<?php endif; 
			wp_reset_postdata(); // Reset postdata
		}
	}
}
endif;

// Create Social Share Buttons .
if ( ! function_exists( 'socialshare_buttons' ) ):
function socialshare_buttons() {
	if( is_single( ) ) {
		// Get current page URL 
		$longvietURL = urlencode(get_permalink());

		// Get current page title
		$longvietTitle = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
		
		// Get Post Thumbnail for pinterest
		$longvietThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

		// Construct sharing URL without using any script
		$twitterURL = 'https://twitter.com/intent/tweet?text='.$longvietTitle.'&amp;url='.$longvietURL;
		$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$longvietURL;
		$bufferURL = 'https://bufferapp.com/add?url='.$longvietURL.'&amp;text='.$longvietTitle;
		$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$longvietURL.'&amp;title='.$longvietTitle;
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$longvietURL.'&amp;media='.$longvietThumbnail[0].'&amp;description='.$longvietTitle;

		// Add sharing button at the end of page/page content
		$content='<div class="longviet-social">
			<div class="longviet-link social-title"><h5>SHARE ON</h5></div>
			<a class="longviet-link longviet-twitter" href="'. $twitterURL .'" target="_blank">Twitter</a>
			<a class="longviet-link longviet-facebook" href="'.$facebookURL.'" target="_blank">Facebook</a>
			<a class="longviet-link longviet-buffer" href="'.$bufferURL.'" target="_blank">Buffer</a>
			<a class="longviet-link longviet-linkedin" href="'.$linkedInURL.'" target="_blank">LinkedIn</a>
			<a class="longviet-link longviet-pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank">Pin It</a>
		</div>';
		echo $content;
	}
}
endif;
