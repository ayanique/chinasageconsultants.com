<?php

if ( ! function_exists( 'allston_eltdf_register_icon_widget' ) ) {
	/**
	 * Function that register icon widget
	 */
	function allston_eltdf_register_icon_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfIconWidget';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_icon_widget' );
}