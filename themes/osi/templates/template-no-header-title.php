<?php
/**
 * Template Name: No Header with Title
 * Template Post Type: post, page, podcast, board-member, license, meeting-minutes, press-mentions, event, supporter
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

get_header(); ?>

<section class="content <?php echo ( osi_display_sidebar() ? 'has_sidebar' : 'has_no_sidebar' ); ?>" id="content">

	<main class="content--body <?php echo esc_attr( osi_main_class() ); ?>" role="main">

		<section class="content--page" id="content-page">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<?php
			while ( have_posts() ) :
				the_post();
				the_title( '<h1>', '</h1>' );
				get_template_part( 'template-parts/content', 'page-no-header' );

			endwhile; // End of the loop.
			?>

		</section>

	</main><!-- #primary -->

</section>

<?php
get_footer();
