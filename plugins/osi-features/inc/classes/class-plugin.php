<?php
/**
 * Plugin manifest class.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc;

use \Osi\Features\Inc\Traits\Singleton;
use \Osi\Features\Inc\Post_Types\Post_Type_Board_Member;
use \Osi\Features\Inc\Post_Types\Post_Type_License;
use \Osi\Features\Inc\Post_Types\Post_Type_Meeting_Minutes;
use \Osi\Features\Inc\Post_Types\Post_Type_Press_Mentions;
use Osi\Features\Inc\Taxonomies\Taxonomy_License_Category;
use Osi\Features\Inc\Taxonomies\Taxonomy_Seat_Type;
use Osi\Features\Inc\Taxonomies\Taxonomy_Status;
use Osi\Features\Inc\Taxonomies\Taxonomy_Steward;
use Osi\Features\Inc\Taxonomies\Taxonomy_Publication;

/**
 * Class Plugin
 */
class Plugin {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		// Load plugin classes.
		// Assets::get_instance();
		$this->load_post_types();
		$this->load_taxonomies();
		Rewrite::get_instance();
		$this->load_plugin_configs();
		SEO::get_instance();
		Blocks::get_instance();
		Meta_Blocks::get_instance();
		License_Search::get_instance();

	}

	/**
	 * Load Post Types.
	 */
	public function load_post_types() {

		// Load all post types.
		Post_Type_Board_Member::get_instance();
		Post_Type_License::get_instance();
		Post_Type_Meeting_Minutes::get_instance();
		Post_Type_Press_Mentions::get_instance();

	}

	/**
	 * Load Taxonomies.
	 */
	public function load_taxonomies() {

		// Load all taxonomies classes.
		Taxonomy_Steward::get_instance();
		Taxonomy_License_Category::get_instance();
		Taxonomy_Status::get_instance();
		Taxonomy_Seat_Type::get_instance();
		Taxonomy_Publication::get_instance();
	}

	/**
	 * Load Plugin Configs.
	 */
	public function load_plugin_configs() {

		// Load all plugin configs.

	}

}
