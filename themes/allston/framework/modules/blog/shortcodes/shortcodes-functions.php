<?php

if ( ! function_exists( 'allston_eltdf_include_blog_shortcodes' ) ) {
	function allston_eltdf_include_blog_shortcodes() {
		include_once ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/blog/shortcodes/blog-list/blog-list.php';
	}
	
	if ( allston_eltdf_core_plugin_installed() ) {
		add_action( 'allston_core_action_include_shortcodes_file', 'allston_eltdf_include_blog_shortcodes' );
	}
}

if ( ! function_exists( 'allston_eltdf_add_blog_shortcodes' ) ) {
	function allston_eltdf_add_blog_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'AllstonCore\CPT\Shortcodes\BlogList\BlogList'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	if ( allston_eltdf_core_plugin_installed() ) {
		add_filter( 'allston_core_filter_add_vc_shortcode', 'allston_eltdf_add_blog_shortcodes' );
	}
}

if ( ! function_exists( 'allston_eltdf_set_blog_list_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for blog shortcodes to set our icon for Visual Composer shortcodes panel
	 */
	function allston_eltdf_set_blog_list_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-blog-list';

		return $shortcodes_icon_class_array;
	}
	
	if ( allston_eltdf_core_plugin_installed() ) {
		add_filter( 'allston_core_filter_add_vc_shortcodes_custom_icon_class', 'allston_eltdf_set_blog_list_icon_class_name_for_vc_shortcodes' );
	}
}