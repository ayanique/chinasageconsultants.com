<?php

if ( ! function_exists( 'allston_core_map_testimonials_meta' ) ) {
	function allston_core_map_testimonials_meta() {
		$testimonial_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => array( 'testimonials' ),
				'title' => esc_html__( 'Testimonial', 'allston-core' ),
				'name'  => 'testimonial_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_testimonial_title',
				'type'        => 'text',
				'label'       => esc_html__( 'Title', 'allston-core' ),
				'description' => esc_html__( 'Enter testimonial title', 'allston-core' ),
				'parent'      => $testimonial_meta_box,
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_testimonial_text',
				'type'        => 'text',
				'label'       => esc_html__( 'Text', 'allston-core' ),
				'description' => esc_html__( 'Enter testimonial text', 'allston-core' ),
				'parent'      => $testimonial_meta_box,
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_testimonial_author',
				'type'        => 'text',
				'label'       => esc_html__( 'Author', 'allston-core' ),
				'description' => esc_html__( 'Enter author name', 'allston-core' ),
				'parent'      => $testimonial_meta_box,
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_testimonial_author_position',
				'type'        => 'text',
				'label'       => esc_html__( 'Author Position', 'allston-core' ),
				'description' => esc_html__( 'Enter author job position', 'allston-core' ),
				'parent'      => $testimonial_meta_box,
			)
		);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_core_map_testimonials_meta', 95 );
}