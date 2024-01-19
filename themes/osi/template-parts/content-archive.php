<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

?>
<?php $content_size = ( 'post' !== get_post_type() && ! is_search() ) ? 'three-column' : 'two-column'; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'archive wp-block-column ' . $content_size ); ?>>
	<?php get_template_part( 'template-parts/featured-image', 'cropped' ); ?>
	<section class="post--summary osi-list--post-content">
		<header class="entry-header">
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
		<?php
		if ( 'post' === get_post_type() ) :
			?>
			<div class="post--byline entry-meta">
				<?php osi_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php
		endif;
		?>
	</section>

</article><!-- #post-<?php the_ID(); ?> -->
