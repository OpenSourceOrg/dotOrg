<?php
/**
 * Sugar Calendar Compatibility File.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if Sugar Calendar isn't active
if ( ! class_exists( 'Sugar_Calendar\\Requirements_Check' ) ) {
	exit; 
}

use Sugar_Calendar\AddOn\Ticketing\Common\Functions as Functions;
use Sugar_Calendar\AddOn\Ticketing\Frontend\Single as Single;

/**
 * Add date & time details to event contents.
 * A modified version of the function sc_add_date_time_details() of the plugin Sugar Calendar.
 *
 * @param integer $post_id   Post ID.
 * @param boolean $show_time Show time.
 *
 * @return void
 */
function osi_add_date_time_details( int $post_id = 0, bool $show_time = true ) {

	// Support 1.x
	$event      = sugar_calendar_get_event_by_object( $post_id );
	$all_day    = $event->is_all_day();
	$start_date = sc_get_event_date( $post_id );
	$start_time = sc_get_event_start_time( $post_id );
	$end_time   = sc_get_event_end_time( $post_id );
	$recurring  = sc_is_recurring( $post_id ) ? sc_get_recurring_description( $post_id ) : '';

	// Recurring description
	if ( ! empty( $recurring ) ) : ?>

		<div class="sc_event_date"><?php echo esc_html( $recurring ); ?></div>

		<?php

		// Non-recurring start DATE
	else :
		?>

		<div class="sc_event_date">
			<?php
				echo wp_kses(
					$start_date,
					array(
						'span' => array( 'class' => array() ),
						'time' => array(
							'datetime'      => array(),
							'data-timezone' => array(),
						),
					)
				);
			?>
		</div>

		<?php
	endif;

	// Start & end TIMES
	if ( is_single() && ! empty( $start_time ) && $show_time ) :

		// Set to all-day and noop the end time
		if ( ! empty( $all_day ) ) :
			$start_time = esc_html__( 'All-day', 'sugar-calendar' );
			$end_time   = false;
		endif;

		// Default format
		$format = 'Y-m-d\TH:i:s';
		$tz     = 'floating';

		// Non-floating
		if ( ! empty( $event->start_tz ) && ( $end_time !== $start_time ) ) {

			// Get the offset
			$offset = sugar_calendar_get_timezone_offset(
				array(
					'time'     => $event->start,
					'timezone' => $event->start_tz,
				)
			);

			// Add timezone to format
			$format = "Y-m-d\TH:i:s{$offset}";
		}

		// Format the date/time
		$dt = $event->start_date( $format );

		// All-day Events have floating time zones
		if ( ! empty( $event->start_tz ) && ! $event->is_all_day() ) {
			$tz = $event->start_tz;
		}

		// Output start (or all-day)
		?>
		<div class="sc_event_time">
			<span class="sc_event_start_time">
			<?php esc_html_e( 'Time:', 'sugar-calendar' ); ?>
				<time datetime="<?php echo esc_attr( $dt ); ?>" title="<?php echo esc_attr( $dt ); ?>" data-timezone="<?php echo esc_attr( $tz ); ?>">
					<?php echo esc_html( $start_time ); ?>
				</time>
			</span>
			<?php

			// Maybe output a separator and the end time
			if ( ! empty( $end_time ) && ( $end_time !== $start_time ) ) :

				// Format
				$format = 'Y-m-d\TH:i:s';
				$tz     = 'floating';

				// Non-floating
				if ( ! empty( $event->end_tz ) ) {

					// Get the offset
					$offset = sugar_calendar_get_timezone_offset(
						array(
							'time'     => $event->end,
							'timezone' => $event->end_tz,
						)
					);

					// Add timezone to format
					$format = "Y-m-d\TH:i:s{$offset}";
				}

				// Format the date/time
				$dt = $event->end_date( $format );

				// All-day Events have floating time zones
				if ( ! empty( $event->end_tz ) && ! $event->is_all_day() ) {
					$tz = $event->end_tz;

					// Maybe fallback to the start time zone
				} elseif ( empty( $event->end_tz ) && ! empty( $event->start_tz ) ) {
					$tz = $event->start_tz;
				}
				?>

				<span class="sc_event_time_sep">
					<?php esc_html_e( 'to', 'sugar-calendar' ); ?>
				</span>

				<span class="sc_event_end_time">
					<time datetime="<?php echo esc_attr( $dt ); ?>" title="<?php echo esc_attr( $dt ); ?>" data-timezone="<?php echo esc_attr( $tz ); ?>">
						<?php echo esc_html( $end_time ); ?>
					</time>
				</span>

			<?php endif; ?>

		</div>

		<?php
	endif;
}
remove_action( 'sc_event_details', 'sc_add_date_time_details' ); // Remove the original date and time details.
add_action( 'sc_event_details', 'osi_add_date_time_details', 20 );

/**
 * Display ticketing information.
 *
 * @return void
 */
function osi_maybe_display_ticketing() {
	remove_action( 'sc_after_event_content', 'Sugar_Calendar\AddOn\Ticketing\Frontend\Single\display' );
	if ( ! is_single() ) {
		remove_action( 'sc_event_details', 'Sugar_Calendar\AddOn\Events\URLs\Theme\Singular\display' );
	}
}
add_action( 'wp', 'osi_maybe_display_ticketing' );

/**
 * Add the registration button after the content in the event listing page.
 *
 * @param integer $post_id The ID of the post.
 *
 * @return void
 */
function osi_register_button_after_content( int $post_id ) {

	// For single posts, if ticket is priced at $0.0, display 'Free Event'.
	// And Button text 'Get a ticket' -> 'Register'
	if ( is_single() ) {
		// Capture current sugar-calendar output
		ob_start();

		Single\display( $post_id );

		$event_tickets_html = ob_get_clean();

		// translators: %s is a placeholder for the currency amount.
		$price_html = sprintf( esc_html__( '%s Per Ticket', 'sc-event-ticketing' ), Functions\currency_filter( 0.0 ) );

		// Replace amount with "Free Event"
		if ( false !== strpos( $event_tickets_html, $price_html ) ) {
			$event_tickets_html = str_replace( $price_html, esc_html__( 'Free Event', 'osi' ), $event_tickets_html );
		}

		echo $event_tickets_html; // phpcs:ignore WordPress.Security.EscapeOutput

		return;
	}

	if ( osi_is_past_event( $post_id ) ) {
		return;
	}

	// Get the Event
	$event = sugar_calendar_get_event_by_object( $post_id, 'post' );

	$is_external_event = get_event_meta( $event->id, 'url', true );

	if ( $is_external_event ) {
		$permalink = $is_external_event;
		$link_text = __( 'Learn More &#8599;', 'osi' );
	} else {
		$permalink = get_permalink( $post_id );
		$link_text = __( 'Learn More', 'osi' );
	}

	?>
	<p class="learn-more">
		<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $link_text ); ?></a>
	</p>
	<?php
}
add_action( 'sc_after_event_content', 'osi_register_button_after_content' );

/**
 * Check if the event is past.
 *
 * @param integer $post_id Post ID.
 *
 * @return boolean
 */
function osi_is_past_event( int $post_id ) {
	$is_past_event = false;

	$event = sugar_calendar_get_event_by_object( $post_id );

	if ( ! $event ) {
		return $is_past_event;
	}

	$timezone = wp_timezone();
	$start    = new DateTime( $event->start, $timezone );
	$today    = new DateTime( 'now', $timezone );

	if ( $start < $today ) {
		$is_past_event = true;
	}

	return $is_past_event;
}

/**
 * Add location details to event contents.
 *
 * @param integer $post_id Post ID.
 *
 * @return void
 */
function osi_add_location_details( int $post_id = 0 ) {
	$location = sugar_calendar_get_event_by_object( $post_id, 'post' )->location;

	// Maybe add location
	if ( ! empty( $location ) ) :
		?>

		<div class="sc_event_location">

			<?php echo esc_html( $location ); ?>

		</div>

		<?php
	endif;
}
remove_action( 'sc_event_details', 'sc_add_location_details' );
add_action( 'sc_event_details', 'osi_add_location_details' );

/**
 * Add the purchase button to the event details.
 *
 * @param string $button_html Button HTML.
 * @param object $event       Event object.
 *
 * @return string
 */
function osi_purchase_button_html( string $button_html, object $event ) {

	// Get the ticket price.
	$ticket_price = get_event_meta( $event->id, 'ticket_price', true );

	// If the price is $0.0, Button text should be replace by 'Register'.
	if ( 0.0 === (float) $ticket_price ) {
		$button_html = str_replace( 'Add to Cart', __( 'Register', 'osi' ), $button_html );
	}

	$button_html = str_replace( 'Add to Cart', __( 'Get a ticket', 'osi' ), $button_html );

	return $button_html;
}
add_filter( 'sc_et_purchase_button_html', 'osi_purchase_button_html', 10, 2 );

/**
 * Modify the events archive query.
 * Set the default display to upcoming events in an ascending order.
 *
 * @return void
 */
function osi_modify_events_archive() {
	// Bail if in admin
	if ( is_admin() ) {
		return;
	}

	// Get post types
	$pts = sugar_calendar_allowed_post_types();

	// Only proceed if an Event post type
	if ( is_post_type_archive( $pts ) && ! isset( $_GET['event-display'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		wp_safe_redirect( '/events/?event-display=upcoming' );
	}
}

add_action( 'template_redirect', 'osi_modify_events_archive' );

/**
 * Generates default event metadata if ticket price is empty.
 *
 * @param mixed   $value     The value of the metadata.
 * @param integer $object_id The ID of the object.
 * @param string  $meta_key  The key of the metadata.
 *
 * @return mixed The modified or original value.
 */
function osi_default_event_metadata( mixed $value, int $object_id, string $meta_key ) {
	if ( 'ticket_price' === $meta_key && '' === $value ) {
		$value = 0.0;
	}

	return $value;
}

add_filter( 'default_sc_event_metadata', 'osi_default_event_metadata', 20, 3 );
