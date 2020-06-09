<?php

if ( ! function_exists( 'allston_eltdf_register_image_gallery_widget' ) ) {
	/**
	 * Function that register image gallery widget
	 */
	function allston_eltdf_register_image_gallery_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfImageGalleryWidget';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_image_gallery_widget' );
}