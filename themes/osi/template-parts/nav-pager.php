<?php // Nav Pager (single)
$post_type_obj = get_post_type( $post );
$all           = get_post_type_object( $post_type_obj )->labels->all_items;
$slug          = get_post_type_object( $post_type_obj )->rewrite['slug'];

if ( is_singular( 'post' ) ) :
	$post_link = get_permalink( get_option( 'page_for_posts' ) );
elseif ( $slug ) :
	$post_link = '/' . $slug;
else :
	$post_link = '/' . $post_type;
endif;
?>

<nav aria-label="Content Pagination" class="nav-pager post--pager">
	<?php previous_post_link( '%link', '&larr; Previous' ); ?>
	<a class="post--pager-all" href="<?php echo esc_url( $post_link ); ?>"><?php echo esc_html( $all ); ?></a>
	<?php next_post_link( '%link', 'Next &rarr;' ); ?>
</nav>
