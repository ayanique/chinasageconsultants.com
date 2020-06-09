<?php
/*
  Plugin Name: DZS ZoomSounds
  Plugin URI: http://digitalzoomstudio.net/
  Description: Creates cool audio players with optional playlists for your site.
  Version: 5.85
  Author: Digital Zoom Studio
  Author URI: http://digitalzoomstudio.net/ 
 */


if (function_exists('plugin_dir_path')) {
  define('DZSAP_BASE_PATH', plugin_dir_path(__FILE__) . '');
} else {
  define('DZSAP_BASE_PATH', dirname(__FILE__) . '/');
}
if (function_exists('plugin_dir_url')) {
  define('DZSAP_BASE_URL', plugin_dir_url(__FILE__));
}

include_once(DZSAP_BASE_PATH . 'dzs_functions.php');

$class_path = DZSAP_BASE_PATH . 'class-dzsap.php';

if (!class_exists('DZSAudioPlayer')) {
  include_once($class_path);
}


define("DZSAP_VERSION", '5.85');
if (class_exists('DZSAudioPlayer')) {
  $dzsap = new DZSAudioPlayer();
}


if (class_exists('Cornerstone_Plugin')) {
//    error_log('cornerstone - ok');
  include_once(DZSAP_BASE_PATH . 'inc/php/cornerstone/cornerstone-functions.php');
  add_action('wp_enqueue_scripts', 'dzsap_cs_enqueue');
  add_action('cornerstone_register_elements', 'dzsap_cs_register_elements');
  add_filter('cornerstone_icon_map', 'dzsap_cs_icon_map');
  add_action('cornerstone_before_wp_editor', 'dzsap_cs_home_before');
  add_action('cornerstone_load_builder', 'dzsap_cs_home_before');
}