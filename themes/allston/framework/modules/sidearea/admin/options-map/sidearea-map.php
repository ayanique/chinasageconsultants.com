<?php

if (!function_exists('allston_eltdf_sidearea_options_map')) {
    function allston_eltdf_sidearea_options_map() {

        allston_eltdf_add_admin_page(
            array(
                'slug'  => '_side_area_page',
                'title' => esc_html__('Side Area', 'allston'),
                'icon'  => 'fa fa-indent'
            )
        );

        $side_area_panel = allston_eltdf_add_admin_panel(
            array(
                'title' => esc_html__('Side Area', 'allston'),
                'name'  => 'side_area',
                'page'  => '_side_area_page'
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent'        => $side_area_panel,
                'type'          => 'select',
                'name'          => 'side_area_type',
                'default_value' => 'side-menu-slide-from-right',
                'label'         => esc_html__('Side Area Type', 'allston'),
                'description'   => esc_html__('Choose a type of Side Area', 'allston'),
                'options'       => array(
                    'side-menu-slide-from-right'       => esc_html__('Slide from Right Over Content', 'allston'),
                    'side-menu-slide-with-content'     => esc_html__('Slide from Right With Content', 'allston'),
                    'side-area-uncovered-from-content' => esc_html__('Side Area Uncovered from Content', 'allston'),
                ),
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent'        => $side_area_panel,
                'type'          => 'text',
                'name'          => 'side_area_width',
                'default_value' => '',
                'label'         => esc_html__('Side Area Width', 'allston'),
                'description'   => esc_html__('Enter a width for Side Area (px or %). Default width: 405px.', 'allston'),
                'args'          => array(
                    'col_width' => 3,
                )
            )
        );

        $side_area_width_container = allston_eltdf_add_admin_container(
            array(
                'parent'     => $side_area_panel,
                'name'       => 'side_area_width_container',
                'dependency' => array(
                    'show' => array(
                        'side_area_type' => 'side-menu-slide-from-right',
                    )
                )
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent'        => $side_area_width_container,
                'type'          => 'color',
                'name'          => 'side_area_content_overlay_color',
                'default_value' => '',
                'label'         => esc_html__('Content Overlay Background Color', 'allston'),
                'description'   => esc_html__('Choose a background color for a content overlay', 'allston'),
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent'        => $side_area_width_container,
                'type'          => 'text',
                'name'          => 'side_area_content_overlay_opacity',
                'default_value' => '',
                'label'         => esc_html__('Content Overlay Background Transparency', 'allston'),
                'description'   => esc_html__('Choose a transparency for the content overlay background color (0 = fully transparent, 1 = opaque)', 'allston'),
                'args'          => array(
                    'col_width' => 3
                )
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent'        => $side_area_panel,
                'type'          => 'select',
                'name'          => 'side_area_icon_source',
                'default_value' => 'icon_pack',
                'label'         => esc_html__('Select Side Area Icon Source', 'allston'),
                'description'   => esc_html__('Choose whether you would like to use icons from an icon pack or SVG icons', 'allston'),
                'options'       => allston_eltdf_get_icon_sources_array()
            )
        );

        $side_area_icon_pack_container = allston_eltdf_add_admin_container(
            array(
                'parent'     => $side_area_panel,
                'name'       => 'side_area_icon_pack_container',
                'dependency' => array(
                    'show' => array(
                        'side_area_icon_source' => 'icon_pack'
                    )
                )
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent'        => $side_area_icon_pack_container,
                'type'          => 'select',
                'name'          => 'side_area_icon_pack',
                'default_value' => 'ion_icons',
                'label'         => esc_html__('Side Area Opener Icon Pack', 'allston'),
                'description'   => esc_html__('Choose icon pack for Side Area opener icon', 'allston'),
                'options'       => allston_eltdf_icon_collections()->getIconCollectionsExclude(array('linea_icons', 'dripicons', 'simple_line_icons'))
            )
        );
	
	    allston_eltdf_add_admin_field(
		    array(
			    'parent'        => $side_area_icon_pack_container,
			    'type'          => 'select',
			    'name'          => 'side_area_close_icon_pack',
			    'default_value' => 'linea_icons',
			    'label'         => esc_html__('Side Area Close Icon Pack', 'allston'),
			    'description'   => esc_html__('Choose icon pack for Side Area close icon', 'allston'),
			    'options'       => allston_eltdf_icon_collections()->getIconCollectionsExclude(array('dripicons', 'simple_line_icons'))
		    )
	    );

        $side_area_svg_icons_container = allston_eltdf_add_admin_container(
            array(
                'parent'     => $side_area_panel,
                'name'       => 'side_area_svg_icons_container',
                'dependency' => array(
                    'show' => array(
                        'side_area_icon_source' => 'svg_path'
                    )
                )
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent'      => $side_area_svg_icons_container,
                'type'        => 'textarea',
                'name'        => 'side_area_icon_svg_path',
                'label'       => esc_html__('Side Area Icon SVG Path', 'allston'),
                'description' => esc_html__('Enter your Side Area icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'allston'),
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent'      => $side_area_svg_icons_container,
                'type'        => 'textarea',
                'name'        => 'side_area_close_icon_svg_path',
                'label'       => esc_html__('Side Area Close Icon SVG Path', 'allston'),
                'description' => esc_html__('Enter your Side Area close icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'allston'),
            )
        );

        $side_area_icon_style_group = allston_eltdf_add_admin_group(
            array(
                'parent'      => $side_area_panel,
                'name'        => 'side_area_icon_style_group',
                'title'       => esc_html__('Side Area Icon Style', 'allston'),
                'description' => esc_html__('Define styles for Side Area icon', 'allston')
            )
        );

        $side_area_icon_style_row1 = allston_eltdf_add_admin_row(
            array(
                'parent' => $side_area_icon_style_group,
                'name'   => 'side_area_icon_style_row1'
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent' => $side_area_icon_style_row1,
                'type'   => 'colorsimple',
                'name'   => 'side_area_icon_color',
                'label'  => esc_html__('Color', 'allston')
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent' => $side_area_icon_style_row1,
                'type'   => 'colorsimple',
                'name'   => 'side_area_icon_hover_color',
                'label'  => esc_html__('Hover Color', 'allston')
            )
        );

        $side_area_icon_style_row2 = allston_eltdf_add_admin_row(
            array(
                'parent' => $side_area_icon_style_group,
                'name'   => 'side_area_icon_style_row2',
                'next'   => true
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent' => $side_area_icon_style_row2,
                'type'   => 'colorsimple',
                'name'   => 'side_area_close_icon_color',
                'label'  => esc_html__('Close Icon Color', 'allston')
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent' => $side_area_icon_style_row2,
                'type'   => 'colorsimple',
                'name'   => 'side_area_close_icon_hover_color',
                'label'  => esc_html__('Close Icon Hover Color', 'allston')
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent'      => $side_area_panel,
                'type'        => 'color',
                'name'        => 'side_area_background_color',
                'label'       => esc_html__('Background Color', 'allston'),
                'description' => esc_html__('Choose a background color for Side Area', 'allston')
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent'      => $side_area_panel,
                'type'        => 'text',
                'name'        => 'side_area_padding',
                'label'       => esc_html__('Padding', 'allston'),
                'description' => esc_html__('Define padding for Side Area in format top right bottom left', 'allston'),
                'args'        => array(
                    'col_width' => 3
                )
            )
        );

        allston_eltdf_add_admin_field(
            array(
                'parent'        => $side_area_panel,
                'type'          => 'selectblank',
                'name'          => 'side_area_aligment',
                'default_value' => '',
                'label'         => esc_html__('Text Alignment', 'allston'),
                'description'   => esc_html__('Choose text alignment for side area', 'allston'),
                'options'       => array(
                    ''       => esc_html__('Default', 'allston'),
                    'left'   => esc_html__('Left', 'allston'),
                    'center' => esc_html__('Center', 'allston'),
                    'right'  => esc_html__('Right', 'allston')
                )
            )
        );
    }

    add_action('allston_eltdf_options_map', 'allston_eltdf_sidearea_options_map', 11);
}