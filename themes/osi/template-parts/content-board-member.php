<?php
/**
 * Template for displaying a board member in a side-by-side layout.
 * All header elements in one column on the left, fixed below the site header.
 *
 * @package osi
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="board-member-wrapper">
		
		<!-- Fixed Left Column: CPT Header -->
		<div class="board-member-header">
			<?php get_template_part( 'template-parts/header-board-member' ); ?>
		</div>
		
		<!-- Scrollable Right Column: Main Content -->
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
/* Overall wrapper to place columns side by side */
.board-member-wrapper {
	display: flex;
}

/* Left Column: Fixed Header (one column stacked) */
.board-member-header {
	width: 40%; 
	position: fixed;
	top: 120px; /* Adjust this to match your site header’s height */
	left: 0;
	bottom: 0;
	overflow-y: auto;
	background-color: #fff;
	padding: 20px;
	box-sizing: border-box;
}

/* Right Column: Scrollable Content */
.board-member-content {
	margin-left: 40%; /* Must match board-member-header width */
	width: 60%;
	padding: 20px;
	overflow-y: auto;
	box-sizing: border-box;
}

/* Stack all items in header vertically */
.cpt-header-single-column > * {
	display: block;
	margin-bottom: 1rem;
}

/* Existing styles for images, text, etc. */
.member-image {
	margin-bottom: 1.5rem;
}
.member-image img.circular-image {
	border-radius: 50%;
	border: 4px solid #FFF;
	width: 300px; /* adjust as needed */
	height: 300px;
	object-fit: cover;
}
.member-position,
.member-dates,
.member-seat,
.member-term-item {
	display: block;
	margin-bottom: 1rem;
}
.member-pronouns {
	font-family: 'Space Mono', monospace;
	display: inline-block;
}
</style>