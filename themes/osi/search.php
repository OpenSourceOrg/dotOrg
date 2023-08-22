<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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

			<header class="entry-header page--header">
				<h1 class="page--title">
					<?php esc_html_e( 'Search Results', 'osi' ); ?>
				</h1>
			</header><!-- .page-header -->
			<?php if ( post_type_exists( 'license' ) ) : ?>
				<?php get_template_part( 'template-parts/content-loop-search' ); ?>
			<?php else : ?>
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
			<?php endif; ?>

	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
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
