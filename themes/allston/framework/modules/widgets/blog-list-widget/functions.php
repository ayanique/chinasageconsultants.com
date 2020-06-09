<?php

if ( ! function_exists( 'allston_eltdf_register_blog_list_widget' ) ) {
	/**
	 * Function that register blog list widget
	 */
	function allston_eltdf_register_blog_list_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfBlogListWidget';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_blog_list_widget' );
}