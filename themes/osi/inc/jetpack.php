<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package osi
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
function osi_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support(
		'infinite-scroll',
		array(
			'container' => 'content-scroll',
			'render'    => 'osi_infinite_scroll_render',
			'footer'    => 'page',
		)
	);

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Social Menu
	add_theme_support( 'jetpack-social-menu' );

	/**
	* Jetpack support
	*/
	add_theme_support(
		'jetpack-content-options',
		array(
			'blog-display'       => array( 'content', 'excerpt' ), // the default setting of the theme: 'content', 'excerpt' or array( 'content', 'excerpt' ) for themes mixing both display.
			'author-bio'         => true, // display or not the author bio: true or false.
			'author-bio-default' => false, // the default setting of the author bio, if it's being displayed or not: true or false (only required if false).
			'masonry'            => '.site-main', // a CSS selector matching the elements that triggers a masonry refresh if the theme is using a masonry layout.
			'post-details'       => array(
				'stylesheet' => 'osi-style', // name of the theme's stylesheet.
				'date'       => '.byline--date', // a CSS selector matching the elements that display the post date.
				'categories' => '.post--metadata', // a CSS selector matching the elements that display the post categories.
				'tags'       => '.post--metadata', // a CSS selector matching the elements that display the post tags.
				'author'     => '.byline--author', // a CSS selector matching the elements that display the post author.
				'comment'    => '.comments--respond', // a CSS selector matching the elements that display the comment link.
			),
			'featured-images'    => array(
				'archive'         => false, // enable or not the featured image check for archive pages: true or false.
				'archive-default' => true, // the default setting of the featured image on archive pages, if it's being displayed or not: true or false (only required if false).
				'post'            => false, // enable or not the featured image check for single posts: true or false.
				'post-default'    => true, // the default setting of the featured image on single posts, if it's being displayed or not: true or false (only required if false).
				'page'            => false, // enable or not the featured image check for single pages: true or false.
				'page-default'    => true, // the default setting of the featured image on single pages, if it's being displayed or not: true or false (only required if false).
			),
		)
	);
}
add_action( 'after_setup_theme', 'osi_jetpack_setup' );

/**
 * Jetpack author bio size
 */
function osi_author_bio_avatar_size() {
	return 60; // in px
}
add_filter( 'jetpack_author_bio_avatar_size', 'osi_author_bio_avatar_size' );

/**
 * Custom render function for Infinite Scroll.
 */
function osi_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content', 'search' );
		else :
			get_template_part( 'template-parts/content', get_post_type() );
		endif;
	}
}

// Add Shortcode
function jetpack_social_shortcode() {
	if ( function_exists( 'jetpack_social_menu' ) ) {
		ob_start();
		jetpack_social_menu();
		return ob_get_clean();
	}
}
add_shortcode( 'jetpack-social', 'jetpack_social_shortcode' );