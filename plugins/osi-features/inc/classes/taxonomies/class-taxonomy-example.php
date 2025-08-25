<?php
/**
 * To register custom taxonomy.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc\Taxonomies;

/**
 * Class Taxonomy_Example
 */
class Taxonomy_Example extends Base {

	/**
	 * Slug of taxonomy.
	 *
	 * @var string
	 */
	const SLUG = 'taxonomy-slug';

	/**
	 * Labels for taxonomy.
	 *
	 * @return array
	 */
	public function get_labels() {
		return array(
			'name'                       => _x( 'Taxonomy_Example', 'taxonomy general name', 'osi-features' ),
			'singular_name'              => _x( 'Taxonomy_Example', 'taxonomy singular name', 'osi-features' ),
			'search_items'               => __( 'Search Taxonomy_Example', 'osi-features' ),
			'popular_items'              => __( 'Popular Taxonomy_Example', 'osi-features' ),
			'all_items'                  => __( 'All Taxonomy_Example', 'osi-features' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Taxonomy_Example', 'osi-features' ),
			'update_item'                => __( 'Update Taxonomy_Example', 'osi-features' ),
			'add_new_item'               => __( 'Add New Taxonomy_Example', 'osi-features' ),
			'new_item_name'              => __( 'New Taxonomy_Example Name', 'osi-features' ),
			'separate_items_with_commas' => __( 'Separate Taxonomy_Example with commas', 'osi-features' ),
			'add_or_remove_items'        => __( 'Add or remove Taxonomy_Example', 'osi-features' ),
			'choose_from_most_used'      => __( 'Choose from the most used Taxonomy_Example', 'osi-features' ),
			'not_found'                  => __( 'No Taxonomy_Example found.', 'osi-features' ),
			'menu_name'                  => __( 'Taxonomy_Example', 'osi-features' ),
		);
	}

	/**
	 * List of post types for taxonomy.
	 *
	 * @return array
	 */
	public function get_post_types() {
		return array(
			'post',
		);
	}
}
