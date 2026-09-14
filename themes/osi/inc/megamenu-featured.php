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
				array(
					'key'          => 'field_osi_megamenu_featured_text',
					'label'        => __( 'Featured text', 'osi' ),
					'name'         => 'osi_megamenu_featured_text',
					'type'         => 'textarea',
					'instructions' => __( 'Short description shown on the card. Leave empty to use the featured item\'s excerpt.', 'osi' ),
					'rows'         => 3,
					'new_lines'    => '',
				),
				array(
					'key'           => 'field_osi_megamenu_featured_link',
					'label'         => __( 'Featured link', 'osi' ),
					'name'          => 'osi_megamenu_featured_link',
					'type'          => 'link',
					'instructions'  => __( 'Link shown under the text. Leave empty to link to the featured item as "Learn More".', 'osi' ),
					'return_format' => 'array',
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
				array(
					array(
						'param'    => 'nav_menu_item',
						'operator' => '==',
						'value'    => 'location/mobile_navigation',
					),
				),
			),
		)
	);
}

/**
 * Resolve a menu item's featured selection into the card's display data.
 *
 * Memoized per item because the same menu renders in both nav locations.
 *
 * @param WP_Post $item Nav menu item.
 *
 * @return array|null Array with 'post' (WP_Post), 'permalink', 'heading', 'text' (may be empty)
 *                    and 'link' (url, label, target flag; falls back to the featured post) keys, or null.
 */
function osi_megamenu_featured( WP_Post $item ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}

	static $cache = array();

	if ( array_key_exists( $item->ID, $cache ) ) {
		return $cache[ $item->ID ];
	}

	$post_id  = (int) get_field( 'osi_megamenu_featured_item', $item );
	$featured = $post_id > 0 ? get_post( $post_id ) : null;

	if ( ! $featured instanceof WP_Post || ! is_post_publicly_viewable( $featured ) || '' !== $featured->post_password ) {
		$cache[ $item->ID ] = null;
		return null;
	}

	$permalink = get_permalink( $featured );
	$heading   = trim( (string) get_field( 'osi_megamenu_featured_heading', $item ) );
	$link      = (array) get_field( 'osi_megamenu_featured_link', $item );
	$link_url  = ! empty( $link['url'] ) ? esc_url_raw( $link['url'] ) : '';

	$cache[ $item->ID ] = array(
		'post'      => $featured,
		'permalink' => $permalink,
		'heading'   => '' !== $heading ? $heading : __( 'Featured', 'osi' ),
		'text'      => trim( (string) get_field( 'osi_megamenu_featured_text', $item ) ),
		'link'      => array(
			'url'    => '' !== $link_url ? $link_url : $permalink,
			'label'  => ! empty( $link['title'] ) ? $link['title'] : __( 'Learn More', 'osi' ),
			'target' => ! empty( $link['target'] ),
		),
	);

	return $cache[ $item->ID ];
}
