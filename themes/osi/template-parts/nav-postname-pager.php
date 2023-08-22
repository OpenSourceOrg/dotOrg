<?php // Nav Pager (single)
$post_type_obj = get_post_type( $post );
$slug          = get_post_type_object( $post_type_obj )->rewrite['slug'];
$prev          = get_previous_post();
$next          = get_next_post();
?>

<section class="nav-pager postname-pager">
<?php
if ( $prev ) :
	setup_postdata( $prev );
	?>
	<div class="pager pager--previous">
	<p class="pager--title"><a class="read-more" href="<?php echo esc_url( get_the_permalink( $prev ) ); ?>"><?php echo esc_html( get_the_title( $prev ) ); ?></a></p>
	</div>
	<?php
	wp_reset_postdata();
endif;
if ( $next ) :
	setup_postdata( $next );
	?>
	<div class="pager pager--next">
	<p class="pager--title"><a class="read-more" href="<?php echo esc_url( get_the_permalink( $next ) ); ?>"><?php echo esc_html( get_the_title( $next ) ); ?></a></p>
	</div>
	<?php
	wp_reset_postdata();
endif;
?>
</section>
