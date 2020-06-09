<?php

if ( ! function_exists( 'allston_eltdf_set_title_centered_type_for_options' ) ) {
	/**
	 * This function set centered title type value for title options map and meta boxes
	 */
	function allston_eltdf_set_title_centered_type_for_options( $type ) {
		$type['centered'] = esc_html__( 'Centered', 'allston' );
		
		return $type;
	}
	
	add_filter( 'allston_eltdf_title_type_global_option', 'allston_eltdf_set_title_centered_type_for_options' );
	add_filter( 'allston_eltdf_title_type_meta_boxes', 'allston_eltdf_set_title_centered_type_for_options' );
}