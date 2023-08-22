<?php
/**
 * To register custom taxonomy.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc\Taxonomies;

use Osi\Features\Inc\Post_Types\Post_Type_Board_Member;

/**
 * Class Taxonomy_Seat_Type
 */
class Taxonomy_Seat_Type extends Base {

	/**
	 * Slug of taxonomy.
	 *
	 * @var string
	 */
	const SLUG = 'taxonomy-seat-type';

	/**
	 * Labels for taxonomy.
	 *
	 * @return array
	 */
	public function get_labels() {

		return [
			'name'                       => _x( 'Seat type', 'taxonomy general name', 'osi-features' ),
			'singular_name'              => _x( 'Seat type', 'taxonomy singular name', 'osi-features' ),
			'search_items'               => __( 'Search Seat type', 'osi-features' ),
			'popular_items'              => __( 'Popular Seat types', 'osi-features' ),
			'all_items'                  => __( 'All Seat types', 'osi-features' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Seat type', 'osi-features' ),
			'update_item'                => __( 'Update Seat type', 'osi-features' ),
			'add_new_item'               => __( 'Add New Seat type', 'osi-features' ),
			'new_item_name'              => __( 'New Seat type Name', 'osi-features' ),
			'separate_items_with_commas' => __( 'Separate Seat types with commas', 'osi-features' ),
			'add_or_remove_items'        => __( 'Add or remove Seat type', 'osi-features' ),
			'choose_from_most_used'      => __( 'Choose from the most used Seat types', 'osi-features' ),
			'not_found'                  => __( 'No Seat type found.', 'osi-features' ),
			'menu_name'                  => __( 'Seat Types', 'osi-features' ),
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
				'rewrite'      => array( 'slug' => 'seat-type' ),
			], 
			parent::get_args()
		);
	}

}
