<?php

if ( ! function_exists( 'allston_eltdf_register_search_opener_widget' ) ) {
	/**
	 * Function that register search opener widget
	 */
	function allston_eltdf_register_search_opener_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfSearchOpener';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_search_opener_widget' );
}