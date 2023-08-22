<?php
/**
 * Template part for displaying single row of search
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

?>
<tr>
	<td class="search-table--title" data-label="Results">
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
		<p class="search-table--description">
			<?php echo wp_kses_post( wp_trim_words( get_the_content(), 20, '...' ) ); ?>
		</p>
	</td>
	<td class="search-table--published" data-label="Publication Date">
		<?php echo get_the_date(); ?>
	</td>
	<td class="search-table--result-type" data-label="Result Type">
		<span class="inline-list">
			<?php echo esc_html( get_post_type_object( $post->post_type )->labels->singular_name ); ?>
		</span>
	</td>
</tr>
