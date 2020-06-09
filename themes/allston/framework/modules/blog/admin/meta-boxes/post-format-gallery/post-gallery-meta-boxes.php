<?php

if ( ! function_exists( 'allston_eltdf_map_post_gallery_meta' ) ) {
	
	function allston_eltdf_map_post_gallery_meta() {
		$gallery_post_format_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Gallery Post Format', 'allston' ),
				'name'  => 'post_format_gallery_meta'
			)
		);
		
		allston_eltdf_add_multiple_images_field(
			array(
				'name'        => 'eltdf_post_gallery_images_meta',
				'label'       => esc_html__( 'Gallery Images', 'allston' ),
				'description' => esc_html__( 'Choose your gallery images', 'allston' ),
				'parent'      => $gallery_post_format_meta_box,
			)
		);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_post_gallery_meta', 21 );
}
