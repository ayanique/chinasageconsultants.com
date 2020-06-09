<?php

if ( ! function_exists( 'allston_eltdf_get_blog_list_types_options' ) ) {
	function allston_eltdf_get_blog_list_types_options() {
		$blog_list_type_options = apply_filters( 'allston_eltdf_blog_list_type_global_option', $blog_list_type_options = array() );
		
		return $blog_list_type_options;
	}
}

if ( ! function_exists( 'allston_eltdf_blog_options_map' ) ) {
	function allston_eltdf_blog_options_map() {
		$blog_list_type_options = allston_eltdf_get_blog_list_types_options();
		
		allston_eltdf_add_admin_page(
			array(
				'slug'  => '_blog_page',
				'title' => esc_html__( 'Blog', 'allston' ),
				'icon'  => 'fa fa-files-o'
			)
		);
		
		/**
		 * Blog Lists
		 */
		$panel_blog_lists = allston_eltdf_add_admin_panel(
			array(
				'page'  => '_blog_page',
				'name'  => 'panel_blog_lists',
				'title' => esc_html__( 'Blog Lists', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'blog_list_type',
				'type'          => 'select',
				'label'         => esc_html__( 'Blog Layout for Archive Pages', 'allston' ),
				'description'   => esc_html__( 'Choose a default blog layout for archived blog post lists', 'allston' ),
				'default_value' => 'standard',
				'parent'        => $panel_blog_lists,
				'options'       => $blog_list_type_options
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'archive_sidebar_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Sidebar Layout for Archive Pages', 'allston' ),
				'description'   => esc_html__( 'Choose a sidebar layout for archived blog post lists', 'allston' ),
				'default_value' => '',
				'parent'        => $panel_blog_lists,
                'options'       => allston_eltdf_get_custom_sidebars_options(),
			)
		);
		
		$allston_custom_sidebars = allston_eltdf_get_custom_sidebars();
		if ( count( $allston_custom_sidebars ) > 0 ) {
			allston_eltdf_add_admin_field(
				array(
					'name'        => 'archive_custom_sidebar_area',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Sidebar to Display for Archive Pages', 'allston' ),
					'description' => esc_html__( 'Choose a sidebar to display on archived blog post lists. Default sidebar is "Sidebar Page"', 'allston' ),
					'parent'      => $panel_blog_lists,
					'options'     => allston_eltdf_get_custom_sidebars(),
					'args'        => array(
						'select2' => true
					)
				)
			);
		}
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'blog_masonry_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Masonry - Layout', 'allston' ),
				'default_value' => 'in-grid',
				'description'   => esc_html__( 'Set masonry layout. Default is in grid.', 'allston' ),
				'parent'        => $panel_blog_lists,
				'options'       => array(
					'in-grid'    => esc_html__( 'In Grid', 'allston' ),
					'full-width' => esc_html__( 'Full Width', 'allston' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'blog_masonry_number_of_columns',
				'type'          => 'select',
				'label'         => esc_html__( 'Masonry - Number of Columns', 'allston' ),
				'default_value' => 'three',
				'description'   => esc_html__( 'Set number of columns for your masonry blog lists. Default value is 4 columns', 'allston' ),
				'parent'        => $panel_blog_lists,
				'options'       => array(
					'two'   => esc_html__( '2 Columns', 'allston' ),
					'three' => esc_html__( '3 Columns', 'allston' ),
					'four'  => esc_html__( '4 Columns', 'allston' ),
					'five'  => esc_html__( '5 Columns', 'allston' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'blog_masonry_space_between_items',
				'type'          => 'select',
				'label'         => esc_html__( 'Masonry - Space Between Items', 'allston' ),
				'description'   => esc_html__( 'Set space size between posts for your masonry blog lists. Default value is normal', 'allston' ),
				'default_value' => 'huge',
				'options'       => allston_eltdf_get_space_between_items_array( false, true, true, true),
				'parent'        => $panel_blog_lists
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'blog_list_featured_image_proportion',
				'type'          => 'select',
				'label'         => esc_html__( 'Masonry - Featured Image Proportion', 'allston' ),
				'default_value' => 'fixed',
				'description'   => esc_html__( 'Choose type of proportions you want to use for featured images on masonry blog lists', 'allston' ),
				'parent'        => $panel_blog_lists,
				'options'       => array(
					'fixed'    => esc_html__( 'Fixed', 'allston' ),
					'original' => esc_html__( 'Original', 'allston' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'blog_pagination_type',
				'type'          => 'select',
				'label'         => esc_html__( 'Pagination Type', 'allston' ),
				'description'   => esc_html__( 'Choose a pagination layout for Blog Lists', 'allston' ),
				'parent'        => $panel_blog_lists,
				'default_value' => 'standard',
				'options'       => array(
					'standard'        => esc_html__( 'Standard', 'allston' ),
					'load-more'       => esc_html__( 'Load More', 'allston' ),
					'infinite-scroll' => esc_html__( 'Infinite Scroll', 'allston' ),
					'no-pagination'   => esc_html__( 'No Pagination', 'allston' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'text',
				'name'          => 'number_of_chars',
				'default_value' => '40',
				'label'         => esc_html__( 'Number of Words in Excerpt', 'allston' ),
				'description'   => esc_html__( 'Enter a number of words in excerpt (article summary). Default value is 40', 'allston' ),
				'parent'        => $panel_blog_lists,
				'args'          => array(
					'col_width' => 3
				)
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'show_tags_area_blog',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Enable Blog Tags on Standard List', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show tags on standard blog list', 'allston' ),
				'parent'        => $panel_blog_lists
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'blog_date_format',
				'type'          => 'select',
				'label'         => esc_html__( 'Date Format', 'allston' ),
				'description'   => esc_html__( 'Choose a date format for Blog Lists', 'allston' ),
				'parent'        => $panel_blog_lists,
				'default_value' => 'standard',
				'options'       => array(
					'standard'        => esc_html__( 'Standard', 'allston' ),
					'simple'          => esc_html__( 'Simple', 'allston' )
				)
			)
		);
		
		/**
		 * Blog Single
		 */
		$panel_blog_single = allston_eltdf_add_admin_panel(
			array(
				'page'  => '_blog_page',
				'name'  => 'panel_blog_single',
				'title' => esc_html__( 'Blog Single', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'blog_single_sidebar_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Sidebar Layout', 'allston' ),
				'description'   => esc_html__( 'Choose a sidebar layout for Blog Single pages', 'allston' ),
				'default_value' => '',
				'parent'        => $panel_blog_single,
                'options'       => allston_eltdf_get_custom_sidebars_options()
			)
		);
		
		if ( count( $allston_custom_sidebars ) > 0 ) {
			allston_eltdf_add_admin_field(
				array(
					'name'        => 'blog_single_custom_sidebar_area',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Sidebar to Display', 'allston' ),
					'description' => esc_html__( 'Choose a sidebar to display on Blog Single pages. Default sidebar is "Sidebar"', 'allston' ),
					'parent'      => $panel_blog_single,
					'options'     => allston_eltdf_get_custom_sidebars(),
					'args'        => array(
						'select2' => true
					)
				)
			);
		}
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'show_title_area_blog',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show title area on single post pages', 'allston' ),
				'parent'        => $panel_blog_single,
				'options'       => allston_eltdf_get_yes_no_select_array(),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'blog_single_title_in_title_area',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Show Post Title in Title Area', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show post title in title area on single post pages', 'allston' ),
				'parent'        => $panel_blog_single,
				'dependency' => array(
					'hide' => array(
						'show_title_area_blog' => 'no'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'blog_single_related_posts',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Show Related Posts', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show related posts on single post pages', 'allston' ),
				'parent'        => $panel_blog_single,
				'default_value' => 'yes'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'blog_single_comments',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Show Comments Form', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show comments form on single post pages', 'allston' ),
				'parent'        => $panel_blog_single,
				'default_value' => 'yes'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_single_navigation',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Prev/Next Single Post Navigation Links', 'allston' ),
				'description'   => esc_html__( 'Enable navigation links through the blog posts (left and right arrows will appear)', 'allston' ),
				'parent'        => $panel_blog_single
			)
		);
		
		$blog_single_navigation_container = allston_eltdf_add_admin_container(
			array(
				'name'            => 'eltdf_blog_single_navigation_container',
				'parent'          => $panel_blog_single,
				'dependency' => array(
					'show' => array(
						'blog_single_navigation' => 'yes'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_navigation_through_same_category',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Navigation Only in Current Category', 'allston' ),
				'description'   => esc_html__( 'Limit your navigation only through current category', 'allston' ),
				'parent'        => $blog_single_navigation_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_author_info',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Author Info Box', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will display author name and descriptions on single post pages', 'allston' ),
				'parent'        => $panel_blog_single
			)
		);
		
		$blog_single_author_info_container = allston_eltdf_add_admin_container(
			array(
				'name'            => 'eltdf_blog_single_author_info_container',
				'parent'          => $panel_blog_single,
				'dependency' => array(
					'show' => array(
						'blog_author_info' => 'yes'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_author_info_email',
				'default_value' => 'no',
				'label'         => esc_html__( 'Show Author Email', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show author email', 'allston' ),
				'parent'        => $blog_single_author_info_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'blog_single_author_social',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Author Social Icons', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show author social icons on single post pages', 'allston' ),
				'parent'        => $blog_single_author_info_container,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		do_action( 'allston_eltdf_blog_single_options_map', $panel_blog_single );
	}
	
	add_action( 'allston_eltdf_options_map', 'allston_eltdf_blog_options_map', 14 );
}