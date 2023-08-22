<?php
/**
 * Template part for displaying single row of license
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package osi
 */

?>
<tr>
	<td class="license-table--title">
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</td>
	<td class="license-table--spdx">
		<?php osi_the_valid_sub_field( 'spdx_identifier', 'display_text' ); ?>
	</td>
	<td class="license-table--category">
		<span class="inline-list">
			<?php echo wp_kses_post( osi_get_single_taxonomy_terms_links( $post, 'taxonomy-license-category' ) ); ?>
		</span>
	</td>
</tr>