<?php

if ( ! function_exists( 'allston_eltdf_map_content_bottom_meta' ) ) {
	function allston_eltdf_map_content_bottom_meta() {
		
		$content_bottom_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => apply_filters( 'allston_eltdf_set_scope_for_meta_boxes', array( 'page', 'post' ), 'content_bottom_meta' ),
				'title' => esc_html__( 'Content Bottom', 'allston' ),
				'name'  => 'content_bottom_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_enable_content_bottom_area_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Enable Content Bottom Area', 'allston' ),
				'description'   => esc_html__( 'This option will enable Content Bottom area on pages', 'allston' ),
				'parent'        => $content_bottom_meta_box,
				'options'       => allston_eltdf_get_yes_no_select_array()
			)
		);
		
		$show_content_bottom_meta_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $content_bottom_meta_box,
				'name'            => 'eltdf_show_content_bottom_meta_container',
				'dependency' => array(
					'show' => array(
						'eltdf_enable_content_bottom_area_meta' => 'yes'
					)
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_content_bottom_sidebar_custom_display_meta',
				'type'          => 'selectblank',
				'default_value' => '',
				'label'         => esc_html__( 'Sidebar to Display', 'allston' ),
				'description'   => esc_html__( 'Choose a content bottom sidebar to display', 'allston' ),
				'options'       => allston_eltdf_get_custom_sidebars(),
				'parent'        => $show_content_bottom_meta_container,
				'args'          => array(
					'select2' => true
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'type'          => 'select',
				'name'          => 'eltdf_content_bottom_in_grid_meta',
				'default_value' => '',
				'label'         => esc_html__( 'Display in Grid', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will place content bottom in grid', 'allston' ),
				'options'       => allston_eltdf_get_yes_no_select_array(),
				'parent'        => $show_content_bottom_meta_container
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'type'        => 'color',
				'name'        => 'eltdf_content_bottom_background_color_meta',
				'label'       => esc_html__( 'Background Color', 'allston' ),
				'description' => esc_html__( 'Choose a background color for content bottom area', 'allston' ),
				'parent'      => $show_content_bottom_meta_container
			)
		);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_content_bottom_meta', 71 );
}