<?php

if ( ! function_exists( 'allston_eltdf_get_title_types_options' ) ) {
	function allston_eltdf_get_title_types_options() {
		$title_type_options = apply_filters( 'allston_eltdf_title_type_global_option', $title_type_options = array() );
		
		return $title_type_options;
	}
}

if ( ! function_exists( 'allston_eltdf_get_title_type_default_options' ) ) {
	function allston_eltdf_get_title_type_default_options() {
		$title_type_option = apply_filters( 'allston_eltdf_default_title_type_global_option', $title_type_option = '' );
		
		return $title_type_option;
	}
}

foreach ( glob( ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/title/types/*/admin/options-map/*.php' ) as $options_load ) {
	include_once $options_load;
}

if ( ! function_exists('allston_eltdf_title_options_map') ) {
	function allston_eltdf_title_options_map() {
		$title_type_options        = allston_eltdf_get_title_types_options();
		$title_type_default_option = allston_eltdf_get_title_type_default_options();

		allston_eltdf_add_admin_page(
			array(
				'slug' => '_title_page',
				'title' => esc_html__('Title', 'allston'),
				'icon' => 'fa fa-list-alt'
			)
		);

		$panel_title = allston_eltdf_add_admin_panel(
			array(
				'page' => '_title_page',
				'name' => 'panel_title',
				'title' => esc_html__('Title Settings', 'allston')
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'show_title_area',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Title Area', 'allston' ),
				'description'   => esc_html__( 'This option will enable/disable Title Area', 'allston' ),
				'parent'        => $panel_title
			)
		);
		
			$show_title_area_container = allston_eltdf_add_admin_container(
				array(
					'parent'          => $panel_title,
					'name'            => 'show_title_area_container',
					'dependency' => array(
						'show' => array(
							'show_title_area' => 'yes'
						)
					)
				)
			);
		
				allston_eltdf_add_admin_field(
					array(
						'name'          => 'title_area_type',
						'type'          => 'select',
						'default_value' => $title_type_default_option,
						'label'         => esc_html__( 'Title Area Type', 'allston' ),
						'description'   => esc_html__( 'Choose title type', 'allston' ),
						'parent'        => $show_title_area_container,
						'options'       => $title_type_options
					)
				);
		
					allston_eltdf_add_admin_field(
						array(
							'name'          => 'title_area_in_grid',
							'type'          => 'yesno',
							'default_value' => 'yes',
							'label'         => esc_html__( 'Title Area In Grid', 'allston' ),
							'description'   => esc_html__( 'Set title area content to be in grid', 'allston' ),
							'parent'        => $show_title_area_container
						)
					);
		
					allston_eltdf_add_admin_field(
						array(
							'name'        => 'title_area_height',
							'type'        => 'text',
							'label'       => esc_html__( 'Height', 'allston' ),
							'description' => esc_html__( 'Set a height for Title Area', 'allston' ),
							'parent'      => $show_title_area_container,
							'args'        => array(
								'col_width' => 2,
								'suffix'    => 'px'
							)
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'name'        => 'title_area_background_color',
							'type'        => 'color',
							'label'       => esc_html__( 'Background Color', 'allston' ),
							'description' => esc_html__( 'Choose a background color for Title Area', 'allston' ),
							'parent'      => $show_title_area_container
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'name'        => 'title_area_background_image',
							'type'        => 'image',
							'label'       => esc_html__( 'Background Image', 'allston' ),
							'description' => esc_html__( 'Choose an Image for Title Area', 'allston' ),
							'parent'      => $show_title_area_container
						)
					);
		
					allston_eltdf_add_admin_field(
						array(
							'name'          => 'title_area_background_image_behavior',
							'type'          => 'select',
							'default_value' => '',
							'label'         => esc_html__( 'Background Image Behavior', 'allston' ),
							'description'   => esc_html__( 'Choose title area background image behavior', 'allston' ),
							'parent'        => $show_title_area_container,
							'options'       => array(
								''                  => esc_html__( 'Default', 'allston' ),
								'responsive'        => esc_html__( 'Enable Responsive Image', 'allston' ),
								'parallax'          => esc_html__( 'Enable Parallax Image', 'allston' ),
								'parallax-zoom-out' => esc_html__( 'Enable Parallax With Zoom Out Image', 'allston' )
							)
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'name'          => 'title_area_vertical_alignment',
							'type'          => 'select',
							'default_value' => 'header-bottom',
							'label'         => esc_html__( 'Vertical Alignment', 'allston' ),
							'description'   => esc_html__( 'Specify title vertical alignment', 'allston' ),
							'parent'        => $show_title_area_container,
							'options'       => array(
								'header-bottom' => esc_html__( 'From Bottom of Header', 'allston' ),
								'window-top'    => esc_html__( 'From Window Top', 'allston' )
							)
						)
					);
		
		/***************** Additional Title Area Layout - start *****************/
		
		do_action( 'allston_eltdf_additional_title_area_options_map', $show_title_area_container );
		
		/***************** Additional Title Area Layout - end *****************/
		
		
		$panel_typography = allston_eltdf_add_admin_panel(
			array(
				'page'  => '_title_page',
				'name'  => 'panel_title_typography',
				'title' => esc_html__( 'Typography', 'allston' )
			)
		);
		
			allston_eltdf_add_admin_section_title(
				array(
					'name'   => 'type_section_title',
					'title'  => esc_html__( 'Title', 'allston' ),
					'parent' => $panel_typography
				)
			);
		
			$group_page_title_styles = allston_eltdf_add_admin_group(
				array(
					'name'        => 'group_page_title_styles',
					'title'       => esc_html__( 'Title', 'allston' ),
					'description' => esc_html__( 'Define styles for page title', 'allston' ),
					'parent'      => $panel_typography
				)
			);
		
				$row_page_title_styles_1 = allston_eltdf_add_admin_row(
					array(
						'name'   => 'row_page_title_styles_1',
						'parent' => $group_page_title_styles
					)
				);
		
					allston_eltdf_add_admin_field(
						array(
							'name'          => 'title_area_title_tag',
							'type'          => 'selectsimple',
							'default_value' => 'h1',
							'label'         => esc_html__( 'Title Tag', 'allston' ),
							'options'       => allston_eltdf_get_title_tag(),
							'parent'        => $row_page_title_styles_1
						)
					);
		
				$row_page_title_styles_2 = allston_eltdf_add_admin_row(
					array(
						'name'   => 'row_page_title_styles_2',
						'parent' => $group_page_title_styles
					)
				);
		
					allston_eltdf_add_admin_field(
						array(
							'type'   => 'colorsimple',
							'name'   => 'page_title_color',
							'label'  => esc_html__( 'Text Color', 'allston' ),
							'parent' => $row_page_title_styles_2
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'textsimple',
							'name'          => 'page_title_font_size',
							'default_value' => '',
							'label'         => esc_html__( 'Font Size', 'allston' ),
							'parent'        => $row_page_title_styles_2,
							'args'          => array(
								'suffix' => 'px'
							)
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'textsimple',
							'name'          => 'page_title_line_height',
							'default_value' => '',
							'label'         => esc_html__( 'Line Height', 'allston' ),
							'parent'        => $row_page_title_styles_2,
							'args'          => array(
								'suffix' => 'px'
							)
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'selectblanksimple',
							'name'          => 'page_title_text_transform',
							'default_value' => '',
							'label'         => esc_html__( 'Text Transform', 'allston' ),
							'options'       => allston_eltdf_get_text_transform_array(),
							'parent'        => $row_page_title_styles_2
						)
					);
		
				$row_page_title_styles_3 = allston_eltdf_add_admin_row(
					array(
						'name'   => 'row_page_title_styles_3',
						'parent' => $group_page_title_styles,
						'next'   => true
					)
				);
		
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'fontsimple',
							'name'          => 'page_title_google_fonts',
							'default_value' => '-1',
							'label'         => esc_html__( 'Font Family', 'allston' ),
							'parent'        => $row_page_title_styles_3
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'selectblanksimple',
							'name'          => 'page_title_font_style',
							'default_value' => '',
							'label'         => esc_html__( 'Font Style', 'allston' ),
							'options'       => allston_eltdf_get_font_style_array(),
							'parent'        => $row_page_title_styles_3
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'selectblanksimple',
							'name'          => 'page_title_font_weight',
							'default_value' => '',
							'label'         => esc_html__( 'Font Weight', 'allston' ),
							'options'       => allston_eltdf_get_font_weight_array(),
							'parent'        => $row_page_title_styles_3
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'textsimple',
							'name'          => 'page_title_letter_spacing',
							'default_value' => '',
							'label'         => esc_html__( 'Letter Spacing', 'allston' ),
							'parent'        => $row_page_title_styles_3,
							'args'          => array(
								'suffix' => 'px'
							)
						)
					);
		
			allston_eltdf_add_admin_section_title(
				array(
					'name'   => 'type_section_subtitle',
					'title'  => esc_html__( 'Subtitle', 'allston' ),
					'parent' => $panel_typography
				)
			);
		
			$group_page_subtitle_styles = allston_eltdf_add_admin_group(
				array(
					'name'        => 'group_page_subtitle_styles',
					'title'       => esc_html__( 'Subtitle', 'allston' ),
					'description' => esc_html__( 'Define styles for page subtitle', 'allston' ),
					'parent'      => $panel_typography
				)
			);
		
				$row_page_subtitle_styles_1 = allston_eltdf_add_admin_row(
					array(
						'name'   => 'row_page_subtitle_styles_1',
						'parent' => $group_page_subtitle_styles
					)
				);
				
					allston_eltdf_add_admin_field(
						array(
							'name' => 'title_area_subtitle_tag',
							'type' => 'selectsimple',
							'default_value' => 'h6',
							'label' => esc_html__('Subtitle Tag', 'allston'),
							'options' => allston_eltdf_get_title_tag(),
							'parent' => $row_page_subtitle_styles_1
						)
					);
		
				$row_page_subtitle_styles_2 = allston_eltdf_add_admin_row(
					array(
						'name'   => 'row_page_subtitle_styles_2',
						'parent' => $group_page_subtitle_styles
					)
				);
		
					allston_eltdf_add_admin_field(
						array(
							'type'   => 'colorsimple',
							'name'   => 'page_subtitle_color',
							'label'  => esc_html__( 'Text Color', 'allston' ),
							'parent' => $row_page_subtitle_styles_2
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'textsimple',
							'name'          => 'page_subtitle_font_size',
							'default_value' => '',
							'label'         => esc_html__( 'Font Size', 'allston' ),
							'parent'        => $row_page_subtitle_styles_2,
							'args'          => array(
								'suffix' => 'px'
							)
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'textsimple',
							'name'          => 'page_subtitle_line_height',
							'default_value' => '',
							'label'         => esc_html__( 'Line Height', 'allston' ),
							'parent'        => $row_page_subtitle_styles_2,
							'args'          => array(
								'suffix' => 'px'
							)
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'selectblanksimple',
							'name'          => 'page_subtitle_text_transform',
							'default_value' => '',
							'label'         => esc_html__( 'Text Transform', 'allston' ),
							'options'       => allston_eltdf_get_text_transform_array(),
							'parent'        => $row_page_subtitle_styles_2
						)
					);
		
				$row_page_subtitle_styles_3 = allston_eltdf_add_admin_row(
					array(
						'name'   => 'row_page_subtitle_styles_3',
						'parent' => $group_page_subtitle_styles,
						'next'   => true
					)
				);
		
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'fontsimple',
							'name'          => 'page_subtitle_google_fonts',
							'default_value' => '-1',
							'label'         => esc_html__( 'Font Family', 'allston' ),
							'parent'        => $row_page_subtitle_styles_3
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'selectblanksimple',
							'name'          => 'page_subtitle_font_style',
							'default_value' => '',
							'label'         => esc_html__( 'Font Style', 'allston' ),
							'options'       => allston_eltdf_get_font_style_array(),
							'parent'        => $row_page_subtitle_styles_3
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'selectblanksimple',
							'name'          => 'page_subtitle_font_weight',
							'default_value' => '',
							'label'         => esc_html__( 'Font Weight', 'allston' ),
							'options'       => allston_eltdf_get_font_weight_array(),
							'parent'        => $row_page_subtitle_styles_3
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'textsimple',
							'name'          => 'page_subtitle_letter_spacing',
							'default_value' => '',
							'label'         => esc_html__( 'Letter Spacing', 'allston' ),
							'args'          => array(
								'suffix' => 'px'
							),
							'parent'        => $row_page_subtitle_styles_3
						)
					);
		
		/***************** Additional Title Typography Layout - start *****************/
		
		do_action( 'allston_eltdf_additional_title_typography_options_map', $panel_typography );
		
		/***************** Additional Title Typography Layout - end *****************/
    }

	add_action( 'allston_eltdf_options_map', 'allston_eltdf_title_options_map', 6);
}