<?php
/**
 * Register License post type.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc\Post_Types;

/**
 * Class Post_Type_License
 */
class Post_Type_License extends Base {

	/**
	 * Slug of post type.
	 *
	 * @var string
	 */
	const SLUG = 'license';

	/**
	 * Post type label for internal uses.
	 *
	 * @var string
	 */
	const LABEL = 'License';

	/**
	 * To get list of labels for post type.
	 *
	 * @return array
	 */
	public function get_labels() {

		return [
			'name'               => __( 'Licenses', 'osi-features' ),
			'singular_name'      => __( 'License', 'osi-features' ),
			'all_items'          => __( 'Licenses', 'osi-features' ),
			'add_new'            => __( 'Add New', 'osi-features' ),
			'add_new_item'       => __( 'Add New License', 'osi-features' ),
			'edit_item'          => __( 'Edit License', 'osi-features' ),
			'new_item'           => __( 'New License', 'osi-features' ),
			'view_item'          => __( 'View License', 'osi-features' ),
			'search_items'       => __( 'Search License', 'osi-features' ),
			'not_found'          => __( 'No License found', 'osi-features' ),
			'not_found_in_trash' => __( 'No License found in Trash', 'osi-features' ),
		];

	}
}
