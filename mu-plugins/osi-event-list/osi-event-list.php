<?php
/**
 * Plugin Name: OSI Event List
 * Version: 1.0.0
 * Author: WordPress.com Special Projects
 * Author URI: https://wpspecialprojects.wordpress.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

function osi_event_list_register_block() {
	register_block_type(
		__DIR__ . '/build',
		array(
			'render_callback' => 'osi_event_list_render_block',
		)
	);
}
// Register the block.
add_action( 'init', 'osi_event_list_register_block' );

function osi_event_list_render_block( $attributes ) {

	if ( ! function_exists( 'sugar_calendar_get_events' ) ) {
		return '';
	}

	if ( ! isset( $attributes['eventCount'] ) ) {
		return '';
	}

	// Retrieve posts with WP_Query
	$events = sugar_calendar_get_events(
		array(
			'object_type' => 'post',
			'status'      => 'publish',
			'orderby'     => 'start',
			'order'       => 'ASC',
			'number'      => $attributes['eventCount'],
			'end_query'   => array(
				'inclusive' => true,
				'after'     => sugar_calendar_get_request_time( 'mysql' ),
			),
		)
	);

	ob_start();

	?>
	<div
		<?php
			echo get_block_wrapper_attributes( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				array(
					'class' => 'osi-event-list',
				)
			);
		?>
	>

		<?php
		if ( isset( $attributes['title'] ) ) {
			?>
			<h2 class="osi-event-list__title">
				<?php echo esc_html( $attributes['title'] ); ?>
			</h2>
			<?php
		}
		?>

		<div class="osi-event-list__content">
			<?php
			foreach ( $events as $event ) {

				?>
				<section class="post--summary osi-list--post-content">

					<header class="entry-header">

						<h2 class="post--title entry-title">
							<a href="<?php echo esc_url( get_permalink( $event->object_id ) ); ?>" rel="bookmark">
								<?php echo esc_html( get_the_title( $event->object_id ) ); ?>
							</a>
						</h2>

					</header><!-- .entry-header -->

					<div class="entry-content post--summary">

						<div class="sc_event_details" id="sc_event_details_<?php echo esc_attr( $event->object_id ); ?>">

							<div class="sc_event_details_inner">

								<?php osi_add_location_details( $event->object_id ); ?>

								<?php osi_add_date_time_details( $event->object_id, false ); ?>

							</div><!--end .sc_event_details_inner-->

						</div><!--end .sc_event_details-->

						<div class="osi-event-list__excerpt">
							<?php
							add_action( 'excerpt_more', '__return_empty_string' );
							echo wp_kses_post( apply_filters( 'the_excerpt', get_the_excerpt( $event->object_id ) ) );
							remove_action( 'excerpt_more', '__return_empty_string' );
							?>
						</div>

						<a class="read-more" href="<?php echo esc_url( get_permalink( $event->object_id ) ); ?>"><?php esc_html_e( 'Read More', 'osi' ); ?></a>

					</div><!-- .entry-content -->

				</section>
				<?php
			}
			?>
		</div>

	</div>
	<?php
	return ob_get_clean();

}
