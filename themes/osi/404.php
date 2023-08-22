<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package osi
 */

get_header(); ?>

<section class="content <?php echo ( osi_display_sidebar() ? 'has_sidebar' : 'has_no_sidebar' ); ?>" id="content">

	<main class="content--body <?php echo esc_attr( osi_main_class() ); ?>" role="main">

		<section class="error-404 not-found content--page" id="content-page">
			<header class="entry-header page--header">
				<h1 class="page--title aligncenter"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'osi' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">

				<div class="wp-block-group">
					<?php dynamic_sidebar( 'sidebar-404' ); ?>
				</div>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #primary -->

	<?php if ( osi_display_sidebar() ) : ?>
		<aside class="sidebar content--sidebar <?php echo esc_attr( osi_sidebar_class() ); ?>" role="complementary">
			<?php get_template_part( 'template-parts/sidebar' ); ?>
		</aside><!-- /.sidebar -->
	<?php endif; ?>

</section>

<?php
get_footer();
