<?php

if ( ! function_exists( 'allston_core_add_dropcaps_shortcodes' ) ) {
	function allston_core_add_dropcaps_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'AllstonCore\CPT\Shortcodes\Dropcaps\Dropcaps'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'allston_core_filter_add_vc_shortcode', 'allston_core_add_dropcaps_shortcodes' );
}