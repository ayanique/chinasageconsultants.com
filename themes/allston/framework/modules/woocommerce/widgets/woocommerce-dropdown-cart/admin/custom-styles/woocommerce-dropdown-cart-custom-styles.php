<?php

if ( ! function_exists( 'allston_eltdf_dropdown_cart_icon_styles' ) ) {
	/**
	 * Generates styles for dropdown cart icon
	 */
	function allston_eltdf_dropdown_cart_icon_styles() {
		$icon_color       = allston_eltdf_options()->getOptionValue( 'dropdown_cart_icon_color' );
		$icon_hover_color = allston_eltdf_options()->getOptionValue( 'dropdown_cart_hover_color' );
		
		if ( ! empty( $icon_color ) ) {
			echo allston_eltdf_dynamic_css( '.eltdf-shopping-cart-holder .eltdf-header-cart a', array( 'color' => $icon_color ) );
		}
		
		if ( ! empty( $icon_hover_color ) ) {
			echo allston_eltdf_dynamic_css( '.eltdf-shopping-cart-holder .eltdf-header-cart a:hover', array( 'color' => $icon_hover_color ) );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_dropdown_cart_icon_styles' );
}