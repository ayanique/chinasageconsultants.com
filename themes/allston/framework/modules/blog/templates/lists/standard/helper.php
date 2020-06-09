<?php

if ( ! function_exists( 'allston_eltdf_get_blog_holder_params' ) ) {
	/**
	 * Function that generates params for holders on blog templates
	 */
	function allston_eltdf_get_blog_holder_params( $params ) {
		$params_list = array();
		
		$params_list['holder'] = 'eltdf-container';
		$params_list['inner']  = 'eltdf-container-inner clearfix';
		
		return $params_list;
	}
	
	add_filter( 'allston_eltdf_blog_holder_params', 'allston_eltdf_get_blog_holder_params' );
}

if ( ! function_exists( 'allston_eltdf_get_blog_holder_classes' ) ) {
	/**
	 * Function that generates blog holder classes for blog page
	 */
	function allston_eltdf_get_blog_holder_classes( $classes ) {
		$sidebar_classes   = array();
		$sidebar_classes[] = 'eltdf-grid-large-gutter';
		
		return implode( ' ', $sidebar_classes );
	}
	
	add_filter( 'allston_eltdf_blog_holder_classes', 'allston_eltdf_get_blog_holder_classes' );
}

if ( ! function_exists( 'allston_eltdf_blog_part_params' ) ) {
	function allston_eltdf_blog_part_params( $params ) {
		
		$part_params              = array();
		$part_params['title_tag'] = 'h1';
		$part_params['link_tag']  = 'h5';
		$part_params['quote_tag'] = 'h5';
		
		return array_merge( $params, $part_params );
	}
	
	add_filter( 'allston_eltdf_blog_part_params', 'allston_eltdf_blog_part_params' );
}