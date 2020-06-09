<?php

if ( ! function_exists( 'allston_eltdf_content_responsive_styles' ) ) {
	/**
	 * Generates content responsive custom styles
	 */
	function allston_eltdf_content_responsive_styles() {
		$content_style = array();
		
		$padding_mobile = allston_eltdf_options()->getOptionValue( 'content_padding_mobile' );
		if ( $padding_mobile !== '' ) {
			$content_style['padding'] = $padding_mobile;
		}
		
		$content_selector = array(
			'.eltdf-content .eltdf-content-inner > .eltdf-container > .eltdf-container-inner',
			'.eltdf-content .eltdf-content-inner > .eltdf-full-width > .eltdf-full-width-inner',
		);
		
		echo allston_eltdf_dynamic_css( $content_selector, $content_style );
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_1024', 'allston_eltdf_content_responsive_styles' );
}

if ( ! function_exists( 'allston_eltdf_h1_responsive_styles3' ) ) {
	function allston_eltdf_h1_responsive_styles3() {
		$selector = array(
			'h1'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h1_responsive', '_3' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_768_1024', 'allston_eltdf_h1_responsive_styles3' );
}

if ( ! function_exists( 'allston_eltdf_h2_responsive_styles3' ) ) {
	function allston_eltdf_h2_responsive_styles3() {
		$selector = array(
			'h2'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h2_responsive', '_3' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_768_1024', 'allston_eltdf_h2_responsive_styles3' );
}

if ( ! function_exists( 'allston_eltdf_h3_responsive_styles3' ) ) {
	function allston_eltdf_h3_responsive_styles3() {
		$selector = array(
			'h3'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h3_responsive', '_3' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_768_1024', 'allston_eltdf_h3_responsive_styles3' );
}

if ( ! function_exists( 'allston_eltdf_h4_responsive_styles3' ) ) {
	function allston_eltdf_h4_responsive_styles3() {
		$selector = array(
			'h4'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h4_responsive', '_3' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_768_1024', 'allston_eltdf_h4_responsive_styles3' );
}

if ( ! function_exists( 'allston_eltdf_h5_responsive_styles3' ) ) {
	function allston_eltdf_h5_responsive_styles3() {
		$selector = array(
			'h5'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h5_responsive', '_3' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_768_1024', 'allston_eltdf_h5_responsive_styles3' );
}

if ( ! function_exists( 'allston_eltdf_h6_responsive_styles3' ) ) {
	function allston_eltdf_h6_responsive_styles3() {
		$selector = array(
			'h6'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h6_responsive', '_3' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_768_1024', 'allston_eltdf_h6_responsive_styles3' );
}

if ( ! function_exists( 'allston_eltdf_h1_responsive_styles' ) ) {
	function allston_eltdf_h1_responsive_styles() {
		$selector = array(
			'h1'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h1_responsive' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680_768', 'allston_eltdf_h1_responsive_styles' );
}

if ( ! function_exists( 'allston_eltdf_h2_responsive_styles' ) ) {
	function allston_eltdf_h2_responsive_styles() {
		$selector = array(
			'h2'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h2_responsive' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680_768', 'allston_eltdf_h2_responsive_styles' );
}

if ( ! function_exists( 'allston_eltdf_h3_responsive_styles' ) ) {
	function allston_eltdf_h3_responsive_styles() {
		$selector = array(
			'h3'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h3_responsive' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680_768', 'allston_eltdf_h3_responsive_styles' );
}

if ( ! function_exists( 'allston_eltdf_h4_responsive_styles' ) ) {
	function allston_eltdf_h4_responsive_styles() {
		$selector = array(
			'h4'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h4_responsive' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680_768', 'allston_eltdf_h4_responsive_styles' );
}

if ( ! function_exists( 'allston_eltdf_h5_responsive_styles' ) ) {
	function allston_eltdf_h5_responsive_styles() {
		$selector = array(
			'h5'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h5_responsive' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680_768', 'allston_eltdf_h5_responsive_styles' );
}

if ( ! function_exists( 'allston_eltdf_h6_responsive_styles' ) ) {
	function allston_eltdf_h6_responsive_styles() {
		$selector = array(
			'h6'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h6_responsive' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680_768', 'allston_eltdf_h6_responsive_styles' );
}

if ( ! function_exists( 'allston_eltdf_text_responsive_styles' ) ) {
	function allston_eltdf_text_responsive_styles() {
		$selector = array(
			'body',
			'p'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'text', '_res1' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680_768', 'allston_eltdf_text_responsive_styles' );
}

if ( ! function_exists( 'allston_eltdf_h1_responsive_styles2' ) ) {
	function allston_eltdf_h1_responsive_styles2() {
		$selector = array(
			'h1'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h1_responsive', '_2' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680', 'allston_eltdf_h1_responsive_styles2' );
}

if ( ! function_exists( 'allston_eltdf_h2_responsive_styles2' ) ) {
	function allston_eltdf_h2_responsive_styles2() {
		$selector = array(
			'h2'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h2_responsive', '_2' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680', 'allston_eltdf_h2_responsive_styles2' );
}

if ( ! function_exists( 'allston_eltdf_h3_responsive_styles2' ) ) {
	function allston_eltdf_h3_responsive_styles2() {
		$selector = array(
			'h3'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h3_responsive', '_2' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680', 'allston_eltdf_h3_responsive_styles2' );
}

if ( ! function_exists( 'allston_eltdf_h4_responsive_styles2' ) ) {
	function allston_eltdf_h4_responsive_styles2() {
		$selector = array(
			'h4'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h4_responsive', '_2' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680', 'allston_eltdf_h4_responsive_styles2' );
}

if ( ! function_exists( 'allston_eltdf_h5_responsive_styles2' ) ) {
	function allston_eltdf_h5_responsive_styles2() {
		$selector = array(
			'h5'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h5_responsive', '_2' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680', 'allston_eltdf_h5_responsive_styles2' );
}

if ( ! function_exists( 'allston_eltdf_h6_responsive_styles2' ) ) {
	function allston_eltdf_h6_responsive_styles2() {
		$selector = array(
			'h6'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'h6_responsive', '_2' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680', 'allston_eltdf_h6_responsive_styles2' );
}

if ( ! function_exists( 'allston_eltdf_text_responsive_styles2' ) ) {
	function allston_eltdf_text_responsive_styles2() {
		$selector = array(
			'body',
			'p'
		);
		
		$styles = allston_eltdf_get_responsive_typography_styles( 'text', '_res2' );
		
		if ( ! empty( $styles ) ) {
			echo allston_eltdf_dynamic_css( $selector, $styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic_responsive_680', 'allston_eltdf_text_responsive_styles2' );
}