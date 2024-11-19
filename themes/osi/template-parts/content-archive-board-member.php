<?php
/**
 * Template part for displaying board members
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

?>
<?php $content_size = ( 'post' !== get_post_type() && !is_search() ) ? 'three-column' : 'two-column'; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'archive wp-block-column ' . $content_size ); ?>>
	<?php get_template_part( 'template-parts/featured-image', 'cropped' ); ?>
	<section class="post--summary osi-list--post-content">
		<header class="entry-header">
		<span class="member-seat inline-list">
			<?php echo wp_kses_post( osi_get_single_taxonomy_terms_links( $post, 'taxonomy-status' ) ); ?>
		</span>
			<?php the_title( '<h2 class="post--title entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content post--summary">
		<p class="member-details">
				<?php if ( osi_field_check( 'pronouns' ) ) : ?>
					<span class="member-pronouns">
						<?php osi_the_valid_field( 'pronouns' ); ?>
					</span>
				<?php endif; ?>

				<?php if ( osi_field_check( 'board_position' ) ) : ?>
					<span class="member-position">
						<?php osi_the_valid_field( 'board_position' ); ?>
					</span>
				<?php endif; ?>
			</p>
			<?php if( osi_field_check( 'current_term_start_date' ) ) : ?>
				<p class="member-dates">
					<?php 
					echo __( 'Current Term:', 'osi' ) . ' ';
					osi_the_valid_date_field( 'current_term_start_date', 'M Y' );
					if( osi_field_check( 'current_term_end_date' ) ) :
						echo ' ' . __( 'to', 'osi' ) . ' ';
						osi_the_valid_date_field( 'current_term_end_date', 'M Y' );
					endif;
					?>
				</p>
			<?php endif; ?>
		</div><!-- .entry-content -->
	</section>

</article><!-- #post-<?php the_ID(); ?> -->
