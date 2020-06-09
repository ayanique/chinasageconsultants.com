<?php

if ( ! function_exists( 'allston_eltdf_register_button_widget' ) ) {
	/**
	 * Function that register button widget
	 */
	function allston_eltdf_register_button_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfButtonWidget';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_button_widget' );
}