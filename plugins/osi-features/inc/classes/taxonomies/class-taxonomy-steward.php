<?php
/**
 * To register custom taxonomy.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc\Taxonomies;

use Osi\Features\Inc\Post_Types\Post_Type_License;

/**
 * Class Taxonomy_Steward
 */
class Taxonomy_Steward extends Base {

	/**
	 * Slug of taxonomy.
	 *
	 * @var string
	 */
	const SLUG = 'taxonomy-steward';

	/**
	 * Labels for taxonomy.
	 *
	 * @return array
	 */
	public function get_labels() {

		return array(
			'name'                       => _x( 'License Steward', 'taxonomy general name', 'osi-features' ),
			'singular_name'              => _x( 'License Steward', 'taxonomy singular name', 'osi-features' ),
			'search_items'               => __( 'Search License Steward', 'osi-features' ),
			'popular_items'              => __( 'Popular License Stewards', 'osi-features' ),
			'all_items'                  => __( 'All License Stewards', 'osi-features' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit License Steward', 'osi-features' ),
			'update_item'                => __( 'Update License Steward', 'osi-features' ),
			'add_new_item'               => __( 'Add New License Steward', 'osi-features' ),
			'new_item_name'              => __( 'New License Steward Name', 'osi-features' ),
			'separate_items_with_commas' => __( 'Separate License Stewards with commas', 'osi-features' ),
			'add_or_remove_items'        => __( 'Add or remove License Steward', 'osi-features' ),
			'choose_from_most_used'      => __( 'Choose from the most used License Stewards', 'osi-features' ),
			'not_found'                  => __( 'No License Steward found.', 'osi-features' ),
			'menu_name'                  => __( 'License Stewards', 'osi-features' ),
		);
	}

	/**
	 * List of post types for taxonomy.
	 *
	 * @return array
	 */
	public function get_post_types() {

		return array(
			Post_Type_License::get_instance()->get_slug(),
		);
	}

	/**
	 * To get argument to register taxonomy.
	 *
	 * @return array
	 */
	public function get_args() {

		return wp_parse_args(
			array(
				'hierarchical' => false,
				'rewrite'      => array(
					'slug'       => Post_Type_License::get_instance()->get_slug() . '/steward',
					'with_front' => false,
				),
			),
			parent::get_args()
		);
	}
}
