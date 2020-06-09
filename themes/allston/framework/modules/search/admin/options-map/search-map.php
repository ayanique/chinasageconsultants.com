<?php


if ( ! function_exists( 'allston_eltdf_search_options_map' ) ) {
	function allston_eltdf_search_options_map() {
		
		allston_eltdf_add_admin_page(
			array(
				'slug'  => '_search_page',
				'title' => esc_html__( 'Search', 'allston' ),
				'icon'  => 'fa fa-search'
			)
		);
		
		$search_page_panel = allston_eltdf_add_admin_panel(
			array(
				'title' => esc_html__( 'Search Page', 'allston' ),
				'name'  => 'search_template',
				'page'  => '_search_page'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'search_page_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Layout', 'allston' ),
				'default_value' => 'in-grid',
				'description'   => esc_html__( 'Set layout. Default is in grid.', 'allston' ),
				'parent'        => $search_page_panel,
				'options'       => array(
					'in-grid'    => esc_html__( 'In Grid', 'allston' ),
					'full-width' => esc_html__( 'Full Width', 'allston' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'search_page_sidebar_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Sidebar Layout', 'allston' ),
				'description'   => esc_html__( "Choose a sidebar layout for search page", 'allston' ),
				'default_value' => 'no-sidebar',
				'options'       => allston_eltdf_get_custom_sidebars_options(),
				'parent'        => $search_page_panel
			)
		);
		
		$allston_custom_sidebars = allston_eltdf_get_custom_sidebars();
		if ( count( $allston_custom_sidebars ) > 0 ) {
			allston_eltdf_add_admin_field(
				array(
					'name'        => 'search_custom_sidebar_area',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Sidebar to Display', 'allston' ),
					'description' => esc_html__( 'Choose a sidebar to display on search page. Default sidebar is "Sidebar"', 'allston' ),
					'parent'      => $search_page_panel,
					'options'     => $allston_custom_sidebars,
					'args'        => array(
						'select2' => true
					)
				)
			);
		}
		
		$search_panel = allston_eltdf_add_admin_panel(
			array(
				'title' => esc_html__( 'Search', 'allston' ),
				'name'  => 'search',
				'page'  => '_search_page'
			)
		);
		

		allston_eltdf_add_admin_field(
			array(
				'parent'        => $search_panel,
				'type'          => 'select',
				'name'          => 'search_icon_source',
				'default_value' => 'icon_pack',
				'label'         => esc_html__( 'Select Search Icon Source', 'allston' ),
				'description'   => esc_html__( 'Choose whether you would like to use icons from an icon pack or SVG icons', 'allston' ),
				'options'       => allston_eltdf_get_icon_sources_array()
			)
		);

		$search_icon_pack_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $search_panel,
				'name'            => 'search_icon_pack_container',
				'dependency' => array(
					'show' => array(
						'search_icon_source' => 'icon_pack'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $search_icon_pack_container,
				'type'          => 'select',
				'name'          => 'search_icon_pack',
				'default_value' => 'ion_icons',
				'label'         => esc_html__( 'Search Icon Pack', 'allston' ),
				'description'   => esc_html__( 'Choose icon pack for search icon', 'allston' ),
				'options'       => allston_eltdf_icon_collections()->getIconCollectionsExclude( array( 'linea_icons', 'dripicons', 'simple_line_icons' ) )
			)
		);

		$search_svg_path_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $search_panel,
				'name'            => 'search_icon_svg_path_container',
				'dependency' => array(
					'show' => array(
						'search_icon_source' => 'svg_path'
					)
				)
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'parent'      => $search_svg_path_container,
				'type'        => 'textarea',
				'name'        => 'search_icon_svg_path',
				'label'       => esc_html__( 'Search Icon SVG Path', 'allston' ),
				'description' => esc_html__( 'Enter your search icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'allston' ),
			)
		);

		allston_eltdf_add_admin_field(
			array(
				'parent'      => $search_svg_path_container,
				'type'        => 'textarea',
				'name'        => 'search_close_icon_svg_path',
				'label'       => esc_html__( 'Search Close Icon SVG Path', 'allston' ),
				'description' => esc_html__( 'Enter your search close icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'allston' ),
			)
		);

        allston_eltdf_add_admin_field(
            array(
                'type'          => 'select',
                'name'          => 'search_sidebar_columns',
                'parent'        => $search_panel,
                'default_value' => '3',
                'label'         => esc_html__( 'Search Sidebar Columns', 'allston' ),
                'description'   => esc_html__( 'Choose number of columns for FullScreen search sidebar area', 'allston' ),
                'options'       => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                )
            )
        );
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $search_panel,
				'type'          => 'yesno',
				'name'          => 'search_in_grid',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Grid Layout', 'allston' ),
				'description'   => esc_html__( 'Set search area to be in grid.', 'allston' ),
			)
		);
		
		allston_eltdf_add_admin_section_title(
			array(
				'parent' => $search_panel,
				'name'   => 'initial_header_icon_title',
				'title'  => esc_html__( 'Initial Search Icon in Header', 'allston' )
			)
		);

		$search_icon_pack_icon_styles_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $search_panel,
				'name'            => 'search_icon_pack_icon_styles_container',
				'dependency' => array(
					'show' => array(
						'search_icon_source' => 'icon_pack'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $search_icon_pack_icon_styles_container,
				'type'          => 'text',
				'name'          => 'header_search_icon_size',
				'default_value' => '',
				'label'         => esc_html__( 'Icon Size', 'allston' ),
				'description'   => esc_html__( 'Set size for icon', 'allston' ),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		$search_icon_color_group = allston_eltdf_add_admin_group(
			array(
				'parent'      => $search_panel,
				'title'       => esc_html__( 'Icon Colors', 'allston' ),
				'description' => esc_html__( 'Define color style for icon', 'allston' ),
				'name'        => 'search_icon_color_group'
			)
		);
		
		$search_icon_color_row = allston_eltdf_add_admin_row(
			array(
				'parent' => $search_icon_color_group,
				'name'   => 'search_icon_color_row'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent' => $search_icon_color_row,
				'type'   => 'colorsimple',
				'name'   => 'header_search_icon_color',
				'label'  => esc_html__( 'Color', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent' => $search_icon_color_row,
				'type'   => 'colorsimple',
				'name'   => 'header_search_icon_hover_color',
				'label'  => esc_html__( 'Hover Color', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $search_panel,
				'type'          => 'yesno',
				'name'          => 'enable_search_icon_text',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Search Icon Text', 'allston' ),
				'description'   => esc_html__( "Enable this option to show 'Search' text next to search icon in header", 'allston' )
			)
		);
		
		$enable_search_icon_text_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $search_panel,
				'name'            => 'enable_search_icon_text_container',
				'dependency' => array(
					'show' => array(
						'enable_search_icon_text' => 'yes'
					)
				)
			)
		);
		
		$enable_search_icon_text_group = allston_eltdf_add_admin_group(
			array(
				'parent'      => $enable_search_icon_text_container,
				'title'       => esc_html__( 'Search Icon Text', 'allston' ),
				'name'        => 'enable_search_icon_text_group',
				'description' => esc_html__( 'Define style for search icon text', 'allston' )
			)
		);
		
		$enable_search_icon_text_row = allston_eltdf_add_admin_row(
			array(
				'parent' => $enable_search_icon_text_group,
				'name'   => 'enable_search_icon_text_row'
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent' => $enable_search_icon_text_row,
				'type'   => 'colorsimple',
				'name'   => 'search_icon_text_color',
				'label'  => esc_html__( 'Text Color', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent' => $enable_search_icon_text_row,
				'type'   => 'colorsimple',
				'name'   => 'search_icon_text_color_hover',
				'label'  => esc_html__( 'Text Hover Color', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $enable_search_icon_text_row,
				'type'          => 'textsimple',
				'name'          => 'search_icon_text_font_size',
				'label'         => esc_html__( 'Font Size', 'allston' ),
				'default_value' => '',
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $enable_search_icon_text_row,
				'type'          => 'textsimple',
				'name'          => 'search_icon_text_line_height',
				'label'         => esc_html__( 'Line Height', 'allston' ),
				'default_value' => '',
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
		
		$enable_search_icon_text_row2 = allston_eltdf_add_admin_row(
			array(
				'parent' => $enable_search_icon_text_group,
				'name'   => 'enable_search_icon_text_row2',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $enable_search_icon_text_row2,
				'type'          => 'selectblanksimple',
				'name'          => 'search_icon_text_text_transform',
				'label'         => esc_html__( 'Text Transform', 'allston' ),
				'default_value' => '',
				'options'       => allston_eltdf_get_text_transform_array()
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $enable_search_icon_text_row2,
				'type'          => 'fontsimple',
				'name'          => 'search_icon_text_google_fonts',
				'label'         => esc_html__( 'Font Family', 'allston' ),
				'default_value' => '-1',
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $enable_search_icon_text_row2,
				'type'          => 'selectblanksimple',
				'name'          => 'search_icon_text_font_style',
				'label'         => esc_html__( 'Font Style', 'allston' ),
				'default_value' => '',
				'options'       => allston_eltdf_get_font_style_array(),
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $enable_search_icon_text_row2,
				'type'          => 'selectblanksimple',
				'name'          => 'search_icon_text_font_weight',
				'label'         => esc_html__( 'Font Weight', 'allston' ),
				'default_value' => '',
				'options'       => allston_eltdf_get_font_weight_array(),
			)
		);
		
		$enable_search_icon_text_row3 = allston_eltdf_add_admin_row(
			array(
				'parent' => $enable_search_icon_text_group,
				'name'   => 'enable_search_icon_text_row3',
				'next'   => true
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'parent'        => $enable_search_icon_text_row3,
				'type'          => 'textsimple',
				'name'          => 'search_icon_text_letter_spacing',
				'label'         => esc_html__( 'Letter Spacing', 'allston' ),
				'default_value' => '',
				'args'          => array(
					'suffix' => 'px'
				)
			)
		);
	}
	
	add_action( 'allston_eltdf_options_map', 'allston_eltdf_search_options_map', 10 );
}