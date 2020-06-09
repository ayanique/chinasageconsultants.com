<?php

if ( ! function_exists( 'allston_eltdf_map_post_video_meta' ) ) {
	function allston_eltdf_map_post_video_meta() {
		$video_post_format_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Video Post Format', 'allston' ),
				'name'  => 'post_format_video_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_video_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Video Type', 'allston' ),
				'description'   => esc_html__( 'Choose video type', 'allston' ),
				'parent'        => $video_post_format_meta_box,
				'default_value' => 'social_networks',
				'options'       => array(
					'social_networks' => esc_html__( 'Video Service', 'allston' ),
					'self'            => esc_html__( 'Self Hosted', 'allston' )
				)
			)
		);
		
		$eltdf_video_embedded_container = allston_eltdf_add_admin_container(
			array(
				'parent' => $video_post_format_meta_box,
				'name'   => 'eltdf_video_embedded_container'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_post_video_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Video URL', 'allston' ),
				'description' => esc_html__( 'Enter Video URL', 'allston' ),
				'parent'      => $eltdf_video_embedded_container,
				'dependency' => array(
					'show' => array(
						'eltdf_video_type_meta' => 'social_networks'
					)
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_post_video_custom_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Video MP4', 'allston' ),
				'description' => esc_html__( 'Enter video URL for MP4 format', 'allston' ),
				'parent'      => $eltdf_video_embedded_container,
				'dependency' => array(
					'show' => array(
						'eltdf_video_type_meta' => 'self'
					)
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_post_video_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Video Image', 'allston' ),
				'description' => esc_html__( 'Enter video image', 'allston' ),
				'parent'      => $eltdf_video_embedded_container,
				'dependency' => array(
					'show' => array(
						'eltdf_video_type_meta' => 'self'
					)
				)
			)
		);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_post_video_meta', 22 );
}