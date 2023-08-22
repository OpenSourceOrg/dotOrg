<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'archive' ); ?>>
	<section class="post--summary osi-list--post-content">
		<header class="entry-header">
			<?php
			the_title( '<h2 class="post--title entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
		</header><!-- .entry-header -->

		<div class="entry-content post--summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->
	</section>

</article><!-- #post-<?php the_ID(); ?> -->
