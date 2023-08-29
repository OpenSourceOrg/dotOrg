<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="entry-content post--content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->

		<?php osi_the_page_dates(); ?>

	</article><!-- #post-<?php the_ID(); ?> -->
