<?php // Search Form

/* Generate unique ID for each search form on page */
global $txt_search;
if ( ! isset( $txt_search ) ) {
	$txt_search = 1;
}
?>

<section class="search-form">
	<form role="search" method="get" class="search--form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="form--group">
			<label for="txtSearch-<?php echo esc_html( $txt_search ); ?>"><?php esc_html_e( 'Search for:', 'osi' ); ?></label>
			<input id="txtSearch-<?php echo esc_html( $txt_search++ ); ?>" type="search" value="<?php echo is_license_search() ? get_license_search_query() : ''; ?>" name="ls" class="textbox search--textbox" placeholder="<?php echo esc_html( 'Search by keyword, SPDX ID, Steward, etc.' ); ?>">

			<button type="submit" class="button search--button"><?php esc_html_e( 'Search', 'osi' ); ?></button>
		</div>
	</form>
</section>
