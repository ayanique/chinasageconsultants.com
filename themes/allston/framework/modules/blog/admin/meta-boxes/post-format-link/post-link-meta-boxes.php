<?php

if ( ! function_exists( 'allston_eltdf_map_post_link_meta' ) ) {
	function allston_eltdf_map_post_link_meta() {
		$link_post_format_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Link Post Format', 'allston' ),
				'name'  => 'post_format_link_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_post_link_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Link', 'allston' ),
				'description' => esc_html__( 'Enter link', 'allston' ),
				'parent'      => $link_post_format_meta_box
			)
		);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_post_link_meta', 24 );
}