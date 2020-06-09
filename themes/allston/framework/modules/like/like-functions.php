<?php

if ( ! function_exists( 'allston_eltdf_like' ) ) {
	/**
	 * Returns AllstonEltdfLike instance
	 *
	 * @return AllstonEltdfLike
	 */
	function allston_eltdf_like() {
		return AllstonEltdfLike::get_instance();
	}
}

function allston_eltdf_get_like() {
	
	echo wp_kses( allston_eltdf_like()->add_like(), array(
		'span' => array(
			'class'       => true,
			'aria-hidden' => true,
			'style'       => true,
			'id'          => true
		),
		'i'    => array(
			'class' => true,
			'style' => true,
			'id'    => true
		),
		'a'    => array(
			'href'  => true,
			'class' => true,
			'id'    => true,
			'title' => true,
			'style' => true
		)
	) );
}