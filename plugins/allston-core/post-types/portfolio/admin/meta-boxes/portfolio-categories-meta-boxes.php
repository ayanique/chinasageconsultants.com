<?php

if ( ! function_exists( 'allston_eltdf_portfolio_category_additional_fields' ) ) {
	function allston_eltdf_portfolio_category_additional_fields() {
		
		$fields = allston_eltdf_add_taxonomy_fields(
			array(
				'scope' => 'portfolio-category',
				'name'  => 'portfolio_category_options'
			)
		);
		
		allston_eltdf_add_taxonomy_field(
			array(
				'name'   => 'eltdf_portfolio_category_image_meta',
				'type'   => 'image',
				'label'  => esc_html__( 'Category Image', 'allston-core' ),
				'parent' => $fields
			)
		);
	}
	
	add_action( 'allston_eltdf_custom_taxonomy_fields', 'allston_eltdf_portfolio_category_additional_fields' );
}