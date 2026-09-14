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
					'instructions'  => __( 'Bottom button of the mobile menu only. Empty = no button.', 'osi' ),
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
 * Resolve the mobile menu CTA; no field value means no button.
 *
 * @return array|null Array with 'url', 'label' and 'target' (boolean) keys, or null.
 */
function osi_menu_cta() {
	$locations = get_nav_menu_locations();
	$menu      = function_exists( 'get_field' ) ? wp_get_nav_menu_object( $locations['primary_navigation'] ?? 0 ) : false;
	$link      = $menu ? (array) get_field( 'osi_menu_cta_link', $menu ) : array();
	$url       = ! empty( $link['url'] ) ? esc_url_raw( $link['url'] ) : '';

	if ( '' === $url ) {
		return null;
	}

	return array(
		'url'    => $url,
		'label'  => ! empty( $link['title'] ) ? $link['title'] : __( 'Get Involved', 'osi' ),
		'target' => ! empty( $link['target'] ),
	);
}
