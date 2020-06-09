<?php

if ( ! function_exists( 'allston_core_enqueue_scripts_for_progress_bar_shortcodes' ) ) {
	/**
	 * Function that includes all necessary 3rd party scripts for this shortcode
	 */
	function allston_core_enqueue_scripts_for_progress_bar_shortcodes() {
		wp_enqueue_script( 'counter', ALLSTON_CORE_SHORTCODES_URL_PATH . '/progress-bar/assets/js/plugins/counter.js', array( 'jquery' ), false, true );
	}
	
	add_action( 'allston_eltdf_enqueue_third_party_scripts', 'allston_core_enqueue_scripts_for_progress_bar_shortcodes' );
}

if ( ! function_exists( 'allston_core_add_progress_bar_shortcodes' ) ) {
	function allston_core_add_progress_bar_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'AllstonCore\CPT\Shortcodes\ProgressBar\ProgressBar'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'allston_core_filter_add_vc_shortcode', 'allston_core_add_progress_bar_shortcodes' );
}

if ( ! function_exists( 'allston_core_set_progress_bar_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for progress bar shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function allston_core_set_progress_bar_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-progress-bar';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'allston_core_filter_add_vc_shortcodes_custom_icon_class', 'allston_core_set_progress_bar_icon_class_name_for_vc_shortcodes' );
}