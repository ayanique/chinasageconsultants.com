<?php

if(!function_exists('allston_eltdf_register_sticky_sidebar_widget')) {
	/**
	 * Function that register sticky sidebar widget
	 */
	function allston_eltdf_register_sticky_sidebar_widget($widgets) {
		$widgets[] = 'AllstonEltdfStickySidebar';
		
		return $widgets;
	}
	
	add_filter('allston_eltdf_register_widgets', 'allston_eltdf_register_sticky_sidebar_widget');
}