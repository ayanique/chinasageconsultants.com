<?php

if ( ! function_exists( 'allston_eltdf_map_post_quote_meta' ) ) {
	function allston_eltdf_map_post_quote_meta() {
		$quote_post_format_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Quote Post Format', 'allston' ),
				'name'  => 'post_format_quote_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_post_quote_text_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Quote Text', 'allston' ),
				'description' => esc_html__( 'Enter Quote text', 'allston' ),
				'parent'      => $quote_post_format_meta_box
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_post_quote_author_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Quote Author', 'allston' ),
				'description' => esc_html__( 'Enter Quote author', 'allston' ),
				'parent'      => $quote_post_format_meta_box
			)
		);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_post_quote_meta', 25 );
}