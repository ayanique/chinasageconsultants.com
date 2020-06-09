<?php

if ( ! function_exists( 'allston_eltdf_breadcrumbs_title_area_typography_style' ) ) {
	function allston_eltdf_breadcrumbs_title_area_typography_style() {
		
		$item_styles = allston_eltdf_get_typography_styles( 'page_breadcrumb' );
		
		$item_selector = array(
			'.eltdf-title-holder .eltdf-title-wrapper .eltdf-breadcrumbs'
		);
		
		echo allston_eltdf_dynamic_css( $item_selector, $item_styles );
		
		
		$breadcrumb_hover_color = allston_eltdf_options()->getOptionValue( 'page_breadcrumb_hovercolor' );
		
		$breadcrumb_hover_styles = array();
		if ( ! empty( $breadcrumb_hover_color ) ) {
			$breadcrumb_hover_styles['color'] = $breadcrumb_hover_color;
		}
		
		$breadcrumb_hover_selector = array(
			'.eltdf-title-holder .eltdf-title-wrapper .eltdf-breadcrumbs a:hover'
		);
		
		echo allston_eltdf_dynamic_css( $breadcrumb_hover_selector, $breadcrumb_hover_styles );
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_breadcrumbs_title_area_typography_style' );
}