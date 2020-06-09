<?php

if ( ! function_exists( 'allston_eltdf_footer_options_map' ) ) {
	function allston_eltdf_footer_options_map() {

		allston_eltdf_add_admin_page(
			array(
				'slug'  => '_footer_page',
				'title' => esc_html__( 'Footer', 'allston' ),
				'icon'  => 'fa fa-sort-amount-asc'
			)
		);

		$footer_panel = allston_eltdf_add_admin_panel(
			array(
				'title' => esc_html__( 'Footer', 'allston' ),
				'name'  => 'footer',
				'page'  => '_footer_page'
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'footer_in_grid',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Footer in Grid', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will place Footer content in grid', 'allston' ),
				'parent'        => $footer_panel
			)
		);

        allston_eltdf_add_admin_field(
            array(
                'type'          => 'yesno',
                'name'          => 'uncovering_footer',
                'default_value' => 'no',
                'label'         => esc_html__( 'Uncovering Footer', 'allston' ),
                'description'   => esc_html__( 'Enabling this option will make Footer gradually appear on scroll', 'allston' ),
                'parent'        => $footer_panel,
            )
        );

		allston_eltdf_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'show_footer_top',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Footer Top', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show Footer Top area', 'allston' ),
				'parent'        => $footer_panel,
			)
		);
		
		$show_footer_top_container = allston_eltdf_add_admin_container(
			array(
				'name'       => 'show_footer_top_container',
				'parent'     => $footer_panel,
				'dependency' => array(
					'show' => array(
						'show_footer_top' => 'yes'
					)
				)
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'footer_top_columns',
				'parent'        => $show_footer_top_container,
				'default_value' => '3 3 3 3',
				'label'         => esc_html__( 'Footer Top Columns', 'allston' ),
				'description'   => esc_html__( 'Choose number of columns for Footer Top area', 'allston' ),
				'options'       => array(
					'12' => '1',
					'6 6' => '2',
					'4 4 4' => '3',
                    '3 3 6' => '3 (25% + 25% + 50%)',
					'3 3 3 3' => '4'
				)
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'footer_top_columns_alignment',
				'default_value' => 'left',
				'label'         => esc_html__( 'Footer Top Columns Alignment', 'allston' ),
				'description'   => esc_html__( 'Text Alignment in Footer Columns', 'allston' ),
				'options'       => array(
					''       => esc_html__( 'Default', 'allston' ),
					'left'   => esc_html__( 'Left', 'allston' ),
					'center' => esc_html__( 'Center', 'allston' ),
					'right'  => esc_html__( 'Right', 'allston' )
				),
				'parent'        => $show_footer_top_container,
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'name'        => 'footer_top_background_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Background Color', 'allston' ),
				'description' => esc_html__( 'Set background color for top footer area', 'allston' ),
				'parent'      => $show_footer_top_container
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'show_footer_bottom',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Footer Bottom', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show Footer Bottom area', 'allston' ),
				'parent'        => $footer_panel,
			)
		);

		$show_footer_bottom_container = allston_eltdf_add_admin_container(
			array(
				'name'            => 'show_footer_bottom_container',
				'parent'          => $footer_panel,
				'dependency' => array(
					'show' => array(
						'show_footer_bottom'  => 'yes'
					)
				)
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'footer_bottom_columns',
				'default_value' => '6 6',
				'label'         => esc_html__( 'Footer Bottom Columns', 'allston' ),
				'description'   => esc_html__( 'Choose number of columns for Footer Bottom area', 'allston' ),
				'options'       => array(
					'12' => '1',
					'6 6' => '2',
					'4 4 4' => '3'
				),
				'parent'        => $show_footer_bottom_container,
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'name'        => 'footer_bottom_background_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Background Color', 'allston' ),
				'description' => esc_html__( 'Set background color for bottom footer area', 'allston' ),
				'parent'      => $show_footer_bottom_container
			)
		);
	}

	add_action( 'allston_eltdf_options_map', 'allston_eltdf_footer_options_map', 12 );
}