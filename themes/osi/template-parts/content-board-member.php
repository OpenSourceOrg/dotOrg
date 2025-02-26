<?php
/**
 * Template for displaying a board member in a side-by-side layout
 * where the left column (header) is sticky and only the right column scrolls.
 *
 * @package osi
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="board-member-wrapper">
		
		<!-- Left Column: Sticky CPT Header -->
		<div class="board-member-header">
			<?php get_template_part( 'template-parts/header-board-member' ); ?>
		</div>
		
		<!-- Right Column: Scrollable Content -->
		<div class="board-member-content">
			<div class="entry-content post--content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
			
			<section class="alignwide email-block">
				<?php // get_template_part( 'template-parts/nav-postname-pager' ); ?>
				<?php // get_template_part( 'template-parts/email-block' ); ?>
			</section>
		</div>
	</div><!-- .board-member-wrapper -->
</article>

<style>
/* 
   1) We make a flex container for the two columns.
   2) The left column is "sticky" so it stays pinned below the site header.
   3) The right column scrolls normally.
*/

.board-member-wrapper {
	display: flex;
	align-items: flex-start; /* So columns top-align */
	gap: 20px; /* optional spacing between columns */
}

/* LEFT COLUMN: Sticky */
.board-member-header {
	position: sticky; 
	top: 120px; /* adjust to your site header’s height */
	flex-shrink: 0; /* so it doesn’t shrink */
	width: 350px;    /* pick any suitable width */
	background-color: #fff;
	padding: 20px;
	box-sizing: border-box;
}

/* RIGHT COLUMN: Normal Flow, Fills Remaining Space */
.board-member-content {
	flex: 1;
	padding: 20px;
	box-sizing: border-box;
}
</style>