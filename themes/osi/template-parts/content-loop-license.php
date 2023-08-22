<?php
/**
 * Template part for the custom license archive loop
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

?>
<section class="license-search toggleable-section">
	<div class="toggle-header open" id="toggle-license-search"><h2><?php esc_html_e( 'Search Licenses', 'osi' ); ?></h2><p class="hide" id="search-prompt"><?php esc_html_e( "You've searched for: ", "osi" ); ?>‘<span></span>’<a class="clear" id="clear-search"><?php esc_html_e( 'clear search', 'osi' ); ?></a></p></div>
	<div class="toggle-content open" data-toggle="toggle-license-search">
		<?php get_template_part( 'template-parts/searchform-license' ); ?>	
	</div>
</section>
<section class="license-categories toggleable-section">
	<div class="toggle-header open" id="toggle-license-categories"><h2><?php esc_html_e( 'Categories', 'osi' ); ?> <span></span></h2></div>
	<div class="toggle-content open" data-toggle="toggle-license-categories">
		<span class="pill-taxonomy">
			<?php echo osi_get_terms_from_taxonomy_checkboxes( 'taxonomy-license-category' ); ?>
			<a class="clear hide" id="clear-categories"><?php esc_html_e( 'clear categories', 'osi' ); ?></a>
		</span>
	</div>
</section>
<section class="license-steward-link">
	<a class="button" href="/licenses"><?php esc_html_e( 'View All Licenses', 'osi' ); ?></a>
</section>
<section class="license-content">
	<?php
	the_posts_pagination(
		array(
			'mid_size'  => 1,
			'prev_text' => '',
			'next_text' => '',
		)
	);
	?>
	<table class="license-table table-sortable" id="content-scroll">
		<caption class="screen-reader-text"><?php esc_html_e('Column headers with buttons are sortable', 'osi'); ?></caption>
		<thead>
			<tr>
				<th id="license-header-title" aria-sort="ascending"><button class="table-sortable--toggle"><?php esc_html_e('License Name', 'osi'); ?></button></th>
				<th id="license-header-spdx"><button class="table-sortable--toggle"><?php esc_html_e('SPDX ID', 'osi'); ?></button></th>
				<th id="license-header-category"><button class="table-sortable--toggle"><?php esc_html_e('Category', 'osi'); ?></button></th>
			</tr>
		</thead>
		<tbody>
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content-loop-license-single' );
			endwhile; 
			?>
		</tbody>
	</table>
	<?php
	the_posts_pagination(
		array(
			'mid_size'  => 1,
			'prev_text' => '',
			'next_text' => '',
		)
	);
	?>
</section>
