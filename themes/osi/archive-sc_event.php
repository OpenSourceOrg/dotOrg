<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

 
if ( ! class_exists( 'Sugar_Calendar\\Requirements_Check' ) ) {
	add_action('init', 
		function() {
			wp_safe_redirect( home_url() );
			exit; 
		}
	);
}

$display_type         = isset( $_GET['event-display'] ) ? sanitize_text_field( wp_unslash( $_GET['event-display'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$event_post_type_slug = sugar_calendar_get_event_post_type_id();

$upcoming_url = ( 'upcoming' === $display_type )
				? get_post_type_archive_link( $event_post_type_slug )
				: add_query_arg( 'event-display', 'upcoming', get_post_type_archive_link( $event_post_type_slug ) );

$past_url = ( 'past' === $display_type )
			? get_post_type_archive_link( $event_post_type_slug )
			: add_query_arg( 'event-display', 'past', get_post_type_archive_link( $event_post_type_slug ) );

get_header(); ?>

<section class="content <?php echo ( osi_display_sidebar() ? 'has_sidebar' : 'has_no_sidebar' ); ?>" id="content">

	<main class="content--body <?php echo esc_attr( osi_main_class() ); ?>" role="main">

	<?php
	if ( have_posts() ) :
		?>
		<section class="content--page" id="content-page">
			<?php get_template_part( 'template-parts/breadcrumbs-sc_event' ); ?>
			<header class="page-header">
				<div class="wp-block-cover has-neutral-dark-background-color">
					<h1 class="archive-title page--title alignwide">
						<?php echo esc_html( osi_title() ); ?>
					</h1>
				</div>
				<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
			</header><!-- .page-header -->

			<div class="wp-block-buttons aligncenter upcoming-past-buttons">

				<div class="wp-block-button<?php echo ( 'upcoming' !== $display_type ? ' is-style-outline' : ' active' ); ?>">
					<a href="<?php echo esc_url( $upcoming_url ); ?>" class="wp-block-button__link wp-element-button has-neutral-dark-color has-text-color">
						<?php echo esc_html__( 'Upcoming Events', 'osi' ); ?>
						<span class="close">X</span>
					</a>
				</div>

				<div class="wp-block-button<?php echo ( 'past' !== $display_type ? ' is-style-outline' : ' active' ); ?>">
					<a href="<?php echo esc_url( $past_url ); ?>" class="wp-block-button__link wp-element-button has-neutral-dark-color has-text-color">
						<?php echo esc_html__( 'Past Events', 'osi' ); ?>
						<span class="close">X</span>
					</a>
				</div>
			</div>

			<div class="archive-columns wp-block-columns" id="content-scroll">

				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Format name) and that will be used instead.
					*/
					get_template_part( 'template-parts/content-archive', get_post_type() );

				endwhile;
				?>
			</div>
		</section>
			<?php
			if ( ! class_exists( 'Jetpack' ) || ! Jetpack::is_module_active( 'infinite-scroll' ) ) :
				the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => '&xlarr; Previous',
						'next_text' => 'Next &xrarr;',
					)
				);
			endif;
		else :
			get_template_part( 'template-parts/content', 'none' );
			?>
	<?php endif; ?>
</section>

	</main><!-- #primary -->

	<?php if ( osi_display_sidebar() ) : ?>
		<aside class="sidebar content--sidebar <?php echo esc_attr( osi_sidebar_class() ); ?>" role="complementary">
			<?php get_template_part( 'template-parts/sidebar' ); ?>
		</aside><!-- /.sidebar -->
	<?php endif; ?>

</section>

<?php
get_footer();
