<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package osi
 */

get_header(); ?>

<section class="content <?php echo ( osi_display_sidebar() ? 'has_sidebar' : 'has_no_sidebar' ); ?>" id="content">

	<main class="content--body <?php echo esc_attr( osi_main_class() ); ?>" role="main">
		<section class="content--page" id="content-page">
			<?php
			if ( 'event' === get_post_type() ) {
				get_template_part( 'template-parts/breadcrumbs-sc_event' );
			} else {
				get_template_part( 'template-parts/breadcrumbs' );
			}
			
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

				//If comments are open or we have at least one comment, load up the comment template.
				if ( 'board-member' === get_post_type() || 'post' === get_post_type() ) :
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endif;

			endwhile; // End of the loop.
			?>
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
