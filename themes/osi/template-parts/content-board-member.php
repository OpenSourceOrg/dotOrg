<?php
/**
 * Template for displaying a board member in a side-by-side layout:
 *  - Left column (header) is 30% width, sticky under the site header.
 *  - Right column (main content) is 70% width, scrolls normally.
 *  - The wrapper spans 100% of the browser width.
 *
 * @package osi
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="board-member-wrapper">
		
		<!-- LEFT COLUMN: Sticky CPT Header (30% width) -->
		<div class="board-member-header">
			<?php get_template_part( 'template-parts/header-board-member' ); ?>
		</div>
		
		<!-- RIGHT COLUMN: Main Content (70% width, scrolls normally) -->
		<div class="board-member-content">
			<div class="entry-content post--content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
			
			<section class="alignwide email-block">
				<?php // get_template_part( 'template-parts/nav-postname-pager' ); ?>
				<?php // get_template_part( 'template-parts/email-block' ); ?>
			</section>
		</div><!-- .board-member-content -->
	</div><!-- .board-member-wrapper -->
</article>

<style>
/* Make the wrapper fill the entire screen width */
.board-member-wrapper {
	width: 100%;
	max-width: none;
	margin: 0;
	padding: 0;
	display: flex;
	align-items: flex-start; /* top-align columns */
}

/* LEFT COLUMN: 30% width, sticky under the site header */
.board-member-header {
	position: sticky;
	top: 120px; /* adjust to your site header height */
	width: 30%;
	flex-shrink: 0; /* don't let the left column shrink */
	background-color: #fff; /* optional if you need a background */
	padding: 20px;
	box-sizing: border-box;
}

/* RIGHT COLUMN: 70% width, scrolls normally */
.board-member-content {
	width: 70%;
	padding: 20px;
	box-sizing: border-box;
}
</style>