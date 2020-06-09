<?php

if ( ! function_exists( 'allston_core_map_portfolio_settings_meta' ) ) {
	function allston_core_map_portfolio_settings_meta() {
		$meta_box = allston_eltdf_meta_box_add( array(
			'scope' => 'portfolio-item',
			'title' => esc_html__( 'Portfolio Settings', 'allston-core' ),
			'name'  => 'portfolio_settings_meta_box'
		) );
		
		allston_eltdf_meta_box_add_field( array(
			'name'        => 'eltdf_portfolio_single_template_meta',
			'type'        => 'select',
			'label'       => esc_html__( 'Portfolio Type', 'allston-core' ),
			'description' => esc_html__( 'Choose a default type for Single Project pages', 'allston-core' ),
			'parent'      => $meta_box,
			'options'     => array(
				''                  => esc_html__( 'Default', 'allston-core' ),
				'huge-images'       => esc_html__( 'Portfolio Full Width Images', 'allston-core' ),
				'images'            => esc_html__( 'Portfolio Images', 'allston-core' ),
				'small-images'      => esc_html__( 'Portfolio Small Images', 'allston-core' ),
				'slider'            => esc_html__( 'Portfolio Slider', 'allston-core' ),
				'small-slider'      => esc_html__( 'Portfolio Small Slider', 'allston-core' ),
				'gallery'           => esc_html__( 'Portfolio Gallery', 'allston-core' ),
				'small-gallery'     => esc_html__( 'Portfolio Small Gallery', 'allston-core' ),
				'masonry'           => esc_html__( 'Portfolio Masonry', 'allston-core' ),
				'small-masonry'     => esc_html__( 'Portfolio Small Masonry', 'allston-core' ),
				'full-screen-slider' => esc_html__( 'Portfolio Fullscreen Slider', 'allston-core' ),
				'custom'            => esc_html__( 'Portfolio Custom', 'allston-core' ),
				'full-width-custom' => esc_html__( 'Portfolio Full Width Custom', 'allston-core' )
			)
		) );
		
		/***************** Gallery Layout *****************/
		
		$gallery_type_meta_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $meta_box,
				'name'            => 'eltdf_gallery_type_meta_container',
				'dependency' => array(
					'show' => array(
						'eltdf_portfolio_single_template_meta'  => array(
							'gallery',
							'small-gallery'
						)
					)
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_portfolio_single_gallery_columns_number_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'allston-core' ),
				'default_value' => '',
				'description'   => esc_html__( 'Set number of columns for portfolio gallery type', 'allston-core' ),
				'parent'        => $gallery_type_meta_container,
				'options'       => array(
					''      => esc_html__( 'Default', 'allston-core' ),
					'two'   => esc_html__( '2 Columns', 'allston-core' ),
					'three' => esc_html__( '3 Columns', 'allston-core' ),
					'four'  => esc_html__( '4 Columns', 'allston-core' )
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_portfolio_single_gallery_space_between_items_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'allston-core' ),
				'description'   => esc_html__( 'Set space size between columns for portfolio gallery type', 'allston-core' ),
				'default_value' => '',
				'options'       => allston_eltdf_get_space_between_items_array( true ),
				'parent'        => $gallery_type_meta_container
			)
		);
		
		/***************** Gallery Layout *****************/
		
		/***************** Masonry Layout *****************/
		
		$masonry_type_meta_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $meta_box,
				'name'            => 'eltdf_masonry_type_meta_container',
				'dependency' => array(
					'show' => array(
						'eltdf_portfolio_single_template_meta'  => array(
							'masonry',
							'small-masonry'
						)
					)
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_portfolio_single_masonry_columns_number_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'allston-core' ),
				'default_value' => '',
				'description'   => esc_html__( 'Set number of columns for portfolio masonry type', 'allston-core' ),
				'parent'        => $masonry_type_meta_container,
				'options'       => array(
					''      => esc_html__( 'Default', 'allston-core' ),
					'two'   => esc_html__( '2 Columns', 'allston-core' ),
					'three' => esc_html__( '3 Columns', 'allston-core' ),
					'four'  => esc_html__( '4 Columns', 'allston-core' )
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_portfolio_single_masonry_space_between_items_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'allston-core' ),
				'description'   => esc_html__( 'Set space size between columns for portfolio masonry type', 'allston-core' ),
				'default_value' => '',
				'options'       => allston_eltdf_get_space_between_items_array( true ),
				'parent'        => $masonry_type_meta_container
			)
		);
		
		/***************** Masonry Layout *****************/
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_show_title_area_portfolio_single_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'allston-core' ),
				'description'   => esc_html__( 'Enabling this option will show title area on your single portfolio page', 'allston-core' ),
				'parent'        => $meta_box,
				'options'       => allston_eltdf_get_yes_no_select_array()
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'portfolio_info_top_padding',
				'type'        => 'text',
				'label'       => esc_html__( 'Portfolio Info Top Padding', 'allston-core' ),
				'description' => esc_html__( 'Set top padding for portfolio info elements holder. This option works only for Portfolio Images, Slider, Gallery and Masonry portfolio types', 'allston-core' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'portfolio_external_link',
				'type'        => 'text',
				'label'       => esc_html__( 'Portfolio External Link', 'allston-core' ),
				'description' => esc_html__( 'Enter URL to link from Portfolio List page', 'allston-core' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_portfolio_featured_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Featured Image', 'allston-core' ),
				'description' => esc_html__( 'Choose an image for Portfolio Lists shortcode where Hover Type option is Switch Featured Images', 'allston-core' ),
				'parent'      => $meta_box
			)
		);

		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'portfolio_short_description',
				'type'        => 'text',
				'label'       => esc_html__( 'Portfolio Short Description', 'allston-core' ),
				'description' => esc_html__( 'Enter short description that is used for portfolio fullscreen slider', 'allston-core' ),
				'parent'      => $meta_box
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_portfolio_masonry_fixed_dimensions_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Dimensions for Masonry - Image Fixed Proportion', 'allston-core' ),
				'description'   => esc_html__( 'Choose image layout when it appears in Masonry type portfolio lists where image proportion is fixed', 'allston-core' ),
				'default_value' => '',
				'parent'        => $meta_box,
				'options'       => array(
					''                   => esc_html__( 'Default', 'allston-core' ),
					'small'              => esc_html__( 'Small', 'allston-core' ),
					'large-width'        => esc_html__( 'Large Width', 'allston-core' ),
					'large-height'       => esc_html__( 'Large Height', 'allston-core' ),
					'large-width-height' => esc_html__( 'Large Width/Height', 'allston-core' )
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_portfolio_masonry_original_dimensions_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Dimensions for Masonry - Image Original Proportion', 'allston-core' ),
				'description'   => esc_html__( 'Choose image layout when it appears in Masonry type portfolio lists where image proportion is original', 'allston-core' ),
				'default_value' => 'default',
				'parent'        => $meta_box,
				'options'       => array(
					'default'     => esc_html__( 'Default', 'allston-core' ),
					'large-width' => esc_html__( 'Large Width', 'allston-core' )
				)
			)
		);
		
		$all_pages = array();
		$pages     = get_pages();
		foreach ( $pages as $page ) {
			$all_pages[ $page->ID ] = $page->post_title;
		}
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'portfolio_single_back_to_link',
				'type'        => 'select',
				'label'       => esc_html__( '"Back To" Link', 'allston-core' ),
				'description' => esc_html__( 'Choose "Back To" page to link from portfolio Single Project page', 'allston-core' ),
				'parent'      => $meta_box,
				'options'     => $all_pages,
				'args'        => array(
					'select2' => true
				)
			)
		);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_core_map_portfolio_settings_meta', 41 );
}