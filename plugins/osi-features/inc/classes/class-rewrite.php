<?php
/**
 * Rewrite class.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc;

use Osi\Features\Inc\Traits\Singleton;
use Osi\Features\Inc\Post_Types\Post_Type_Board_Member;
use Osi\Features\Inc\Taxonomies\Taxonomy_Status;
use Osi\Features\Inc\Post_Types\Post_Type_License;
use Osi\Features\Inc\Taxonomies\Taxonomy_License_Category;
use Osi\Features\Inc\Post_Types\Post_Type_Press_Mentions;
use Osi\Features\Inc\Taxonomies\Taxonomy_Publication;
use Osi\Features\Inc\Taxonomies\Taxonomy_Seat_Type;
use Osi\Features\Inc\Taxonomies\Taxonomy_Steward;

/**
 * Class Rewrite
 */
class Rewrite {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		$this->setup_hooks();

	}

	/**
	 * To setup action/filter.
	 *
	 * @return void
	 */
	protected function setup_hooks() {
		add_filter( 'query_vars', array( $this, 'add_query_vars' ), 10 );
		add_action( 'init', [ $this, 'add_custom_rewrite_rules' ], 20 );
	}

	public function add_query_vars( $vars ) {
		$vars[] = 'categories';

		return $vars;
	}

	/**
	 * Add custom rewrite rules for custom post types and taxonomies.
	 *
	 * @return void
	 */
	public function add_custom_rewrite_rules() {
		$base = Post_Type_License::get_instance()->get_slug();
		add_rewrite_rule(
			'^' . $base . '/steward/([^/]+)/?$',
			'index.php?taxonomy=' . Taxonomy_Steward::SLUG . '&term=$matches[1]',
			'top'
		);
		
		$base = Post_Type_Board_Member::get_instance()->get_slug();
		add_rewrite_rule(
			'^' . $base . '/status/([^/]+)/?$',
			'index.php?taxonomy=' . Taxonomy_Status::SLUG . '&term=$matches[1]',
			'top'
		);

		$base = Post_Type_Board_Member::get_instance()->get_slug();
		add_rewrite_rule(
			'^' . $base . '/seat-type/([^/]+)/?$',
			'index.php?taxonomy=' . Taxonomy_Seat_Type::SLUG . '&term=$matches[1]',
			'top'
		);

		$base = Post_Type_License::get_instance()->get_slug();
		add_rewrite_rule(
			'^' . $base . '/category/([^/]+)/?$',
			'index.php?taxonomy=' . Taxonomy_License_Category::SLUG . '&term=$matches[1]',
			'top'
		);

		$base = Post_Type_Press_Mentions::get_instance()->get_slug();
		add_rewrite_rule(
			'^' . $base . '/publication/([^/]+)/?$',
			'index.php?taxonomy=' . Taxonomy_Publication::SLUG . '&term=$matches[1]',
			'top'
		);


	}

}
