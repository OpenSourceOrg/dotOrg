<?php
/**
 * Template part for displaying board memeber post type content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php get_template_part( 'template-parts/header-board-member' ); ?>

		<div class="entry-content post--content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
		<section class="alignwide email-block">
			<?php // get_template_part( 'template-parts/nav-postname-pager' ); ?>
			<?php // get_template_part( 'template-parts/email-block' ); ?>
		</section>

	</article><!-- #post-<?php the_ID(); ?> -->
