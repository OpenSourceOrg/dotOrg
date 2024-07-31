<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php get_template_part( 'template-parts/header-featured-image' ); ?>

	<div class="entry-content post--content">
		<?php 
		$sugar_cal_post_type_id = 'placeholder';
		if ( class_exists( 'Sugar_Calendar\\Requirements_Check' ) ) {
			$sugar_cal_post_type_id = sugar_calendar_get_event_post_type_id();
		}
		if ( $sugar_cal_post_type_id !== get_post_type() ) { ?>

			<div class="entry-meta post--byline">
				<?php osi_posted_on(); ?>
				<?php echo wp_kses_post( osi_get_single_taxonomy_terms_links( $post, 'category' ) ); ?>
				<div class="post--metadata-group">
					<ul>
						<li>
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>">
								<?php the_author(); ?>
							</a>
						</li>
					</ul>
				</div>
			</div><!-- .entry-meta -->

		<?php } ?>
		<?php the_title( '<h1 class="entry-title post--title">', '</h1>' ); ?>

		<?php the_content(); ?>
	</div><!-- .entry-content -->
	<section id="pre-footer">
		<?php get_template_part( 'template-parts/nav-postname-pager' ); ?>
	</section>

</article><!-- #post-<?php the_ID(); ?> -->
