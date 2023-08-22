<?php
/**
* Editor Setup
*/
function osi_setup_editor() {

	/** Editor Style */
	add_theme_support( 'editor-styles' );

	/** Gutenberg Features */
	add_theme_support( 'align-wide' ); // gutenberg wide/full block support
	remove_theme_support( 'core-block-patterns' ); // no core block patterns

}
add_action( 'after_setup_theme', 'osi_setup_editor' );


/**
* -------------------------
* COLORS
* -------------------------
*/

/**
* Register Editor Color Controls
*/
function osi_editor_color_palette() {
	$palette = osi_editor_palette(); // palette.php
	foreach ( $palette as $key => $item ) {
		$color                  = get_theme_mod( $key, $item['color'] );
		$editor_color_palette[] = array(
			'name'  => $item['name'],
			'slug'  => $key,
			'color' => $color,
		);
	}
	add_theme_support( 'editor-color-palette', $editor_color_palette );

}
add_action( 'after_setup_theme', 'osi_editor_color_palette' );

/**
* Gradient Palettes
* Remove disable gradients above when this is done
*/
function osi_editor_gradient_palette() {

	$palette = osi_brand_colors(); // palette.php
	$j       = 1;

	foreach ( $palette as $key => $item ) { // single color
		if ( array_key_exists( 'color', $item ) ) {
			$color       = get_theme_mod( $key, $item['color'] );
			$gradients[] = array(
				'name'     => $item['name'] . ' Darker',
				'gradient' => 'linear-gradient(135deg,' . $color . ' 0%,' . color_luminance( $color, -.5 ) . ' 100%)',
				'slug'     => $key . '-gradient-darker',
			);
			$gradients[] = array(
				'name'     => $item['name'] . ' Lighter',
				'gradient' => 'linear-gradient(135deg,' . $color . ' 0%,' . color_luminance( $color, .6 ) . ' 100%)',
				'slug'     => $key . '-gradient-lighter',
			);
		}
	}

	foreach ( $palette as $key => $item ) { // multi color
		if ( array_key_exists( 'color', $item ) ) {
			$color = get_theme_mod( $key, $item['color'] );

			foreach ( array_slice( $palette, $j++ ) as $key2 => $item2 ) {
				$color2 = get_theme_mod( $key2, $item2['color'] );

				if ( $color2 ) {
					$gradients[] = array(
						'name'     => $item['name'] . ' And ' . $item2['name'],
						'gradient' => 'linear-gradient(135deg,' . $color . ' 0%,' . $color2 . ' 100%)',
						'slug'     => $key . '-' . $key2 . '-gradient',
					);
				}
			}
		}
	}
	add_theme_support( 'editor-gradient-presets', $gradients );
}
add_action( 'after_setup_theme', 'osi_editor_gradient_palette' );
