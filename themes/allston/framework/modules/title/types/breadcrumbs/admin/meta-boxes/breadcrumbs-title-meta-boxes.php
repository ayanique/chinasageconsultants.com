<?php

if ( ! function_exists( 'allston_eltdf_breadcrumbs_title_type_options_meta_boxes' ) ) {
	function allston_eltdf_breadcrumbs_title_type_options_meta_boxes( $show_title_area_meta_container ) {
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_breadcrumbs_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Breadcrumbs Color', 'allston' ),
				'description' => esc_html__( 'Choose a color for breadcrumbs text', 'allston' ),
				'parent'      => $show_title_area_meta_container
			)
		);
	}
	
	add_action( 'allston_eltdf_additional_title_area_meta_boxes', 'allston_eltdf_breadcrumbs_title_type_options_meta_boxes' );
}