<?php
/**
 * Template for displaying a board member in a side-by-side layout.
 *
 * @package osi
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="board-member-wrapper">
		<!-- Fixed Left Column: Header -->
		<div class="board-member-header">
			<?php get_template_part( 'template-parts/header-board-member' ); ?>
		</div>
		
		<!-- Scrollable Right Column: Content -->
		<div class="board-member-content">
			<div class="entry-content post--content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
			<section class="alignwide email-block">
				<?php // Uncomment below if needed: get_template_part( 'template-parts/nav-postname-pager' ); ?>
				<?php // Uncomment below if needed: get_template_part( 'template-parts/email-block' ); ?>
			</section>
		</div>
	</div>
</article>

<style>
.board-member-wrapper {
	display: flex;
}

/* Left Column: Fixed Header */
.board-member-header {
	width: 40%;               /* Adjust as needed (or use a fixed width, e.g., 350px) */
	position: fixed;          /* Keeps the header fixed on the left */
	top: 0;
	left: 0;
	bottom: 0;
	overflow-y: auto;         /* In case header content overflows */
	background-color: #fff;   /* Optional: ensures the content below doesn't show through */
	padding: 20px;            /* Optional spacing */
	box-sizing: border-box;
}

/* Right Column: Scrollable Content */
.board-member-content {
	margin-left: 40%;         /* Must match header width; if using fixed px for header, set this to same px value */
	width: 60%;
	padding: 20px;
	overflow-y: auto;
	box-sizing: border-box;
}
</style>