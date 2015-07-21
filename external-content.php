<?php # -*- coding: utf-8 -*-
/**
 * Plugin Name: External Content
 * Plugin URI:  https://wordpress.org/plugins/external-content/
 * Description: This plugin registers a custom post type to handle external content like any other post. The post permalink is replaced by a custom post meta that holds an external URL.
 * Author:      Thorsten Frommen
 * Author URI:  http://ipm-frommen.de/wordpress
 * Version:     1.2
 * Text Domain: external-content
 * Domain Path: /languages
 * License:     GPLv3
 */

namespace tf\ExternalContent;

use tf\Autoloader;

if ( ! function_exists( 'add_action' ) ) {
	return;
}

require_once __DIR__ . '/inc/Autoloader/bootstrap.php';

add_action( 'plugins_loaded', __NAMESPACE__ . '\initialize' );

/**
 * Initialize the plugin.
 *
 * @wp-hook plugins_loaded
 *
 * @return void
 */
function initialize() {

	$autoloader = new Autoloader\Autoloader();
	$autoloader->add_rule( new Autoloader\NamespaceRule( __DIR__ . '/inc', __NAMESPACE__ ) );

	$plugin = new Plugin( __FILE__ );
	$plugin->initialize();
}
