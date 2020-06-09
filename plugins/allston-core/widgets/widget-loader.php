<?php

if ( ! function_exists( 'allston_eltdf_register_widgets' ) ) {
	function allston_eltdf_register_widgets() {
		$widgets = apply_filters( 'allston_eltdf_register_widgets', $widgets = array() );
		
		foreach ( $widgets as $widget ) {
			register_widget( $widget );
		}
	}
	
	add_action( 'widgets_init', 'allston_eltdf_register_widgets' );
}