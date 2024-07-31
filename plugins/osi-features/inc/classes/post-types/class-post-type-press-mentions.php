<?php
/**
 * Register Articles post type.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc\Post_Types;

/**
 * Class Post_Type_Meeting_Minutes
 */
class Post_Type_Press_Mentions extends Base {

	/**
	 * Slug of post type.
	 *
	 * @var string
	 */
	const SLUG = 'press-mentions';

	/**
	 * Post type label for internal uses.
	 *
	 * @var string
	 */
	const LABEL = 'Press mentions';

	/**
	 * To get list of labels for post type.
	 *
	 * @return array
	 */
	public function get_labels() {

		return [
			'name'               => __( 'Press mentions', 'osi-features' ),
			'singular_name'      => __( 'Press mentions', 'osi-features' ),
			'all_items'          => __( 'Press mentions', 'osi-features' ),
			'add_new'            => __( 'Add New', 'osi-features' ),
			'add_new_item'       => __( 'Add New Press mention', 'osi-features' ),
			'edit_item'          => __( 'Edit Press mention', 'osi-features' ),
			'new_item'           => __( 'New Press mention', 'osi-features' ),
			'view_item'          => __( 'View Press mention', 'osi-features' ),
			'search_items'       => __( 'Search Press mentions', 'osi-features' ),
			'not_found'          => __( 'No Press mentions found', 'osi-features' ),
			'not_found_in_trash' => __( 'No Press mentions found in Trash', 'osi-features' ),
		];

	}

	/**
	 * To get argument to register custom post type.
	 *
	 * @return array
	 */
	public function get_args() {

		return [
			'show_in_rest'  => true,
			'public'        => true,
			'has_archive'   => true,
			'menu_position' => 6,
			'supports'      => [ 'title', 'author', 'excerpt' ],
			'rewrite'       => [ 'slug' => 'press-mentions', 'with_front' => false ]
		];

	}
}
