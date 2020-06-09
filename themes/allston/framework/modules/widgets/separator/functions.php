<?php

if ( ! function_exists( 'allston_eltdf_register_separator_widget' ) ) {
	/**
	 * Function that register separator widget
	 */
	function allston_eltdf_register_separator_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfSeparatorWidget';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_separator_widget' );
}