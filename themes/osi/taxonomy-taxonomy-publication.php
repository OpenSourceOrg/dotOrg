<?php
/**
 * The template for displaying archive pages
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
		$postCount = 0;
		?>
		<section class="content--page" id="content-page">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
				<div class="archive-press-mentions" id="content-scroll">

				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					$postCount++;
					the_post();

					if( $postCount == 1 ) : 
						
						if ( !is_paged() ) :
						?>

							<header class="page-header press-mentions-header wp-block-cover alignfull has-neutral-dark-background-color has-neutral-white-text-color has-background-dim-100 has-background-dim alignfull">
								<div class="wp-block-cover__inner-container">
									<h1 class="archive-title page--title press-mentions-title">
										<?php echo esc_html( osi_title() ); ?>
									</h1>
									<?php get_template_part( 'template-parts/content-archive', 'press-mentions' ); ?>
								</div>
							</header><!-- .page-header -->
						
						<?php else : ?>

							<header class="page-header press-mentions-header">
								<h1 class="archive-title page--title">
									<?php echo esc_html( osi_title() ); ?>
								</h1>
							</header><!-- .page-header -->

							<?php get_template_part( 'template-parts/content-archive', 'press-mentions' ); ?>
						
						<?php endif; ?>
								
					<?php else :
					
						get_template_part( 'template-parts/content-archive', 'press-mentions' );
					
					endif;

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
		else :
			?>
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
