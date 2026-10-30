<?php
/**
 * Register License post type.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc\Post_Types;

/**
 * Class Post_Type_License
 */
class Post_Type_License extends Base {

	/**
	 * Slug of post type.
	 *
	 * @var string
	 */
	const SLUG = 'license';

	/**
	 * Post type label for internal uses.
	 *
	 * @var string
	 */
	const LABEL = 'License';

	/**
	 * Cache group for dotted slug lookups.
	 *
	 * @var string
	 */
	const CACHE_GROUP = 'osi_license_slugs';

	/**
	 * To register action/filters.
	 *
	 * @return void
	 */
	protected function setup_hooks() {
		parent::setup_hooks();

		// Save side: preserve dots when creating/updating license posts.
		add_filter( 'wp_insert_post_data', array( $this, 'preserve_dots_on_save' ), 10, 2 );
		add_filter( 'wp_unique_post_slug', array( $this, 'preserve_dots_in_unique_slug' ), 10, 6 );

		// Query side: restore dotted slug during lookups so WP_Query finds the post.
		add_filter( 'sanitize_title', array( $this, 'restore_dots_on_query' ), 10, 3 );

		// Cache invalidation: clear when a license is saved, trashed, or deleted.
		add_action( 'save_post_' . self::SLUG, array( $this, 'clear_slug_cache' ) );
		add_action( 'before_delete_post', array( $this, 'clear_slug_cache' ) );
		add_action( 'wp_trash_post', array( $this, 'clear_slug_cache' ) );

		// Gutenberg: override cleanForSlug to preserve dots in the editor UI.
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_slug_script' ) );
	}

	/**
	 * Preserve dots in the post slug when saving a license post.
	 *
	 * WordPress sanitize_title strips dots by default. This rebuilds
	 * the slug with dots preserved using a placeholder swap.
	 *
	 * @param array $data    An array of slashed, sanitized post data.
	 * @param array $postarr An array of sanitized post data (unslashed).
	 *
	 * @return array The modified post data.
	 */
	public function preserve_dots_on_save( array $data, array $postarr ) {
		if ( self::SLUG !== $data['post_type'] ) {
			return $data;
		}

		$raw_source = ! empty( $postarr['post_name'] ) ? $postarr['post_name'] : $data['post_title'];

		if ( false === strpos( $raw_source, '.' ) ) {
			return $data;
		}

		$data['post_name'] = $this->sanitize_slug_with_dots( $raw_source );

		return $data;
	}

	/**
	 * Preserve dots in the unique post slug for license posts.
	 *
	 * WordPress may strip dots when checking slug uniqueness.
	 * This ensures the dot-containing slug survives.
	 *
	 * @param string  $slug          The post slug.
	 * @param integer $post_id       Post ID.
	 * @param string  $post_status   The post status.
	 * @param string  $post_type     Post type.
	 * @param integer $post_parent   Post parent ID.
	 * @param string  $original_slug The original slug.
	 *
	 * @return string The slug with dots preserved for license posts.
	 */
	public function preserve_dots_in_unique_slug( string $slug, int $post_id, string $post_status, string $post_type, int $post_parent, string $original_slug ) {
		if ( self::SLUG !== $post_type ) {
			return $slug;
		}

		if ( false === strpos( $original_slug, '.' ) || false !== strpos( $slug, '.' ) ) {
			return $slug;
		}

		// Only restore the dotted slug if no other license post already uses it.
		global $wpdb;
		$existing = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_type = %s AND ID != %d LIMIT 1",
				$original_slug,
				$post_type,
				$post_id
			)
		);

		return $existing ? $slug : $original_slug;
	}

	/**
	 * Restore dotted slugs during query-time sanitization.
	 *
	 * When WordPress queries a post by slug, it runs sanitize_title
	 * which strips dots. This checks whether a license post with the
	 * dotted version of the slug exists and returns it if so.
	 *
	 * Uses wp_cache and a single $wpdb query for the existence check
	 * to avoid infinite loops (get_posts would call sanitize_title again).
	 *
	 * @param string $title     The sanitized title.
	 * @param string $raw_title The raw title before sanitization.
	 * @param string $context   The context (e.g., 'save', 'display', 'query').
	 *
	 * @return string The dotted slug if a matching license exists, otherwise the default.
	 */
	public function restore_dots_on_query( string $title, string $raw_title, string $context ) {
		// Skip during saves — the wp_insert_post_data hook handles that.
		if ( 'save' === $context ) {
			return $title;
		}

		if ( false === strpos( $raw_title, '.' ) ) {
			return $title;
		}

		// Build what the dotted slug would look like.
		$dotted_slug = $this->sanitize_slug_with_dots( $raw_title );

		// If sanitization didn't change anything, no dots were stripped.
		if ( $dotted_slug === $title ) {
			return $title;
		}

		// Check cache first.
		$cache_key = 'slug_' . md5( $dotted_slug );
		$cached    = wp_cache_get( $cache_key, self::CACHE_GROUP );

		if ( false !== $cached ) {
			return $cached ? $dotted_slug : $title;
		}

		// Check if a license post with this dotted slug exists.
		global $wpdb;
		$exists = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_type = %s LIMIT 1",
				$dotted_slug,
				self::SLUG
			)
		) ? 1 : 0;

		wp_cache_set( $cache_key, $exists, self::CACHE_GROUP );

		return $exists ? $dotted_slug : $title;
	}

	/**
	 * Clear the slug cache when a license post is saved, trashed, or deleted.
	 *
	 * @param integer $post_id The post ID.
	 *
	 * @return void
	 */
	public function clear_slug_cache( int $post_id ) {
		if ( self::SLUG !== get_post_type( $post_id ) ) {
			return;
		}

		$post = get_post( $post_id );
		if ( ! $post ) {
			return;
		}

		$cache_key = 'slug_' . md5( $post->post_name );
		wp_cache_delete( $cache_key, self::CACHE_GROUP );
	}

	/**
	 * Enqueue the Gutenberg slug override script on the license editor screen.
	 *
	 * Subscribes to the editor data store and restores dots in the slug
	 * when the post title contains dots (e.g., SPDX identifiers).
	 *
	 * @return void
	 */
	public function enqueue_editor_slug_script() {
		$screen = get_current_screen();
		if ( ! $screen || self::SLUG !== $screen->post_type ) {
			return;
		}

		wp_enqueue_script(
			'osi-license-slug-dots',
			OSI_URL . '/assets/src/js/license-slug-dots.js',
			array( 'wp-data', 'wp-editor' ),
			filemtime( OSI_PATH . '/assets/src/js/license-slug-dots.js' ),
			true
		);
	}

	/**
	 * Sanitize a string as a slug while preserving dots.
	 *
	 * Swaps dots for a placeholder, runs the standard WordPress
	 * sanitize_title_with_dashes, then restores the dots.
	 *
	 * @param string $raw The raw string to sanitize.
	 *
	 * @return string The sanitized slug with dots preserved.
	 */
	private function sanitize_slug_with_dots( string $raw ) {
		$placeholder      = 'xdotx';
		$with_placeholder = str_replace( '.', $placeholder, $raw );
		$sanitized        = sanitize_title_with_dashes( $with_placeholder, '', 'save' );

		return str_replace( $placeholder, '.', $sanitized );
	}

	/**
	 * To get list of labels for post type.
	 *
	 * @return array
	 */
	public function get_labels() {
		return array(
			'name'               => __( 'Licenses', 'osi-features' ),
			'singular_name'      => __( 'License', 'osi-features' ),
			'all_items'          => __( 'Licenses', 'osi-features' ),
			'add_new'            => __( 'Add New', 'osi-features' ),
			'add_new_item'       => __( 'Add New License', 'osi-features' ),
			'edit_item'          => __( 'Edit License', 'osi-features' ),
			'new_item'           => __( 'New License', 'osi-features' ),
			'view_item'          => __( 'View License', 'osi-features' ),
			'search_items'       => __( 'Search License', 'osi-features' ),
			'not_found'          => __( 'No License found', 'osi-features' ),
			'not_found_in_trash' => __( 'No License found in Trash', 'osi-features' ),
		);
	}
}
