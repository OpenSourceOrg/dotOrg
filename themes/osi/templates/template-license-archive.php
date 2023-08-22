<?php
/**
 * Template Name: License Archive
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

global $wp_query;
get_header(); ?>

<section class="content <?php echo ( osi_display_sidebar() ? 'has_sidebar' : 'has_no_sidebar' ); ?>" id="content">

	<main class="content--body <?php echo esc_attr( osi_main_class() ); ?>" role="main">

		<section class="content--page" id="content-page">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content post--content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->

				</article><!-- #post-<?php the_ID(); ?>-->

			<?php endwhile; // End of the loop. ?>

		<?php
		$main_query = $wp_query; // save old query
		$paged      = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$categories = ( get_query_var( 'categories' ) ) ? get_query_var( 'categories' ) : '';

		$args = array(
			'post_type'      => 'license',
			'paged'          => $paged,
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'publish_status' => 'publish',
		);

		if ( $categories ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'taxonomy-license-category',
					'field'    => 'slug',
					'terms'    => explode( ',', $categories ),
				),
			);
		}

		// change wp_query so we can use standard archive template part
		$wp_query = new WP_Query( // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$args
		);

		if ( have_posts() ) :

			get_template_part( 'template-parts/content-loop-license' );
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;

		$wp_query = $main_query; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- reset wp_query to original query
		?>

		</section>

	</main><!-- #primary -->

</section>

<?php
get_footer();
