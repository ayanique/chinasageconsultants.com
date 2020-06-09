<?php

if ( ! function_exists( 'allston_eltdf_include_search_types_before_load' ) ) {
    /**
     * Load's all header types before load files by going through all folders that are placed directly in header types folder.
     * Functions from this files before-load are used to set all hooks and variables before global options map are init
     */
    function allston_eltdf_include_search_types_before_load() {
        foreach ( glob( ELATED_FRAMEWORK_SEARCH_ROOT_DIR . '/types/*/before-load.php' ) as $module_load ) {
            include_once $module_load;
        }
    }

    add_action( 'allston_eltdf_options_map', 'allston_eltdf_include_search_types_before_load', 1 ); // 1 is set to just be before header option map init
}

if ( ! function_exists( 'allston_eltdf_load_search' ) ) {
	function allston_eltdf_load_search() {
		$search_type_meta = allston_eltdf_options()->getOptionValue( 'search_type' );
		$search_type      = ! empty( $search_type_meta ) ? $search_type_meta : 'fullscreen';
		
		if ( allston_eltdf_active_widget( false, false, 'eltdf_search_opener' ) ) {
			include_once ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/search/types/covers-header/covers-header.php';
		}
	}
	
	add_action( 'init', 'allston_eltdf_load_search' );
}

if ( ! function_exists( 'allston_eltdf_get_holder_params_search' ) ) {
	/**
	 * Function which return holder class and holder inner class for blog pages
	 */
	function allston_eltdf_get_holder_params_search() {
		$params_list = array();
		
		$layout = allston_eltdf_options()->getOptionValue( 'search_page_layout' );
		if ( $layout == 'in-grid' ) {
			$params_list['holder'] = 'eltdf-container';
			$params_list['inner']  = 'eltdf-container-inner clearfix';
		} else {
			$params_list['holder'] = 'eltdf-full-width';
			$params_list['inner']  = 'eltdf-full-width-inner';
		}
		
		/**
		 * Available parameters for holder params
		 * -holder
		 * -inner
		 */
		return apply_filters( 'allston_eltdf_search_holder_params', $params_list );
	}
}

if ( ! function_exists( 'allston_eltdf_get_search_page' ) ) {
	function allston_eltdf_get_search_page() {
		$sidebar_layout = allston_eltdf_sidebar_layout();
		
		$params = array(
			'sidebar_layout' => $sidebar_layout
		);
		
		allston_eltdf_get_module_template_part( 'templates/holder', 'search', '', $params );
	}
}

if ( ! function_exists( 'allston_eltdf_get_search_page_layout' ) ) {
	/**
	 * Function which create query for blog lists
	 */
	function allston_eltdf_get_search_page_layout() {
		global $wp_query;
		$path   = apply_filters( 'allston_eltdf_search_page_path', 'templates/page' );
		$type   = apply_filters( 'allston_eltdf_search_page_layout', 'default' );
		$module = apply_filters( 'allston_eltdf_search_page_module', 'search' );
		$plugin = apply_filters( 'allston_eltdf_search_page_plugin_override', false );
		
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}
		
		$params = array(
			'type'          => $type,
			'query'         => $wp_query,
			'paged'         => $paged,
			'max_num_pages' => allston_eltdf_get_max_number_of_pages(),
		);
		
		$params = apply_filters( 'allston_eltdf_search_page_params', $params );
		
		allston_eltdf_get_module_template_part( $path . '/' . $type, $module, '', $params, $plugin );
	}
}

if ( ! function_exists( 'allston_eltdf_get_search_submit_icon_class' ) ) {
	/**
	 * Loads search submit icon class
	 */
	function allston_eltdf_get_search_submit_icon_class() {

		$search_icon_source	= allston_eltdf_options()->getOptionValue( 'search_icon_source' );

		$search_close_icon_class_array = array(
			'eltdf-search-submit'
		);

		$search_close_icon_class_array[] = $search_icon_source == 'icon_pack' ? 'eltdf-search-submit-icon-pack' : 'eltdf-search-submit-svg-path';

		return $search_close_icon_class_array;
	}
}

if ( ! function_exists( 'allston_eltdf_get_search_close_icon_class' ) ) {
	/**
	 * Loads search close icon class
	 */
	function allston_eltdf_get_search_close_icon_class() {

		$search_icon_source	= allston_eltdf_options()->getOptionValue( 'search_icon_source' );

		$search_close_icon_class_array = array(
			'eltdf-search-close'
		);

		$search_close_icon_class_array[] = $search_icon_source == 'icon_pack' ? 'eltdf-search-close-icon-pack' : 'eltdf-search-close-svg-path';

		return $search_close_icon_class_array;
	}
}

if ( ! function_exists( 'allston_eltdf_get_search_icon_html' ) ) {
	/**
	 * Loads search close icon HTML
	 */
	function allston_eltdf_get_search_icon_html() {

		$search_icon_source 			= allston_eltdf_options()->getOptionValue( 'search_icon_source' );
		$search_icon_pack 				= allston_eltdf_options()->getOptionValue( 'search_icon_pack' );
		$search_icon_svg_path 			= allston_eltdf_options()->getOptionValue( 'search_icon_svg_path' );

		$search_icon_html = '';

		if ( ( $search_icon_source == 'icon_pack' ) && isset( $search_icon_pack ) ) {
			$search_icon_html .= allston_eltdf_icon_collections()->getSearchIcon( $search_icon_pack, false );
		} else if ( isset( $search_icon_svg_path ) ) {
			$search_icon_html .= $search_icon_svg_path; 
		}

		return $search_icon_html;
	}
}

if ( ! function_exists( 'allston_eltdf_get_search_close_icon_html' ) ) {
	/**
	 * Loads search close icon HTML
	 */
	function allston_eltdf_get_search_close_icon_html() {

		$search_icon_source 			= allston_eltdf_options()->getOptionValue( 'search_icon_source' );
		$search_icon_pack 				= allston_eltdf_options()->getOptionValue( 'search_icon_pack' );
		$search_close_icon_svg_path 	= allston_eltdf_options()->getOptionValue( 'search_close_icon_svg_path' );

		$search_close_icon_html = '';

		if ( ( $search_icon_source == 'icon_pack' ) && isset( $search_icon_pack ) ) {
			$search_close_icon_html .= allston_eltdf_icon_collections()->getSearchClose( $search_icon_pack, false );
		} else if ( isset( $search_close_icon_svg_path ) ) {
			$search_close_icon_html .= $search_close_icon_svg_path; 
		}

		return $search_close_icon_html;
	}
}