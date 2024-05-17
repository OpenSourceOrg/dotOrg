<?php
/**
 * Plugin Name: OSI Events Manager Tweaks
 * Description: Customizations for the Events Manager plugin.
 * Version: 1.0.0
 * Author: WordPress.com Special Projects
 * Author URI: https://wpspecialprojects.wordpress.com/
 */

add_filter('em_event_output_placeholder', 'osi_em_event_output_placeholder', 10, 5);
function osi_em_event_output_placeholder( $replace, $EM_Event, $full_result, $target, $placeholder_atts ) {
	if ( '#_EVENTTIMEZONE' === $full_result ) {
		$event_times = $EM_Event->output('#_EVENTTIMES');
		if ( 'All Day' === $event_times ) {
			$replace = '';
		}
	}
	return $replace;
}