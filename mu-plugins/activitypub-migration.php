<?php
/**
 * Plugin Name: ActivityPub Migration
 * Plugin Description: Adds the `blog.opensource.org` to the Actors `alsoKnownAs` list.
 * Version: 1.0.0
 * Author: WordPress.com Special Projects
 * Author URI: https://wpspecialprojects.wordpress.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Adds the `blog.opensource.org` to the Actors `alsoKnownAs` list.
 *
 * @param array $actor Actor as Array.
 *
 * @return array $actor Filtered Actor Array.
 */
function activitypub_actor_migration( array $actor ) {
	if ( ! $actor ) {
		return $actor;
	}

	$host = wp_parse_url( get_home_url(), PHP_URL_HOST );
	$id   = str_replace( $host, 'blog.' . $host, $actor['id'] );
	$id   = str_replace( '/blog/', '/', $id );

	$actor['alsoKnownAs'] = array( $id );
	return $actor;
}
add_filter( 'activitypub_activity_user_object_array', 'activitypub_actor_migration' );
add_filter( 'activitypub_activity_blog_user_object_array', 'activitypub_actor_migration' );
