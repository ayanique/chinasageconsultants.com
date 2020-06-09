<?php

if ( ! function_exists( 'allston_eltdf_register_author_info_widget' ) ) {
	/**
	 * Function that register author info widget
	 */
	function allston_eltdf_register_author_info_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfAuthorInfoWidget';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_author_info_widget' );
}