<?php
/**
 * Template part for displaying board member post type content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="board-member-layout">
		<!-- Include the header for the board member -->
		<div class="left-column">
			<?php get_template_part('template-parts/header-board-member'); ?>
		</div>

		<!-- Right Column for the post content -->
		<div class="right-column">
			<div class="entry-content post--content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

<style>
.board-member-layout {
    display: flex;
}

.left-column {
    flex: 0 0 30%; /* Fixed width of 30% */
    padding: 20px; /* Optional padding */
    text-align: center; /* Center content */
}

.right-column {
    flex: 1; /* Takes the remaining space */
    overflow-y: auto; /* Makes it scrollable if content overflows */
    padding: 20px; /* Optional padding */
}

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
