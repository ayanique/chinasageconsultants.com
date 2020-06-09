<?php

if (!function_exists('allston_eltdf_side_area_slide_from_right_type_style')) {

    function allston_eltdf_side_area_slide_from_right_type_style() {

        if (allston_eltdf_options()->getOptionValue('side_area_type') == 'side-menu-slide-from-right') {

            if (allston_eltdf_options()->getOptionValue('side_area_width') !== '') {
                echo allston_eltdf_dynamic_css('.eltdf-side-menu-slide-from-right .eltdf-side-menu', array(
                    'right' => '-' . allston_eltdf_options()->getOptionValue('side_area_width'),
                    'width' => allston_eltdf_options()->getOptionValue('side_area_width')
                ));
            }

            if (allston_eltdf_options()->getOptionValue('side_area_content_overlay_color') !== '') {

                echo allston_eltdf_dynamic_css('.eltdf-side-menu-slide-from-right .eltdf-wrapper .eltdf-cover', array(
                    'background-color' => allston_eltdf_options()->getOptionValue('side_area_content_overlay_color')
                ));

            }

            if (allston_eltdf_options()->getOptionValue('side_area_content_overlay_opacity') !== '') {

                echo allston_eltdf_dynamic_css('.eltdf-side-menu-slide-from-right.eltdf-right-side-menu-opened .eltdf-wrapper .eltdf-cover', array(
                    'opacity' => allston_eltdf_options()->getOptionValue('side_area_content_overlay_opacity')
                ));

            }
        }

    }

    add_action('allston_eltdf_style_dynamic', 'allston_eltdf_side_area_slide_from_right_type_style');

}

if (!function_exists('allston_eltdf_side_area_slide_with_content_type_style')) {

    function allston_eltdf_side_area_slide_with_content_type_style() {

        if (allston_eltdf_options()->getOptionValue('side_area_type') == 'side-menu-slide-with-content') {

            if (allston_eltdf_options()->getOptionValue('side_area_width') !== '') {
                echo allston_eltdf_dynamic_css('.eltdf-side-menu-slide-with-content .eltdf-side-menu', array(
                    'right' => '-' . allston_eltdf_options()->getOptionValue('side_area_width'),
                    'width' => allston_eltdf_options()->getOptionValue('side_area_width')
                ));

                $side_menu_open_classes = array(
                    '.eltdf-side-menu-slide-with-content.eltdf-side-menu-open .eltdf-wrapper',
                    '.eltdf-side-menu-slide-with-content.eltdf-side-menu-open footer.uncover',
                    '.eltdf-side-menu-slide-with-content.eltdf-side-menu-open .eltdf-sticky-header',
                    '.eltdf-side-menu-slide-with-content.eltdf-side-menu-open .eltdf-fixed-wrapper',
                    '.eltdf-side-menu-slide-with-content.eltdf-side-menu-open .eltdf-mobile-header-inner',
                );

                echo allston_eltdf_dynamic_css($side_menu_open_classes, array(
                    'left' => '-' . allston_eltdf_options()->getOptionValue('side_area_width'),
                ));
            }

        }

    }

    add_action('allston_eltdf_style_dynamic', 'allston_eltdf_side_area_slide_with_content_type_style');

}

if (!function_exists('allston_eltdf_side_area_uncovered_from_content_type_style')) {

    function allston_eltdf_side_area_uncovered_from_content_type_style() {

        if (allston_eltdf_options()->getOptionValue('side_area_type') == 'side-area-uncovered-from-content') {

            if (allston_eltdf_options()->getOptionValue('side_area_width') !== '') {
                echo allston_eltdf_dynamic_css('.eltdf-side-area-uncovered-from-content .eltdf-side-menu', array(
                    'width' => allston_eltdf_options()->getOptionValue('side_area_width')
                ));

                $side_menu_open_classes = array(
                    '.eltdf-side-area-uncovered-from-content.eltdf-right-side-menu-opened .eltdf-wrapper',
                    '.eltdf-side-area-uncovered-from-content.eltdf-right-side-menu-opened footer.uncover',
                    '.eltdf-side-area-uncovered-from-content.eltdf-right-side-menu-opened .eltdf-sticky-header',
                    '.eltdf-side-area-uncovered-from-content.eltdf-right-side-menu-opened .eltdf-fixed-wrapper.fixed',
                    '.eltdf-side-area-uncovered-from-content.eltdf-right-side-menu-opened .eltdf-mobile-header-inner',
                    '.eltdf-side-area-uncovered-from-content.eltdf-right-side-menu-opened .mobile-header-appear .eltdf-mobile-header-inner',
                );

                echo allston_eltdf_dynamic_css($side_menu_open_classes, array(
                    'left' => '-' . allston_eltdf_options()->getOptionValue('side_area_width'),
                ));
            }

        }

    }

    add_action('allston_eltdf_style_dynamic', 'allston_eltdf_side_area_uncovered_from_content_type_style');

}

if (!function_exists('allston_eltdf_side_area_icon_color_styles')) {
    function allston_eltdf_side_area_icon_color_styles() {
        $icon_color = allston_eltdf_options()->getOptionValue('side_area_icon_color');
        $icon_hover_color = allston_eltdf_options()->getOptionValue('side_area_icon_hover_color');
        $close_icon_color = allston_eltdf_options()->getOptionValue('side_area_close_icon_color');
        $close_icon_hover_color = allston_eltdf_options()->getOptionValue('side_area_close_icon_hover_color');

        $icon_hover_selector = array(
            '.eltdf-side-menu-button-opener:hover',
            '.eltdf-side-menu-button-opener.opened'
        );

        if (!empty($icon_color)) {
            echo allston_eltdf_dynamic_css('.eltdf-side-menu-button-opener', array(
                'color' => $icon_color
            ));
        }

        if (!empty($icon_hover_color)) {
            echo allston_eltdf_dynamic_css($icon_hover_selector, array(
                'color' => $icon_hover_color
            ));
        }

        if (!empty($close_icon_color)) {
            echo allston_eltdf_dynamic_css('.eltdf-side-menu a.eltdf-close-side-menu', array(
                'color' => $close_icon_color
            ));
        }

        if (!empty($close_icon_hover_color)) {
            echo allston_eltdf_dynamic_css('.eltdf-side-menu a.eltdf-close-side-menu:hover', array(
                'color' => $close_icon_hover_color
            ));
        }
    }

    add_action('allston_eltdf_style_dynamic', 'allston_eltdf_side_area_icon_color_styles');
}

if (!function_exists('allston_eltdf_side_area_styles')) {
    function allston_eltdf_side_area_styles() {
        $side_area_styles = array();
        $background_color = allston_eltdf_options()->getOptionValue('side_area_background_color');
        $padding = allston_eltdf_options()->getOptionValue('side_area_padding');
        $text_alignment = allston_eltdf_options()->getOptionValue('side_area_aligment');

        if (!empty($background_color)) {
            $side_area_styles['background-color'] = $background_color;
        }

        if (!empty($padding)) {
            $side_area_styles['padding'] = esc_attr($padding);
        }

        if (!empty($text_alignment)) {
            $side_area_styles['text-align'] = $text_alignment;
        }

        if (!empty($side_area_styles)) {
            echo allston_eltdf_dynamic_css('.eltdf-side-menu', $side_area_styles);
        }

        if ($text_alignment === 'center') {
            echo allston_eltdf_dynamic_css('.eltdf-side-menu .widget img', array(
                'margin' => '0 auto'
            ));
        }
    }

    add_action('allston_eltdf_style_dynamic', 'allston_eltdf_side_area_styles');
}