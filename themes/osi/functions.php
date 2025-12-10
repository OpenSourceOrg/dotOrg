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

/**
 * Register the AI block template.
 *
 * @return void
 */
function osi_register_block_template() {
	$post_type     = 'page'; // Assign the template to pages
	$template_slug = 'ai-template';
	$template_file = 'templates/ai-template.html';

	// Register the block template
	register_block_template(
		$post_type,
		array(
			'title' => __( 'AI Template new', 'osi' ),
			'slug'  => $template_slug,
			'path'  => get_theme_file_path( $template_file ),
		)
	);

	// Enqueue styles conditionally
	add_action(
		'wp_enqueue_scripts',
		function () use ( $template_slug ) {
			if ( get_page_template_slug() === 'templates/ai-template.html' || get_page_template_slug() === 'templates/ai-fse.php' ) {
				// Font Awesome - Updated to latest version
				wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1' );

				// Other CSS files
				wp_enqueue_style( 'swiper', 'https://opensourceorg.github.io/ai/assets/css/plugins/swiper.css', array(), '1.0.0' );
				wp_enqueue_style( 'unicons', 'https://opensourceorg.github.io/ai/assets/css/plugins/unicons.css', array(), '1.0.0' );
				wp_enqueue_style( 'metismenu', 'https://opensourceorg.github.io/ai/assets/css/plugins/metismenu.css', array(), '1.0.0' );
				wp_enqueue_style( 'animate', 'https://opensourceorg.github.io/ai/assets/css/vendor/animate.css', array(), '1.0.0' );
				wp_enqueue_style( 'bootstrap', 'https://opensourceorg.github.io/ai/assets/css/vendor/bootstrap.min.css', array(), '1.0.0' );
				wp_enqueue_style( 'ai-custom', 'https://opensourceorg.github.io/ai/assets/css/style.css', array( 'bootstrap' ), '1.0.0' );

				// JavaScript files - with proper dependencies
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'jqueryui', 'https://opensourceorg.github.io/ai/assets/js/vendor/jqueryui.js', array( 'jquery' ), '1.0.0', true );
				wp_enqueue_script( 'counter-up', 'https://opensourceorg.github.io/ai/assets/js/plugins/counter-up.js', array( 'jquery' ), '1.0.0', true );
				wp_enqueue_script( 'swiper-js', 'https://opensourceorg.github.io/ai/assets/js/plugins/swiper.js', array( 'jquery' ), '1.0.0', true );
				wp_enqueue_script( 'metismenu-js', 'https://opensourceorg.github.io/ai/assets/js/plugins/metismenu.js', array( 'jquery' ), '1.0.0', true );
				wp_enqueue_script( 'waypoint', 'https://opensourceorg.github.io/ai/assets/js/vendor/waypoint.js', array( 'jquery' ), '1.0.0', true );
				wp_enqueue_script( 'waw', 'https://opensourceorg.github.io/ai/assets/js/vendor/waw.js', array( 'jquery' ), '1.0.0', true );
				wp_enqueue_script( 'gsap', 'https://opensourceorg.github.io/ai/assets/js/plugins/gsap.min.js', array(), '1.0.0', true );
				wp_enqueue_script( 'scrolltrigger', 'https://opensourceorg.github.io/ai/assets/js/plugins/scrolltigger.js', array( 'gsap' ), '1.0.0', true );
				wp_enqueue_script( 'split-text', 'https://opensourceorg.github.io/ai/assets/js/vendor/split-text.js', array( 'gsap' ), '1.0.0', true );
				wp_enqueue_script( 'contact-form', 'https://opensourceorg.github.io/ai/assets/js/vendor/contact.form.js', array( 'jquery' ), '1.0.0', true );
				wp_enqueue_script( 'split-type', 'https://opensourceorg.github.io/ai/assets/js/vendor/split-type.js', array(), '1.0.0', true );
				wp_enqueue_script( 'jquery-timepicker', 'https://opensourceorg.github.io/ai/assets/js/plugins/jquery-timepicker.js', array( 'jquery' ), '1.0.0', true );
				wp_enqueue_script( 'bootstrap-js', 'https://opensourceorg.github.io/ai/assets/js/plugins/bootstrap.min.js', array( 'jquery' ), '1.0.0', true );
				wp_enqueue_script( 'ai-main', 'https://opensourceorg.github.io/ai/assets/js/main.js', array( 'jquery', 'bootstrap-js' ), '1.0.0', true );
			}
		}
	);
}
add_action( 'init', 'osi_register_block_template' );

/**
 * Process the supporter form submission.
 *
 * @param WPCF7_ContactForm $contact_form The Contact Form 7 instance.
 *
 * @return void
 */
function osi_handle_support_form_submission( WPCF7_ContactForm $contact_form ): void { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	$submission = WPCF7_Submission::get_instance();

	if ( $submission ) {
		$data = $submission->get_posted_data();

		osi_save_supporter_form_data_to_cpt( $data );
	}
}
add_action( 'wpcf7_before_send_mail', 'osi_handle_support_form_submission' );

/**
 * Save supporter form data to a custom post type.
 *
 * @param array $form_data The form data.
 *
 * @return void
 */
function osi_save_supporter_form_data_to_cpt( array $form_data ): void {
	$post_id = wp_insert_post(
		array(
			'post_title'  => $form_data['your-name'],
			'post_type'   => 'supporter',
			'post_status' => 'pending',
		)
	);

	// If we have a wp_error, abort.
	if ( is_wp_error( $post_id ) ) {
		return;
	}

	if ( $post_id ) {
		update_field( 'name', $form_data['your-name'], $post_id );
		update_field( 'organization', $form_data['your-org'], $post_id );
		update_field( 'endorsement_type', $form_data['your-endorsement'], $post_id );
		update_field( 'quote', $form_data['your-message'], $post_id );
	}
}

/**
 * Handle the supporter form spam status change.
 *
 * @param string  $new_status The new status.
 * @param string  $old_status The old status.
 * @param WP_Post $post       The post object.
 *
 * @return void
 */
function osi_handle_supporter_form_flamingo_spam_status_change( string $new_status, string $old_status, WP_Post $post ): void {
	if ( 'flamingo_inbound' !== get_post_type( $post ) ) {
		return;
	}

	if ( 'flamingo-spam' === $old_status && 'publish' === $new_status ) {
		$term_obj_list = get_the_terms( $post->ID, 'flamingo_inbound_channel' );

		if ( empty( $term_obj_list ) || is_wp_error( $term_obj_list ) || 'OSAID Endorsement' !== $term_obj_list[0]->name ) {
			return;
		}

		$form_data = array(
			'your-name'        => get_post_meta( $post->ID, '_field_your-name', true ),
			'your-org'         => get_post_meta( $post->ID, '_field_your-org', true ),
			'your-endorsement' => get_post_meta( $post->ID, '_field_your-endorsement', true ),
			'your-message'     => get_post_meta( $post->ID, '_field_your-message', true ),
		);

		if ( ! empty( $form_data['your-name'] ) ) {
			osi_save_supporter_form_data_to_cpt( $form_data );
		}
	}
}
add_action( 'transition_post_status', 'osi_handle_supporter_form_flamingo_spam_status_change', 10, 3 );

/**
 * Register the AI menu.
 *
 * @return void
 */
function osi_register_ai_menu() {
	register_nav_menu( 'ai', __( 'AI Menu', 'osi' ) );
	register_nav_menu( 'ai_secondary_nav', __( 'AI Secondary Navigation', 'osi' ) );
}
add_action( 'after_setup_theme', 'osi_register_ai_menu' );

/**
 * Enqueue the full-width editor styles for the AI template.
 *
 * @param array $editor_settings The editor settings.
 *
 * @return array
 */
function osi_full_width_editor( array $editor_settings ): array {
	if ( get_page_template_slug() === 'templates/ai-wide.php' ) {
		$editor_settings['styles'][] = array(
			'css' => '.wp-block { max-width: 1140px !important; }',
		);
	}
	return $editor_settings;
}
add_filter( 'block_editor_settings_all', 'osi_full_width_editor' );

add_filter( 'jetpack_disable_tracking', '__return_true' );

/**
 * Modify the post type arguments for the podcast post type.
 *
 * @param array $args The post type arguments.
 *
 * @return array The modified post type arguments.
 */
function osi_ssp_register_post_type_args( array $args ): array {
	$args['rewrite']['slug']       = 'ai';
	$args['rewrite']['with_front'] = false;
	return $args;
}
add_filter( 'ssp_register_post_type_args', 'osi_ssp_register_post_type_args', 10, 1 );


/**
 * Block booking if honeypot phone field is filled.
 * Phone field is hidden using CSS.
 * Field must have the slug 'phone_hp', and must be a text input.
 *
 * @param boolean    $result     The result.
 * @param EM_Booking $em_booking The booking object.
 *
 * @return boolean The result.
 */
function osi_block_booking_if_phone_filled( bool $result, EM_Booking $em_booking ) {
	if ( ! empty( $em_booking->event ) ) {
		if ( isset( $_POST['phone_hp'] ) && trim( $_POST['phone_hp'] ) !== '' ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$em_booking->add_error( 'There was a problem with your booking. Please do not include a phone number.' );
			return false;
		}
	}
	return $result;
}
add_filter( 'em_booking_validate', 'osi_block_booking_if_phone_filled', 10, 2 );

/**
 * Queuing swiper for the new home page rotating quotes
 *
 * @return void
**/
function osi_enqueue_swiper_assets(): void {
	wp_enqueue_style( 'swiper-css', 'https://unpkg.com/swiper@11/swiper-bundle.min.css', array(), filemtime( untrailingslashit( get_template_directory() ) . '/style.css' ) );
	wp_enqueue_script( 'swiper-js', 'https://unpkg.com/swiper@11/swiper-bundle.min.js', array(), filemtime( untrailingslashit( get_template_directory() ) . '/style.css' ), true );
}
add_action( 'wp_enqueue_scripts', 'osi_enqueue_swiper_assets' );

/**
 * Disable loading separate block styles for the osi theme.
 *
 * @return bool
 */
add_filter( 'should_load_separate_core_block_assets', '__return_false' );
