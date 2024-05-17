<?php
/**
 * Plugin Name: OSI Events Manager Tweaks
 * Description: Customizations for the Events Manager plugin.
 * Version: 1.0.0
 * Author: WordPress.com Special Projects
 * Author URI: https://wpspecialprojects.wordpress.com/
 */

 /**
 * Remove the event time zone if the event is all day.
 *
 * @param string $replace         The string to replace.
 * @param EM_Event $EM_Event      The event object.
 * @param string $full_result     The full result.
 * @param string $target          The target.
 * @param array $placeholder_atts The placeholder attributes.
 *
 * @return string
*/
function osi_em_event_output_placeholder( $replace, $EM_Event, $full_result, $target, $placeholder_atts ) {
	if ( '#_EVENTTIMEZONE' === $full_result ) {
		$event_times = $EM_Event->output('#_EVENTTIMES');
		if ( 'All Day' === $event_times ) {
			$replace = '';
		}
	}
	return $replace;
}
add_filter('em_event_output_placeholder', 'osi_em_event_output_placeholder', 10, 5);

/**
 * Display "Free" for events with a price of 0.00.
 *
 * @param string $formatted_price The formatted price.
 * @param string $price           The price.
 * @param string $currency        The currency.
 * @param string $format          The format.
 * @return void
 */
function osi_format_event_manager_price( $formatted_price, $price, $currency, $format ) {
	if( 0.00 === (float)$price ) {
		$formatted_price = 'Free';
	}

	return $formatted_price;
}
add_filter('em_get_currency_formatted', 'osi_format_event_manager_price', 10, 4 );
