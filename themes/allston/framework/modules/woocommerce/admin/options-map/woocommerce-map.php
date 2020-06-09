<?php

if ( ! function_exists( 'allston_eltdf_woocommerce_options_map' ) ) {
	
	/**
	 * Add Woocommerce options page
	 */
	function allston_eltdf_woocommerce_options_map() {
		
		allston_eltdf_add_admin_page(
			array(
				'slug'  => '_woocommerce_page',
				'title' => esc_html__( 'Woocommerce', 'allston' ),
				'icon'  => 'fa fa-shopping-cart'
			)
		);
		
		/**
		 * Product List Settings
		 */
		$panel_product_list = allston_eltdf_add_admin_panel(
			array(
				'page'  => '_woocommerce_page',
				'name'  => 'panel_product_list',
				'title' => esc_html__( 'Product List', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'eltdf_woo_product_list_columns',
				'label'         => esc_html__( 'Product List Columns', 'allston' ),
				'default_value' => 'eltdf-woocommerce-columns-4',
				'description'   => esc_html__( 'Choose number of columns for main shop page', 'allston' ),
				'options'       => array(
					'eltdf-woocommerce-columns-3' => esc_html__( '3 Columns', 'allston' ),
					'eltdf-woocommerce-columns-4' => esc_html__( '4 Columns', 'allston' )
				),
				'parent'        => $panel_product_list,
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'eltdf_woo_product_list_columns_space',
				'label'         => esc_html__( 'Space Between Items', 'allston' ),
				'description'   => esc_html__( 'Select space between items for product listing and related products on single product', 'allston' ),
				'default_value' => 'normal',
				'options'       => allston_eltdf_get_space_between_items_array(),
				'parent'        => $panel_product_list,
			)
		);
		
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'text',
				'name'          => 'eltdf_woo_products_per_page',
				'label'         => esc_html__( 'Number of products per page', 'allston' ),
				'description'   => esc_html__( 'Set number of products on shop page', 'allston' ),
				'parent'        => $panel_product_list,
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'eltdf_products_list_title_tag',
				'label'         => esc_html__( 'Products Title Tag', 'allston' ),
				'default_value' => 'h4',
				'options'       => allston_eltdf_get_title_tag(),
				'parent'        => $panel_product_list,
			)
		);
		
		/**
		 * Single Product Settings
		 */
		$panel_single_product = allston_eltdf_add_admin_panel(
			array(
				'page'  => '_woocommerce_page',
				'name'  => 'panel_single_product',
				'title' => esc_html__( 'Single Product', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'show_title_area_woo',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show title area on single post pages', 'allston' ),
				'parent'        => $panel_single_product,
				'options'       => allston_eltdf_get_yes_no_select_array(),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'eltdf_single_product_title_tag',
				'default_value' => 'h1',
				'label'         => esc_html__( 'Single Product Title Tag', 'allston' ),
				'options'       => allston_eltdf_get_title_tag(),
				'parent'        => $panel_single_product,
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'woo_number_of_thumb_images',
				'default_value' => '4',
				'label'         => esc_html__( 'Number of Thumbnail Images per Row', 'allston' ),
				'options'       => array(
					'4' => esc_html__( 'Four', 'allston' ),
					'3' => esc_html__( 'Three', 'allston' ),
					'2' => esc_html__( 'Two', 'allston' )
				),
				'parent'        => $panel_single_product
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'woo_set_thumb_images_position',
				'default_value' => 'below-image',
				'label'         => esc_html__( 'Set Thumbnail Images Position', 'allston' ),
				'options'       => array(
					'below-image'  => esc_html__( 'Below Featured Image', 'allston' ),
					'on-left-side' => esc_html__( 'On The Left Side Of Featured Image', 'allston' )
				),
				'parent'        => $panel_single_product
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'woo_enable_single_product_zoom_image',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Zoom Maginfier', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show magnifier image on featured image hover', 'allston' ),
				'parent'        => $panel_single_product,
				'options'       => allston_eltdf_get_yes_no_select_array( false ),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'woo_set_single_images_behavior',
				'default_value' => 'pretty-photo',
				'label'         => esc_html__( 'Set Images Behavior', 'allston' ),
				'options'       => array(
					'pretty-photo' => esc_html__( 'Pretty Photo Lightbox', 'allston' ),
					'photo-swipe'  => esc_html__( 'Photo Swipe Lightbox', 'allston' )
				),
				'parent'        => $panel_single_product
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'eltdf_woo_related_products_columns',
				'label'         => esc_html__( 'Related Products Columns', 'allston' ),
				'default_value' => 'eltdf-woocommerce-columns-4',
				'description'   => esc_html__( 'Choose number of columns for related products on single product page', 'allston' ),
				'options'       => array(
					'eltdf-woocommerce-columns-3' => esc_html__( '3 Columns', 'allston' ),
					'eltdf-woocommerce-columns-4' => esc_html__( '4 Columns', 'allston' )
				),
				'parent'        => $panel_single_product,
			)
		);

		do_action('allston_eltdf_woocommerce_additional_options_map');
	}
	
	add_action( 'allston_eltdf_options_map', 'allston_eltdf_woocommerce_options_map', 21 );
}