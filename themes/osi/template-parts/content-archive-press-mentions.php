<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */
global $post;
$permalink = get_field( 'article_url' ) ? get_field( 'article_url' ) : '';
$publication = get_the_terms( $post->ID, 'taxonomy-publication' ) && !is_wp_error( get_the_terms( $post->ID, 'taxonomy-publication' ) ) ? get_the_terms( $post->ID, 'taxonomy-publication' )[0] : false;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'archive' ); ?>>
	<section class="post--summary osi-list--post-content">
		<header class="entry-header">
			<?php if( osi_field_check( 'date_of_publication' ) ) : ?>
				<span class="post--byline entry-meta">
					<?php osi_the_valid_date_field( 'date_of_publication', 'F j, Y' ); ?>
				</span>
			<?php endif; ?>
			<?php the_title( '<h2 class="post--title entry-title"><a href="' . esc_url( $permalink ) . '" rel="bookmark" target="_blank">', '</a></h2>' );
			?>
			<?php if( $publication ) : ?>
			<a class="post--publication" href="<?php echo esc_url( get_term_link( $publication->term_id ) ); ?>" target="_blank">
				<?php echo esc_html( $publication->name ); ?>
			</a>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content post--summary">
			<?php 
			if( has_excerpt() ) :
				  the_excerpt();
			endif; 
			?>
		</div><!-- .entry-content -->
	</section>

</article><!-- #post-<?php the_ID(); ?> -->
