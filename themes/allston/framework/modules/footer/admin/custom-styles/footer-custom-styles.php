<?php

if ( ! function_exists( 'allston_eltdf_footer_top_general_styles' ) ) {
	/**
	 * Generates general custom styles for footer top area
	 */
	function allston_eltdf_footer_top_general_styles() {
		$item_styles      = array();
		$background_color = allston_eltdf_options()->getOptionValue( 'footer_top_background_color' );
		
		if ( ! empty( $background_color ) ) {
			$item_styles['background-color'] = $background_color;
		}
		
		echo allston_eltdf_dynamic_css( '.eltdf-page-footer .eltdf-footer-top-holder', $item_styles );
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_footer_top_general_styles' );
}

if ( ! function_exists( 'allston_eltdf_footer_bottom_general_styles' ) ) {
	/**
	 * Generates general custom styles for footer bottom area
	 */
	function allston_eltdf_footer_bottom_general_styles() {
		$item_styles      = array();
		$background_color = allston_eltdf_options()->getOptionValue( 'footer_bottom_background_color' );
		
		if ( ! empty( $background_color ) ) {
			$item_styles['background-color'] = $background_color;
		}
		
		echo allston_eltdf_dynamic_css( '.eltdf-page-footer .eltdf-footer-bottom-holder', $item_styles );
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_footer_bottom_general_styles' );
}