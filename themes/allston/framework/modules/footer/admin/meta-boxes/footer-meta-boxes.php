<?php

if ( ! function_exists( 'allston_eltdf_map_footer_meta' ) ) {
	function allston_eltdf_map_footer_meta() {
		
		$footer_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => apply_filters( 'allston_eltdf_set_scope_for_meta_boxes', array( 'page', 'post' ), 'footer_meta' ),
				'title' => esc_html__( 'Footer', 'allston' ),
				'name'  => 'footer_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_disable_footer_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Disable Footer for this Page', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will hide footer on this page', 'allston' ),
				'options'       => allston_eltdf_get_yes_no_select_array(),
				'parent'        => $footer_meta_box
			)
		);
		
		$show_footer_meta_container = allston_eltdf_add_admin_container(
			array(
				'name'       => 'eltdf_show_footer_meta_container',
				'parent'     => $footer_meta_box,
				'dependency' => array(
					'hide' => array(
						'eltdf_disable_footer_meta' => 'yes'
					)
				)
			)
		);
		
			allston_eltdf_meta_box_add_field(
				array(
					'name'          => 'eltdf_show_footer_top_meta',
					'type'          => 'select',
					'default_value' => '',
					'label'         => esc_html__( 'Show Footer Top', 'allston' ),
					'description'   => esc_html__( 'Enabling this option will show Footer Top area', 'allston' ),
					'options'       => allston_eltdf_get_yes_no_select_array(),
					'parent'        => $show_footer_meta_container
				)
			);
			
			allston_eltdf_meta_box_add_field(
				array(
					'name'          => 'eltdf_show_footer_bottom_meta',
					'type'          => 'select',
					'default_value' => '',
					'label'         => esc_html__( 'Show Footer Bottom', 'allston' ),
					'description'   => esc_html__( 'Enabling this option will show Footer Bottom area', 'allston' ),
					'options'       => allston_eltdf_get_yes_no_select_array(),
					'parent'        => $show_footer_meta_container
				)
			);

        allston_eltdf_meta_box_add_field(
            array(
                'name'          => 'eltdf_footer_in_grid_meta',
                'type'          => 'select',
                'default_value' => '',
                'label'         => esc_html__( 'Footer in Grid', 'allston' ),
                'description'   => esc_html__( 'Enabling this option will place Footer content in grid', 'allston' ),
                'options'       => allston_eltdf_get_yes_no_select_array(),
                'dependency' => array(
                    'hide' => array(
                        'eltdf_show_footer_top_meta' => array('', 'no'),
                        'eltdf_show_footer_bottom_meta' => array('', 'no')
                    )
                ),
                'parent'        => $show_footer_meta_container
            )
        );

        allston_eltdf_meta_box_add_field(
            array(
                'name'          => 'eltdf_uncovering_footer_meta',
                'type'          => 'select',
                'default_value' => '',
                'label'         => esc_html__( 'Uncovering Footer', 'allston' ),
                'description'   => esc_html__( 'Enabling this option will make Footer gradually appear on scroll', 'allston' ),
                'options'       => allston_eltdf_get_yes_no_select_array(),
                'parent'        => $show_footer_meta_container,
            )
        );
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_footer_meta', 70 );
}