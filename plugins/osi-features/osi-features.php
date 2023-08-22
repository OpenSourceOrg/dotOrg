<?php
/**
 * Plugin Name: Osi Features
 * Description: All backend functionality will take place in this plugin. Like, registering post type, taxonomy, widget and meta box.
 * Plugin URI:  https://rtcamp.com
 * Author:      rtCamp
 * Author URI:  https://rtcamp.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version:     1.0
 * Text Domain: osi-features
 *
 * @package osi-features
 */

define( 'OSI_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'OSI_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

// phpcs:disable WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
require_once OSI_PATH . '/inc/helpers/autoloader.php';
require_once OSI_PATH . '/inc/helpers/custom-functions.php';
// phpcs:enable WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

/**
 * To load plugin manifest class.
 *
 * @return void
 */
function osi_plugin_loader() {
	\Osi\Features\Inc\Plugin::get_instance();
}

osi_plugin_loader();

add_filter('acf/settings/save_json', 'my_acf_json_save_point');
 
function my_acf_json_save_point( $path ) {
    
    // update path
    $path = OSI_PATH . '/acf-fields';

    // return
    return $path;
}

add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) {
    
    // remove original path (optional)
    unset($paths[0]);
    
    
    // append path
    $paths[] = OSI_PATH . '/acf-fields';
    
    
    // return
    return $paths;
    
}
