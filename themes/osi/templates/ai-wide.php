<?php
/*
Template Name: AI Full Width
Template Post Type: page
Description: Custom template for full width
*/

get_header( 'ai' ); ?>

<section class="content ai-full-width" id="content">

	<main class="content--body <?php echo esc_attr( osi_main_class() ); ?>" role="main">
		<section class="content--page" id="content-page">
			<?php
			get_template_part( 'template-parts/breadcrumbs' );

			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'page-no-header' );
			endwhile; // End of the loop.
			?>
		</section>
	</main><!-- #primary -->

</section>

<?php
get_footer();
