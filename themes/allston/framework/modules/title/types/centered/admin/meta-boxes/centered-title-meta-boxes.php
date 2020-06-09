<?php

if ( ! function_exists( 'allston_eltdf_centered_title_type_options_meta_boxes' ) ) {
	function allston_eltdf_centered_title_type_options_meta_boxes( $show_title_area_meta_container ) {
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_subtitle_side_padding_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Subtitle Side Padding', 'allston' ),
				'description' => esc_html__( 'Set left/right padding for subtitle area', 'allston' ),
				'parent'      => $show_title_area_meta_container,
				'args'        => array(
					'col_width' => 2,
					'suffix'    => 'px or %'
				)
			)
		);
	}
	
	add_action( 'allston_eltdf_additional_title_area_meta_boxes', 'allston_eltdf_centered_title_type_options_meta_boxes', 5 );
}