<?php
/**
 * The header for our theme
 *
 * Custom header for AI
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package osi
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div class="wrapper" role="document">
		<header id="masthead" class="site-header header-main ai-header">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'osi' ); ?></a>
			<div class="header--inner">
				<div class="site-branding header--blog-name">
					<?php osi_linked_logo( 'header-logo', 'large' ); ?>
				</div><!-- .site-branding -->
				<nav aria-label="Primary" id="site-navigation" class="nav-main" role="navigation">
					<?php
					if ( array_key_exists( 'ai', get_registered_nav_menus() ) ) :
							wp_nav_menu(
								array(
									'theme_location' => 'primary_navigation',
									'menu_class'     => 'nav-main--menu',
									'menu'           => 'ai',
								)
							);
					endif;
					if ( has_nav_menu( 'ai' ) ) :
							wp_nav_menu(
								array(
									'theme_location' => 'mobile_navigation',
									'menu_class'     => 'nav-mobile--menu',
									'menu'           => 'ai',
								)
							);
					endif;
					?>
				</nav><!-- #site-navigation -->

				<section class="open-button-wrapper">
						<button aria-label="Open Menu" id="openMainMenu" class="open-main-menu open-button">
							<span class="menu-text"><?php esc_html_e( 'Open Main Menu', 'osi' ); ?></span>
							<span></span>
							<span></span>
						</button>
						<?php echo wp_kses_post( osi_sidebar_button() ); ?>
				</section>
			</div>
		</header><!-- #masthead -->
