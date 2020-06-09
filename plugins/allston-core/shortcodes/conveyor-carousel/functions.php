<?php

if ( ! function_exists( 'allston_core_add_conveyor_carousel_shortcodes' ) ) {
	function allston_core_add_conveyor_carousel_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'AllstonCore\CPT\Shortcodes\ConveyorCarousel\ConveyorCarousel'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'allston_core_filter_add_vc_shortcode', 'allston_core_add_conveyor_carousel_shortcodes' );
}

if ( ! function_exists( 'allston_core_set_conveyor_carousel_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for image conveyor carousel shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function allston_core_set_conveyor_carousel_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-conveyor-carousel';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'allston_core_filter_add_vc_shortcodes_custom_icon_class', 'allston_core_set_conveyor_carousel_icon_class_name_for_vc_shortcodes' );
}