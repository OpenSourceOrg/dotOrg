<?php
/**
 * Plugin Name: OSI Editor Tweaks
 * Plugin Description: A place where all custom block variations and syles are added.
 * Version: 1.0.0
 * Author: WordPress.com Special Projects
 * Author URI: https://wpspecialprojects.wordpress.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

define( 'OSI_ET_VERSION', '1.0.0' );
define( 'OSI_BUILD_PATH', plugin_dir_path( __FILE__ ) . 'build/' );
define( 'OSI_BUILD_URL', plugin_dir_url( __FILE__ ) . 'build/' );


/**
 * Renders the block editor scripts.
 *
 * @return void
 */
function osi_et_admin_scripts() {
	// If file exists, enqueue the script.
	if ( file_exists( OSI_BUILD_PATH . 'scripts/editor/editor.asset.php' ) ) {
		$assets = include OSI_BUILD_PATH . 'scripts/editor/editor.asset.php';
		wp_enqueue_script(
			'osi-event-list',
			OSI_BUILD_URL . 'scripts/editor/editor.js',
			$assets['dependencies'],
			$assets['version'],
			true
		);
	}

	// If file exists, enqueue the editor styles.
	if ( file_exists( OSI_BUILD_PATH . 'styles/editor/editor.scss.css' ) ) {
		wp_enqueue_style(
			'osi-event-list-editor',
			OSI_BUILD_URL . 'styles/editor/editor.scss.css',
			array(),
			OSI_ET_VERSION
		);
	}
}
add_action( 'enqueue_block_editor_assets', 'osi_et_admin_scripts' );

/**
 * Renders the front-end scripts.
 *
 * @return void
 */
function osi_et_frontend_scripts() {
	// If file exists, enqueue the script.
	if ( file_exists( OSI_BUILD_PATH . 'scripts/theme/theme.asset.php' ) ) {
		$assets = include OSI_BUILD_PATH . 'scripts/theme/theme.asset.php';
		wp_enqueue_script(
			'osi-et-theme',
			OSI_BUILD_URL . 'scripts/theme/theme.js',
			$assets['dependencies'],
			$assets['version'],
			true
		);
	}

	// If file exists, enqueue the front-end styles.
	if ( file_exists( OSI_BUILD_PATH . 'styles/theme/theme.scss.css' ) ) {
		wp_enqueue_style(
			'osi-et-theme',
			OSI_BUILD_URL . 'styles/theme/theme.scss.css',
			array(),
			OSI_ET_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'osi_et_frontend_scripts' );
