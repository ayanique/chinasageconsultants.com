<?php

if ( ! function_exists( 'allston_eltdf_reset_options_map' ) ) {
	/**
	 * Reset options panel
	 */
	function allston_eltdf_reset_options_map() {
		
		allston_eltdf_add_admin_page(
			array(
				'slug'  => '_reset_page',
				'title' => esc_html__( 'Reset', 'allston' ),
				'icon'  => 'fa fa-retweet'
			)
		);
		
		$panel_reset = allston_eltdf_add_admin_panel(
			array(
				'page'  => '_reset_page',
				'name'  => 'panel_reset',
				'title' => esc_html__( 'Reset', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'reset_to_defaults',
				'default_value' => 'no',
				'label'         => esc_html__( 'Reset to Defaults', 'allston' ),
				'description'   => esc_html__( 'This option will reset all Select Options values to defaults', 'allston' ),
				'parent'        => $panel_reset
			)
		);
	}
	
	add_action( 'allston_eltdf_options_map', 'allston_eltdf_reset_options_map', 100 );
}