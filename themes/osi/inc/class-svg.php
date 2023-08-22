<?php
namespace OSI;

final class SVG {

	/**
	 * Setup the hooks.
	 */
	public static function setup_hooks() {
		add_filter( 'wp_kses_allowed_html', array( __CLASS__, 'add_kses_svg_support' ), 10, 2 );
	}

	/**
	 * Add svg support to kses.
	 *
	 * @param array $allowedtags
	 * @param array $context
	 * @return array
	 */
	public static function add_kses_svg_support( $allowedtags, $context ) {

		if ( 'svg' === $context ) {
			$allowedtags['svg'] = array(
				'class'               => true,
				'xmlns'               => true,
				'width'               => true,
				'height'              => true,
				'viewbox'             => true,
				'preserveaspectratio' => true,
				'fill'                => true,
				'aria-hidden'         => true,
				'focusable'           => true,
				'role'                => true,
			);

			$allowedtags ['path'] = array(
				'fill'      => true,
				'fill-rule' => true,
				'd'         => true,
				'transform' => true,
			);

			$allowedtags['polygon'] = array(
				'fill'      => true,
				'fill-rule' => true,
				'points'    => true,
				'transform' => true,
				'focusable' => true,
			);

			$allowedtags['rect'] = array(
				'fill'      => true,
				'fill-rule' => true,
				'height'    => true,
				'width'     => true,
				'x'         => true,
				'y'         => true,
			);

			$allowedtags['line'] = array(
				'fill'         => true,
				'fill-rule'    => true,
				'x1'           => true,
				'x2'           => true,
				'y1'           => true,
				'y2'           => true,
				'stroke'       => true,
				'stroke-width' => true,
				'transform'    => true,
			);

			$allowedtags['defs'] = array(
				'id' => true,
			);

			$allowedtags['clipPath'] = array(
				'id' => true,
			);

			$allowedtags['g'] = array(
				'clip-path' => true,
				'mask'      => true,
			);

			$allowedtags['circle'] = array(
				'cx'   => true,
				'cy'   => true,
				'r'    => true,
				'fill' => true,
			);

			$allowedtags['mask'] = array(
				'id'   => true,
				'fill' => true,
				'style' => true,
				'maskUnits' => true,
				'x' => true,
				'y' => true,
				'width' => true,
				'height' => true,
			);
		}

		return $allowedtags;
	}

	/**
	 * Sanitize SVG code.
	 *
	 * @param string $svg SVG code.
	 * @return string
	 */
	public static function wp_kses_svg( $svg ) {
		return wp_kses( $svg, 'svg' );
	}


	/**
	 * Get the content of the SVG file.
	 *
	 * @param string $svg_id
	 * @return string
	 */
	public static function get_svg( string $svg_id, array $args = array() ) : string {

		// Check if file is readable.
		if ( ! is_readable( get_theme_file_path( 'assets/svg/' . $svg_id . '.svg' ) ) ) {
			return esc_html__( 'SVG Not Found', 'julephouston' );
		}

		$svg = file_get_contents( get_theme_file_path( '/assets/svg/' . $svg_id . '.svg' ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Not remote file.

		// Adjust the width of the SVG.
		if ( isset( $args['width'] ) ) {
			$svg = preg_replace( '/width="(\d+)px"/', 'width="' . absint( $args['width'] ) . 'px"', $svg );
		}

		// Adjust the height of the SVG.
		if ( isset( $args['height'] ) ) {
			$svg = preg_replace( '/height="(\d+)px"/', 'height="' . absint( $args['height'] ) . 'px"', $svg );
		}

		// Change the color of the svg.
		if ( isset( $args['color'] ) ) {
			$svg = preg_replace( '/fill="#([a-f0-9]{3}|[a-f0-9]{6})"/', 'fill="' . esc_attr( $args['color'] ) . '"', $svg );
		}

		// Trim extra whitespace.
		$svg = trim( $svg );

		return self::wp_kses_svg( $svg );
	}

	/**
	 * Echo the content of the svg file.
	 *
	 * @param string $svg_id
	 * @return void
	 */
	public static function the_svg( string $svg_id ) : void {
		echo self::get_svg( $svg_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in get_svg().
	}


}

SVG::setup_hooks();
