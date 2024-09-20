<?php
/**
 * Template part for displaying license post type content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php get_template_part( 'template-parts/header-license' ); ?>

	<div class="entry-content post--content license-content">
		<div>
			<?php the_content(); ?>
			
			<hr />
			<div class="license-comments">
				<?php
				if ( osi_field_check( 'comments' ) ) :
					echo wp_kses_post( '<h2 class="wp-block-heading" id="license-comments">' . __( 'Comments', 'osi' ) . '</h2>' );
					osi_the_valid_field( 'comments' );
				endif;
				?>
			</div>
		</div>
		
		<aside class="sidebar content--sidebar license-sidebar <?php echo esc_attr( osi_sidebar_class() ); ?>" role="complementary">
			<?php dynamic_sidebar( 'license-sidebar' ); ?>
		</aside><!-- .license-sidebar -->
	</div><!-- .entry-content -->
	
	

</article><!-- #post-<?php the_ID(); ?> -->
