<?php

if ( ! function_exists( 'allston_eltdf_get_title_types_meta_boxes' ) ) {
	function allston_eltdf_get_title_types_meta_boxes() {
		$title_type_options = apply_filters( 'allston_eltdf_title_type_meta_boxes', $title_type_options = array( '' => esc_html__( 'Default', 'allston' ) ) );
		
		return $title_type_options;
	}
}

foreach ( glob( ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/title/types/*/admin/meta-boxes/*.php' ) as $meta_box_load ) {
	include_once $meta_box_load;
}

if ( ! function_exists( 'allston_eltdf_map_title_meta' ) ) {
	function allston_eltdf_map_title_meta() {
		$title_type_meta_boxes = allston_eltdf_get_title_types_meta_boxes();
		
		$title_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => apply_filters( 'allston_eltdf_set_scope_for_meta_boxes', array( 'page', 'post' ), 'title_meta' ),
				'title' => esc_html__( 'Title', 'allston' ),
				'name'  => 'title_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_show_title_area_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'allston' ),
				'description'   => esc_html__( 'Disabling this option will turn off page title area', 'allston' ),
				'parent'        => $title_meta_box,
				'options'       => allston_eltdf_get_yes_no_select_array()
			)
		);
		
			$show_title_area_meta_container = allston_eltdf_add_admin_container(
				array(
					'parent'          => $title_meta_box,
					'name'            => 'eltdf_show_title_area_meta_container',
					'dependency' => array(
						'hide' => array(
							'eltdf_show_title_area_meta' => 'no'
						)
					)
				)
			);
		
				allston_eltdf_meta_box_add_field(
					array(
						'name'          => 'eltdf_title_area_type_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Title Area Type', 'allston' ),
						'description'   => esc_html__( 'Choose title type', 'allston' ),
						'parent'        => $show_title_area_meta_container,
						'options'       => $title_type_meta_boxes
					)
				);
		
				allston_eltdf_meta_box_add_field(
					array(
						'name'          => 'eltdf_title_area_in_grid_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Title Area In Grid', 'allston' ),
						'description'   => esc_html__( 'Set title area content to be in grid', 'allston' ),
						'options'       => allston_eltdf_get_yes_no_select_array(),
						'parent'        => $show_title_area_meta_container
					)
				);
		
				allston_eltdf_meta_box_add_field(
					array(
						'name'        => 'eltdf_title_area_height_meta',
						'type'        => 'text',
						'label'       => esc_html__( 'Height', 'allston' ),
						'description' => esc_html__( 'Set a height for Title Area', 'allston' ),
						'parent'      => $show_title_area_meta_container,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px'
						)
					)
				);
				
				allston_eltdf_meta_box_add_field(
					array(
						'name'        => 'eltdf_title_area_background_color_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Background Color', 'allston' ),
						'description' => esc_html__( 'Choose a background color for title area', 'allston' ),
						'parent'      => $show_title_area_meta_container
					)
				);
		
				allston_eltdf_meta_box_add_field(
					array(
						'name'        => 'eltdf_title_area_background_image_meta',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Image', 'allston' ),
						'description' => esc_html__( 'Choose an Image for title area', 'allston' ),
						'parent'      => $show_title_area_meta_container
					)
				);
		
				allston_eltdf_meta_box_add_field(
					array(
						'name'          => 'eltdf_title_area_background_image_behavior_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Background Image Behavior', 'allston' ),
						'description'   => esc_html__( 'Choose title area background image behavior', 'allston' ),
						'parent'        => $show_title_area_meta_container,
						'options'       => array(
							''                    => esc_html__( 'Default', 'allston' ),
							'hide'                => esc_html__( 'Hide Image', 'allston' ),
							'responsive'          => esc_html__( 'Enable Responsive Image', 'allston' ),
							'responsive-disabled' => esc_html__( 'Disable Responsive Image', 'allston' ),
							'parallax'            => esc_html__( 'Enable Parallax Image', 'allston' ),
							'parallax-zoom-out'   => esc_html__( 'Enable Parallax With Zoom Out Image', 'allston' ),
							'parallax-disabled'   => esc_html__( 'Disable Parallax Image', 'allston' )
						)
					)
				);
				
				allston_eltdf_meta_box_add_field(
					array(
						'name'          => 'eltdf_title_area_vertical_alignment_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Vertical Alignment', 'allston' ),
						'description'   => esc_html__( 'Specify title area content vertical alignment', 'allston' ),
						'parent'        => $show_title_area_meta_container,
						'options'       => array(
							''              => esc_html__( 'Default', 'allston' ),
							'header-bottom' => esc_html__( 'From Bottom of Header', 'allston' ),
							'window-top'    => esc_html__( 'From Window Top', 'allston' )
						)
					)
				);
				
				allston_eltdf_meta_box_add_field(
					array(
						'name'          => 'eltdf_title_area_title_tag_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Title Tag', 'allston' ),
						'options'       => allston_eltdf_get_title_tag( true ),
						'parent'        => $show_title_area_meta_container
					)
				);
				
				allston_eltdf_meta_box_add_field(
					array(
						'name'        => 'eltdf_title_text_color_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Title Color', 'allston' ),
						'description' => esc_html__( 'Choose a color for title text', 'allston' ),
						'parent'      => $show_title_area_meta_container
					)
				);
				
				allston_eltdf_meta_box_add_field(
					array(
						'name'          => 'eltdf_title_area_subtitle_meta',
						'type'          => 'text',
						'default_value' => '',
						'label'         => esc_html__( 'Subtitle Text', 'allston' ),
						'description'   => esc_html__( 'Enter your subtitle text', 'allston' ),
						'parent'        => $show_title_area_meta_container,
						'args'          => array(
							'col_width' => 6
						)
					)
				);
		
				allston_eltdf_meta_box_add_field(
					array(
						'name'          => 'eltdf_title_area_subtitle_tag_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Subtitle Tag', 'allston' ),
						'options'       => allston_eltdf_get_title_tag( true, array( 'p' => 'p' ) ),
						'parent'        => $show_title_area_meta_container
					)
				);
				
				allston_eltdf_meta_box_add_field(
					array(
						'name'        => 'eltdf_subtitle_color_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Subtitle Color', 'allston' ),
						'description' => esc_html__( 'Choose a color for subtitle text', 'allston' ),
						'parent'      => $show_title_area_meta_container
					)
				);
		
		/***************** Additional Title Area Layout - start *****************/
		
		do_action( 'allston_eltdf_additional_title_area_meta_boxes', $show_title_area_meta_container );
		
		/***************** Additional Title Area Layout - end *****************/
		
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_title_meta', 60 );
}