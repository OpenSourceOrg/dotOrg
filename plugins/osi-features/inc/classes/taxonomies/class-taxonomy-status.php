<?php
/**
 * To register custom taxonomy.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc\Taxonomies;

use Osi\Features\Inc\Post_Types\Post_Type_Board_Member;

/**
 * Class Taxonomy_Status
 */
class Taxonomy_Status extends Base {

	/**
	 * Slug of taxonomy.
	 *
	 * @var string
	 */
	const SLUG = 'taxonomy-status';

	/**
	 * Labels for taxonomy.
	 *
	 * @return array
	 */
	public function get_labels() {

		return [
			'name'                       => _x( 'Status', 'taxonomy general name', 'osi-features' ),
			'singular_name'              => _x( 'Status', 'taxonomy singular name', 'osi-features' ),
			'search_items'               => __( 'Search Status', 'osi-features' ),
			'popular_items'              => __( 'Popular Statuses', 'osi-features' ),
			'all_items'                  => __( 'All Statuses', 'osi-features' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Status', 'osi-features' ),
			'update_item'                => __( 'Update Status', 'osi-features' ),
			'add_new_item'               => __( 'Add New Status', 'osi-features' ),
			'new_item_name'              => __( 'New Status Name', 'osi-features' ),
			'separate_items_with_commas' => __( 'Separate Statuses with commas', 'osi-features' ),
			'add_or_remove_items'        => __( 'Add or remove Status', 'osi-features' ),
			'choose_from_most_used'      => __( 'Choose from the most used Statuses', 'osi-features' ),
			'not_found'                  => __( 'No Status found.', 'osi-features' ),
			'menu_name'                  => __( 'Statuses', 'osi-features' ),
		];

	}

	/**
	 * List of post types for taxonomy.
	 *
	 * @return array
	 */
	public function get_post_types() {

		return [
			Post_Type_Board_Member::get_instance()->get_slug(),
		];

	}

	/**
	 * To get argument to register taxonomy.
	 *
	 * @return array
	 */
	public function get_args() {
		
		return wp_parse_args( 
			[
				'hierarchical' => false,
				'rewrite'      => array(
					'slug' => 'about/board-of-directors',
					'with_front' => false,
					'hierarchical' => false,
				),
			], 
			parent::get_args()
		);
	}

}
