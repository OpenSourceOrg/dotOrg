<?php
/**
 * Mobile menu CTA: field registration + resolution.
 *
 * @package osi
 */

add_action( 'acf/include_fields', 'osi_menu_cta_field' );
/**
 * Register the CTA link field shown on the primary menu's settings in Appearance > Menus.
 *
 * @return void
 */
function osi_menu_cta_field() {
	acf_add_local_field_group(
		array(
			'key'             => 'group_osi_menu_cta',
			'title'           => __( 'Mobile menu CTA', 'osi' ),
			'label_placement' => 'top',
			'fields'          => array(
				array(
					'key'           => 'field_osi_menu_cta_link',
					'label'         => __( 'CTA link', 'osi' ),
					'name'          => 'osi_menu_cta_link',
					'type'          => 'link',
					'instructions'  => __( 'Bottom button of the mobile menu only. Empty = the default "Get Involved" link.', 'osi' ),
					'return_format' => 'array',
				),
			),
			'location'        => array(
				array(
					array(
						'param'    => 'nav_menu',
						'operator' => '==',
						'value'    => 'location/primary_navigation',
					),
				),
			),
		)
	);
}

/**
 * Resolve the mobile menu CTA, falling back to the Get Involved page.
 *
 * @return array Array with 'url', 'label' and 'target' (boolean) keys.
 */
function osi_menu_cta() {
	$locations = get_nav_menu_locations();
	$menu      = function_exists( 'get_field' ) ? wp_get_nav_menu_object( $locations['primary_navigation'] ?? 0 ) : false;
	$link      = $menu ? (array) get_field( 'osi_menu_cta_link', $menu ) : array();
	$url       = ! empty( $link['url'] ) ? esc_url_raw( $link['url'] ) : '';

	return array(
		'url'    => '' !== $url ? $url : home_url( '/get-involved/' ),
		'label'  => ! empty( $link['title'] ) ? $link['title'] : __( 'Get Involved', 'osi' ),
		'target' => ! empty( $link['target'] ),
	);
}
