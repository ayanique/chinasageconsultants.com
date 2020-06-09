<?php

if ( ! function_exists( 'allston_eltdf_register_blog_standard_template_file' ) ) {
	/**
	 * Function that register blog standard template
	 */
	function allston_eltdf_register_blog_standard_template_file( $templates ) {
		$templates['blog-standard'] = esc_html__( 'Blog: Standard', 'allston' );
		
		return $templates;
	}
	
	add_filter( 'allston_eltdf_register_blog_templates', 'allston_eltdf_register_blog_standard_template_file' );
}

if ( ! function_exists( 'allston_eltdf_set_blog_standard_type_global_option' ) ) {
	/**
	 * Function that set blog list type value for global blog option map
	 */
	function allston_eltdf_set_blog_standard_type_global_option( $options ) {
		$options['standard'] = esc_html__( 'Blog: Standard', 'allston' );
		
		return $options;
	}
	
	add_filter( 'allston_eltdf_blog_list_type_global_option', 'allston_eltdf_set_blog_standard_type_global_option' );
}