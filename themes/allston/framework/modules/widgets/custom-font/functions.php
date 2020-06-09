<?php

if ( ! function_exists( 'allston_eltdf_register_custom_font_widget' ) ) {
	/**
	 * Function that register custom font widget
	 */
	function allston_eltdf_register_custom_font_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfCustomFontWidget';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_custom_font_widget' );
}