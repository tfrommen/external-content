<?php # -*- coding: utf-8 -*-
/**
 * Plugin Name: External Content
 * Plugin URI:  https://wordpress.org/plugins/external-content/
 * Description: This plugin registers a custom post type to handle external content like any other post. The post permalink is replaced by a custom post meta that holds an external URL.
 * Author:      Thorsten Frommen
 * Author URI:  http://tfrommen.de
 * Version:     1.4.0
 * Text Domain: external-content
 * Domain Path: /src/languages
 * License:     GPLv3
 */

defined( 'ABSPATH' ) or die();

require_once __DIR__ . '/src/' . basename( __FILE__ );
