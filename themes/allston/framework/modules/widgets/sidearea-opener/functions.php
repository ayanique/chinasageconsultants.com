<?php

if ( ! function_exists( 'allston_eltdf_register_sidearea_opener_widget' ) ) {
	/**
	 * Function that register sidearea opener widget
	 */
	function allston_eltdf_register_sidearea_opener_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfSideAreaOpener';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_sidearea_opener_widget' );
}