<?php

if ( ! function_exists( 'allston_core_import_object' ) ) {
	function allston_core_import_object() {
		$allston_core_import_object = new AllstonCoreImport();
	}
	
	add_action( 'init', 'allston_core_import_object' );
}

if ( ! function_exists( 'allston_core_data_import' ) ) {
	function allston_core_data_import() {
		$importObject = AllstonCoreImport::getInstance();
		
		if ( $_POST['import_attachments'] == 1 ) {
			$importObject->attachments = true;
		} else {
			$importObject->attachments = false;
		}
		
		$folder = "allston/";
		if ( ! empty( $_POST['example'] ) ) {
			$folder = $_POST['example'] . "/";
		}
		
		$importObject->import_content( $folder . $_POST['xml'] );
		
		die();
	}
	
	add_action( 'wp_ajax_allston_core_data_import', 'allston_core_data_import' );
}

if ( ! function_exists( 'allston_core_widgets_import' ) ) {
	function allston_core_widgets_import() {
		$importObject = AllstonCoreImport::getInstance();
		
		$folder = "allston/";
		if ( ! empty( $_POST['example'] ) ) {
			$folder = $_POST['example'] . "/";
		}
		
		$importObject->import_widgets( $folder . 'widgets.txt', $folder . 'custom_sidebars.txt' );
		
		die();
	}
	
	add_action( 'wp_ajax_allston_core_widgets_import', 'allston_core_widgets_import' );
}

if ( ! function_exists( 'allston_core_options_import' ) ) {
	function allston_core_options_import() {
		$importObject = AllstonCoreImport::getInstance();
		
		$folder = "allston/";
		if ( ! empty( $_POST['example'] ) ) {
			$folder = $_POST['example'] . "/";
		}
		
		$importObject->import_options( $folder . 'options.txt' );
		
		die();
	}
	
	add_action( 'wp_ajax_allston_core_options_import', 'allston_core_options_import' );
}

if ( ! function_exists( 'allston_core_other_import' ) ) {
	function allston_core_other_import() {
		$importObject = AllstonCoreImport::getInstance();
		
		$folder = "allston/";
		if ( ! empty( $_POST['example'] ) ) {
			$folder = $_POST['example'] . "/";
		}
		
		$importObject->import_options( $folder . 'options.txt' );
		$importObject->import_widgets( $folder . 'widgets.txt', $folder . 'custom_sidebars.txt' );
		$importObject->import_menus( $folder . 'menus.txt' );
		$importObject->import_settings_pages( $folder . 'settingpages.txt' );

		$importObject->eltdf_update_meta_fields_after_import($folder);
		$importObject->eltdf_update_options_after_import($folder);

		if ( allston_core_is_revolution_slider_installed() ) {
			$importObject->rev_slider_import( $folder );
		}
		
		die();
	}
	
	add_action( 'wp_ajax_allston_core_other_import', 'allston_core_other_import' );
}