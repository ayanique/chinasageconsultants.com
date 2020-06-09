<?php

foreach ( glob( ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/blog/admin/meta-boxes/*/*.php' ) as $meta_box_load ) {
	include_once $meta_box_load;
}

if ( ! function_exists( 'allston_eltdf_map_blog_meta' ) ) {
	function allston_eltdf_map_blog_meta() {
		$eltdf_blog_categories = array();
		$categories           = get_categories();
		foreach ( $categories as $category ) {
			$eltdf_blog_categories[ $category->slug ] = $category->name;
		}
		
		$blog_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => array( 'page' ),
				'title' => esc_html__( 'Blog', 'allston' ),
				'name'  => 'blog_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_blog_category_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Blog Category', 'allston' ),
				'description' => esc_html__( 'Choose category of posts to display (leave empty to display all categories)', 'allston' ),
				'parent'      => $blog_meta_box,
				'options'     => $eltdf_blog_categories
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_show_posts_per_page_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Number of Posts', 'allston' ),
				'description' => esc_html__( 'Enter the number of posts to display', 'allston' ),
				'parent'      => $blog_meta_box,
				'options'     => $eltdf_blog_categories,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_blog_masonry_layout_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Masonry - Layout', 'allston' ),
				'description' => esc_html__( 'Set masonry layout. Default is in grid.', 'allston' ),
				'parent'      => $blog_meta_box,
				'options'     => array(
					''           => esc_html__( 'Default', 'allston' ),
					'in-grid'    => esc_html__( 'In Grid', 'allston' ),
					'full-width' => esc_html__( 'Full Width', 'allston' )
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_blog_masonry_number_of_columns_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Masonry - Number of Columns', 'allston' ),
				'description' => esc_html__( 'Set number of columns for your masonry blog lists', 'allston' ),
				'parent'      => $blog_meta_box,
				'options'     => array(
					''      => esc_html__( 'Default', 'allston' ),
					'two'   => esc_html__( '2 Columns', 'allston' ),
					'three' => esc_html__( '3 Columns', 'allston' ),
					'four'  => esc_html__( '4 Columns', 'allston' ),
					'five'  => esc_html__( '5 Columns', 'allston' )
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_blog_masonry_space_between_items_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Masonry - Space Between Items', 'allston' ),
				'description' => esc_html__( 'Set space size between posts for your masonry blog lists', 'allston' ),
				'options'     => allston_eltdf_get_space_between_items_array( true, true, true, true ),
				'parent'      => $blog_meta_box
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_blog_list_featured_image_proportion_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Masonry - Featured Image Proportion', 'allston' ),
				'description'   => esc_html__( 'Choose type of proportions you want to use for featured images on masonry blog lists', 'allston' ),
				'parent'        => $blog_meta_box,
				'default_value' => '',
				'options'       => array(
					''         => esc_html__( 'Default', 'allston' ),
					'fixed'    => esc_html__( 'Fixed', 'allston' ),
					'original' => esc_html__( 'Original', 'allston' )
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_blog_pagination_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Pagination Type', 'allston' ),
				'description'   => esc_html__( 'Choose a pagination layout for Blog Lists', 'allston' ),
				'parent'        => $blog_meta_box,
				'default_value' => '',
				'options'       => array(
					''                => esc_html__( 'Default', 'allston' ),
					'standard'        => esc_html__( 'Standard', 'allston' ),
					'load-more'       => esc_html__( 'Load More', 'allston' ),
					'infinite-scroll' => esc_html__( 'Infinite Scroll', 'allston' ),
					'no-pagination'   => esc_html__( 'No Pagination', 'allston' )
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'type'          => 'text',
				'name'          => 'eltdf_number_of_chars_meta',
				'default_value' => '',
				'label'         => esc_html__( 'Number of Words in Excerpt', 'allston' ),
				'description'   => esc_html__( 'Enter a number of words in excerpt (article summary). Default value is 40', 'allston' ),
				'parent'        => $blog_meta_box,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_blog_meta', 30 );
}