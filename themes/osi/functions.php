<?php
/**
 * Team 51 Starter Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package osi
 */

if ( ! function_exists( 'osi_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @return void
	 */
	function osi_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on osi, use a find and replace
		 * to change 'osi' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'osi', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		* Enable support for Responsive Embeds
		*/
		add_theme_support( 'responsive-embeds' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'_s_custom_background_args',
				array(
					'default-color'      => 'ffffff',
					'default-image'      => '',
					'default-preset'     => 'default',
					'default-size'       => 'cover',
					'default-repeat'     => 'no-repeat',
					'default-attachment' => 'scroll',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 300,
				'width'       => 600,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => array( 'site-title', 'site-description' ),
			)
		);

		/*
		* Register Nav Menus
		*/
		register_nav_menus(
			array(
				'primary_navigation'   => esc_html__( 'Primary', 'osi' ),
				'quicklink_navigation' => esc_html__( 'Quicklink', 'osi' ),
				'mobile_navigation'    => esc_html__( 'Mobile', 'osi' ),
				'footer_navigation'    => esc_html__( 'Footer', 'osi' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'osi_setup' );

/**
 * Register sidebars and widgets
 *
 * @return void
 */
function osi_widgets_init() {
	// Sidebars
	register_sidebar(
		array(
			'name'          => __( 'Primary', 'osi' ),
			'id'            => 'sidebar-primary',
			'before_widget' => '<section class="widget wp-block-column %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer', 'osi' ),
			'id'            => 'sidebar-footer',
			'before_widget' => '<section class="wp-block-column widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Social', 'osi' ),
			'id'            => 'sidebar-footer-cta',
			'before_widget' => '<section class="wp-block-column widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( '404', 'osi' ),
			'id'            => 'sidebar-404',
			'before_widget' => '<section class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'License Sidebar', 'osi' ),
			'id'            => 'license-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar on License posts.', 'osi' ),
			'before_widget' => '<section class="widget wp-block-column %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></section>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'osi_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width to set.
 * @return void
 */
function osi_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'osi_content_width', 640 );
}
add_action( 'after_setup_theme', 'osi_content_width', 0 );

/**
 * Add a reusable block admin menu link for easy administration.
 *
 * @return void
 */
function osi_reusable_blocks_admin_menu(): void {
	add_theme_page(
		'Reusable Blocks',
		'Reusable Blocks',
		'edit_posts',
		'edit.php?post_type=wp_block',
		'',
		22
	);
}
add_action( 'admin_menu', 'osi_reusable_blocks_admin_menu' );

/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
function osi_scripts() {
	wp_enqueue_style(
		'osi-style',
		get_stylesheet_uri(),
		array(),
		filemtime( untrailingslashit( get_template_directory() ) . '/style.css' )
	);

	wp_enqueue_style( 'dashicons' );

	$js_file = untrailingslashit( get_template_directory() ) . '/assets/js/build/theme.js';
	if ( file_exists( $js_file ) ) {
		wp_enqueue_script(
			'osi-theme-scripts',
			get_template_directory_uri() . '/assets/js/build/theme.js',
			array( 'jquery' ),
			filemtime( $js_file ),
			true
		);

		$data = array(
			'ajaxURL' => admin_url( 'admin-ajax.php' ),
			'action'  => 'osi_license_db',
		);
		wp_add_inline_script( 'osi-theme-scripts', 'const OSI_LICENSE_DB = ' . wp_json_encode( $data ), 'before' );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'osi_scripts' );

/**
 * Add inline styles to the frontend.
 *
 * @return void
 */
function osi_inline_styles() {
	wp_add_inline_style( 'osi-style', osi_palette_css() );
	wp_add_inline_style( 'osi-style', osi_gradient_css() );
	wp_add_inline_style( 'osi-style', osi_rgb_css() );
	wp_add_inline_style( 'osi-style', osi_inline_media_styles() );
}
add_action( 'wp_enqueue_scripts', 'osi_inline_styles', 100 ); // prioritize as last

/**
 * Add block editor assets.
 *
 * @return void
 */
function osi_add_block_editor_assets() {
	wp_enqueue_style( 'editor-styles', get_template_directory_uri() . '/assets/css/editor-style.css', '', 1 );
	wp_add_inline_style( 'editor-styles', osi_palette_css() );
	wp_add_inline_style( 'editor-styles', osi_gradient_css() );
	wp_add_inline_style( 'editor-styles', osi_rgb_css() );
	wp_add_inline_style( 'editor-styles', osi_inline_media_styles() );
}
add_action( 'enqueue_block_editor_assets', 'osi_add_block_editor_assets' );

/**
 * Config.
 */
require get_template_directory() . '/inc/config.php';

/**
 * Sidebar functions.
 */
require get_template_directory() . '/inc/class-osi-sidebar.php';

/**
 * Color functions.
 */
require get_template_directory() . '/inc/palette.php';

/**
 * Custom fonts.
 */
require get_template_directory() . '/inc/custom-fonts.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Editor additions.
 */
require get_template_directory() . '/inc/editor.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Block Functions
 */
require get_template_directory() . '/inc/block-templates.php';
require get_template_directory() . '/inc/block-patterns.php';
require get_template_directory() . '/inc/block-styles.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load the SVG icons class.
 */
require get_template_directory() . '/inc/class-svg.php';

/**
 * Load the Sugar Calendar compatibility file.
 */
if ( class_exists( 'Sugar_Calendar\\Requirements_Check' ) ) {
	require get_template_directory() . '/inc/sugar-calendar.php';
}
/**
 * Register the "Footer - Above credits" sidebar.
 *
 * @return void
 */
function register_footer_above_sidebar() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer - Above Credits', 'osi' ),
			'id'            => 'footer-above-credits',
			'description'   => esc_html__( 'Add widgets here to appear above the credits in the footer.', 'osi' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'register_footer_above_sidebar' );

/**
 * Adjust the 'blog' (post archive) to show a different number of posts on the first page.
 *
 * @param WP_Query $query WordPress Query object.
 *
 * @return void
 */
function osi_query_offset( WP_Query &$query ) {
	if ( ! ( $query->is_blog() || is_main_query() ) || is_admin() || is_front_page() || is_archive() || is_404() ) {
		return;
	}

	// If this is a page and its not set as the page for posts, return.
	if ( (int) get_option( 'page_for_posts' ) !== (int) get_queried_object_id() ) {
		return;
	}

	$offset = -1;
	$ppp    = get_option( 'posts_per_page' );

	if ( $query->is_paged ) {
		// Manually determine page query offset (offset + current page (minus one) x posts per page)
		$page_offset = $offset + ( ( $query->query_vars['paged'] - 1 ) * $ppp );
		// Apply adjust page offset
		$query->set( 'offset', $page_offset );
	} else {
		// This is the first page. Set a different number for posts per page
		$query->set( 'posts_per_page', $offset + $ppp );
	}
}
add_action( 'pre_get_posts', 'osi_query_offset', 1 );

/**
 * Adjust the pagination offset.
 *
 * @param integer  $found_posts The number of found posts.
 * @param WP_Query $query       WordPress Query object.
 *
 * @return integer Adjusted number of found posts.
 */
function osi_adjust_offset_pagination( int $found_posts, WP_Query $query ) {
	$offset = -1;
	if ( $query->is_blog() && is_main_query() && ! is_admin() && ! $query->is_front_page() ) {
		return $found_posts - $offset;
	}
	return $found_posts;
}
add_filter( 'found_posts', 'osi_adjust_offset_pagination', 1, 2 );

/**
 * Trim the Discourse comment body to 50 words.
 *
 * @param string $comment_body The comment body.
 *
 * @return string The trimmed comment body.
 */
function osi_wpdc_comment_body( string $comment_body ) {
	$trimmed_comment_body = wp_trim_words( $comment_body, 50, '(...)' );
	return $trimmed_comment_body;
}
add_filter( 'wpdc_comment_body', 'osi_wpdc_comment_body', 10, 1 );
