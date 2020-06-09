<?php

if ( ! function_exists( 'allston_eltdf_header_types_meta_boxes' ) ) {
	function allston_eltdf_header_types_meta_boxes() {
		$header_type_options = apply_filters( 'allston_eltdf_header_type_meta_boxes', $header_type_options = array( '' => esc_html__( 'Default', 'allston' ) ) );
		
		return $header_type_options;
	}
}

if ( ! function_exists( 'allston_eltdf_get_hide_dep_for_header_behavior_meta_boxes' ) ) {
	function allston_eltdf_get_hide_dep_for_header_behavior_meta_boxes() {
		$hide_dep_options = apply_filters( 'allston_eltdf_header_behavior_hide_meta_boxes', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

foreach ( glob( ELATED_FRAMEWORK_HEADER_ROOT_DIR . '/admin/meta-boxes/*/*.php' ) as $meta_box_load ) {
	include_once $meta_box_load;
}

foreach ( glob( ELATED_FRAMEWORK_HEADER_TYPES_ROOT_DIR . '/*/admin/meta-boxes/*.php' ) as $meta_box_load ) {
	include_once $meta_box_load;
}

if ( ! function_exists( 'allston_eltdf_map_header_meta' ) ) {
	function allston_eltdf_map_header_meta() {
		$header_type_meta_boxes              = allston_eltdf_header_types_meta_boxes();
		$header_behavior_meta_boxes_hide_dep = allston_eltdf_get_hide_dep_for_header_behavior_meta_boxes();
		
		$header_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => apply_filters( 'allston_eltdf_set_scope_for_meta_boxes', array( 'page', 'post' ), 'header_meta' ),
				'title' => esc_html__( 'Header', 'allston' ),
				'name'  => 'header_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_header_type_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Choose Header Type', 'allston' ),
				'description'   => esc_html__( 'Select header type layout', 'allston' ),
				'parent'        => $header_meta_box,
				'options'       => $header_type_meta_boxes
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_header_style_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Header Skin', 'allston' ),
				'description'   => esc_html__( 'Choose a header style to make header elements (logo, main menu, side menu button) in that predefined style', 'allston' ),
				'parent'        => $header_meta_box,
				'options'       => array(
					''             => esc_html__( 'Default', 'allston' ),
					'light-header' => esc_html__( 'Light', 'allston' ),
					'dark-header'  => esc_html__( 'Dark', 'allston' )
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'parent'          => $header_meta_box,
				'type'            => 'select',
				'name'            => 'eltdf_header_behaviour_meta',
				'default_value'   => '',
				'label'           => esc_html__( 'Choose Header Behaviour', 'allston' ),
				'description'     => esc_html__( 'Select the behaviour of header when you scroll down to page', 'allston' ),
				'options'         => array(
					''                                => esc_html__( 'Default', 'allston' ),
					'fixed-on-scroll'                 => esc_html__( 'Fixed on scroll', 'allston' ),
					'no-behavior'                     => esc_html__( 'No Behavior', 'allston' ),
					'sticky-header-on-scroll-up'      => esc_html__( 'Sticky on scroll up', 'allston' ),
					'sticky-header-on-scroll-down-up' => esc_html__( 'Sticky on scroll up/down', 'allston' )
				),
				'dependency' => array(
					'hide' => array(
						'eltdf_header_type_meta'  => $header_behavior_meta_boxes_hide_dep
					)
				)
			)
		);
		
		//additional area
		do_action( 'allston_eltdf_additional_header_area_meta_boxes_map', $header_meta_box );
		
		//top area
		do_action( 'allston_eltdf_header_top_area_meta_boxes_map', $header_meta_box );
		
		//logo area
		do_action( 'allston_eltdf_header_logo_area_meta_boxes_map', $header_meta_box );
		
		//menu area
		do_action( 'allston_eltdf_header_menu_area_meta_boxes_map', $header_meta_box );
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_header_meta', 50 );
}