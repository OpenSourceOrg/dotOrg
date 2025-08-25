<?php
/**
 * To register custom taxonomy.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc\Taxonomies;

use Osi\Features\Inc\Post_Types\Post_Type_Press_Mentions;

/**
 * Class Taxonomy_Steward
 */
class Taxonomy_Publication extends Base {

	/**
	 * Slug of taxonomy.
	 *
	 * @var string
	 */
	const SLUG = 'taxonomy-publication';

	/**
	 * Labels for taxonomy.
	 *
	 * @return array
	 */
	public function get_labels() {

		return array(
			'name'                       => _x( 'Publication', 'taxonomy general name', 'osi-features' ),
			'singular_name'              => _x( 'Publication', 'taxonomy singular name', 'osi-features' ),
			'search_items'               => __( 'Search Publication', 'osi-features' ),
			'popular_items'              => __( 'Popular Publications', 'osi-features' ),
			'all_items'                  => __( 'All Publications', 'osi-features' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Publication', 'osi-features' ),
			'update_item'                => __( 'Update Publication', 'osi-features' ),
			'add_new_item'               => __( 'Add New Publication', 'osi-features' ),
			'new_item_name'              => __( 'New Publication Name', 'osi-features' ),
			'separate_items_with_commas' => __( 'Separate Publications with commas', 'osi-features' ),
			'add_or_remove_items'        => __( 'Add or remove Publication', 'osi-features' ),
			'choose_from_most_used'      => __( 'Choose from the most used Publications', 'osi-features' ),
			'not_found'                  => __( 'No Publication found.', 'osi-features' ),
			'menu_name'                  => __( 'Publications', 'osi-features' ),
		);
	}

	/**
	 * List of post types for taxonomy.
	 *
	 * @return array
	 */
	public function get_post_types() {

		return array(
			Post_Type_Press_Mentions::get_instance()->get_slug(),
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
				'hierarchical' => true,
				'rewrite'      => array(
					'slug'       => Post_Type_Press_Mentions::get_instance()->get_slug() . '/publication',
					'with_front' => false,
				),
			),
			parent::get_args()
		);
	}
}
