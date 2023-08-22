<?php
/**
 * Manage all license search related functionality.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc;

use Osi\Features\Inc\Taxonomies\Taxonomy_License_Category;
use Osi\Features\Inc\Taxonomies\Taxonomy_Steward;
use Osi\Features\Inc\Traits\Singleton;

/**
 * Class License_Search
 */
final class License_Search {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		$this->setup_hooks();

	}

	/**
	 * Setup hooks.
	 *
	 * @return void
	 */
	public function setup_hooks() {
		add_action( 'pre_get_posts', array( $this, 'osi_filter_license_posts' ) );
		add_action( 'wp_ajax_osi_license_db', array( $this, 'osi_license_db' ) );
		add_action( 'wp_ajax_nopriv_osi_license_db', array( $this, 'osi_license_db' ) );

		add_filter( 'posts_where', array( $this, 'osi_license_search_where' ), 10, 2 );
		add_filter( 'posts_join', array( $this, 'osi_license_search_join' ), 10, 2 );
		add_filter( 'posts_groupby', array( $this, 'osi_license_search_groupby' ), 10, 2 );

	}

	/**
	 * Check if the current query is a license search query.
	 *
	 * @param \WP_Query $query The WP_Query object.
	 */
	public function is_license_search_query( $query ) {

		if ( ! isset( $query->query_vars['post_type'] ) || 'license' !== $query->query_vars['post_type'] ) {
			return;
		}

		if ( ! is_license_search() ) {
			return;
		}

		return true;

	}

	/**
	 * Modify the query to include the category filter.
	 *
	 * @param \WP_Query $query The WP_Query object.
	 */
	public function osi_filter_license_posts( $query ) {

		// Check if we're in the backend or the query is the main query.
		if ( ( is_admin() && ! wp_doing_ajax() ) || $query->is_main_query() ) {
			return;
		}

		if ( ! $this->is_license_search_query( $query ) ) {
			return;
		}

		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );

		$categories = isset( $_REQUEST['categories'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['categories'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( ! empty( $categories ) ) {
			$query->set(
				'tax_query',
				array(
					array(
						'taxonomy' => Taxonomy_License_Category::SLUG,
						'field'    => 'slug',
						'terms'    => explode( ',', $categories ),
					),
				)
			);
		}

	}

	/**
	 * Modify the search query to include the meta value.
	 *
	 * @param string   $where The WHERE clause of the query.
	 * @param \WP_Query $query The WP_Query instance (passed by reference).
	 *
	 * @return string
	 */
	public function osi_license_search_where( $where, $query ) {
		global $wpdb;

		if ( ! $this->is_license_search_query( $query ) ) {
			return $where;
		}

		$like = '%' . $wpdb->esc_like( get_license_search_query() ) . '%';

		$where .= $wpdb->prepare(
			"
			AND (
				{$wpdb->posts}.post_title LIKE %s
				OR
				(
					{$wpdb->postmeta}.meta_key = 'spdx_identifier_display_text'
					AND
					{$wpdb->postmeta}.meta_value LIKE %s
				)
				OR
				(
					ts.term_taxonomy_id = (
						SELECT
							t.term_id
					  	FROM
						  	{$wpdb->terms} AS t
							INNER JOIN {$wpdb->term_taxonomy} AS tt ON t.term_id = tt.term_id
					  	WHERE
							tt.taxonomy IN (%s)
							AND t.name LIKE %s
					 	 LIMIT 1
					)
				)
			)
			",
			$like,
			$like,
			Taxonomy_Steward::SLUG,
			$like
		);

		return $where;

	}

	/**
	 * Modify the search query to join the meta table.
	 *
	 * @param string   $join The JOIN clause of the query.
	 * @param \WP_Query $query The WP_Query instance (passed by reference).
	 *
	 * @return string
	 */
	public function osi_license_search_join( $join, $query ) {
		global $wpdb;

		if ( ! $this->is_license_search_query( $query ) ) {
			return $join;
		}

		$join .= "INNER JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id ";
		$join .= "LEFT JOIN {$wpdb->term_relationships} ts ON ( {$wpdb->posts}.ID = ts.object_id ) ";

		return $join;
	}

	/**
	 * Modify the search query to include the group by clause.
	 *
	 * @param string   $groupby The GROUPBY clause of the query.
	 * @param \WP_Query $query The WP_Query instance (passed by reference).
	 *
	 * @return string
	 */
	public function osi_license_search_groupby( $groupby, $query ) {
		global $wpdb;

		if ( ! $this->is_license_search_query( $query ) ) {
			return $groupby;
		}

		$groupby = "{$wpdb->posts}.ID";

		return $groupby;
	}

	/**
	 * License Ajax
	 */
	public function osi_license_db() {

		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$categories = isset( $_POST['categories'] ) ? $_POST['categories'] : '';

		$args = array(
			'post_type'        => 'license',
			'post_status'      => 'publish',
			'posts_per_page'   => -1,
			'orderby'          => 'title',
			'order'            => 'ASC',
			'suppress_filters' => false,
		);

		if ( $categories ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'taxonomy-license-category',
					'field'    => 'slug',
					'terms'    => explode( ',', $categories ),
				),
			);
		}

		$licenses = get_posts( $args );

		wp_send_json_success(
			array(
				'html'     => $this->osi_license_contents( $licenses ),
				'licenses' => $licenses,
			)
		);
	}

	/**
	 * License Contents
	 *
	 * @param array $licenses
	 * @return string
	 */
	public function osi_license_contents( $licenses ) {
		ob_start();
		global $post;
		foreach ( $licenses as $post ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			setup_postdata( $post );
			get_template_part( 'template-parts/content-loop-license-single' );
			wp_reset_postdata();
		endforeach;
		return ob_get_clean();
	}

}
