<?php

if ( ! function_exists( 'allston_eltdf_get_hide_dep_for_header_standard_meta_boxes' ) ) {
	function allston_eltdf_get_hide_dep_for_header_standard_meta_boxes() {
		$hide_dep_options = apply_filters( 'allston_eltdf_header_standard_hide_meta_boxes', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'allston_eltdf_header_standard_meta_map' ) ) {
	function allston_eltdf_header_standard_meta_map( $parent ) {
		$hide_dep_options = allston_eltdf_get_hide_dep_for_header_standard_meta_boxes();
		
		allston_eltdf_meta_box_add_field(
			array(
				'parent'          => $parent,
				'type'            => 'select',
				'name'            => 'eltdf_set_menu_area_position_meta',
				'default_value'   => '',
				'label'           => esc_html__( 'Choose Menu Area Position', 'allston' ),
				'description'     => esc_html__( 'Select menu area position in your header', 'allston' ),
				'options'         => array(
					''       => esc_html__( 'Default', 'allston' ),
					'left'   => esc_html__( 'Left', 'allston' ),
					'right'  => esc_html__( 'Right', 'allston' ),
					'center' => esc_html__( 'Center', 'allston' )
				),
				'dependency' => array(
					'hide' => array(
						'eltdf_header_type_meta'  => $hide_dep_options
					)
				)
			)
		);
	}
	
	add_action( 'allston_eltdf_additional_header_area_meta_boxes_map', 'allston_eltdf_header_standard_meta_map' );
}