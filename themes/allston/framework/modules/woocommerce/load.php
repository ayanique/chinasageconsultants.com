<?php
include_once ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/woocommerce/woocommerce-functions.php';

if ( allston_eltdf_is_woocommerce_installed() ) {
	include_once ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/woocommerce/admin/options-map/woocommerce-map.php';
	include_once ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/woocommerce/admin/meta-boxes/woocommerce-meta-boxes.php';
	include_once ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/woocommerce/woocommerce-template-hooks.php';
	include_once ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/woocommerce/woocommerce-config.php';
	

    foreach ( glob( ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/woocommerce/widgets/*/load.php' ) as $widget_load ) {
        include_once $widget_load;
    }
	
	foreach ( glob( ELATED_FRAMEWORK_MODULES_ROOT_DIR . '/woocommerce/plugins/*/load.php' ) as $plugin_load ) {
		include_once $plugin_load;
	}
}