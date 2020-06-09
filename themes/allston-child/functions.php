<?php

/*** Child Theme Function  ***/
if ( ! function_exists( 'allston_eltdf_child_theme_enqueue_scripts' ) ) {
	function allston_eltdf_child_theme_enqueue_scripts()
	{

		$parent_style = 'allston-eltdf-default-style';

		wp_enqueue_style('allston-eltdf-style', get_stylesheet_directory_uri() . '/style.css', array($parent_style));
	}

	add_action('wp_enqueue_scripts', 'allston_eltdf_child_theme_enqueue_scripts');
}