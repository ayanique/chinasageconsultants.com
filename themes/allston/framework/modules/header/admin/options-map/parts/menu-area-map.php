<?php

if ( ! function_exists( 'allston_eltdf_get_hide_dep_for_header_menu_area_options' ) ) {
	function allston_eltdf_get_hide_dep_for_header_menu_area_options() {
		$hide_dep_options = apply_filters( 'allston_eltdf_header_menu_area_hide_global_option', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'allston_eltdf_header_menu_area_options_map' ) ) {
	function allston_eltdf_header_menu_area_options_map( $panel_header ) {
		$hide_dep_options = allston_eltdf_get_hide_dep_for_header_menu_area_options();
		
		$menu_area_container = allston_eltdf_add_admin_container_no_style(
			array(
				'parent'          => $panel_header,
				'name'            => 'menu_area_container',
				'dependency' => array(
					'hide' => array(
						'header_options'  => $hide_dep_options
					)
				),
			)
		);
		
		allston_eltdf_add_admin_section_title(
			array(
				'parent' => $menu_area_container,
				'name'   => 'menu_area_style',
				'title'  => esc_html__( 'Menu Area Style', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $menu_area_container,
				'type'          => 'yesno',
				'name'          => 'menu_area_in_grid',
				'default_value' => 'no',
				'label'         => esc_html__( 'Menu Area In Grid', 'allston' ),
				'description'   => esc_html__( 'Set menu area content to be in grid', 'allston' ),
			)
		);
		
		$menu_area_in_grid_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $menu_area_container,
				'name'            => 'menu_area_in_grid_container',
				'dependency' => array(
					'hide' => array(
						'menu_area_in_grid'  => 'no'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_container,
				'type'          => 'color',
				'name'          => 'menu_area_grid_background_color',
				'default_value' => '',
				'label'         => esc_html__( 'Grid Background Color', 'allston' ),
				'description'   => esc_html__( 'Set grid background color for menu area', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_container,
				'type'          => 'text',
				'name'          => 'menu_area_grid_background_transparency',
				'default_value' => '',
				'label'         => esc_html__( 'Grid Background Transparency', 'allston' ),
				'description'   => esc_html__( 'Set grid background transparency for menu area', 'allston' ),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_container,
				'type'          => 'yesno',
				'name'          => 'menu_area_in_grid_shadow',
				'default_value' => 'no',
				'label'         => esc_html__( 'Grid Area Shadow', 'allston' ),
				'description'   => esc_html__( 'Set shadow on grid area', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_container,
				'type'          => 'yesno',
				'name'          => 'menu_area_in_grid_border',
				'default_value' => 'no',
				'label'         => esc_html__( 'Grid Area Border', 'allston' ),
				'description'   => esc_html__( 'Set border on grid area', 'allston' )
			)
		);
		
		$menu_area_in_grid_border_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $menu_area_in_grid_container,
				'name'            => 'menu_area_in_grid_border_container',
				'dependency' => array(
					'hide' => array(
						'menu_area_in_grid_border'  => 'no'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $menu_area_in_grid_border_container,
				'type'          => 'color',
				'name'          => 'menu_area_in_grid_border_color',
				'default_value' => '',
				'label'         => esc_html__( 'Border Color', 'allston' ),
				'description'   => esc_html__( 'Set border color for menu area', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $menu_area_container,
				'type'          => 'color',
				'name'          => 'menu_area_background_color',
				'default_value' => '',
				'label'         => esc_html__( 'Background Color', 'allston' ),
				'description'   => esc_html__( 'Set background color for menu area', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $menu_area_container,
				'type'          => 'text',
				'name'          => 'menu_area_background_transparency',
				'default_value' => '',
				'label'         => esc_html__( 'Background Transparency', 'allston' ),
				'description'   => esc_html__( 'Set background transparency for menu area', 'allston' ),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $menu_area_container,
				'type'          => 'yesno',
				'name'          => 'menu_area_shadow',
				'default_value' => 'no',
				'label'         => esc_html__( 'Menu Area Shadow', 'allston' ),
				'description'   => esc_html__( 'Set shadow on menu area', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'menu_area_border',
				'default_value' => 'no',
				'label'         => esc_html__( 'Menu Area Border', 'allston' ),
				'description'   => esc_html__( 'Set border on menu area', 'allston' ),
				'parent'        => $menu_area_container
			)
		);
		
		$menu_area_border_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $menu_area_container,
				'name'            => 'menu_area_border_container',
				'dependency' => array(
					'hide' => array(
						'menu_area_border'  => 'no'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'        => 'color',
				'name'        => 'menu_area_border_color',
				'label'       => esc_html__( 'Border Color', 'allston' ),
				'description' => esc_html__( 'Set border color for menu area', 'allston' ),
				'parent'      => $menu_area_border_container
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'        => 'text',
				'name'        => 'menu_area_height',
				'label'       => esc_html__( 'Height', 'allston' ),
				'description' => esc_html__( 'Enter header height', 'allston' ),
				'parent'      => $menu_area_container,
				'args'        => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'   => 'text',
				'name'   => 'menu_area_side_padding',
				'label'  => esc_html__( 'Menu Area Side Padding', 'allston' ),
				'parent' => $menu_area_container,
				'args'   => array(
					'col_width' => 2,
					'suffix'    => esc_html__( 'px or %', 'allston' )
				)
			)
		);
		
		do_action( 'allston_eltdf_header_menu_area_additional_options', $panel_header );
	}
	
	add_action( 'allston_eltdf_header_menu_area_options_map', 'allston_eltdf_header_menu_area_options_map', 10, 1 );
}