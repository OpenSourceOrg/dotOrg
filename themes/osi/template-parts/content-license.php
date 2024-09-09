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
		</div>
		
		<aside class="sidebar content--sidebar license-sidebar <?php echo esc_attr( osi_sidebar_class() ); ?>" role="complementary">
			<?php dynamic_sidebar( 'license-sidebar' ); ?>
		</aside><!-- .license-sidebar -->
	</div><!-- .entry-content -->
	
	

</article><!-- #post-<?php the_ID(); ?> -->
