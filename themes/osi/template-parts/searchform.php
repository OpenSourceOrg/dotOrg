<?php // Search Form

/* Generate unique ID for each search form on page */
global $txt_search;
if ( ! isset( $txt_search ) ) {
	$txt_search = 1;
}

$search_query = '';
$search_name  = '';
$action_url   = '';

if ( is_license_search() ) {

	$search_query = get_license_search_query();
	$search_name  = 'ls';
	$action_url   = get_post_type_archive_link( 'license' );

} elseif ( is_search() ) {

	$search_query = get_search_query();
	$search_name  = 's';
	$action_url   = home_url( '/' );

}

?>

<section class="search-form">
	<form role="search" method="get" class="search--form" action="<?php echo esc_url( $action_url ); ?>">
		<div class="form--group">
			<label for="txtSearch-<?php echo esc_html( $txt_search ); ?>"><?php esc_html_e( 'Search for:', 'osi' ); ?></label>
			<input id="txtSearch-<?php echo esc_html( $txt_search++ ); ?>" type="search" value="<?php echo esc_attr( $search_query ); ?>" name="<?php echo esc_attr( $search_name ); ?>" class="textbox search--textbox" placeholder="<?php echo esc_html( 'Search ' . get_bloginfo( 'name' ) ); ?>">
			<button type="submit" class="button search--button"><?php esc_html_e( 'Search', 'osi' ); ?></button>
		</div>
	</form>
</section>
