<?php

if ( ! function_exists( 'allston_eltdf_register_header_standard_type' ) ) {
	/**
	 * This function is used to register header type class for header factory file
	 */
	function allston_eltdf_register_header_standard_type( $header_types ) {
		$header_type = array(
			'header-standard' => 'AllstonEltdf\Modules\Header\Types\HeaderStandard'
		);
		
		$header_types = array_merge( $header_types, $header_type );
		
		return $header_types;
	}
}

if ( ! function_exists( 'allston_eltdf_init_register_header_standard_type' ) ) {
	/**
	 * This function is used to wait header-function.php file to init header object and then to init hook registration function above
	 */
	function allston_eltdf_init_register_header_standard_type() {
		add_filter( 'allston_eltdf_register_header_type_class', 'allston_eltdf_register_header_standard_type' );
	}
	
	add_action( 'allston_eltdf_before_header_function_init', 'allston_eltdf_init_register_header_standard_type' );
}