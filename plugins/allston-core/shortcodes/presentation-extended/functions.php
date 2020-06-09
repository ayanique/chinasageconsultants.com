<?php

if ( ! function_exists( 'allston_core_add_presentation_extended_shortcode' ) ) {
	function allston_core_add_presentation_extended_shortcode( $shortcodes_class_name ) {
		$shortcodes = array(
			'AllstonCore\CPT\Shortcodes\PresentationExtended\PresentationExtended'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'allston_core_filter_add_vc_shortcode', 'allston_core_add_presentation_extended_shortcode' );
}

if ( ! function_exists( 'allston_core_set_presentation_extended_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for banner shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function allston_core_set_presentation_extended_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-presentation-extended';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'allston_core_filter_add_vc_shortcodes_custom_icon_class', 'allston_core_set_presentation_extended_icon_class_name_for_vc_shortcodes' );
}