<?php

/**
 * Plugin Name: OSI API
 * Description: Provides an API for the Open Source Initiative.
 * Version: 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define the API namespace
define( 'OSI_API_NAMESPACE', 'osi/v1' );

/**
 * OSI API Class
 */
class OSI_API {

	/**
	 * Initialize the API
	 *
	 * @return void
	 */
	public static function init() {
		$instance = new self();

		// Add the API routes
		add_action( 'rest_api_init', array( $instance, 'register_routes' ) );

		// Add all custom rewrites
		add_action( 'init', array( $instance, 'add_rewrites' ) );
		add_filter( 'query_vars', array( $instance, 'add_query_vars' ), 0 );
		add_action( 'template_redirect', array( $instance, 'handle_redirects' ), 0 );
	}

	/**
	 * Register the API routes
	 *
	 * @return void
	 */
	public function register_routes() {
		// Register the all OSI licenses endpoint
		register_rest_route(
			OSI_API_NAMESPACE,
			'/licenses',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_licenses' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'name'    => array(
						'required'    => false,
						'type'        => 'string',
						'description' => 'Filter by license name',
					),
					'keyword' => array(
						'required'    => false,
						'type'        => 'string',
						'description' => 'Filter licenses by keyword',
					),
					'steward' => array(
						'required'    => false,
						'type'        => 'string',
						'description' => 'Filter licenses by steward',
					),
				),
				'schema'              => array(
					'$schema' => 'http://json-schema.org/draft-04/schema#',
					'title'   => 'licenses',
					'type'    => 'array',
					'items'   => array(
						'type'       => 'object',
						'properties' => $this->get_license_schema(),
					),
				),
			)
		);

		register_rest_route(
			OSI_API_NAMESPACE,
			'/license/(?P<slug>[a-zA-Z0-9-_]+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_license_by_slug' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'slug' => array(
						'required'    => true,
						'type'        => 'string',
						'description' => 'The slug of the license',
					),
				),
				'schema'              => array(
					'$schema'    => 'http://json-schema.org/draft-04/schema#',
					'title'      => 'license',
					'type'       => 'object',
					'properties' => $this->get_license_schema(),
				),
			)
		);
	}

	/**
	 * Get all OSI licenses
	 *
	 * @param WP_REST_Request $data The request object.
	 *
	 * @return WP_REST_Response
	 */
	public function get_licenses( WP_REST_Request $data ) {

		// Check if we have an ID passed.
		$searched_slug = $data->get_param( 'name' );

		// Check if we have any keyword passed.
		$keyword = $data->get_param( 'keyword' );

		// Check if we have any steward passed.
		$steward = $data->get_param( 'steward' );

		// Check the SPDX parameter.
		$spdx = $data->get_param( 'spdx' );

		// Get all public posts from the 'osi_license' post type
		$args = array(
			'post_type'      => 'license',
			'post_status'    => 'publish',
			'posts_per_page' => -1, // Get all licenses
		);

		// If we have an id, search for posts with a name LIKE
		if ( ! empty( $searched_slug ) ) {
			// Add the filter
			add_filter( 'posts_where', array( $this, 'posts_where_title_like' ), 10, 2 );

			$args['post_title_like'] = sanitize_text_field( $searched_slug ); // Use the post name (slug) to filter by ID
		} elseif ( ! empty( $spdx ) ) {
			// Cast the term to a regex pattern
			$regex = $this->cast_wildcard_to_regex( $spdx );

			// If we have no wildcards, look for a direct match
			$args['meta_query'][] = array(
				'key'     => 'spdx_identifier_display_text',
				'value'   => $regex,
				'compare' => str_contains( $spdx, '*' ) ? 'REGEXP' : '==',
			);
		} elseif ( ! empty( $keyword ) ) {
			// Add a tax query on taxonomy-license-category where passed term is a the slug
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'taxonomy-license-category',
					'field'    => 'slug',
					'terms'    => sanitize_text_field( $keyword ),
				),
			);
		} elseif ( ! empty( $steward ) ) {
			// Add a tax query on taxonomy-steward where passed term is a the slug
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'taxonomy-steward',
					'field'    => 'slug',
					'terms'    => sanitize_text_field( $steward ),
				),
			);
		}
		// If we have a keyword, add a LIKE filter on the post title
		$licenses_query = new WP_Query( $args );

		// If we added a filter for the post title, remove it after the query

		$all = array();
		foreach ( $licenses_query->posts as $license ) {
			$all[] = $this->get_license_model( $license->ID );
		}

		if ( isset( $args['post_title_like'] ) ) {
			// Remove the filter to avoid affecting other queries
			remove_filter( 'posts_where', array( $this, 'posts_where_title_like' ), 10, 2 );
		}

		return new WP_REST_Response( $all, 200 );
	}

	/**
	 * Turns a wildcard string into a LIKE query format.
	 *
	 * @param string $spdx The SPDX identifier to search for.
	 *
	 * @return string The LIKE query format for the SPDX identifier.
	 */
	public function cast_wildcard_to_regex( string $spdx ): string {
		$escaped = preg_quote( $spdx, '/' );

		$pattern = str_replace(
			array( '\*', '\?' ),
			array( '.*', '.' ),
			$escaped
		);

		// Ensure it matches the whole string
		return '^' . $pattern . '$';
	}

	/**
	 * Get a license by its slug.
	 *
	 * @param WP_REST_Request $request The request object.
	 *
	 * @return WP_REST_Response
	 */
	public function get_license_by_slug( WP_REST_Request $request ) {
		$slug = $request->get_param( 'slug' );

		if ( empty( $slug ) ) {
			return new WP_REST_Response( array( 'error' => 'License slug is required.' ), 400 );
		}

		// Get the license post by slug
		$licenses = get_posts(
			array(
				'name'        => $slug,
				'post_type'   => 'license',
				'post_status' => 'publish',
				'numberposts' => 1,
			)
		);
		if ( empty( $licenses ) ) {
			return new WP_REST_Response( array( 'error' => 'License not found.' ), 404 );
		}

		// Compile the license model
		$model = $this->get_license_model( $licenses[0]->ID );

		return new WP_REST_Response( $model, 200 );
	}

	/**
	 * Compile a licence model from its ID.
	 *
	 * @param string $id The ID of the license.
	 *
	 * @return array|null The license model.
	 */
	public function get_license_model( string $id ): ?array {
		// Get the license post by ID
		$license = get_post( $id );

		if ( ! $license ) {
			return null; // License not found
		}

		// Prepare the license model
		$model = array(
			'id'   => $license->post_name,
			'name' => $license->post_title,
		);
		$meta  = array(
			'spdx_id'                 => get_post_meta( $license->ID, 'spdx_identifier_display_text', true ),
			'version'                 => get_post_meta( $license->ID, 'version', true ),
			'submission_date'         => get_post_meta( $license->ID, 'release_date', true ),
			'submission_url'          => get_post_meta( $license->ID, 'submission_url', true ),
			'submitter_name'          => get_post_meta( $license->ID, 'submitter', true ),
			'approved'                => get_post_meta( $license->ID, 'approved', true ) === '1' ? true : false,
			'approval_date'           => get_post_meta( $license->ID, 'approval_date', true ),
			'license_steward_version' => get_post_meta( $license->ID, 'license_steward_version', true ),
			'license_steward_url'     => get_post_meta( $license->ID, 'license_steward_version_url', true ),
			'board_minutes'           => get_post_meta( $license->ID, 'link_to_board_minutes_url', true ),
		);

		// Get the license stewards (terms)
		$license_stewards = array_map(
			function ( $term ) {
				return $term->slug;
			},
		get_the_terms( $license->ID, 'taxonomy-steward' ) ?: array() // phpcs:ignore
		);

		// Get all the license categories.
		$license_categories = array_map(
			function ( $term ) {
				return $term->slug;
			},
		get_the_terms( $license->ID, 'taxonomy-license-category' ) ?: array() // phpcs:ignore
		);

		// Remove any 'Uncategorized' terms
		$license_categories = array_filter(
			$license_categories,
			function ( $category ) {
				return 'Uncategorized' !== $category;
			}
		);

		// Create the links.
		$links = array(
			'self'       => array(
				'href' => home_url( 'api/license/' ) . $model['id'],
			),
			'html'       => array(
				'href' => get_permalink( $license->ID ),
			),
			'collection' => array(
				'href' => home_url( 'api/licenses' ),
			),
		);

		return array_merge(
			$model,
			array_map( array( $this, 'sanitize_value' ), $meta ),
			array( 'stewards' => $license_stewards ),
			array( 'keywords' => $license_categories ),
			array( '_links' => $links )
		);
	}

	/**
	 * Sanitize values to ensure all but bools are escaped.
	 *
	 * @param mixed $value The value to sanitize.
	 *
	 * @return mixed The sanitized value.
	 */
	public function sanitize_value( $value ) { // phpcs:ignore
		return is_bool( $value ) ? $value : esc_html( $value );
	}

	/**
	 * Filter to allow the LIKE search of a post title.
	 *
	 * This is used to search for licenses by their ID.
	 *
	 * @param string    $where The WHERE clause of the SQL query.
	 * @param \WP_Query $query The WP_Query object.
	 *
	 * @return string The modified WHERE clause.
	 */
	public function posts_where_title_like( string $where, \WP_Query $query ) {
		$title = $query->get( 'post_title_like' );
		if ( $title ) {
			global $wpdb;
			$search_term = '%' . $wpdb->esc_like( strtolower( $title ) ) . '%';
			$where      .= $wpdb->prepare(
				" AND (LOWER({$wpdb->posts}.post_title) LIKE %s OR LOWER({$wpdb->posts}.post_name) LIKE %s)",
				$search_term,
				$search_term
			);
		}
		return $where;
	}

	/**
	 * Register the License rewrites.
	 *
	 * @return void
	 */
	public function add_rewrites() {
		add_rewrite_rule(
			'^api/licenses?/?$',
			'index.php?osi_api_redirect=1',
			'top'
		);

		// Redirect /api/license/{slug} to REST single
		add_rewrite_rule(
			'^api/license/([^/]+)/?$',
			'index.php?osi_api_slug_redirect=1&license_slug=$matches[1]',
			'top'
		);
	}

	/**
	 * Adds the rewrite tag for the custom query var.
	 *
	 * @param array $vars The array of query variables.
	 *
	 * @return array The modified array of query variables.
	 */
	public function add_query_vars( array $vars ): array {
		$vars[] = 'osi_api_redirect';
		$vars[] = 'osi_api_slug_redirect';  // for /api/license/{slug}
		$vars[] = 'license_slug';           // capture the slug
		return $vars;
	}

	/**
	 * Handle internal redirects for the API.
	 *
	 * @return void
	 */
	public function handle_redirects() {

		// Prevent WordPress canonical redirects for custom API endpoints
		if ( get_query_var( 'osi_api_redirect' ) || get_query_var( 'osi_api_slug_redirect' ) ) {
			remove_filter( 'template_redirect', 'redirect_canonical' );
		}

		if ( get_query_var( 'osi_api_redirect' ) ) {
			// Build REST request
			$request = new WP_REST_Request( 'GET', '/osi/v1/licenses' );

			// Add query parameters if any
			if ( ! empty( $_GET ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				foreach ( $_GET as $key => $value ) { // phpcs:ignore WordPress.Security.NonceVerification
					$sanitized_key   = sanitize_key( $key );
					$sanitized_value = is_array( $value )
						? array_map( 'sanitize_text_field', $value )
						: sanitize_text_field( $value );

					$request->set_param( $sanitized_key, $sanitized_value );
				}
			}

			// Execute internal REST request
			$response = rest_do_request( $request );

			// Set JSON header
			header( 'Content-Type: application/json; charset=utf-8' );

			if ( is_wp_error( $response ) ) {
				status_header( 500 );
				echo wp_json_encode( array( 'error' => $response->get_error_message() ) );
				exit;
			}

			// Output response with proper status
			status_header( $response->get_status() );
			echo wp_json_encode( $response->get_data() );
			exit;
		}

		// Handle /api/license/{slug}
		if ( get_query_var( 'osi_api_slug_redirect' ) ) {
			remove_filter( 'template_redirect', 'redirect_canonical' );

			$slug    = get_query_var( 'license_slug' );
			$request = new WP_REST_Request( 'GET', '/osi/v1/license/' . $slug );

			$response = rest_do_request( $request );
			header( 'Content-Type: application/json; charset=utf-8' );

			if ( is_wp_error( $response ) ) {
				status_header( 404 );
				echo wp_json_encode( array( 'error' => $response->get_error_message() ) );
			} else {
				status_header( $response->get_status() );
				echo wp_json_encode( $response->get_data() );
			}
			exit;
		}
	}

	/**
	 * Get the License scehema.
	 *
	 * @return array The schema for the license.
	 */
	public function get_license_schema(): array {
		return array(
			'id'                      => array(
				'description' => 'The unique slug ID of the license.',
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
			),
			'spdx_id'                 => array(
				'description' => 'The SPDX identifier for the license.',
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
			),
			'name'                    => array(
				'description' => 'The name of the license.',
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
			),
			'version'                 => array(
				'description' => 'The license version.',
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
			),
			'submission_date'         => array(
				'description' => 'Date the license was submitted.',
				'type'        => 'string',
				'format'      => 'date',
				'context'     => array( 'view', 'edit' ),
			),
			'submission_url'          => array(
				'description' => 'URL to the license submission discussion.',
				'type'        => 'string',
				'format'      => 'uri',
				'context'     => array( 'view' ),
			),
			'submitter_name'          => array(
				'description' => 'Name of the submitter.',
				'type'        => 'string',
				'context'     => array( 'view' ),
			),
			'approved'                => array(
				'description' => 'Whether the license is approved.',
				'type'        => 'boolean',
				'default'     => false,
				'context'     => array( 'view', 'edit' ),
			),
			'approval_date'           => array(
				'description' => 'Date the license was approved.',
				'type'        => 'string',
				'format'      => 'date',
				'context'     => array( 'view' ),
			),
			'license_steward_version' => array(
				'description' => 'Version info from the license steward.',
				'type'        => 'string',
				'context'     => array( 'view' ),
			),
			'licanse_steward_url'     => array(
				'description' => 'URL to the steward\'s license page.',
				'type'        => 'string',
				'format'      => 'uri',
				'context'     => array( 'view' ),
			),
			'board_minutes'           => array(
				'description' => 'Link to board meeting minutes where license was approved.',
				'type'        => 'string',
				'format'      => 'uri',
				'context'     => array( 'view' ),
			),
			'stewards'                => array(
				'description' => 'List of stewards associated with this license.',
				'type'        => 'array',
				'items'       => array(
					'type' => 'string',
				),
				'context'     => array( 'view' ),
			),
			'keywords'                => array(
				'description' => 'Keywords or tags related to the license.',
				'type'        => 'array',
				'items'       => array(
					'type' => 'string',
				),
				'context'     => array( 'view' ),
			),
			'_links'                  => array(
				'description' => 'Links to related resources.',
				'type'        => 'object',
				'context'     => array( 'view' ),
				'properties'  => array(
					'self'       => array(
						'type'       => 'object',
						'properties' => array(
							'href' => array(
								'type'   => 'string',
								'format' => 'uri',
							),
						),
					),
					'html'       => array(
						'type'       => 'object',
						'properties' => array(
							'href' => array(
								'type'   => 'string',
								'format' => 'uri',
							),
						),
					),
					'collection' => array(
						'type'       => 'object',
						'properties' => array(
							'href' => array(
								'type'   => 'string',
								'format' => 'uri',
							),
						),
					),
				),
			),
		);
	}
}

add_action( 'init', array( OSI_API::class, 'init' ), 0 );
