<?php

if ( ! function_exists( 'allston_eltdf_register_recent_posts_widget' ) ) {
	/**
	 * Function that register search opener widget
	 */
	function allston_eltdf_register_recent_posts_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfRecentPosts';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_recent_posts_widget' );
}