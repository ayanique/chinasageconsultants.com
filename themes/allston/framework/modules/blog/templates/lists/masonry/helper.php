<?php

if ( ! function_exists( 'allston_eltdf_get_blog_holder_params' ) ) {
	/**
	 * Function that generates params for holders on blog templates
	 */
	function allston_eltdf_get_blog_holder_params( $params ) {
		$params_list = array();
		
		$masonry_layout = allston_eltdf_get_meta_field_intersect( 'blog_masonry_layout' );
		if ( $masonry_layout === 'in-grid' ) {
			$params_list['holder'] = 'eltdf-container';
			$params_list['inner']  = 'eltdf-container-inner clearfix';
		} else {
			$params_list['holder'] = 'eltdf-full-width';
			$params_list['inner']  = 'eltdf-full-width-inner';
		}
		
		return $params_list;
	}
	
	add_filter( 'allston_eltdf_blog_holder_params', 'allston_eltdf_get_blog_holder_params' );
}

if ( ! function_exists( 'allston_eltdf_get_blog_list_classes' ) ) {
	/**
	 * Function that generates blog list holder classes for blog list templates
	 */
	function allston_eltdf_get_blog_list_classes( $classes ) {
		$list_classes   = array();
		$list_classes[] = 'eltdf-blog-type-masonry';
		
		$number_of_columns = allston_eltdf_get_meta_field_intersect( 'blog_masonry_number_of_columns' );
		if ( ! empty( $number_of_columns ) ) {
			$list_classes[] = 'eltdf-blog-' . $number_of_columns . '-columns';
		}
		
		$space_between_items = allston_eltdf_get_meta_field_intersect( 'blog_masonry_space_between_items' );
		if ( ! empty( $space_between_items ) ) {
			$list_classes[] = 'eltdf-' . $space_between_items . '-space';
		}
		
		$masonry_layout = allston_eltdf_get_meta_field_intersect( 'blog_masonry_layout' );
		$list_classes[] = 'eltdf-blog-masonry-' . $masonry_layout;
		
		$classes = array_merge( $classes, $list_classes );
		
		return $classes;
	}
	
	add_filter( 'allston_eltdf_blog_list_classes', 'allston_eltdf_get_blog_list_classes' );
}

if ( ! function_exists( 'allston_eltdf_blog_part_params' ) ) {
	function allston_eltdf_blog_part_params( $params ) {
		$part_params              = array();
		$part_params['title_tag'] = 'h2';
		$part_params['link_tag']  = 'h5';
		$part_params['quote_tag'] = 'h5';
		
		return array_merge( $params, $part_params );
	}
	
	add_filter( 'allston_eltdf_blog_part_params', 'allston_eltdf_blog_part_params' );
}