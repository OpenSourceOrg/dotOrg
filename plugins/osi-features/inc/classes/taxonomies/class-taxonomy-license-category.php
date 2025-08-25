<?php
/**
 * To register custom taxonomy.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc\Taxonomies;

use Osi\Features\Inc\Post_Types\Post_Type_License;

/**
 * Class Taxonomy_License_Category
 */
class Taxonomy_License_Category extends Base {

	/**
	 * Slug of taxonomy.
	 *
	 * @var string
	 */
	const SLUG = 'taxonomy-license-category';

	/**
	 * Labels for taxonomy.
	 *
	 * @return array
	 */
	public function get_labels() {
		return array(
			'name'                       => _x( 'Category', 'taxonomy general name', 'osi-features' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name', 'osi-features' ),
			'search_items'               => __( 'Search Category', 'osi-features' ),
			'popular_items'              => __( 'Popular Categories', 'osi-features' ),
			'all_items'                  => __( 'All Categories', 'osi-features' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Category', 'osi-features' ),
			'update_item'                => __( 'Update Category', 'osi-features' ),
			'add_new_item'               => __( 'Add New Category', 'osi-features' ),
			'new_item_name'              => __( 'New Category Name', 'osi-features' ),
			'separate_items_with_commas' => __( 'Separate Categories with commas', 'osi-features' ),
			'add_or_remove_items'        => __( 'Add or remove Category', 'osi-features' ),
			'choose_from_most_used'      => __( 'Choose from the most used Categories', 'osi-features' ),
			'not_found'                  => __( 'No Category found.', 'osi-features' ),
			'menu_name'                  => __( 'Categories', 'osi-features' ),
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
				'rewrite' => array(
					'slug'       => Post_Type_License::get_instance()->get_slug() . '/category',
					'with_front' => false,
				),
			),
			parent::get_args()
		);
	}
}
