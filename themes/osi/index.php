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
			<?php
				if ( 'event' === get_post_type() ) {
					get_template_part( 'template-parts/breadcrumbs-sc_event' );
				} else {
					get_template_part( 'template-parts/breadcrumbs' );
				}
				$count = 0;
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();
					// this conditional is just for the first post on the post archive page, so it'll display outside of the main archive loop
					if ( is_home() && ! is_paged() && 0 === $wp_query->current_post ) :
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'archive wp-block-column first-post ' ); ?>>
							<?php get_template_part( 'template-parts/featured-image', 'medium' ); ?>
							<section class="post--summary osi-list--post-content">
								<header class="entry-header">
								<?php echo wp_kses_post( osi_get_single_taxonomy_terms_links( $post, 'category' ) ); ?>
									<?php
									the_title( '<h2 class="post--title entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
									?>
								</header><!-- .entry-header -->

								<div class="entry-content post--summary">
									<?php
										the_excerpt(
											/* translators: %s: Name of current post. Only visible to screen readers */
											wp_kses( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'osi' ), 'osi' )
										);
									?>
								</div><!-- .entry-content -->

								<div class="entry-meta">
									<?php
									if ( 'post' === get_post_type() ) :
										?>
											<div class="post--byline entry-meta">
												<?php osi_posted_on(); ?>
												by 
												<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>">
													<?php the_author(); ?>
												</a>
											</div><!-- .entry-meta -->
											<?php
									endif;
									?>
								</div>
							</section>

						</article><!-- #post-<?php the_ID(); ?> -->
						<div class="special-sep">
							<hr />
						</div>
						<?php
					else :
						if ( 0 === $count ) :
							?>
						<div class="post-archive-wrap">
							<h2>Recent Posts</h2>
							<div class="wp-block-columns archive-columns" id="content-scroll">
						<?php endif; ?>
						<?php
						get_template_part( 'template-parts/content-archive', get_post_type() );
						$count++;
					endif;
				endwhile;
				?>
				</div>
			</div>
			<aside class="sidebar content--sidebar <?php echo esc_attr( osi_sidebar_class() ); ?>" role="complementary">
				<?php get_template_part( 'template-parts/sidebar' ); ?>
			</aside><!-- /.sidebar -->
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
</section>

<?php
get_footer();
