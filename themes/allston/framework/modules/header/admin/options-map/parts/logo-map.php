<?php

if ( ! function_exists( 'allston_eltdf_logo_options_map' ) ) {
	function allston_eltdf_logo_options_map() {
		
		allston_eltdf_add_admin_page(
			array(
				'slug'  => '_logo_page',
				'title' => esc_html__( 'Logo', 'allston' ),
				'icon'  => 'fa fa-coffee'
			)
		);
		
		$panel_logo = allston_eltdf_add_admin_panel(
			array(
				'page'  => '_logo_page',
				'name'  => 'panel_logo',
				'title' => esc_html__( 'Logo', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $panel_logo,
				'type'          => 'yesno',
				'name'          => 'hide_logo',
				'default_value' => 'no',
				'label'         => esc_html__( 'Hide Logo', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will hide logo image', 'allston' )
			)
		);
		
		$hide_logo_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $panel_logo,
				'name'            => 'hide_logo_container',
				'dependency' => array(
					'hide' => array(
						'hide_logo'  => 'yes'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'logo_image',
				'type'          => 'image',
				'default_value' => ELATED_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__( 'Logo Image - Default', 'allston' ),
				'parent'        => $hide_logo_container
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'logo_image_dark',
				'type'          => 'image',
				'default_value' => ELATED_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__( 'Logo Image - Dark', 'allston' ),
				'parent'        => $hide_logo_container
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'logo_image_light',
				'type'          => 'image',
				'default_value' => ELATED_ASSETS_ROOT . "/img/logo_white.png",
				'label'         => esc_html__( 'Logo Image - Light', 'allston' ),
				'parent'        => $hide_logo_container
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'logo_image_sticky',
				'type'          => 'image',
				'default_value' => ELATED_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__( 'Logo Image - Sticky', 'allston' ),
				'parent'        => $hide_logo_container
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'logo_image_mobile',
				'type'          => 'image',
				'default_value' => ELATED_ASSETS_ROOT . "/img/logo.png",
				'label'         => esc_html__( 'Logo Image - Mobile', 'allston' ),
				'parent'        => $hide_logo_container
			)
		);
	}
	
	add_action( 'allston_eltdf_options_map', 'allston_eltdf_logo_options_map', 2 );
}