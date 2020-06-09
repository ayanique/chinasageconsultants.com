<?php

if ( ! function_exists( 'allston_eltdf_get_hide_dep_for_header_standard_options' ) ) {
	function allston_eltdf_get_hide_dep_for_header_standard_options() {
		$hide_dep_options = apply_filters( 'allston_eltdf_header_standard_hide_global_option', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'allston_eltdf_header_standard_map' ) ) {
	function allston_eltdf_header_standard_map( $parent ) {
		$hide_dep_options = allston_eltdf_get_hide_dep_for_header_standard_options();
		
		allston_eltdf_add_admin_field(
			array(
				'parent'          => $parent,
				'type'            => 'select',
				'name'            => 'set_menu_area_position',
				'default_value'   => 'right',
				'label'           => esc_html__( 'Choose Menu Area Position', 'allston' ),
				'description'     => esc_html__( 'Select menu area position in your header', 'allston' ),
				'options'         => array(
					'right'  => esc_html__( 'Right', 'allston' ),
					'left'   => esc_html__( 'Left', 'allston' ),
					'center' => esc_html__( 'Center', 'allston' )
				),
				'dependency' => array(
					'hide' => array(
						'header_options'  => $hide_dep_options
					)
				)
			)
		);
	}
	
	add_action( 'allston_eltdf_additional_header_menu_area_options_map', 'allston_eltdf_header_standard_map' );
}