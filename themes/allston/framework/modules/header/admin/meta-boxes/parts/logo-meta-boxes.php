<?php

if ( ! function_exists( 'allston_eltdf_logo_meta_box_map' ) ) {
	function allston_eltdf_logo_meta_box_map() {
		
		$logo_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => apply_filters( 'allston_eltdf_set_scope_for_meta_boxes', array( 'page', 'post' ), 'logo_meta' ),
				'title' => esc_html__( 'Logo', 'allston' ),
				'name'  => 'logo_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_logo_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Default', 'allston' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'allston' ),
				'parent'      => $logo_meta_box
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_logo_image_dark_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Dark', 'allston' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'allston' ),
				'parent'      => $logo_meta_box
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_logo_image_light_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Light', 'allston' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'allston' ),
				'parent'      => $logo_meta_box
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_logo_image_sticky_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Sticky', 'allston' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'allston' ),
				'parent'      => $logo_meta_box
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_logo_image_mobile_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Logo Image - Mobile', 'allston' ),
				'description' => esc_html__( 'Choose a default logo image to display ', 'allston' ),
				'parent'      => $logo_meta_box
			)
		);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_logo_meta_box_map', 47 );
}