<?php
/**
 * Template part for the custom search archive loop
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

?>
<section class="search-content">
	<?php
	the_posts_pagination(
		array(
			'mid_size'  => 1,
			'prev_text' => '&xlarr; Previous',
			'next_text' => 'Next &xrarr;',
		)
	);
	?>
	<table class="search-table table-sortable" id="content-scroll">
		<caption class="screen-reader-text"><?php esc_html_e( 'Column headers with buttons are sortable', 'osi' ); ?></caption>
		<colgroup>
			<col span="1" style="width: 50%;">
			<col span="1" style="width: 25%;">
			<col span="1" style="width: 25%;">
		</colgroup>
		<thead>
			<tr>
				<th id="search-header-title" aria-sort="ascending"><button class="table-sortable--toggle"><?php esc_html_e( 'Results', 'osi' ); ?></button></th>
				<th id="search-header-published"><button class="table-sortable--toggle"><?php esc_html_e( 'Publication Date', 'osi' ); ?></button></th>
				<th id="search-header-category"><button class="table-sortable--toggle"><?php esc_html_e( 'Result Type', 'osi' ); ?></button></th>
			</tr>
		</thead>
		<tbody>
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content-loop-search-single' );
			endwhile;
			?>
		</tbody>
	</table>
	<?php
	the_posts_pagination(
		array(
			'mid_size'  => 1,
			'prev_text' => '&xlarr; Previous',
			'next_text' => 'Next &xrarr;',
		)
	);
	?>
</section>
