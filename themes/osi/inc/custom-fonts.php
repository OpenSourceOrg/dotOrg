<?php

add_action( 'init', 'enqueue_global_styles_fonts', 100 );
add_action( 'admin_init', 'enqueue_fse_font_styles' );
add_filter( 'pre_render_block', 'enqueue_block_fonts', 10, 2 );
add_filter( 'jetpack_google_fonts_list', 'osi_filter_jetpack_google_fonts_list' );

$osi_enqueued_font_slugs = array();

/**
 * Get the CSS containing font_face values for a given slug
 *
 * @return string String of CSS
 */
function get_style_css( $slug ) {
	$font_face_file = get_template_directory() . '/assets/fonts/' . $slug . '/font-face.css';
	if ( ! file_exists( $font_face_file ) ) {
		return '';
	}
	$contents = file_get_contents( $font_face_file );
	return str_replace( 'src: url(./', 'src: url(' . get_template_directory_uri() . '/assets/fonts/' . $slug . '/', $contents );
}


/**
 * Build a list of all font slugs provided by Blockbase from theme.json
 *
 * @return array Collection of all font slugs defined in the theme.json file
 */
function collect_fonts_from_osi() {
	$fonts                  = array();
	$parent_theme_json_data = json_decode( file_get_contents( get_template_directory() . '/theme.json' ), true );
	$font_families          = $parent_theme_json_data['settings']['typography']['fontFamilies'];

	foreach ( $font_families as $font ) {
		// Only pick it up if we're claiming it as ours to manage
		if ( array_key_exists( 'provider', $font ) && 'osi-fonts' === $font['provider'] ) {
			$fonts[] = $font;
		}
	}

	return $fonts;
}

/**
 * Enqeue all of the fonts used in global styles settings.
 *
 * @return void
 */
function enqueue_global_styles_fonts() {

	global $osi_enqueued_font_slugs;

	$font_slugs = array();
	$font_css   = '';

	$font_families = collect_fonts_from_osi();
	foreach ( $font_families as $font_family ) {
		$font_slugs[] = $font_family['slug'];
	}


	$osi_enqueued_font_slugs = $font_slugs;

	foreach ( $font_slugs as $font_slug ) {
		$font_css .= get_style_css( $font_slug );
	}

	// Bail out if there are no styles to enqueue.
	if ( '' === $font_css ) {
		return;
	}

	// Enqueue the stylesheet.
	wp_register_style( 'osi_font_faces', '' );
	wp_enqueue_style( 'osi_font_faces' );

	// Add the styles to the stylesheet.
	wp_add_inline_style( 'osi_font_faces', $font_css );
}

/**
 * Enqueue all of the fonts provided by Blockbase for FSE use
 */
function enqueue_fse_font_styles( $fonts ) {
	$fonts    = collect_fonts_from_osi();
	$font_css = '';

	foreach ( $fonts as $font ) {
		$font_css .= get_style_css( $font['slug'] );
	}

	wp_enqueue_style( 'wp-block-library' );
	wp_add_inline_style( 'wp-block-library', $font_css );
}

/**
 * Add fonts that have been assigned via CSS
 */
function enqueue_block_fonts( $content, $parsed_block ) {
	global $osi_enqueued_font_slugs;
	if ( ! is_admin() && isset( $parsed_block['attrs']['fontFamily'] ) ) {
		$font_slug = $parsed_block['attrs']['fontFamily'];
		if ( ! in_array( $font_slug, $osi_enqueued_font_slugs, true ) ) {
			$font_css = get_style_css( $font_slug );
			if ( $font_css ) {
				$osi_enqueued_font_slugs[] = $font_slug;
				wp_add_inline_style( 'osi_font_faces', $font_css );
			}
		}
	}
	return $content;
}

/**
 * Jetpack may attempt to register fonts for the Google Font Provider.
 * If that happens on a child theme then ONLY Jetpack fonts are registered.
 * This 'filter' filters out all of the fonts Jetpack should register
 * so that we depend exclusively on those provided by Blockbase.
 */
function osi_filter_jetpack_google_fonts_list( $list_to_filter ) {
	return array();
}
