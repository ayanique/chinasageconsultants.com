<?php

if ( ! function_exists( 'allston_eltdf_get_hide_dep_for_header_logo_area_options' ) ) {
	function allston_eltdf_get_hide_dep_for_header_logo_area_options() {
		$hide_dep_options = apply_filters( 'allston_eltdf_header_logo_area_hide_global_option', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'allston_eltdf_header_logo_area_options_map' ) ) {
	function allston_eltdf_header_logo_area_options_map( $panel_header ) {
		$hide_dep_options = allston_eltdf_get_hide_dep_for_header_logo_area_options();
		
		$logo_area_container = allston_eltdf_add_admin_container_no_style(
			array(
				'parent'          => $panel_header,
				'name'            => 'logo_area_container',
				'dependency' => array(
					'hide' => array(
						'header_options'  => $hide_dep_options
					)
				)
			)
		);
		
		allston_eltdf_add_admin_section_title(
			array(
				'parent' => $logo_area_container,
				'name'   => 'logo_menu_area_title',
				'title'  => esc_html__( 'Logo Area', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $logo_area_container,
				'type'          => 'yesno',
				'name'          => 'logo_area_in_grid',
				'default_value' => 'no',
				'label'         => esc_html__( 'Logo Area In Grid', 'allston' ),
				'description'   => esc_html__( 'Set menu area content to be in grid', 'allston' )
			)
		);
		
		$logo_area_in_grid_container = allston_eltdf_add_admin_container(
			array(
				'parent'     => $logo_area_container,
				'dependency' => array(
					'hide' => array(
						'logo_area_in_grid' => 'no'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $logo_area_in_grid_container,
				'type'          => 'color',
				'name'          => 'logo_area_grid_background_color',
				'default_value' => '',
				'label'         => esc_html__( 'Grid Background Color', 'allston' ),
				'description'   => esc_html__( 'Set grid background color for logo area', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $logo_area_in_grid_container,
				'type'          => 'text',
				'name'          => 'logo_area_grid_background_transparency',
				'default_value' => '',
				'label'         => esc_html__( 'Grid Background Transparency', 'allston' ),
				'description'   => esc_html__( 'Set grid background transparency', 'allston' ),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $logo_area_in_grid_container,
				'type'          => 'yesno',
				'name'          => 'logo_area_in_grid_border',
				'default_value' => 'no',
				'label'         => esc_html__( 'Grid Area Border', 'allston' ),
				'description'   => esc_html__( 'Set border on grid area', 'allston' )
			)
		);
		
		$logo_area_in_grid_border_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $logo_area_in_grid_container,
				'name'            => 'logo_area_in_grid_border_container',
				'dependency' => array(
					'hide' => array(
						'logo_area_in_grid_border'  => 'no'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'      => $logo_area_in_grid_border_container,
				'type'        => 'color',
				'name'        => 'logo_area_in_grid_border_color',
				'label'       => esc_html__( 'Border Color', 'allston' ),
				'description' => esc_html__( 'Set border color for grid area', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'      => $logo_area_container,
				'type'        => 'color',
				'name'        => 'logo_area_background_color',
				'label'       => esc_html__( 'Background Color', 'allston' ),
				'description' => esc_html__( 'Set background color for logo area', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $logo_area_container,
				'type'          => 'text',
				'name'          => 'logo_area_background_transparency',
				'default_value' => '',
				'label'         => esc_html__( 'Background Transparency', 'allston' ),
				'description'   => esc_html__( 'Set background transparency for logo area', 'allston' ),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $logo_area_container,
				'type'          => 'yesno',
				'name'          => 'logo_area_border',
				'default_value' => 'no',
				'label'         => esc_html__( 'Logo Area Border', 'allston' ),
				'description'   => esc_html__( 'Set border on logo area', 'allston' )
			)
		);
		
		$logo_area_border_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $logo_area_container,
				'name'            => 'logo_area_border_container',
				'dependency' => array(
					'hide' => array(
						'logo_area_border'  => 'no'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'color',
				'name'          => 'logo_area_border_color',
				'label'         => esc_html__( 'Border Color', 'allston' ),
				'description'   => esc_html__( 'Set border color for logo area', 'allston' ),
				'parent'        => $logo_area_border_container
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'text',
				'name'          => 'logo_area_height',
				'label'         => esc_html__( 'Height', 'allston' ),
				'description'   => esc_html__( 'Enter logo area height (default is 90px)', 'allston' ),
				'parent'        => $logo_area_container,
				'args'          => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		do_action( 'allston_eltdf_header_logo_area_additional_options', $logo_area_container );
	}
	
	add_action( 'allston_eltdf_header_logo_area_options_map', 'allston_eltdf_header_logo_area_options_map', 10, 1 );
}