<?php
/*
Plugin Name: OSI Post Migration Script
Description: Registers WP CLI script to run once the migration is done from Drupal.
Version: 1.0
Author: WordPress.com Special Projects / Vijayaraghavan M
Author URI: https://wpspecialprojects.wordpress.com/
License: GPLv3
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once dirname( __FILE__ ) . '/inc/class-post-migration-script.php';

