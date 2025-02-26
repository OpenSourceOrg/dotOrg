<?php
/**
 * Template for displaying a board member in a side-by-side layout:
 * Left column (header) is 30% wide and sticky; right column is 70% wide.
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
/* 
   The container for both columns:
   - We use flex to lay out the left and right columns.
   - We leave some gap if needed.
*/
.board-member-wrapper {
	display: flex;
	align-items: flex-start; /* So columns align at the top */
	gap: 0; /* adjust as desired */
}

/* LEFT COLUMN: 30% width, sticky under the site header */
.board-member-header {
	position: sticky;
	top: 120px; /* match this to your site header height so there's no overlap */
	width: 30%;
	flex-shrink: 0; /* prevents the left column from shrinking */
	box-sizing: border-box;
}

/* RIGHT COLUMN: 70% width, scrolls normally */
.board-member-content {
	width: 70%;
	padding: 20px;
	box-sizing: border-box;
}
</style>