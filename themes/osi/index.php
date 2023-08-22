<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

get_header(); ?>

<section class="content <?php echo ( osi_display_sidebar() ? 'has_sidebar' : 'has_no_sidebar' ); ?>" id="content">

	<main class="content--body <?php echo esc_attr( osi_main_class() ); ?>" role="main">

	<?php
	if ( have_posts() ) :
		?>
		<section class="content--page" id="content-page">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<?php
			if ( is_home() && ! is_front_page() ) :
				?>
				<header class="page--header">
					<h1 class="archive-columns archive-title page--title">
					<?php echo esc_html( osi_title() ); ?>
				</h1>
				</header>

			<?php endif; ?>
			<div class="wp-block-columns archive-columns" id="content-scroll">

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
			if ( ( class_exists( 'Jetpack' ) && ! Jetpack::is_module_active( 'infinite-scroll' ) ) || ! class_exists( 'Jetpack' ) ) :
				the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => '',
						'next_text' => '',
					)
				);
			endif;
			?>

		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
			</section>

	<?php endif; ?>

	</main><!-- #primary -->

	<?php if ( osi_display_sidebar() ) : ?>
		<aside class="sidebar content--sidebar <?php echo esc_attr( osi_sidebar_class() ); ?>" role="complementary">
			<?php get_template_part( 'template-parts/sidebar' ); ?>
		</aside><!-- /.sidebar -->
	<?php endif; ?>

</section>

<?php
get_footer();
