<?php
/**
 * osi Theme Customizer
 *
 * @package osi
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function osi_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'osi_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'osi_customize_partial_blogdescription',
			)
		);
	}

	// Color
	$palette = osi_customizer_palette(); // palette.php
	foreach ( $palette as $key => $item ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $item['color'],
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$key,
				array(
					'label'    => $item['name'],
					'section'  => 'colors',
					'settings' => $key,
				)
			)
		);
	}
}
add_action( 'customize_register', 'osi_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function osi_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function osi_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function osi_customize_preview_js() {
	wp_enqueue_script( 'osi-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'osi_customize_preview_js' );
