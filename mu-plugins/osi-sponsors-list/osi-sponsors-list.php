<?php
/**
 * Plugin Name: OSI Plugin List
 * Version: 1.0.0
 * Author: WordPress.com Special Projects
 * Author URI: https://wpspecialprojects.wordpress.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

function osi_sponsors_list_register_block() {
	register_block_type(
		__DIR__ . '/build'
	);
}
// Register the block.
add_action( 'init', 'osi_sponsors_list_register_block' );
