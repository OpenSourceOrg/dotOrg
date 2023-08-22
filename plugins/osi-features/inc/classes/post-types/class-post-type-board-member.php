<?php
/**
 * Register Board_Director post type.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc\Post_Types;

/**
 * Class Post_Type_Board_Member
 */
class Post_Type_Board_Member extends Base {

	/**
	 * Slug of post type.
	 *
	 * @var string
	 */
	const SLUG = 'board-member';

	/**
	 * Post type label for internal uses.
	 *
	 * @var string
	 */
	const LABEL = 'Board Member';

	/**
	 * To get list of labels for post type.
	 *
	 * @return array
	 */
	public function get_labels() {

		return [
			'name'               => __( 'Board Members', 'osi-features' ),
			'singular_name'      => __( 'Board Member', 'osi-features' ),
			'all_items'          => __( 'Board Members', 'osi-features' ),
			'add_new'            => __( 'Add New', 'osi-features' ),
			'add_new_item'       => __( 'Add New Board Member', 'osi-features' ),
			'edit_item'          => __( 'Edit Board Member', 'osi-features' ),
			'new_item'           => __( 'New Board Member', 'osi-features' ),
			'view_item'          => __( 'View Board Member', 'osi-features' ),
			'search_items'       => __( 'Search Board Member', 'osi-features' ),
			'not_found'          => __( 'No Board Member found', 'osi-features' ),
			'not_found_in_trash' => __( 'No Board Member found in Trash', 'osi-features' ),
		];

	}
}
