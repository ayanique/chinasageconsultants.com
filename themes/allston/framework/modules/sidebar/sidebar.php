<?php

if ( ! function_exists( 'allston_eltdf_register_sidebars' ) ) {
	/**
	 * Function that registers theme's sidebars
	 */
	function allston_eltdf_register_sidebars() {
		
		register_sidebar(
			array(
				'id'            => 'sidebar',
				'name'          => esc_html__( 'Sidebar', 'allston' ),
				'description'   => esc_html__( 'Default Sidebar area. In order to display this area you need to enable it through global theme options or on page meta box options.', 'allston' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="eltdf-widget-title-holder"><h3 class="eltdf-widget-title">',
				'after_title'   => '</h3></div>'
			)
		);
	}
	
	add_action( 'widgets_init', 'allston_eltdf_register_sidebars', 1 );
}

if ( ! function_exists( 'allston_eltdf_add_support_custom_sidebar' ) ) {
	/**
	 * Function that adds theme support for custom sidebars. It also creates AllstonEltdfSidebar object
	 */
	function allston_eltdf_add_support_custom_sidebar() {
		add_theme_support( 'AllstonEltdfSidebar' );
		
		if ( get_theme_support( 'AllstonEltdfSidebar' ) ) {
			new AllstonEltdfSidebar();
		}
	}
	
	add_action( 'after_setup_theme', 'allston_eltdf_add_support_custom_sidebar' );
}