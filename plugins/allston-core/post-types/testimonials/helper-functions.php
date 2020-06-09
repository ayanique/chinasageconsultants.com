<?php

if ( ! function_exists( 'allston_core_testimonials_meta_box_functions' ) ) {
	function allston_core_testimonials_meta_box_functions( $post_types ) {
		$post_types[] = 'testimonials';
		
		return $post_types;
	}
	
	add_filter( 'allston_eltdf_meta_box_post_types_save', 'allston_core_testimonials_meta_box_functions' );
	add_filter( 'allston_eltdf_meta_box_post_types_remove', 'allston_core_testimonials_meta_box_functions' );
}

if ( ! function_exists( 'allston_core_register_testimonials_cpt' ) ) {
	function allston_core_register_testimonials_cpt( $cpt_class_name ) {
		$cpt_class = array(
			'AllstonCore\CPT\Testimonials\TestimonialsRegister'
		);
		
		$cpt_class_name = array_merge( $cpt_class_name, $cpt_class );
		
		return $cpt_class_name;
	}
	
	add_filter( 'allston_core_filter_register_custom_post_types', 'allston_core_register_testimonials_cpt' );
}

// Load testimonials shortcodes
if(!function_exists('allston_core_include_testimonials_shortcodes_files')) {
    /**
     * Loades all shortcodes by going through all folders that are placed directly in shortcodes folder
     */
    function allston_core_include_testimonials_shortcodes_files() {
        foreach(glob(ALLSTON_CORE_CPT_PATH.'/testimonials/shortcodes/*/load.php') as $shortcode_load) {
            include_once $shortcode_load;
        }
    }

    add_action('allston_core_action_include_shortcodes_file', 'allston_core_include_testimonials_shortcodes_files');
}