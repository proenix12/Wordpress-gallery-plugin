<?php
/*
Plugin Name: My Plugin
Plugin URI: http://my-awesomeness-emporium.com
description: description
a plugin to create awesomeness and spread joy
Version: 1.2
Author: Mr. Awesome
Author URI: http://mrtotallyawesome.com
License: GPL2
*/

define( 'GDPR_VERSION', '0.0.1' );

define( 'GDPR_REQUIRED_WP_VERSION', '4.9' );

define( 'GDPR_PLUGIN', __FILE__ );

define( 'GDPR_PLUGIN_BASENAME', plugin_basename( GDPR_PLUGIN ) );

define( 'GDPR_PLUGIN_NAME', trim( dirname( GDPR_PLUGIN_BASENAME ), '/' ) );

define( 'GDPR_PLUGIN_DIR', untrailingslashit( dirname( GDPR_PLUGIN ) ) );

define( 'GDPR_PLUGIN_MODULES_DIR', GDPR_PLUGIN_DIR . '/modules' );

require_once GDPR_PLUGIN_DIR . '/settings.php';

function add_my_css_and_my_js_files(){
		wp_enqueue_style( 'your-stylesheet-name', plugins_url('/css/style.css', __FILE__), false, '1.0.0', 'all');
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'myjs', plugins_url('/js/functions.js', __FILE__));
}
add_action('wp_enqueue_scripts', "add_my_css_and_my_js_files");