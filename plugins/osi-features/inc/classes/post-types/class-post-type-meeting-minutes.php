<?php
/**
 * Register meeting Minutes post type.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc\Post_Types;

/**
 * Class Post_Type_Meeting_Minutes
 */
class Post_Type_Meeting_Minutes extends Base {

	/**
	 * Slug of post type.
	 *
	 * @var string
	 */
	const SLUG = 'meeting-minutes';

	/**
	 * Post type label for internal uses.
	 *
	 * @var string
	 */
	const LABEL = 'Meeting Minutes';

	/**
	 * To get list of labels for post type.
	 *
	 * @return array
	 */
	public function get_labels() {

		return [
			'name'               => __( 'Meeting Minutes', 'osi-features' ),
			'singular_name'      => __( 'Meeting Minutes', 'osi-features' ),
			'all_items'          => __( 'Meeting Minutes', 'osi-features' ),
			'add_new'            => __( 'Add New', 'osi-features' ),
			'add_new_item'       => __( 'Add New Meeting Minutes', 'osi-features' ),
			'edit_item'          => __( 'Edit Meeting Minutes', 'osi-features' ),
			'new_item'           => __( 'New Meeting Minutes', 'osi-features' ),
			'view_item'          => __( 'View Meeting Minutes', 'osi-features' ),
			'search_items'       => __( 'Search Meeting Minutes', 'osi-features' ),
			'not_found'          => __( 'No Meeting Minutes found', 'osi-features' ),
			'not_found_in_trash' => __( 'No Meeting Minutes found in Trash', 'osi-features' ),
		];

	}
}
