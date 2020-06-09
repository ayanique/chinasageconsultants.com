<?php

if ( ! function_exists( 'allston_eltdf_register_social_icons_widget' ) ) {
	/**
	 * Function that register social icon widget
	 */
	function allston_eltdf_register_social_icons_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfClassIconsGroupWidget';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_social_icons_widget' );
}