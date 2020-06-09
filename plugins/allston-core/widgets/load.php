<?php

if ( ! function_exists( 'allston_eltdf_load_widget_class' ) ) {
	/**
	 * Loades widget class file.
	 */
	function allston_eltdf_load_widget_class() {
		include_once 'widget-class.php';
	}
	
	add_action( 'allston_eltdf_before_options_map', 'allston_eltdf_load_widget_class' );
}

if ( ! function_exists( 'allston_eltdf_load_widgets' ) ) {
	/**
	 * Loades all widgets by going through all folders that are placed directly in widgets folder
	 * and loads load.php file in each. Hooks to eltdf_themename_action_after_options_map action
	 */
	function allston_eltdf_load_widgets() {
		
		if ( allston_core_theme_installed() ) {
			foreach ( glob( ELATED_FRAMEWORK_ROOT_DIR . '/modules/widgets/*/load.php' ) as $widget_load ) {
				include_once $widget_load;
			}
		}
		
		include_once 'widget-loader.php';
	}
	
	add_action( 'allston_eltdf_before_options_map', 'allston_eltdf_load_widgets' );
}