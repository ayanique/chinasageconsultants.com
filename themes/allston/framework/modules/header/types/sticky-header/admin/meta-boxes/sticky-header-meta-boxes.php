<?php

if ( ! function_exists( 'allston_eltdf_sticky_header_meta_boxes_options_map' ) ) {
	function allston_eltdf_sticky_header_meta_boxes_options_map( $header_meta_box ) {
		
		$sticky_amount_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $header_meta_box,
				'name'            => 'sticky_amount_container_meta_container',
				'dependency' => array(
					'hide' => array(
						'eltdf_header_behaviour_meta'  => array( '', 'no-behavior','fixed-on-scroll','sticky-header-on-scroll-up' )
					)
				)
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_scroll_amount_for_sticky_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Scroll Amount for Sticky Header Appearance', 'allston' ),
				'description' => esc_html__( 'Define scroll amount for sticky header appearance', 'allston' ),
				'parent'      => $sticky_amount_container,
				'args'        => array(
					'col_width' => 2,
					'suffix'    => 'px'
				)
			)
		);
		
		$allston_custom_sidebars = allston_eltdf_get_custom_sidebars();
		if ( count( $allston_custom_sidebars ) > 0 ) {
			allston_eltdf_meta_box_add_field(
				array(
					'name'        => 'eltdf_custom_sticky_menu_area_sidebar_meta',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Choose Custom Widget Area In Sticky Header Menu Area', 'allston' ),
					'description' => esc_html__( 'Choose custom widget area to display in sticky header menu area"', 'allston' ),
					'parent'      => $header_meta_box,
					'options'     => $allston_custom_sidebars,
					'dependency' => array(
						'show' => array(
							'eltdf_header_behaviour_meta' => array( 'sticky-header-on-scroll-up', 'sticky-header-on-scroll-down-up' )
						)
					)
				)
			);
		}
	}
	
	add_action( 'allston_eltdf_additional_header_area_meta_boxes_map', 'allston_eltdf_sticky_header_meta_boxes_options_map', 8, 1 );
}