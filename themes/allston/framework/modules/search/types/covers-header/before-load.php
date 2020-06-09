<?php

if ( ! function_exists( 'allston_eltdf_set_search_covers_header_global_option' ) ) {
    /**
     * This function set search type value for search options map
     */
    function allston_eltdf_set_search_covers_header_global_option( $search_type_options ) {
        $search_type_options['covers-header'] = esc_html__( 'Covers Header', 'allston' );

        return $search_type_options;
    }

    add_filter( 'allston_eltdf_search_type_global_option', 'allston_eltdf_set_search_covers_header_global_option' );
}