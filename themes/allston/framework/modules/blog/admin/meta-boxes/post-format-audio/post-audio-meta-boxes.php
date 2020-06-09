<?php

if ( ! function_exists( 'allston_eltdf_map_post_audio_meta' ) ) {
	function allston_eltdf_map_post_audio_meta() {
		$audio_post_format_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Audio Post Format', 'allston' ),
				'name'  => 'post_format_audio_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_audio_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Audio Type', 'allston' ),
				'description'   => esc_html__( 'Choose audio type', 'allston' ),
				'parent'        => $audio_post_format_meta_box,
				'default_value' => 'social_networks',
				'options'       => array(
					'social_networks' => esc_html__( 'Audio Service', 'allston' ),
					'self'            => esc_html__( 'Self Hosted', 'allston' )
				)
			)
		);
		
		$eltdf_audio_embedded_container = allston_eltdf_add_admin_container(
			array(
				'parent' => $audio_post_format_meta_box,
				'name'   => 'eltdf_audio_embedded_container'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_post_audio_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Audio URL', 'allston' ),
				'description' => esc_html__( 'Enter audio URL', 'allston' ),
				'parent'      => $eltdf_audio_embedded_container,
				'dependency' => array(
					'show' => array(
						'eltdf_audio_type_meta' => 'social_networks'
					)
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_post_audio_custom_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Audio Link', 'allston' ),
				'description' => esc_html__( 'Enter audio link', 'allston' ),
				'parent'      => $eltdf_audio_embedded_container,
				'dependency' => array(
					'show' => array(
						'eltdf_audio_type_meta' => 'self'
					)
				)
			)
		);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_post_audio_meta', 23 );
}