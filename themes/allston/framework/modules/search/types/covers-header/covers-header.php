<?php

if ( ! function_exists( 'allston_eltdf_search_body_class' ) ) {
	/**
	 * Function that adds body classes for different search types
	 *
	 * @param $classes array original array of body classes
	 *
	 * @return array modified array of classes
	 */
	function allston_eltdf_search_body_class( $classes ) {
		$classes[] = 'eltdf-search-covers-header';
		
		return $classes;
	}
	
	add_filter( 'body_class', 'allston_eltdf_search_body_class' );
}

if ( ! function_exists( 'allston_eltdf_get_search' ) ) {
	/**
	 * Loads search HTML based on search type option.
	 */
	function allston_eltdf_get_search() {
		allston_eltdf_load_search_template();
	}
	
	add_action( 'allston_eltdf_before_page_header_html_close', 'allston_eltdf_get_search' );
	add_action( 'allston_eltdf_before_mobile_header_html_close', 'allston_eltdf_get_search' );
}

if ( ! function_exists( 'allston_eltdf_load_search_template' ) ) {
	/**
	 * Loads search HTML based on search type option.
	 */
	function allston_eltdf_load_search_template() {

		$search_in_grid   = allston_eltdf_options()->getOptionValue( 'search_in_grid' ) == 'yes' ? true : false;
		
		$parameters = array(
			'search_in_grid'    		=> $search_in_grid,
			'search_close_icon_class' 	=> allston_eltdf_get_search_close_icon_class()
		);
		
		allston_eltdf_get_module_template_part( 'types/covers-header/templates/covers-header', 'search', '', $parameters );
	}
}