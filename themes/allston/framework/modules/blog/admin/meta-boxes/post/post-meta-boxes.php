<?php

/*** Post Settings ***/

if ( ! function_exists( 'allston_eltdf_map_post_meta' ) ) {
	function allston_eltdf_map_post_meta() {
		
		$post_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Post', 'allston' ),
				'name'  => 'post-meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_blog_single_sidebar_layout_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Sidebar Layout', 'allston' ),
				'description'   => esc_html__( 'Choose a sidebar layout for Blog single page', 'allston' ),
				'default_value' => '',
				'parent'        => $post_meta_box,
                'options'       => allston_eltdf_get_custom_sidebars_options( true )
			)
		);
		
		$allston_custom_sidebars = allston_eltdf_get_custom_sidebars();
		if ( count( $allston_custom_sidebars ) > 0 ) {
			allston_eltdf_meta_box_add_field( array(
				'name'        => 'eltdf_blog_single_custom_sidebar_area_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Sidebar to Display', 'allston' ),
				'description' => esc_html__( 'Choose a sidebar to display on Blog single page. Default sidebar is "Sidebar"', 'allston' ),
				'parent'      => $post_meta_box,
				'options'     => allston_eltdf_get_custom_sidebars(),
				'args' => array(
					'select2' => true
				)
			) );
		}
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_blog_list_featured_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Blog List Image', 'allston' ),
				'description' => esc_html__( 'Choose an Image for displaying in blog list. If not uploaded, featured image will be shown.', 'allston' ),
				'parent'      => $post_meta_box
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_blog_masonry_gallery_fixed_dimensions_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Dimensions for Fixed Proportion', 'allston' ),
				'description'   => esc_html__( 'Choose image layout when it appears in Masonry lists in fixed proportion', 'allston' ),
				'default_value' => 'small',
				'parent'        => $post_meta_box,
				'options'       => array(
					'small'              => esc_html__( 'Small', 'allston' ),
					'large-width'        => esc_html__( 'Large Width', 'allston' ),
					'large-height'       => esc_html__( 'Large Height', 'allston' ),
					'large-width-height' => esc_html__( 'Large Width/Height', 'allston' )
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_blog_masonry_gallery_original_dimensions_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Dimensions for Original Proportion', 'allston' ),
				'description'   => esc_html__( 'Choose image layout when it appears in Masonry lists in original proportion', 'allston' ),
				'default_value' => 'default',
				'parent'        => $post_meta_box,
				'options'       => array(
					'default'     => esc_html__( 'Default', 'allston' ),
					'large-width' => esc_html__( 'Large Width', 'allston' )
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_show_title_area_blog_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show title area on your single post page', 'allston' ),
				'parent'        => $post_meta_box,
				'options'       => allston_eltdf_get_yes_no_select_array()
			)
		);

		do_action('allston_eltdf_blog_post_meta', $post_meta_box);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_post_meta', 20 );
}
