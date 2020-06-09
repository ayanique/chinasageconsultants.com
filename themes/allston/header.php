<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php
	/**
	 * allston_eltdf_header_meta hook
	 *
	 * @see allston_eltdf_header_meta() - hooked with 10
	 * @see allston_eltdf_user_scalable_meta - hooked with 10
	 * @see allston_core_set_open_graph_meta - hooked with 10
	 */
	do_action( 'allston_eltdf_header_meta' );
	
	wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
	<?php
	/**
	 * allston_eltdf_after_body_tag hook
	 *
	 * @see allston_eltdf_get_side_area() - hooked with 10
	 * @see allston_eltdf_smooth_page_transitions() - hooked with 10
	 */
	do_action( 'allston_eltdf_after_body_tag' ); ?>

    <div class="eltdf-wrapper">
        <div class="eltdf-wrapper-inner">
            <?php
            /**
             * allston_eltdf_after_wrapper_inner hook
             *
             * @see allston_eltdf_get_header() - hooked with 10
             * @see allston_eltdf_get_mobile_header() - hooked with 20
             * @see allston_eltdf_back_to_top_button() - hooked with 30
             * @see allston_eltdf_get_header_minimal_full_screen_menu() - hooked with 40
             * @see allston_eltdf_get_header_bottom_navigation() - hooked with 40
             */
            do_action( 'allston_eltdf_after_wrapper_inner' ); ?>
	        
            <div class="eltdf-content" <?php allston_eltdf_content_elem_style_attr(); ?>>
                <div class="eltdf-content-inner">