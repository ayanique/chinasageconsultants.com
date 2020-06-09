<?php

if ( ! function_exists( 'allston_eltdf_sidebar_options_map' ) ) {
	function allston_eltdf_sidebar_options_map() {
		
		allston_eltdf_add_admin_page(
			array(
				'slug'  => '_sidebar_page',
				'title' => esc_html__( 'Sidebar Area', 'allston' ),
				'icon'  => 'fa fa-indent'
			)
		);
		
		$sidebar_panel = allston_eltdf_add_admin_panel(
			array(
				'title' => esc_html__( 'Sidebar Area', 'allston' ),
				'name'  => 'sidebar',
				'page'  => '_sidebar_page'
			)
		);
		
		allston_eltdf_add_admin_field( array(
			'name'          => 'sidebar_layout',
			'type'          => 'select',
			'label'         => esc_html__( 'Sidebar Layout', 'allston' ),
			'description'   => esc_html__( 'Choose a sidebar layout for pages', 'allston' ),
			'parent'        => $sidebar_panel,
			'default_value' => 'no-sidebar',
            'options'       => allston_eltdf_get_custom_sidebars_options()
		) );
		
		$allston_custom_sidebars = allston_eltdf_get_custom_sidebars();
		if ( count( $allston_custom_sidebars ) > 0 ) {
			allston_eltdf_add_admin_field( array(
				'name'        => 'custom_sidebar_area',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Sidebar to Display', 'allston' ),
				'description' => esc_html__( 'Choose a sidebar to display on pages. Default sidebar is "Sidebar"', 'allston' ),
				'parent'      => $sidebar_panel,
				'options'     => $allston_custom_sidebars,
				'args'        => array(
					'select2' => true
				)
			) );
		}
	}
	
	add_action( 'allston_eltdf_options_map', 'allston_eltdf_sidebar_options_map', 9 );
}