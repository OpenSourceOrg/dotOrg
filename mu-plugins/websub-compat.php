<?php
/**
 * Plugin Name: WebSub Backwards Compatibility
 * Version: 1.0.0
 * Author: WordPress.com Special Projects
 * Author URI: https://wpspecialprojects.wordpress.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Filter `pubsubhubbub_feed_urls` and `pubsubhubbub_comment_feed_urls`.
 *
 * Still send pings for the old `blog.opensource.org` Feed-URLs.
 *
 * @param array $links Array of Feed URLs.
 *
 * @return array $links Array of filtered Feed URLs.
 */
function websub_compat( $links ) {
	if ( ! $links || ! is_array( $links ) ) {
		return $links;
	}

	$host         = wp_parse_url( get_home_url(), PHP_URL_HOST );
	$compat_links = array();

	foreach ( $links as $link ) {
		$compat_links[] = str_replace( $host, 'blog.' . $host, $link );
	}

	return array_unique( array_merge( $links, $compat_links ) );
}
add_filter( 'pubsubhubbub_feed_urls', 'websub_compat' );
add_filter( 'pubsubhubbub_comment_feed_urls', 'websub_compat' );
