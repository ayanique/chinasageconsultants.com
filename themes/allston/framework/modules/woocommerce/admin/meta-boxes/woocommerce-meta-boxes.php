<?php

if ( ! function_exists( 'allston_eltdf_map_woocommerce_meta' ) ) {
	function allston_eltdf_map_woocommerce_meta() {
		
		$woocommerce_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => array( 'product' ),
				'title' => esc_html__( 'Product Meta', 'allston' ),
				'name'  => 'woo_product_meta'
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_product_featured_image_size',
				'type'        => 'select',
				'label'       => esc_html__( 'Dimensions for Product List Shortcode', 'allston' ),
				'description' => esc_html__( 'Choose image layout when it appears in Elated Product List - Masonry layout shortcode', 'allston' ),
				'options'     => array(
					''                   => esc_html__( 'Default', 'allston' ),
					'small'              => esc_html__( 'Small', 'allston' ),
					'large-width'        => esc_html__( 'Large Width', 'allston' ),
					'large-height'       => esc_html__( 'Large Height', 'allston' ),
					'large-width-height' => esc_html__( 'Large Width Height', 'allston' )
				),
				'parent'      => $woocommerce_meta_box
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_show_title_area_woo_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'allston' ),
				'description'   => esc_html__( 'Disabling this option will turn off page title area', 'allston' ),
				'options'       => allston_eltdf_get_yes_no_select_array(),
				'parent'        => $woocommerce_meta_box
			)
		);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_show_new_sign_woo_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Show New Sign', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will show new sign mark on product', 'allston' ),
				'parent'        => $woocommerce_meta_box
			)
		);
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_woocommerce_meta', 99 );
}