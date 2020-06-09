<?php

foreach ( glob( ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/title/types/*/admin/custom-styles/*.php' ) as $options_load ) {
	include_once $options_load;
}

if ( ! function_exists( 'allston_eltdf_title_area_typography_style' ) ) {
	function allston_eltdf_title_area_typography_style() {
		
		// title default/small style
		
		$item_styles = allston_eltdf_get_typography_styles( 'page_title' );
		
		$item_selector = array(
			'.eltdf-title-holder .eltdf-title-wrapper .eltdf-page-title'
		);
		
		echo allston_eltdf_dynamic_css( $item_selector, $item_styles );
		
		// subtitle style
		
		$item_styles = allston_eltdf_get_typography_styles( 'page_subtitle' );
		
		$item_selector = array(
			'.eltdf-title-holder .eltdf-title-wrapper .eltdf-page-subtitle'
		);
		
		echo allston_eltdf_dynamic_css( $item_selector, $item_styles );
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_title_area_typography_style' );
}