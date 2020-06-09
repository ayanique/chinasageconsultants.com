<?php

if ( ! function_exists( 'allston_eltdf_get_hide_dep_for_header_menu_area_meta_boxes' ) ) {
	function allston_eltdf_get_hide_dep_for_header_menu_area_meta_boxes() {
		$hide_dep_options = apply_filters( 'allston_eltdf_header_menu_area_hide_meta_boxes', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'allston_eltdf_get_hide_dep_for_header_menu_area_widgets_meta_boxes' ) ) {
	function allston_eltdf_get_hide_dep_for_header_menu_area_widgets_meta_boxes() {
		$hide_dep_options = apply_filters( 'allston_eltdf_header_menu_area_widgets_hide_meta_boxes', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'allston_eltdf_header_menu_area_meta_options_map' ) ) {
	function allston_eltdf_header_menu_area_meta_options_map( $header_meta_box ) {
		$hide_dep_options = allston_eltdf_get_hide_dep_for_header_menu_area_meta_boxes();
		$hide_dep_widgets = allston_eltdf_get_hide_dep_for_header_menu_area_widgets_meta_boxes();
		
		$menu_area_container = allston_eltdf_add_admin_container_no_style(
			array(
				'type'       => 'container',
				'name'       => 'menu_area_container',
				'parent'     => $header_meta_box,
				'dependency' => array(
					'hide' => array(
						'eltdf_header_type_meta' => $hide_dep_options
					)
				),
				'args'       => array(
					'enable_panels_for_default_value' => true
				)
			)
		);
		
		allston_eltdf_add_admin_section_title(
			array(
				'parent' => $menu_area_container,
				'name'   => 'menu_area_style',
				'title'  => esc_html__( 'Menu Area Style', 'allston' )
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_disable_header_widget_menu_area_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Disable Header Menu Area Widget', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will hide widget area from the menu area', 'allston' ),
				'parent'        => $menu_area_container,
				'dependency' => array(
					'hide' => array(
						'eltdf_header_type_meta' => $hide_dep_widgets
					)
				)
			)
		);
		
		$allston_custom_sidebars = allston_eltdf_get_custom_sidebars();
		if ( count( $allston_custom_sidebars ) > 0 ) {
			allston_eltdf_meta_box_add_field(
				array(
					'name'        => 'eltdf_custom_menu_area_sidebar_meta',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Choose Custom Widget Area In Menu Area', 'allston' ),
					'description' => esc_html__( 'Choose custom widget area to display in header menu area', 'allston' ),
					'parent'      => $menu_area_container,
					'options'     => $allston_custom_sidebars,
					'dependency' => array(
						'hide' => array(
							'eltdf_header_type_meta' => $hide_dep_widgets
						)
					)
				)
			);
		}
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_menu_area_in_grid_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Menu Area In Grid', 'allston' ),
				'description'   => esc_html__( 'Set menu area content to be in grid', 'allston' ),
				'parent'        => $menu_area_container,
				'default_value' => '',
				'options'       => allston_eltdf_get_yes_no_select_array()
			)
		);
		
		$menu_area_in_grid_container = allston_eltdf_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'menu_area_in_grid_container',
				'parent'          => $menu_area_container,
				'dependency' => array(
					'show' => array(
						'eltdf_menu_area_in_grid_meta'  => 'yes'
					)
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_menu_area_grid_background_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Grid Background Color', 'allston' ),
				'description' => esc_html__( 'Set grid background color for menu area', 'allston' ),
				'parent'      => $menu_area_in_grid_container
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_menu_area_grid_background_transparency_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Grid Background Transparency', 'allston' ),
				'description' => esc_html__( 'Set grid background transparency for menu area (0 = fully transparent, 1 = opaque)', 'allston' ),
				'parent'      => $menu_area_in_grid_container,
				'args'        => array(
					'col_width' => 2
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_menu_area_in_grid_shadow_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Grid Area Shadow', 'allston' ),
				'description'   => esc_html__( 'Set shadow on grid menu area', 'allston' ),
				'parent'        => $menu_area_in_grid_container,
				'default_value' => '',
				'options'       => allston_eltdf_get_yes_no_select_array()
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_menu_area_in_grid_border_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Grid Area Border', 'allston' ),
				'description'   => esc_html__( 'Set border on grid menu area', 'allston' ),
				'parent'        => $menu_area_in_grid_container,
				'default_value' => '',
				'options'       => allston_eltdf_get_yes_no_select_array()
			)
		);
		
		$menu_area_in_grid_border_container = allston_eltdf_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'menu_area_in_grid_border_container',
				'parent'          => $menu_area_in_grid_container,
				'dependency' => array(
					'show' => array(
						'eltdf_menu_area_in_grid_border_meta'  => 'yes'
					)
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_menu_area_in_grid_border_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Border Color', 'allston' ),
				'description' => esc_html__( 'Set border color for grid area', 'allston' ),
				'parent'      => $menu_area_in_grid_border_container
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_menu_area_background_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Background Color', 'allston' ),
				'description' => esc_html__( 'Choose a background color for menu area', 'allston' ),
				'parent'      => $menu_area_container
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_menu_area_background_transparency_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Transparency', 'allston' ),
				'description' => esc_html__( 'Choose a transparency for the menu area background color (0 = fully transparent, 1 = opaque)', 'allston' ),
				'parent'      => $menu_area_container,
				'args'        => array(
					'col_width' => 2
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_menu_area_shadow_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Menu Area Shadow', 'allston' ),
				'description'   => esc_html__( 'Set shadow on menu area', 'allston' ),
				'parent'        => $menu_area_container,
				'default_value' => '',
				'options'       => allston_eltdf_get_yes_no_select_array()
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_menu_area_border_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Menu Area Border', 'allston' ),
				'description'   => esc_html__( 'Set border on menu area', 'allston' ),
				'parent'        => $menu_area_container,
				'default_value' => '',
				'options'       => allston_eltdf_get_yes_no_select_array()
			)
		);
		
		$menu_area_border_bottom_color_container = allston_eltdf_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'menu_area_border_bottom_color_container',
				'parent'          => $menu_area_container,
				'dependency' => array(
					'show' => array(
						'eltdf_menu_area_border_meta'  => 'yes'
					)
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_menu_area_border_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Border Color', 'allston' ),
				'description' => esc_html__( 'Choose color of header bottom border', 'allston' ),
				'parent'      => $menu_area_border_bottom_color_container
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'type'        => 'text',
				'name'        => 'eltdf_menu_area_side_padding_meta',
				'label'       => esc_html__( 'Menu Area Side Padding', 'allston' ),
				'description' => esc_html__( 'Enter value in px or percentage to define menu area side padding', 'allston' ),
				'parent'      => $menu_area_container,
				'args'        => array(
					'col_width' => 3,
					'suffix'    => esc_html__( 'px or %', 'allston' )
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'parent'        => $menu_area_container,
				'type'          => 'text',
				'name'          => 'eltdf_dropdown_top_position_meta',
				'label'         => esc_html__( 'Dropdown Position', 'allston' ),
				'description'   => esc_html__( 'Enter value in percentage of entire header height', 'allston' ),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => '%'
				)
			)
		);

        allston_eltdf_meta_box_add_field(
            array(
                'name'          => 'eltdf_wide_dropdown_menu_in_grid_meta',
                'type'          => 'select',
                'label'         => esc_html__( 'Wide Dropdown Menu In Grid', 'allston' ),
                'description'   => esc_html__( 'Set wide dropdown menu to be in grid', 'allston' ),
                'parent'        => $menu_area_container,
                'default_value' => '',
                'options'       => allston_eltdf_get_yes_no_select_array()
            )
        );

        $wide_dropdown_menu_in_grid_container = allston_eltdf_add_admin_container(
            array(
                'type'            => 'container',
                'name'            => 'wide_dropdown_menu_in_grid_container',
                'parent'          => $menu_area_container,
                'dependency' => array(
                    'show' => array(
                        'eltdf_wide_dropdown_menu_in_grid_meta'  => 'no'
                    )
                )
            )
        );

        allston_eltdf_meta_box_add_field(
            array(
                'name'        => 'eltdf_wide_dropdown_menu_content_in_grid_meta',
                'type'          => 'select',
                'label'       => esc_html__( 'Wide Dropdown Menu Content In Grid', 'allston' ),
                'description' => esc_html__( 'Set wide dropdown menu content to be in grid', 'allston' ),
                'parent'      => $wide_dropdown_menu_in_grid_container,
                'default_value' => '',
                'options'       => allston_eltdf_get_yes_no_select_array()
            )
        );
		
		do_action( 'allston_eltdf_header_menu_area_additional_meta_boxes_map', $menu_area_container );
	}
	
	add_action( 'allston_eltdf_header_menu_area_meta_boxes_map', 'allston_eltdf_header_menu_area_meta_options_map', 10, 1 );
}