<?php
/**
 * Megamenu featured content: field registration + resolution.
 *
 * @package osi
 */

add_action( 'acf/include_fields', 'osi_megamenu_featured_fields' );
/**
 * Register the featured-content fields shown on menu items in Appearance > Menus.
 *
 * @return void
 */
function osi_megamenu_featured_fields() {
	acf_add_local_field_group(
		array(
			'key'      => 'group_osi_megamenu_featured',
			'title'    => __( 'Megamenu Featured Content', 'osi' ),
			'fields'   => array(
				array(
					'key'           => 'field_osi_megamenu_featured_item',
					'label'         => __( 'Featured item', 'osi' ),
					'name'          => 'osi_megamenu_featured_item',
					'type'          => 'post_object',
					'instructions'  => __( 'Top-level megamenu items only: the page or post featured on the right side of the dropdown panel.', 'osi' ),
					'post_type'     => array( 'page', 'post' ),
					'return_format' => 'id',
					'allow_null'    => 1,
				),
				array(
					'key'           => 'field_osi_megamenu_featured_heading',
					'label'         => __( 'Featured heading', 'osi' ),
					'name'          => 'osi_megamenu_featured_heading',
					'type'          => 'text',
					'default_value' => __( 'Featured', 'osi' ),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'nav_menu_item',
						'operator' => '==',
						'value'    => 'location/primary_navigation',
					),
				),
			),
		)
	);
}

/**
 * Resolve a menu item's featured selection into a publicly-visible post + card heading.
 *
 * @param WP_Post $item Nav menu item.
 *
 * @return array|null Array with 'post' (WP_Post) and 'heading' (string) keys, or null.
 */
function osi_megamenu_featured( WP_Post $item ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}

	$post_id  = (int) get_field( 'osi_megamenu_featured_item', $item );
	$featured = $post_id > 0 ? get_post( $post_id ) : null;

	if ( ! $featured instanceof WP_Post || ! is_post_publicly_viewable( $featured ) || '' !== $featured->post_password ) {
		return null;
	}

	$heading = trim( (string) get_field( 'osi_megamenu_featured_heading', $item ) );

	return array(
		'post'    => $featured,
		'heading' => '' !== $heading ? $heading : __( 'Featured', 'osi' ),
	);
}
