<?php

if ( ! function_exists( 'allston_eltdf_register_blog_masonry_template_file' ) ) {
	/**
	 * Function that register blog masonry template
	 */
	function allston_eltdf_register_blog_masonry_template_file( $templates ) {
		$templates['blog-masonry'] = esc_html__( 'Blog: Masonry', 'allston' );
		
		return $templates;
	}
	
	add_filter( 'allston_eltdf_register_blog_templates', 'allston_eltdf_register_blog_masonry_template_file' );
}

if ( ! function_exists( 'allston_eltdf_set_blog_masonry_type_global_option' ) ) {
	/**
	 * Function that set blog list type value for global blog option map
	 */
	function allston_eltdf_set_blog_masonry_type_global_option( $options ) {
		$options['masonry'] = esc_html__( 'Blog: Masonry', 'allston' );
		
		return $options;
	}
	
	add_filter( 'allston_eltdf_blog_list_type_global_option', 'allston_eltdf_set_blog_masonry_type_global_option' );
}