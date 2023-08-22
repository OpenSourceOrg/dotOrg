<?php
/**
 * .main classes
 */
function osi_main_class() {

	if ( osi_display_sidebar() ) {
		// Classes on pages with the sidebar
		$class = 'content-main';
	} else {
		// Classes on full width pages
		$class = 'content-full';
	}
	return $class;
}

/**
 * .sidebar classes
 */
function osi_sidebar_class() {
	return 'sidebar-main';
}

function osi_sidebar_button() {

	if ( osi_display_sidebar() ) {
		// Show sidebar button on pages where sidebar is enabled
		$sidebar_button = '<button aria-label="Open Sidebar" id="openSidebar" class="open-sidebar open-button"><span>Open Sidebar</span></button>';
	} else {
		// Disable sidebar button where sidebar is disabled
		$sidebar_button = '';
	}

	return $sidebar_button;
}

/**
 * Define which pages should have the sidebar
 *
 * @see lib/sidebar.php for more details
 */
function osi_display_sidebar() {
	$sidebar_config = new Osi_Sidebar(
		/**
		 * Conditional tag checks (http://codex.wordpress.org/Conditional_Tags)
		 * Any of these conditional tags that return true will show the sidebar
		 *
		 * To use a function that accepts arguments, use the following format:
		 *
		 * array('function_name', array('arg1', 'arg2'))
		 *
		 * The second element must be an array even if there's only 1 argument.
		 */
		array(
			// array( 'is_singular', array( 'post' ) ),
			// 'is_archive',
			// array( 'is_post_type_archive', array( 'post' ) ),
			// 'is_blog',
		),
		/**
		 * Page template checks (via is_page_template())
		 * By default, page templates do not show the sidebar
		 * Any of these page templates that return true will show the sidebar
		 */
		array(
			//'template-custom.php'
		)
	);
	return apply_filters( 'osi_display_sidebar', $sidebar_config->display );
}

/**
 * Clean up the_excerpt()
 */
define( 'POST_EXCERPT_LENGTH', 30 ); // Length in words for excerpt_length filter (http://codex.wordpress.org/Plugin_API/Filter_Reference/excerpt_length)
function osi_excerpt_length( $length ) {
	return POST_EXCERPT_LENGTH;
}

function osi_excerpt_more( $more ) {

	if ( is_post_type_archive( sugar_calendar_get_event_post_type_id() ) ) {
		return '...';
	}

	return '... <a class="read-more" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read More', 'osi' ) . '</a>';
}
add_filter( 'excerpt_length', 'osi_excerpt_length' );
add_filter( 'excerpt_more', 'osi_excerpt_more' );

/**
* Email Notification Defaults
*/
add_filter( 'wp_mail_from', 'osi_mail_from' );
add_filter( 'wp_mail_from_name', 'osi_mail_name' );

function osi_mail_from( $email ) {
	$email = str_replace( 'http://', '', get_site_url( '', '', 'http' ) );
	return 'noreply@' . $email; // new email address from sender.
}

function osi_mail_name( $email ) {
	return get_bloginfo( 'name' ); // new email name from sender.
}
