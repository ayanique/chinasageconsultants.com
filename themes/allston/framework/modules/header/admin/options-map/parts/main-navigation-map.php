<?php

if ( ! function_exists( 'allston_eltdf_get_hide_dep_for_header_main_menu_options' ) ) {
	function allston_eltdf_get_hide_dep_for_header_main_menu_options() {
		$hide_dep_options = apply_filters( 'allston_eltdf_header_main_menu_hide_global_option', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'allston_eltdf_header_main_navigation_options_map' ) ) {
	function allston_eltdf_header_main_navigation_options_map() {
		$hide_dep_options = allston_eltdf_get_hide_dep_for_header_main_menu_options();
		
		$panel_main_menu = allston_eltdf_add_admin_panel(
			array(
				'title'           => esc_html__( 'Main Menu', 'allston' ),
				'name'            => 'panel_main_menu',
				'page'            => '_header_page',
				'dependency' => array(
					'hide' => array(
						'header_options'  => $hide_dep_options
					)
				)
			)
		);
		
		allston_eltdf_add_admin_section_title(
			array(
				'parent' => $panel_main_menu,
				'name'   => 'main_menu_area_title',
				'title'  => esc_html__( 'Main Menu General Settings', 'allston' )
			)
		);
		
		$drop_down_group = allston_eltdf_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'drop_down_group',
				'title'       => esc_html__( 'Main Dropdown Menu', 'allston' ),
				'description' => esc_html__( 'Choose a color and transparency for the main menu background (0 = fully transparent, 1 = opaque)', 'allston' )
			)
		);
		
		$drop_down_row1 = allston_eltdf_add_admin_row(
			array(
				'parent' => $drop_down_group,
				'name'   => 'drop_down_row1',
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $drop_down_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_background_color',
				'default_value' => '',
				'label'         => esc_html__( 'Background Color', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $drop_down_row1,
				'type'          => 'textsimple',
				'name'          => 'dropdown_background_transparency',
				'default_value' => '',
				'label'         => esc_html__( 'Background Transparency', 'allston' ),
			)
		);

        allston_eltdf_add_admin_field(
            array(
                'parent'        => $panel_main_menu,
                'type'          => 'yesno',
                'name'          => 'wide_dropdown_menu_in_grid',
                'default_value' => 'no',
                'label'         => esc_html__( 'Wide Dropdown Menu In Grid', 'allston' ),
                'description'   => esc_html__( 'Set wide dropdown menu to be in grid', 'allston' ),
            )
        );

        $wide_dropdown_menu_in_grid_container = allston_eltdf_add_admin_container(
            array(
                'parent'          => $panel_main_menu,
                'name'            => 'wide_dropdown_menu_in_grid_container',
                'dependency' => array(
                    'hide' => array(
                        'wide_dropdown_menu_in_grid'  => 'yes'
                    )
                )
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent'        => $wide_dropdown_menu_in_grid_container,
                'type'          => 'yesno',
                'name'          => 'wide_dropdown_menu_content_in_grid',
                'default_value' => 'yes',
                'label'         => esc_html__( 'Wide Dropdown Menu Content In Grid', 'allston' ),
                'description'   => esc_html__( 'Set wide dropdown menu content to be in grid', 'allston' )
            )
        );
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $panel_main_menu,
				'type'          => 'select',
				'name'          => 'menu_dropdown_appearance',
				'default_value' => 'dropdown-animate-height',
				'label'         => esc_html__( 'Main Dropdown Menu Appearance', 'allston' ),
				'description'   => esc_html__( 'Choose appearance for dropdown menu', 'allston' ),
				'options'       => array(
					'dropdown-default'        => esc_html__( 'Default', 'allston' ),
					'dropdown-animate-height' => esc_html__( 'Animate Height', 'allston' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $panel_main_menu,
				'type'          => 'text',
				'name'          => 'dropdown_top_position',
				'default_value' => '',
				'label'         => esc_html__( 'Dropdown Position', 'allston' ),
				'description'   => esc_html__( 'Enter value in percentage of entire header height', 'allston' ),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => '%'
				)
			)
		);
		
		$first_level_group = allston_eltdf_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'first_level_group',
				'title'       => esc_html__( '1st Level Menu', 'allston' ),
				'description' => esc_html__( 'Define styles for 1st level in Top Navigation Menu', 'allston' )
			)
		);
		
		$first_level_row1 = allston_eltdf_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row1'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'menu_color',
				'default_value' => '',
				'label'         => esc_html__( 'Text Color', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'menu_hovercolor',
				'default_value' => '',
				'label'         => esc_html__( 'Hover Text Color', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'menu_activecolor',
				'default_value' => '',
				'label'         => esc_html__( 'Active Text Color', 'allston' ),
			)
		);
		
		$first_level_row3 = allston_eltdf_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row3',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row3,
				'type'          => 'colorsimple',
				'name'          => 'menu_light_hovercolor',
				'default_value' => '',
				'label'         => esc_html__( 'Light Menu Hover Text Color', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row3,
				'type'          => 'colorsimple',
				'name'          => 'menu_light_activecolor',
				'default_value' => '',
				'label'         => esc_html__( 'Light Menu Active Text Color', 'allston' ),
			)
		);
		
		$first_level_row4 = allston_eltdf_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row4',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row4,
				'type'          => 'colorsimple',
				'name'          => 'menu_dark_hovercolor',
				'default_value' => '',
				'label'         => esc_html__( 'Dark Menu Hover Text Color', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row4,
				'type'          => 'colorsimple',
				'name'          => 'menu_dark_activecolor',
				'default_value' => '',
				'label'         => esc_html__( 'Dark Menu Active Text Color', 'allston' ),
			)
		);
		
		$first_level_row5 = allston_eltdf_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row5',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row5,
				'type'          => 'fontsimple',
				'name'          => 'menu_google_fonts',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row5,
				'type'          => 'textsimple',
				'name'          => 'menu_font_size',
				'default_value' => '',
				'label'         => esc_html__( 'Font Size', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row5,
				'type'          => 'textsimple',
				'name'          => 'menu_line_height',
				'default_value' => '',
				'label'         => esc_html__( 'Line Height', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		$first_level_row6 = allston_eltdf_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row6',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row6,
				'type'          => 'selectblanksimple',
				'name'          => 'menu_font_style',
				'default_value' => '',
				'label'         => esc_html__( 'Font Style', 'allston' ),
				'options'       => allston_eltdf_get_font_style_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row6,
				'type'          => 'selectblanksimple',
				'name'          => 'menu_font_weight',
				'default_value' => '',
				'label'         => esc_html__( 'Font Weight', 'allston' ),
				'options'       => allston_eltdf_get_font_weight_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row6,
				'type'          => 'textsimple',
				'name'          => 'menu_letter_spacing',
				'default_value' => '',
				'label'         => esc_html__( 'Letter Spacing', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row6,
				'type'          => 'selectblanksimple',
				'name'          => 'menu_text_transform',
				'default_value' => '',
				'label'         => esc_html__( 'Text Transform', 'allston' ),
				'options'       => allston_eltdf_get_text_transform_array()
			)
		);
		
		$first_level_row7 = allston_eltdf_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row7',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row7,
				'type'          => 'textsimple',
				'name'          => 'menu_padding_left_right',
				'default_value' => '',
				'label'         => esc_html__( 'Padding Left/Right', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $first_level_row7,
				'type'          => 'textsimple',
				'name'          => 'menu_margin_left_right',
				'default_value' => '',
				'label'         => esc_html__( 'Margin Left/Right', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		$second_level_group = allston_eltdf_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'second_level_group',
				'title'       => esc_html__( '2nd Level Menu', 'allston' ),
				'description' => esc_html__( 'Define styles for 2nd level in Top Navigation Menu', 'allston' )
			)
		);
		
		$second_level_row1 = allston_eltdf_add_admin_row(
			array(
				'parent' => $second_level_group,
				'name'   => 'second_level_row1'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_color',
				'default_value' => '',
				'label'         => esc_html__( 'Text Color', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_hovercolor',
				'default_value' => '',
				'label'         => esc_html__( 'Hover/Active Color', 'allston' )
			)
		);
		
		$second_level_row2 = allston_eltdf_add_admin_row(
			array(
				'parent' => $second_level_group,
				'name'   => 'second_level_row2',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_row2,
				'type'          => 'fontsimple',
				'name'          => 'dropdown_google_fonts',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_font_size',
				'default_value' => '',
				'label'         => esc_html__( 'Font Size', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_line_height',
				'default_value' => '',
				'label'         => esc_html__( 'Line Height', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		$second_level_row3 = allston_eltdf_add_admin_row(
			array(
				'parent' => $second_level_group,
				'name'   => 'second_level_row3',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_font_style',
				'default_value' => '',
				'label'         => esc_html__( 'Font Style', 'allston' ),
				'options'       => allston_eltdf_get_font_style_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_font_weight',
				'default_value' => '',
				'label'         => esc_html__( 'Font Weight', 'allston' ),
				'options'       => allston_eltdf_get_font_weight_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_row3,
				'type'          => 'textsimple',
				'name'          => 'dropdown_letter_spacing',
				'default_value' => '',
				'label'         => esc_html__( 'Letter Spacing', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_text_transform',
				'default_value' => '',
				'label'         => esc_html__( 'Text Transform', 'allston' ),
				'options'       => allston_eltdf_get_text_transform_array()
			)
		);
		
		$second_level_wide_group = allston_eltdf_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'second_level_wide_group',
				'title'       => esc_html__( '2nd Level Wide Menu', 'allston' ),
				'description' => esc_html__( 'Define styles for 2nd level in Wide Menu', 'allston' )
			)
		);
		
		$second_level_wide_row1 = allston_eltdf_add_admin_row(
			array(
				'parent' => $second_level_wide_group,
				'name'   => 'second_level_wide_row1'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_wide_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_wide_color',
				'default_value' => '',
				'label'         => esc_html__( 'Text Color', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_wide_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_wide_hovercolor',
				'default_value' => '',
				'label'         => esc_html__( 'Hover/Active Color', 'allston' )
			)
		);
		
		$second_level_wide_row2 = allston_eltdf_add_admin_row(
			array(
				'parent' => $second_level_wide_group,
				'name'   => 'second_level_wide_row2',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_wide_row2,
				'type'          => 'fontsimple',
				'name'          => 'dropdown_wide_google_fonts',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_wide_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_font_size',
				'default_value' => '',
				'label'         => esc_html__( 'Font Size', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_wide_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_line_height',
				'default_value' => '',
				'label'         => esc_html__( 'Line Height', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		$second_level_wide_row3 = allston_eltdf_add_admin_row(
			array(
				'parent' => $second_level_wide_group,
				'name'   => 'second_level_wide_row3',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_wide_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_wide_font_style',
				'default_value' => '',
				'label'         => esc_html__( 'Font Style', 'allston' ),
				'options'       => allston_eltdf_get_font_style_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_wide_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_wide_font_weight',
				'default_value' => '',
				'label'         => esc_html__( 'Font Weight', 'allston' ),
				'options'       => allston_eltdf_get_font_weight_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_wide_row3,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_letter_spacing',
				'default_value' => '',
				'label'         => esc_html__( 'Letter Spacing', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $second_level_wide_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_wide_text_transform',
				'default_value' => '',
				'label'         => esc_html__( 'Text Transform', 'allston' ),
				'options'       => allston_eltdf_get_text_transform_array()
			)
		);
		
		$third_level_group = allston_eltdf_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'third_level_group',
				'title'       => esc_html__( '3nd Level Menu', 'allston' ),
				'description' => esc_html__( 'Define styles for 3nd level in Top Navigation Menu', 'allston' )
			)
		);
		
		$third_level_row1 = allston_eltdf_add_admin_row(
			array(
				'parent' => $third_level_group,
				'name'   => 'third_level_row1'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_color_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Text Color', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_hovercolor_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Hover/Active Color', 'allston' )
			)
		);
		
		$third_level_row2 = allston_eltdf_add_admin_row(
			array(
				'parent' => $third_level_group,
				'name'   => 'third_level_row2',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_row2,
				'type'          => 'fontsimple',
				'name'          => 'dropdown_google_fonts_thirdlvl',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_font_size_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Font Size', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_line_height_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Line Height', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		$third_level_row3 = allston_eltdf_add_admin_row(
			array(
				'parent' => $third_level_group,
				'name'   => 'third_level_row3',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_font_style_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Font Style', 'allston' ),
				'options'       => allston_eltdf_get_font_style_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_font_weight_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Font Weight', 'allston' ),
				'options'       => allston_eltdf_get_font_weight_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_row3,
				'type'          => 'textsimple',
				'name'          => 'dropdown_letter_spacing_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Letter Spacing', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_text_transform_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Text Transform', 'allston' ),
				'options'       => allston_eltdf_get_text_transform_array()
			)
		);
		
		$third_level_wide_group = allston_eltdf_add_admin_group(
			array(
				'parent'      => $panel_main_menu,
				'name'        => 'third_level_wide_group',
				'title'       => esc_html__( '3rd Level Wide Menu', 'allston' ),
				'description' => esc_html__( 'Define styles for 3rd level in Wide Menu', 'allston' )
			)
		);
		
		$third_level_wide_row1 = allston_eltdf_add_admin_row(
			array(
				'parent' => $third_level_wide_group,
				'name'   => 'third_level_wide_row1'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_wide_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_wide_color_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Text Color', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_wide_row1,
				'type'          => 'colorsimple',
				'name'          => 'dropdown_wide_hovercolor_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Hover/Active Color', 'allston' )
			)
		);
		
		$third_level_wide_row2 = allston_eltdf_add_admin_row(
			array(
				'parent' => $third_level_wide_group,
				'name'   => 'third_level_wide_row2',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_wide_row2,
				'type'          => 'fontsimple',
				'name'          => 'dropdown_wide_google_fonts_thirdlvl',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_wide_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_font_size_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Font Size', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_wide_row2,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_line_height_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Line Height', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		$third_level_wide_row3 = allston_eltdf_add_admin_row(
			array(
				'parent' => $third_level_wide_group,
				'name'   => 'third_level_wide_row3',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_wide_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_wide_font_style_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Font Style', 'allston' ),
				'options'       => allston_eltdf_get_font_style_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_wide_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_wide_font_weight_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Font Weight', 'allston' ),
				'options'       => allston_eltdf_get_font_weight_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_wide_row3,
				'type'          => 'textsimple',
				'name'          => 'dropdown_wide_letter_spacing_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Letter Spacing', 'allston' ),
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $third_level_wide_row3,
				'type'          => 'selectblanksimple',
				'name'          => 'dropdown_wide_text_transform_thirdlvl',
				'default_value' => '',
				'label'         => esc_html__( 'Text Transform', 'allston' ),
				'options'       => allston_eltdf_get_text_transform_array()
			)
		);
	}
	
	add_action( 'allston_eltdf_header_main_navigation_options_map', 'allston_eltdf_header_main_navigation_options_map', 10, 1 );
}