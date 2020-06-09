<?php

if ( ! function_exists( 'allston_eltdf_portfolio_options_map' ) ) {
	function allston_eltdf_portfolio_options_map() {
		
		allston_eltdf_add_admin_page(
			array(
				'slug'  => '_portfolio',
				'title' => esc_html__( 'Portfolio', 'allston-core' ),
				'icon'  => 'fa fa-camera-retro'
			)
		);
		
		$panel_archive = allston_eltdf_add_admin_panel(
			array(
				'title' => esc_html__( 'Portfolio Archive', 'allston-core' ),
				'name'  => 'panel_portfolio_archive',
				'page'  => '_portfolio'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'        => 'portfolio_archive_number_of_items',
				'type'        => 'text',
				'label'       => esc_html__( 'Number of Items', 'allston-core' ),
				'description' => esc_html__( 'Set number of items for your portfolio list on archive pages. Default value is 12', 'allston-core' ),
				'parent'      => $panel_archive,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_archive_number_of_columns',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'allston-core' ),
				'default_value' => '4',
				'description'   => esc_html__( 'Set number of columns for your portfolio list on archive pages. Default value is 4 columns', 'allston-core' ),
				'parent'        => $panel_archive,
				'options'       => array(
					'2' => esc_html__( '2 Columns', 'allston-core' ),
					'3' => esc_html__( '3 Columns', 'allston-core' ),
					'4' => esc_html__( '4 Columns', 'allston-core' ),
					'5' => esc_html__( '5 Columns', 'allston-core' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_archive_space_between_items',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'allston-core' ),
				'description'   => esc_html__( 'Set space size between portfolio items for your portfolio list on archive pages. Default value is normal', 'allston-core' ),
				'default_value' => 'normal',
				'options'       => allston_eltdf_get_space_between_items_array(),
				'parent'        => $panel_archive
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_archive_image_size',
				'type'          => 'select',
				'label'         => esc_html__( 'Image Proportions', 'allston-core' ),
				'default_value' => 'landscape',
				'description'   => esc_html__( 'Set image proportions for your portfolio list on archive pages. Default value is landscape', 'allston-core' ),
				'parent'        => $panel_archive,
				'options'       => array(
					'full'      => esc_html__( 'Original', 'allston-core' ),
					'landscape' => esc_html__( 'Landscape', 'allston-core' ),
					'portrait'  => esc_html__( 'Portrait', 'allston-core' ),
					'square'    => esc_html__( 'Square', 'allston-core' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_archive_item_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Item Style', 'allston-core' ),
				'default_value' => 'standard-shader',
				'description'   => esc_html__( 'Set item style for your portfolio list on archive pages. Default value is Standard - Shader', 'allston-core' ),
				'parent'        => $panel_archive,
				'options'       => array(
					'standard-shader' => esc_html__( 'Standard - Shader', 'allston-core' ),
					'gallery-overlay' => esc_html__( 'Gallery - Overlay', 'allston-core' )
				)
			)
		);
		
		$panel = allston_eltdf_add_admin_panel(
			array(
				'title' => esc_html__( 'Portfolio Single', 'allston-core' ),
				'name'  => 'panel_portfolio_single',
				'page'  => '_portfolio'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_template',
				'type'          => 'select',
				'label'         => esc_html__( 'Portfolio Type', 'allston-core' ),
				'default_value' => 'small-images',
				'description'   => esc_html__( 'Choose a default type for Single Project pages', 'allston-core' ),
				'parent'        => $panel,
				'options'       => array(
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
			)
		);
		
		/***************** Gallery Layout *****************/
		
		$portfolio_gallery_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $panel,
				'name'            => 'portfolio_gallery_container',
				'dependency' => array(
					'show' => array(
						'portfolio_single_template'  => array(
							'gallery',
							'small-gallery'
						)
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_gallery_columns_number',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'allston-core' ),
				'default_value' => 'three',
				'description'   => esc_html__( 'Set number of columns for portfolio gallery type', 'allston-core' ),
				'parent'        => $portfolio_gallery_container,
				'options'       => array(
					'two'   => esc_html__( '2 Columns', 'allston-core' ),
					'three' => esc_html__( '3 Columns', 'allston-core' ),
					'four'  => esc_html__( '4 Columns', 'allston-core' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_gallery_space_between_items',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'allston-core' ),
				'description'   => esc_html__( 'Set space size between columns for portfolio gallery type', 'allston-core' ),
				'default_value' => 'normal',
				'options'       => allston_eltdf_get_space_between_items_array(),
				'parent'        => $portfolio_gallery_container
			)
		);
		
		/***************** Gallery Layout *****************/
		
		/***************** Masonry Layout *****************/
		
		$portfolio_masonry_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $panel,
				'name'            => 'portfolio_masonry_container',
				'dependency' => array(
					'show' => array(
						'portfolio_single_template'  => array(
							'masonry',
							'small-masonry'
						)
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_masonry_columns_number',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'allston-core' ),
				'default_value' => 'three',
				'description'   => esc_html__( 'Set number of columns for portfolio masonry type', 'allston-core' ),
				'parent'        => $portfolio_masonry_container,
				'options'       => array(
					'two'   => esc_html__( '2 Columns', 'allston-core' ),
					'three' => esc_html__( '3 Columns', 'allston-core' ),
					'four'  => esc_html__( '4 Columns', 'allston-core' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_masonry_space_between_items',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'allston-core' ),
				'description'   => esc_html__( 'Set space size between columns for portfolio masonry type', 'allston-core' ),
				'default_value' => 'normal',
				'options'       => allston_eltdf_get_space_between_items_array(),
				'parent'        => $portfolio_masonry_container
			)
		);
		
		/***************** Masonry Layout *****************/
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'show_title_area_portfolio_single',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'allston-core' ),
				'description'   => esc_html__( 'Enabling this option will show title area on single projects', 'allston-core' ),
				'parent'        => $panel,
				'options'       => array(
					''    => esc_html__( 'Default', 'allston-core' ),
					'yes' => esc_html__( 'Yes', 'allston-core' ),
					'no'  => esc_html__( 'No', 'allston-core' )
				),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_lightbox_images',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Enable Lightbox for Images', 'allston-core' ),
				'description'   => esc_html__( 'Enabling this option will turn on lightbox functionality for projects with images', 'allston-core' ),
				'parent'        => $panel,
				'default_value' => 'yes'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_lightbox_videos',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Enable Lightbox for Videos', 'allston-core' ),
				'description'   => esc_html__( 'Enabling this option will turn on lightbox functionality for YouTube/Vimeo projects', 'allston-core' ),
				'parent'        => $panel,
				'default_value' => 'no'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_enable_categories',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Enable Categories', 'allston-core' ),
				'description'   => esc_html__( 'Enabling this option will enable category meta description on single projects', 'allston-core' ),
				'parent'        => $panel,
				'default_value' => 'yes'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_hide_date',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Enable Date', 'allston-core' ),
				'description'   => esc_html__( 'Enabling this option will enable date meta on single projects', 'allston-core' ),
				'parent'        => $panel,
				'default_value' => 'yes'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_sticky_sidebar',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Enable Sticky Side Text', 'allston-core' ),
				'description'   => esc_html__( 'Enabling this option will make side text sticky on Single Project pages. This option works only for Full Width Images, Small Images, Small Gallery and Small Masonry portfolio types', 'allston-core' ),
				'parent'        => $panel,
				'default_value' => 'yes'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_comments',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Show Comments', 'allston-core' ),
				'description'   => esc_html__( 'Enabling this option will show comments on your page', 'allston-core' ),
				'parent'        => $panel,
				'default_value' => 'no'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_hide_pagination',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Hide Pagination', 'allston-core' ),
				'description'   => esc_html__( 'Enabling this option will turn off portfolio pagination functionality', 'allston-core' ),
				'parent'        => $panel,
				'default_value' => 'no'
			)
		);
		
		$container_navigate_category = allston_eltdf_add_admin_container(
			array(
				'name'            => 'navigate_same_category_container',
				'parent'          => $panel,
				'dependency' => array(
					'hide' => array(
						'portfolio_single_hide_pagination'  => array(
							'yes'
						)
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'portfolio_single_nav_same_category',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Enable Pagination Through Same Category', 'allston-core' ),
				'description'   => esc_html__( 'Enabling this option will make portfolio pagination sort through current category', 'allston-core' ),
				'parent'        => $container_navigate_category,
				'default_value' => 'no'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'        => 'portfolio_single_slug',
				'type'        => 'text',
				'label'       => esc_html__( 'Portfolio Single Slug', 'allston-core' ),
				'description' => esc_html__( 'Enter if you wish to use a different Single Project slug (Note: After entering slug, navigate to Settings -> Permalinks and click "Save" in order for changes to take effect)', 'allston-core' ),
				'parent'      => $panel,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
	}
	
	add_action( 'allston_eltdf_options_map', 'allston_eltdf_portfolio_options_map', 15 );
}