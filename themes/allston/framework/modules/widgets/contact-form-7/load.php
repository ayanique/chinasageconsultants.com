<?php

if ( allston_eltdf_contact_form_7_installed() ) {
	include_once ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/widgets/contact-form-7/contact-form-7.php';
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_cf7_widget' );
}

if ( ! function_exists( 'allston_eltdf_register_cf7_widget' ) ) {
	/**
	 * Function that register cf7 widget
	 */
	function allston_eltdf_register_cf7_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfContactForm7Widget';
		
		return $widgets;
	}
}