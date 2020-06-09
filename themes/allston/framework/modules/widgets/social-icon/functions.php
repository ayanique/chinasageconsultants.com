<?php

if ( ! function_exists( 'allston_eltdf_register_social_icon_widget' ) ) {
	/**
	 * Function that register social icon widget
	 */
	function allston_eltdf_register_social_icon_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfSocialIconWidget';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_social_icon_widget' );
}