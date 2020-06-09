<?php

if ( ! function_exists( 'allston_eltdf_disable_wpml_css' ) ) {
	function allston_eltdf_disable_wpml_css() {
		define( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true );
	}
	
	add_action( 'after_setup_theme', 'allston_eltdf_disable_wpml_css' );
}