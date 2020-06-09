<?php

if ( ! function_exists( 'allston_core_map_portfolio_meta' ) ) {
	function allston_core_map_portfolio_meta() {
		global $allston_eltdf_Framework;
		
		$allston_pages = array();
		$pages      = get_pages();
		foreach ( $pages as $page ) {
			$allston_pages[ $page->ID ] = $page->post_title;
		}
		
		//Portfolio Images
		
		$allston_portfolio_images = new AllstonEltdfMetaBox( 'portfolio-item', esc_html__( 'Portfolio Images (multiple upload)', 'allston-core' ), '', '', 'portfolio_images' );
		$allston_eltdf_Framework->eltdfMetaBoxes->addMetaBox( 'portfolio_images', $allston_portfolio_images );
		
		$allston_portfolio_image_gallery = new AllstonEltdfMultipleImages( 'eltdf-portfolio-image-gallery', esc_html__( 'Portfolio Images', 'allston-core' ), esc_html__( 'Choose your portfolio images', 'allston-core' ) );
		$allston_portfolio_images->addChild( 'eltdf-portfolio-image-gallery', $allston_portfolio_image_gallery );
		
		//Portfolio Single Upload Images/Videos 
		
		$allston_portfolio_images_videos = allston_eltdf_meta_box_add(
			array(
				'scope' => array( 'portfolio-item' ),
				'title' => esc_html__( 'Portfolio Images/Videos (single upload)', 'allston-core' ),
				'name'  => 'eltdf_portfolio_images_videos'
			)
		);
		allston_eltdf_add_repeater_field(
			array(
				'name'        => 'eltdf_portfolio_single_upload',
				'parent'      => $allston_portfolio_images_videos,
				'button_text' => esc_html__( 'Add Image/Video', 'allston-core' ),
				'fields'      => array(
					array(
						'type'        => 'select',
						'name'        => 'file_type',
						'label'       => esc_html__( 'File Type', 'allston-core' ),
						'options' => array(
							'image' => esc_html__('Image','allston-core'),
							'video' => esc_html__('Video','allston-core'),
						)
					),
					array(
						'type'        => 'image',
						'name'        => 'single_image',
						'label'       => esc_html__( 'Image', 'allston-core' ),
						'dependency' => array(
							'show' => array(
								'file_type'  => 'image'
							)
						)
					),
					array(
						'type'        => 'select',
						'name'        => 'video_type',
						'label'       => esc_html__( 'Video Type', 'allston-core' ),
						'options'	  => array(
							'youtube' => esc_html__('YouTube', 'allston-core'),
							'vimeo' => esc_html__('Vimeo', 'allston-core'),
							'self' => esc_html__('Self Hosted', 'allston-core'),
						),
						'dependency' => array(
							'show' => array(
								'file_type'  => 'video'
							)
						)
					),
					array(
						'type'        => 'text',
						'name'        => 'video_id',
						'label'       => esc_html__( 'Video ID', 'allston-core' ),
						'dependency' => array(
							'show' => array(
								'file_type' => 'video',
								'video_type'  => array('youtube','vimeo')
							)
						)
					),
					array(
						'type'        => 'text',
						'name'        => 'video_mp4',
						'label'       => esc_html__( 'Video mp4', 'allston-core' ),
						'dependency' => array(
							'show' => array(
								'file_type' => 'video',
								'video_type'  => 'self'
							)
						)
					),
					array(
						'type'        => 'image',
						'name'        => 'video_cover_image',
						'label'       => esc_html__( 'Video Cover Image', 'allston-core' ),
						'dependency' => array(
							'show' => array(
								'file_type' => 'video',
								'video_type'  => 'self'
							)
						)
					)
				)
			)
		);
		
		//Portfolio Additional Sidebar Items
		
		$allston_additional_sidebar_items = allston_eltdf_meta_box_add(
			array(
				'scope' => array( 'portfolio-item' ),
				'title' => esc_html__( 'Additional Portfolio Sidebar Items', 'allston-core' ),
				'name'  => 'portfolio_properties'
			)
		);

		allston_eltdf_add_repeater_field(
			array(
				'name'        => 'eltdf_portfolio_properties',
				'parent'      => $allston_additional_sidebar_items,
				'button_text' => esc_html__( 'Add New Item', 'allston-core' ),
				'fields'      => array(
					array(
						'type'        => 'text',
						'name'        => 'item_title',
						'label'       => esc_html__( 'Item Title', 'allston-core' ),
					),
					array(
						'type'        => 'text',
						'name'        => 'item_text',
						'label'       => esc_html__( 'Item Text', 'allston-core' )
					),
					array(
						'type'        => 'text',
						'name'        => 'item_url',
						'label'       => esc_html__( 'Enter Full URL for Item Text Link', 'allston-core' )
					)
				)
			)
		);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_core_map_portfolio_meta', 40 );
}