<?php
/*
Template Name: AI Full Width
Template Post Type: page
Description: Custom template for full width
*/

if ( osi_field_check( 'osi_use_ai_header' ) && true === (bool) osi_get_valid_field( 'osi_use_ai_header' ) ) :
	get_header( 'ai' );
else :
	get_header();
	// Display the AI secondary nav menu
        echo '<div class="ai-secondary-navbar-wrapper">';
        wp_nav_menu( array(
          'theme_location' => 'ai_secondary_nav',
          'menu'           => 'AI secondary nav',
          'container'      => 'nav',
          'container_class'=> 'ai-secondary-nav',
          'menu_class'     => 'ai-secondary-nav-menu',
        ) );
        echo '</div>';
endif;
?>

<section class="content ai-full-width" id="content">

	<main class="content--body <?php echo esc_attr( osi_main_class() ); ?>" role="main">
		<section class="content--page" id="content-page">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'page-no-header' );
			endwhile; // End of the loop.
			?>
		</section>
	</main><!-- #primary -->

</section>

<?php
if ( osi_field_check( 'osi_use_ai_footer' ) && true === (bool) osi_get_valid_field( 'osi_use_ai_footer' ) ) :
	get_footer( 'ai' );
else :
	get_footer();
endif;
