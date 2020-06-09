<?php

if ( ! function_exists( 'allston_core_add_parallax_info_item_shortcodes' ) ) {
	function allston_core_add_parallax_info_item_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'AllstonCore\CPT\Shortcodes\ParallaxInfoItem\ParallaxInfoItem'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'allston_core_filter_add_vc_shortcode', 'allston_core_add_parallax_info_item_shortcodes' );
}

if ( ! function_exists( 'allston_core_set_parallax_info_item_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for parallax info item shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function allston_core_set_parallax_info_item_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-parallax-info-item';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'allston_core_filter_add_vc_shortcodes_custom_icon_class', 'allston_core_set_parallax_info_item_icon_class_name_for_vc_shortcodes' );
}