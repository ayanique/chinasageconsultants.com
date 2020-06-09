<?php

if ( ! function_exists( 'allston_eltdf_mobile_header_options_map' ) ) {
	function allston_eltdf_mobile_header_options_map() {
		
		$panel_mobile_header = allston_eltdf_add_admin_panel(
			array(
				'title' => esc_html__( 'Mobile Header', 'allston' ),
				'name'  => 'panel_mobile_header',
				'page'  => '_header_page'
			)
		);
		
		allston_eltdf_add_admin_section_title(
			array(
				'parent' => $panel_mobile_header,
				'name'   => 'mobile_menu_area_title',
				'title'  => esc_html__( 'Mobile Menu Settings', 'allston' )
			)
		);
		
		$mobile_header_group = allston_eltdf_add_admin_group(
			array(
				'parent' => $panel_mobile_header,
				'name'   => 'mobile_header_group',
				'title'  => esc_html__( 'Mobile Header Styles', 'allston' )
			)
		);
		
		$mobile_header_row1 = allston_eltdf_add_admin_row(
			array(
				'parent' => $mobile_header_group,
				'name'   => 'mobile_header_row1'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_header_height',
				'type'   => 'textsimple',
				'label'  => esc_html__( 'Height', 'allston' ),
				'parent' => $mobile_header_row1,
				'args'   => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_header_background_color',
				'type'   => 'colorsimple',
				'label'  => esc_html__( 'Background Color', 'allston' ),
				'parent' => $mobile_header_row1
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_header_border_bottom_color',
				'type'   => 'colorsimple',
				'label'  => esc_html__( 'Border Bottom Color', 'allston' ),
				'parent' => $mobile_header_row1
			)
		);
		
		$mobile_menu_group = allston_eltdf_add_admin_group(
			array(
				'parent' => $panel_mobile_header,
				'name'   => 'mobile_menu_group',
				'title'  => esc_html__( 'Mobile Menu Styles', 'allston' )
			)
		);
		
		$mobile_menu_row1 = allston_eltdf_add_admin_row(
			array(
				'parent' => $mobile_menu_group,
				'name'   => 'mobile_menu_row1'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_menu_background_color',
				'type'   => 'colorsimple',
				'label'  => esc_html__( 'Background Color', 'allston' ),
				'parent' => $mobile_menu_row1
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_menu_border_bottom_color',
				'type'   => 'colorsimple',
				'label'  => esc_html__( 'Border Bottom Color', 'allston' ),
				'parent' => $mobile_menu_row1
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_menu_separator_color',
				'type'   => 'colorsimple',
				'label'  => esc_html__( 'Menu Item Separator Color', 'allston' ),
				'parent' => $mobile_menu_row1
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'        => 'mobile_logo_height',
				'type'        => 'text',
				'label'       => esc_html__( 'Logo Height For Mobile Header', 'allston' ),
				'description' => esc_html__( 'Define logo height for screen size smaller than 1024px', 'allston' ),
				'parent'      => $panel_mobile_header,
				'args'        => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'        => 'mobile_logo_height_phones',
				'type'        => 'text',
				'label'       => esc_html__( 'Logo Height For Mobile Devices', 'allston' ),
				'description' => esc_html__( 'Define logo height for screen size smaller than 480px', 'allston' ),
				'parent'      => $panel_mobile_header,
				'args'        => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_section_title(
			array(
				'parent' => $panel_mobile_header,
				'name'   => 'mobile_header_fonts_title',
				'title'  => esc_html__( 'Typography', 'allston' )
			)
		);
		
		$first_level_group = allston_eltdf_add_admin_group(
			array(
				'parent'      => $panel_mobile_header,
				'name'        => 'first_level_group',
				'title'       => esc_html__( '1st Level Menu', 'allston' ),
				'description' => esc_html__( 'Define styles for 1st level in Mobile Menu Navigation', 'allston' )
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
				'name'   => 'mobile_text_color',
				'type'   => 'colorsimple',
				'label'  => esc_html__( 'Text Color', 'allston' ),
				'parent' => $first_level_row1
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_text_hover_color',
				'type'   => 'colorsimple',
				'label'  => esc_html__( 'Hover/Active Text Color', 'allston' ),
				'parent' => $first_level_row1
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_text_google_fonts',
				'type'   => 'fontsimple',
				'label'  => esc_html__( 'Font Family', 'allston' ),
				'parent' => $first_level_row1
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_text_font_size',
				'type'   => 'textsimple',
				'label'  => esc_html__( 'Font Size', 'allston' ),
				'parent' => $first_level_row1,
				'args'   => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		$first_level_row2 = allston_eltdf_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row2'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_text_line_height',
				'type'   => 'textsimple',
				'label'  => esc_html__( 'Line Height', 'allston' ),
				'parent' => $first_level_row2,
				'args'   => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'    => 'mobile_text_text_transform',
				'type'    => 'selectsimple',
				'label'   => esc_html__( 'Text Transform', 'allston' ),
				'parent'  => $first_level_row2,
				'options' => allston_eltdf_get_text_transform_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'    => 'mobile_text_font_style',
				'type'    => 'selectsimple',
				'label'   => esc_html__( 'Font Style', 'allston' ),
				'parent'  => $first_level_row2,
				'options' => allston_eltdf_get_font_style_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'    => 'mobile_text_font_weight',
				'type'    => 'selectsimple',
				'label'   => esc_html__( 'Font Weight', 'allston' ),
				'parent'  => $first_level_row2,
				'options' => allston_eltdf_get_font_weight_array()
			)
		);
		
		$first_level_row3 = allston_eltdf_add_admin_row(
			array(
				'parent' => $first_level_group,
				'name'   => 'first_level_row3'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'textsimple',
				'name'          => 'mobile_text_letter_spacing',
				'label'         => esc_html__( 'Letter Spacing', 'allston' ),
				'default_value' => '',
				'parent'        => $first_level_row3,
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		$second_level_group = allston_eltdf_add_admin_group(
			array(
				'parent'      => $panel_mobile_header,
				'name'        => 'second_level_group',
				'title'       => esc_html__( 'Dropdown Menu', 'allston' ),
				'description' => esc_html__( 'Define styles for drop down menu items in Mobile Menu Navigation', 'allston' )
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
				'name'   => 'mobile_dropdown_text_color',
				'type'   => 'colorsimple',
				'label'  => esc_html__( 'Text Color', 'allston' ),
				'parent' => $second_level_row1
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_dropdown_text_hover_color',
				'type'   => 'colorsimple',
				'label'  => esc_html__( 'Hover/Active Text Color', 'allston' ),
				'parent' => $second_level_row1
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_dropdown_text_google_fonts',
				'type'   => 'fontsimple',
				'label'  => esc_html__( 'Font Family', 'allston' ),
				'parent' => $second_level_row1
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_dropdown_text_font_size',
				'type'   => 'textsimple',
				'label'  => esc_html__( 'Font Size', 'allston' ),
				'parent' => $second_level_row1,
				'args'   => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		$second_level_row2 = allston_eltdf_add_admin_row(
			array(
				'parent' => $second_level_group,
				'name'   => 'second_level_row2'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_dropdown_text_line_height',
				'type'   => 'textsimple',
				'label'  => esc_html__( 'Line Height', 'allston' ),
				'parent' => $second_level_row2,
				'args'   => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'    => 'mobile_dropdown_text_text_transform',
				'type'    => 'selectsimple',
				'label'   => esc_html__( 'Text Transform', 'allston' ),
				'parent'  => $second_level_row2,
				'options' => allston_eltdf_get_text_transform_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'    => 'mobile_dropdown_text_font_style',
				'type'    => 'selectsimple',
				'label'   => esc_html__( 'Font Style', 'allston' ),
				'parent'  => $second_level_row2,
				'options' => allston_eltdf_get_font_style_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'    => 'mobile_dropdown_text_font_weight',
				'type'    => 'selectsimple',
				'label'   => esc_html__( 'Font Weight', 'allston' ),
				'parent'  => $second_level_row2,
				'options' => allston_eltdf_get_font_weight_array()
			)
		);
		
		$second_level_row3 = allston_eltdf_add_admin_row(
			array(
				'parent' => $second_level_group,
				'name'   => 'second_level_row3'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'textsimple',
				'name'          => 'mobile_dropdown_text_letter_spacing',
				'label'         => esc_html__( 'Letter Spacing', 'allston' ),
				'default_value' => '',
				'parent'        => $second_level_row3,
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_section_title(
			array(
				'name'   => 'mobile_opener_panel',
				'parent' => $panel_mobile_header,
				'title'  => esc_html__( 'Mobile Menu Opener', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'        => 'mobile_menu_title',
				'type'        => 'text',
				'label'       => esc_html__( 'Mobile Navigation Title', 'allston' ),
				'description' => esc_html__( 'Enter title for mobile menu navigation', 'allston' ),
				'parent'      => $panel_mobile_header,
				'args'        => array(
					'col_width' => 3
				)
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'parent'        => $panel_mobile_header,
				'type'          => 'select',
				'name'          => 'mobile_icon_icon_source',
				'default_value' => 'icon_pack',
				'label'         => esc_html__( 'Select Mobile Navigation Icon Source', 'allston' ),
				'description'   => esc_html__( 'Choose whether you would like to use icons from an icon pack or SVG icons', 'allston' ),
				'options'       => allston_eltdf_get_icon_sources_array()
			)
		);

		$mobile_icon_pack_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $panel_mobile_header,
				'name'            => 'mobile_icon_pack_container',
				'dependency' => array(
					'show' => array(
						'mobile_icon_icon_source' => 'icon_pack'
					)
				)
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'parent'        => $mobile_icon_pack_container,
				'type'          => 'select',
				'name'          => 'mobile_icon_icon_pack',
				'default_value' => 'font_elegant',
				'label'         => esc_html__( 'Mobile Navigation Icon Pack', 'allston' ),
				'description'   => esc_html__( 'Choose icon pack for mobile navigation icon', 'allston' ),
				'options'       => allston_eltdf_icon_collections()->getIconCollectionsExclude( array( 'linea_icons', 'dripicons', 'simple_line_icons' ) )
			)
		);

		$mobile_icon_svg_path_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $panel_mobile_header,
				'name'            => 'mobile_icon_svg_path_container',
				'dependency' => array(
					'show' => array(
						'mobile_icon_icon_source' => 'svg_path'
					)
				)
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'parent'      => $mobile_icon_svg_path_container,
				'type'        => 'textarea',
				'name'        => 'mobile_icon_svg_path',
				'label'       => esc_html__( 'Mobile Navigation Icon SVG Path', 'allston' ),
				'description' => esc_html__( 'Enter your mobile navigation icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_icon_color',
				'type'   => 'color',
				'label'  => esc_html__( 'Mobile Navigation Icon Color', 'allston' ),
				'parent' => $panel_mobile_header
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'   => 'mobile_icon_hover_color',
				'type'   => 'color',
				'label'  => esc_html__( 'Mobile Navigation Icon Hover Color', 'allston' ),
				'parent' => $panel_mobile_header
			)
		);
	}
	
	add_action( 'allston_eltdf_action_mobile_header_options_map', 'allston_eltdf_mobile_header_options_map' );
}