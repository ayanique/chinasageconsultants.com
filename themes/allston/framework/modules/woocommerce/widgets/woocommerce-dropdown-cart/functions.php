<?php

if ( ! function_exists( 'allston_eltdf_register_woocommerce_dropdown_cart_widget' ) ) {
	/**
	 * Function that register dropdown cart widget
	 */
	function allston_eltdf_register_woocommerce_dropdown_cart_widget( $widgets ) {
		$widgets[] = 'AllstonEltdfWoocommerceDropdownCart';
		
		return $widgets;
	}
	
	add_filter( 'allston_eltdf_register_widgets', 'allston_eltdf_register_woocommerce_dropdown_cart_widget' );
}

if ( ! function_exists( 'allston_eltdf_get_dropdown_cart_icon_class' ) ) {
	/**
	 * Returns dropdow cart icon class
	 */
	function allston_eltdf_get_dropdown_cart_icon_class() {
		$dropdown_cart_icon_source = allston_eltdf_options()->getOptionValue( 'dropdown_cart_icon_source' );
		
		$dropdown_cart_icon_class_array = array(
			'eltdf-header-cart'
		);
		
		$dropdown_cart_icon_class_array[] = $dropdown_cart_icon_source == 'icon_pack' ? 'eltdf-header-cart-icon-pack' : 'eltdf-header-cart-svg-path';
		
		return $dropdown_cart_icon_class_array;
	}
}

if ( ! function_exists( 'allston_eltdf_get_dropdown_cart_icon_html' ) ) {
	/**
	 * Returns dropdown cart icon HTML
	 */
	function allston_eltdf_get_dropdown_cart_icon_html() {
		$dropdown_cart_icon_source   = allston_eltdf_options()->getOptionValue( 'dropdown_cart_icon_source' );
		$dropdown_cart_icon_pack     = allston_eltdf_options()->getOptionValue( 'dropdown_cart_icon_pack' );
		$dropdown_cart_icon_svg_path = allston_eltdf_options()->getOptionValue( 'dropdown_cart_icon_svg_path' );
		
		$dropdown_cart_icon_html = '';
		
		if ( ( $dropdown_cart_icon_source == 'icon_pack' ) && ( isset( $dropdown_cart_icon_pack ) ) ) {
			$dropdown_cart_icon_html .= allston_eltdf_icon_collections()->getDropdownCartIcon( $dropdown_cart_icon_pack );
		} else if ( isset( $dropdown_cart_icon_svg_path ) ) {
			$dropdown_cart_icon_html .= $dropdown_cart_icon_svg_path;
		}
		
		return $dropdown_cart_icon_html;
	}
}