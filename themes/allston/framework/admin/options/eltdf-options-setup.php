<?php

if ( ! function_exists( 'allston_eltdf_admin_map_init' ) ) {
	function allston_eltdf_admin_map_init() {
		do_action( 'allston_eltdf_before_options_map' );
		
		require_once ELATED_FRAMEWORK_ROOT_DIR . '/admin/options/fonts/map.php';
		require_once ELATED_FRAMEWORK_ROOT_DIR . '/admin/options/general/map.php';
		require_once ELATED_FRAMEWORK_ROOT_DIR . '/admin/options/page/map.php';
		require_once ELATED_FRAMEWORK_ROOT_DIR . '/admin/options/social/map.php';
		require_once ELATED_FRAMEWORK_ROOT_DIR . '/admin/options/reset/map.php';
		
		do_action( 'allston_eltdf_options_map' );
		
		do_action( 'allston_eltdf_after_options_map' );
	}
	
	add_action( 'after_setup_theme', 'allston_eltdf_admin_map_init', 1 );
}