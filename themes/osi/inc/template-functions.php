<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package osi
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function osi_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Remove unnecessary classes
	$home_id_class  = 'page-id-' . get_option( 'page_on_front' );
	$remove_classes = array(
		'page-template-default',
		$home_id_class,
	);
	$classes        = array_diff( $classes, $remove_classes );

	return $classes;
}
add_filter( 'body_class', 'osi_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function osi_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'osi_pingback_header' );


/**
* Gets rid of current_page_parent class mistakenly being applied to Blog pages while on Custom Post Types
* via https://wordpress.org/support/topic/post-type-and-its-children-show-blog-as-the-current_page_parent
*/
function is_blog() {
	global $post;
	$posttype = get_post_type( $post );
	return ( ( 'post' === $posttype ) && ( is_home() || is_single() || is_archive() || is_category() || is_tag() || is_author() ) ) ? true : false;
}

function fix_blog_link_on_cpt( $classes, $item, $args ) {
	if ( ! is_blog() ) {
		$blog_page_id = intval( get_option( 'page_for_posts' ) );

		if ( 0 !== $blog_page_id && $item->object_id === $blog_page_id ) {
			if ( in_array( 'current_page_parent', $classes, true ) ) {
				unset( $classes[ array_search( 'current_page_parent', $classes, true ) ] );
			}
		}
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'fix_blog_link_on_cpt', 10, 3 );


/**
 * Add thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
function osi_caption( $output, $attr, $content ) {
	if ( is_feed() ) {
		return $output;
	}

	$defaults = array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => '',
	);

	$attr = shortcode_atts( $defaults, $attr );

	// If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
	if ( $attr['width'] < 1 || empty( $attr['caption'] ) ) {
		return $content;
	}

	// Set up the attributes for the caption <figure>
	$attributes  = ( ! empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="thumbnail wp-caption ' . esc_attr( $attr['align'] ) . '"';

	$output  = '<figure' . $attributes . '>';
	$output .= do_shortcode( $content );
	$output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
	$output .= '</figure>';

	return $output;
}
add_filter( 'img_caption_shortcode', 'osi_caption', 10, 3 );


/**
* remove width attribute of thumbnails
*/
function osi_remove_width_attribute( $html ) {
	$html = preg_replace( '/(width|height)="\d*"\s/', '', $html );
	return $html;
}
add_filter( 'post_thumbnail_html', 'osi_remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'osi_remove_width_attribute', 10 );

/**
* From http://wordpress.stackexchange.com/questions/115368/overide-gallery-default-link-to-settings
* Default image links in gallery (not the same as image_default_link_type)
*/
function osi_gallery_default_type_set_link( $settings ) {
		$settings['galleryDefaults']['link'] = 'file';
		return $settings;
}
add_filter( 'media_view_settings', 'osi_gallery_default_type_set_link' );


/**
* Remove the overly opinionated gallery styles
*/
add_filter( 'use_default_gallery_style', '__return_false' );


/**
* Inline Media Default assert_options
*/
function osi_inline_media_styles() {
	$styles = '';
	if ( get_custom_header() ) {
		$styles .= '.wp-block-cover { background-image:url(' . get_header_image() . ')}';
	}
	return $styles;
}

/**
 * Check if we're on the license search page
 */
if ( ! function_exists( 'is_license_search' ) ) {

	function is_license_search() {

		if ( ! isset( $_REQUEST['ls'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return false;
		}

		return true;
	}
}

/**
 * Get the license search query
 */
if ( ! function_exists( 'get_license_search_query' ) ) {

	function get_license_search_query() {

		$query = isset( $_REQUEST['ls'] ) ? $_REQUEST['ls'] : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		$query = sanitize_text_field( $query );

		return $query;
	}
}


// Meta Block Field Filter Date
add_filter( 'meta_field_block_get_block_content', 'osi_filter_meta_block_date_output', 10, 4 );
function osi_filter_meta_block_date_output( $content, $attributes, $block, $post_id ) {
	if ( is_numeric( $content ) && 8 === strlen( $content ) ) {
		$content = DateTime::createFromFormat( 'Ymd', $content )->format( 'M Y' );
	}
	return $content;
}

// Order Press Mentions by Publication Date
add_action( 'pre_get_posts', 'osi_press_mentions_by_publication_date' );
function osi_press_mentions_by_publication_date( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {
		if ( is_post_type_archive( 'press-mentions' ) ) {
			$query->set( 'meta_key', 'date_of_publication' );
			$query->set( 'orderby', 'meta_value_num' );
			$query->set( 'order', 'DESC' );
			$query->set(
				'meta_query',
				array(
					array(
						'key'  => 'date_of_publication',
						'type' => 'numeric',
					),
				)
			);
		}
	}
	return $query;
}

/**
* Renders the "Created" and "Last modified" string for a page.
*/

function osi_the_page_dates() {
	if ( is_page() && ! is_home() && ! is_front_page() ) {
		$max_date = '2023-02-01'; // February 1, 2023
		$created  = get_the_date( 'F j, Y' );
		$modified = get_the_modified_date( 'F j, Y' );

		if ( strtotime( $created ) < strtotime( $max_date ) ) {
			// Post was created before the 'max date'.
			echo sprintf( '<h4 class="page_dates">Page created on %1$s | Last modified on %2$s</h4>', esc_html( $created ), esc_html( $modified ) );
		}
	}
}

/**
 * Force external links to open in new tab.
 *
 * @param string $content The content to process.
 *
 * @return string The processed content.
 */
function osi_the_content( $content ) {
	if ( ! em_is_event_rsvpable() ) {
		// Instantiate the processor.
		$processor = new \WP_HTML_Tag_Processor( $content );

		// Get the domain of the site without scheme.
		$site_domain = wp_parse_url( site_url(), PHP_URL_HOST );

		// Loop through all the A tags and parse href to see if it's an external link.
		while ( $processor->next_tag( 'A' ) ) {
			$href        = $processor->get_attribute( 'href' );
			$root_domain = wp_parse_url( $href, PHP_URL_HOST );

			// If root domain is null, it's an internal link (no host), skip.
			if ( null === $root_domain ) {
				continue;
			}

			// If the root domain is not the same as the site domain, it's an external link.
			if ( $root_domain !== $site_domain ) {
				$processor->set_attribute( 'target', '_blank' );
			}
		}

		return $processor->get_updated_html();
	}

	return $content;
}

add_filter( 'the_content', 'osi_the_content' );
