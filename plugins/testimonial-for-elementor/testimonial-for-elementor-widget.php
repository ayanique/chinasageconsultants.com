<?php
/**
 * Plugin Name: Testimonial for Elementor
 * Description: The Testimonial is a elementor addons package for Elementor page builder plugin for WordPress.
 * Plugin URI: 	http://demo.wphash.com/htmega/
 * Author: 		HasThemes
 * Author URI: 	https://hasthemes.com/
 * Version: 	1.0.0
 * License:     GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: testimonial-fe
 * Domain Path: /languages
*/

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly
define( 'TESTIMONIAL_FOR_ELEMENTOR_VERSION', '1.0.0' );
define( 'TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_ROOT', __FILE__ );
define( 'TESTIMONIAL_FOR_ELEMENTOR_ADDONS_CSS', TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_ROOT.'assets/css' );
define( 'TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_URL', plugins_url( '/', TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_ROOT ) );
define( 'TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_PATH', plugin_dir_path( TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_ROOT ) );
define( 'TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PLUGIN_BASE', plugin_basename( TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_ROOT ) );
define( 'TESTIMONIAL_FOR_ELEMENTOR_PL_INCLUDE', TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_PATH .'include/' );

// Required File
require_once ( TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_PATH .'include/class.testimonial.php' );