<?php

if ( ! function_exists( 'allston_eltdf_map_sidebar_meta' ) ) {
	function allston_eltdf_map_sidebar_meta() {
		$eltdf_sidebar_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => apply_filters( 'allston_eltdf_set_scope_for_meta_boxes', array( 'page' ), 'sidebar_meta' ),
				'title' => esc_html__( 'Sidebar', 'allston' ),
				'name'  => 'sidebar_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_sidebar_layout_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Sidebar Layout', 'allston' ),
				'description' => esc_html__( 'Choose the sidebar layout', 'allston' ),
				'parent'      => $eltdf_sidebar_meta_box,
                'options'       => allston_eltdf_get_custom_sidebars_options( true )
			)
		);
		
		$eltdf_custom_sidebars = allston_eltdf_get_custom_sidebars();
		if ( count( $eltdf_custom_sidebars ) > 0 ) {
			allston_eltdf_meta_box_add_field(
				array(
					'name'        => 'eltdf_custom_sidebar_area_meta',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Choose Widget Area in Sidebar', 'allston' ),
					'description' => esc_html__( 'Choose Custom Widget area to display in Sidebar"', 'allston' ),
					'parent'      => $eltdf_sidebar_meta_box,
					'options'     => $eltdf_custom_sidebars,
					'args'        => array(
						'select2' => true
					)
				)
			);
		}
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_sidebar_meta', 31 );
}