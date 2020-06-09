<?php

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Eltdf_Process extends WPBakeryShortCodesContainer {}
}

if ( ! function_exists( 'allston_core_core_add_process_shortcodes' ) ) {
	function allston_core_core_add_process_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'AllstonCore\CPT\Shortcodes\Process\Process',
			'AllstonCore\CPT\Shortcodes\Process\ProcessItem'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'allston_core_filter_add_vc_shortcode', 'allston_core_core_add_process_shortcodes' );
}

if ( ! function_exists( 'allston_core_core_set_process_custom_style_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom css style for process shortcode
	 */
	function allston_core_core_set_process_custom_style_for_vc_shortcodes( $style ) {
		$current_style = '.wpb_content_element.wpb_allston_core_process_item > .wpb_element_wrapper {
			background-color: #f4f4f4; 
		}';
		
		$style .= $current_style;
		
		return $style;
	}
	
	add_filter( 'allston_core_filter_add_vc_shortcodes_custom_style', 'allston_core_core_set_process_custom_style_for_vc_shortcodes' );
}

if ( ! function_exists( 'allston_core_core_set_process_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for process shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function allston_core_core_set_process_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-process';
		$shortcodes_icon_class_array[] = '.icon-wpb-process-item';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'allston_core_filter_add_vc_shortcodes_custom_icon_class', 'allston_core_core_set_process_icon_class_name_for_vc_shortcodes' );
}