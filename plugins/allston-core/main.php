<?php
/*
Plugin Name: Allston Core
Description: Plugin that adds all post types needed by our theme
Author: Elated Themes
Version: 1.2
*/

require_once 'load.php';

add_action('after_setup_theme', array(AllstonCore\CPT\PostTypesRegister::getInstance(), 'register'));
add_action( 'add_meta_boxes', 'allston_eltdf_meta_box_add_global' );

if (!function_exists('allston_core_activation')) {
    /**
     * Triggers when plugin is activated. It calls flush_rewrite_rules
     * and defines allston_eltdf_core_on_activate action
     */
    function allston_core_activation() {
        do_action('allston_eltdf_core_on_activate');

        AllstonCore\CPT\PostTypesRegister::getInstance()->register();
        flush_rewrite_rules();
    }

    register_activation_hook(__FILE__, 'allston_core_activation');
}

if (!function_exists('allston_core_text_domain')) {
    /**
     * Loads plugin text domain so it can be used in translation
     */
    function allston_core_text_domain() {
        load_plugin_textdomain('allston-core', false, ALLSTON_CORE_REL_PATH . '/languages');
    }

    add_action('plugins_loaded', 'allston_core_text_domain');
}

if (!function_exists('allston_core_version_class')) {
    /**
     * Adds plugins version class to body
     *
     * @param $classes
     *
     * @return array
     */
    function allston_core_version_class($classes) {
        $classes[] = 'allston-core-' . ALLSTON_CORE_VERSION;

        return $classes;
    }

    add_filter('body_class', 'allston_core_version_class');
}

if (!function_exists('allston_core_theme_installed')) {
    /**
     * Checks whether theme is installed or not
     * @return bool
     */
    function allston_core_theme_installed() {
        return defined('ELATED_ROOT');
    }
}

if (!function_exists('allston_core_is_woocommerce_installed')) {
    /**
     * Function that checks if woocommerce is installed
     * @return bool
     */
    function allston_core_is_woocommerce_installed() {
        return function_exists('is_woocommerce');
    }
}

if (!function_exists('allston_core_is_woocommerce_integration_installed')) {
    //is Elated Woocommerce Integration installed?
    function allston_core_is_woocommerce_integration_installed() {
        return defined('ALLSTON_CHECKOUT_INTEGRATION');
    }
}

if (!function_exists('allston_core_is_revolution_slider_installed')) {
    function allston_core_is_revolution_slider_installed() {
        return class_exists('RevSliderFront');
    }
}

if (!function_exists('allston_core_is_wpml_installed')) {
    /**
     * Function that checks if WPML plugin is installed
     * @return bool
     *
     * @version 0.1
     */
    function allston_core_is_wpml_installed() {
        return defined('ICL_SITEPRESS_VERSION');
    }
}

if (!function_exists('allston_core_theme_menu')) {
    /**
     * Function that generates admin menu for options page.
     * It generates one admin page per options page.
     */
    function allston_core_theme_menu() {
        if (allston_core_theme_installed()) {

            global $allston_eltdf_Framework;
            allston_eltdf_init_theme_options();

            $page_hook_suffix = add_menu_page(
                esc_html__('Allston Options', 'allston-core'), // The value used to populate the browser's title bar when the menu page is active
                esc_html__('Allston Options', 'allston-core'), // The text of the menu in the administrator's sidebar
                'administrator',                            // What roles are able to access the menu
                ELATED_OPTIONS_SLUG,            // The ID used to bind submenu items to this menu
                array($allston_eltdf_Framework->getSkin(), 'renderOptions'), // The callback function used to render this menu
                $allston_eltdf_Framework->getSkin()->getSkinURI() . '/assets/img/admin-logo-icon.png', // Icon For menu Item
                100                                                                                            // Position
            );

            foreach ($allston_eltdf_Framework->eltdfOptions->adminPages as $key => $value) {
                $slug = "";

                if (!empty($value->slug)) {
                    $slug = "_tab" . $value->slug;
                }

                $subpage_hook_suffix = add_submenu_page(
                    ELATED_OPTIONS_SLUG,
                    esc_html__('Allston Options - ', 'allston-core') . $value->title, // The value used to populate the browser's title bar when the menu page is active
                    $value->title,                                                 // The text of the menu in the administrator's sidebar
                    'administrator',                                               // What roles are able to access the menu
                    ELATED_OPTIONS_SLUG . $slug,                       // The ID used to bind submenu items to this menu
                    array($allston_eltdf_Framework->getSkin(), 'renderOptions')
                );

                add_action('admin_print_scripts-' . $subpage_hook_suffix, 'allston_eltdf_enqueue_admin_scripts');
                add_action('admin_print_styles-' . $subpage_hook_suffix, 'allston_eltdf_enqueue_admin_styles');
            };

            add_action('admin_print_scripts-' . $page_hook_suffix, 'allston_eltdf_enqueue_admin_scripts');
            add_action('admin_print_styles-' . $page_hook_suffix, 'allston_eltdf_enqueue_admin_styles');
        }
    }

    add_action('admin_menu', 'allston_core_theme_menu');
}

if (!function_exists('allston_core_theme_menu_backup_options')) {
    /**
     * Function that generates admin menu for options page.
     * It generates one admin page per options page.
     */
    function allston_core_theme_menu_backup_options() {
        if (allston_core_theme_installed()) {
            global $allston_eltdf_Framework;

            $slug = "_backup_options";
            $page_hook_suffix = add_submenu_page(
                ELATED_OPTIONS_SLUG,
                esc_html__('Allston Options - Backup Options', 'allston-core'), // The value used to populate the browser's title bar when the menu page is active
                esc_html__('Backup Options', 'allston-core'),                // The text of the menu in the administrator's sidebar
                'administrator',                                             // What roles are able to access the menu
                ELATED_OPTIONS_SLUG . $slug,                     // The ID used to bind submenu items to this menu
                array($allston_eltdf_Framework->getSkin(), 'renderBackupOptions')
            );

            add_action('admin_print_scripts-' . $page_hook_suffix, 'allston_eltdf_enqueue_admin_scripts');
            add_action('admin_print_styles-' . $page_hook_suffix, 'allston_eltdf_enqueue_admin_styles');
        }
    }

    add_action('admin_menu', 'allston_core_theme_menu_backup_options');
}

if (!function_exists('allston_core_theme_admin_bar_menu_options')) {
    /**
     * Add a link to the WP Toolbar
     */
    function allston_core_theme_admin_bar_menu_options($wp_admin_bar) {
        global $allston_eltdf_Framework;

        $args = array(
            'id'    => 'allston-admin-bar-options',
            'title' => sprintf('<span class="ab-icon dashicons-before dashicons-admin-generic"></span> %s', esc_html__('Allston Options', 'allston-core')),
            'href'  => esc_url(admin_url('admin.php?page=' . ELATED_OPTIONS_SLUG))
        );

        $wp_admin_bar->add_node($args);

        foreach ($allston_eltdf_Framework->eltdfOptions->adminPages as $key => $value) {
            $suffix = !empty($value->slug) ? '_tab' . $value->slug : '';

            $args = array(
                'id'     => 'allston-admin-bar-options-' . $suffix,
                'title'  => $value->title,
                'parent' => 'allston-admin-bar-options',
                'href'   => esc_url(admin_url('admin.php?page=' . ELATED_OPTIONS_SLUG . $suffix))
            );

            $wp_admin_bar->add_node($args);
        };
    }

    add_action('admin_bar_menu', 'allston_core_theme_admin_bar_menu_options', 999);
}

if (!function_exists('allston_core_meta_box_add_handler')) {

	function allston_core_meta_box_add_handler( $box, $key ) {
		$hidden = false;
		if ( ! empty( $box->hidden_property ) ) {
			foreach ( $box->hidden_values as $value ) {
				if ( allston_eltdf_option_get_value( $box->hidden_property ) == $value ) {
					$hidden = true;
				}
			}
		}
		
		if ( is_string( $box->scope ) ) {
			$box->scope = array( $box->scope );
		}
		
		if ( is_array( $box->scope ) && count( $box->scope ) ) {
			foreach ( $box->scope as $screen ) {
				add_meta_box(
					'eltdf-meta-box-' . $key,
					$box->title,
					'allston_eltdf_render_meta_box',
					$screen,
					'advanced',
					'high',
					array( 'box' => $box )
				);
				
				if ( $hidden ) {
					add_filter( 'postbox_classes_' . $screen . '_eltdf-meta-box-' . $key, 'allston_eltdf_meta_box_add_hidden_class' );
				}
			}
		}
	}
}