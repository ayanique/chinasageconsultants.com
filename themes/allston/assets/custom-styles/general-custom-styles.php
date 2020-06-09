<?php

if(!function_exists('allston_eltdf_design_styles')) {
    /**
     * Generates general custom styles
     */
    function allston_eltdf_design_styles() {
	    $font_family = allston_eltdf_options()->getOptionValue( 'google_fonts' );
	    if ( ! empty( $font_family ) && allston_eltdf_is_font_option_valid( $font_family ) ) {
		    $font_family_selector = array(
			    'body'
		    );
		    echo allston_eltdf_dynamic_css( $font_family_selector, array( 'font-family' => allston_eltdf_get_font_option_val( $font_family ) ) );
	    }

		$first_main_color = allston_eltdf_options()->getOptionValue('first_color');
        if(!empty($first_main_color)) {
            $color_selector = array(
	            'a:hover',
	            'h1 a:hover',
	            'h2 a:hover',
	            'h3 a:hover',
	            'h4 a:hover',
	            'h5 a:hover',
	            'h6 a:hover',
	            'p a:hover',
	            '.eltdf-comment-holder .eltdf-comment-text .comment-edit-link:hover',
	            '.eltdf-comment-holder .eltdf-comment-text .comment-reply-link:hover',
	            '.eltdf-comment-holder .eltdf-comment-text .replay:hover',
	            '.eltdf-comment-holder .eltdf-comment-text #cancel-comment-reply-link',
	            'footer .widget ul li a:hover',
	            'footer .widget #wp-calendar tfoot a:hover',
	            'footer .widget.widget_search .input-holder button:hover',
	            'footer .widget.widget_tag_cloud a:hover',
	            '.eltdf-side-menu .widget ul li a:hover',
	            '.eltdf-side-menu .widget #wp-calendar tfoot a:hover',
	            '.eltdf-side-menu .widget.widget_search .input-holder button:hover',
	            '.eltdf-side-menu .widget.widget_tag_cloud a:hover',
	            '.wpb_widgetised_column .widget ul li a:hover',
	            'aside.eltdf-sidebar .widget ul li a:hover',
	            '.wpb_widgetised_column .widget #wp-calendar tfoot a:hover',
	            'aside.eltdf-sidebar .widget #wp-calendar tfoot a:hover',
	            '.wpb_widgetised_column .widget.widget_search .input-holder button:hover',
	            'aside.eltdf-sidebar .widget.widget_search .input-holder button:hover',
	            '.wpb_widgetised_column .widget.widget_tag_cloud a:hover',
	            'aside.eltdf-sidebar .widget.widget_tag_cloud a:hover',
	            '.widget ul li a:hover',
	            '.widget #wp-calendar tfoot a:hover',
	            '.widget.widget_search .input-holder button:hover',
	            '.widget.widget_tag_cloud a:hover',
	            '.widget.widget_eltdf_twitter_widget .eltdf-twitter-widget.eltdf-twitter-slider li .eltdf-tweet-text a',
	            '.widget.widget_eltdf_twitter_widget .eltdf-twitter-widget.eltdf-twitter-slider li .eltdf-tweet-text span',
	            '.widget.widget_eltdf_twitter_widget .eltdf-twitter-widget.eltdf-twitter-standard li .eltdf-tweet-text a:hover',
	            '.widget.widget_eltdf_twitter_widget .eltdf-twitter-widget.eltdf-twitter-slider li .eltdf-twitter-icon i',
	            'body .pp_pic_holder a.pp_arrow_next:hover',
	            'body .pp_pic_holder a.pp_arrow_previous:hover',
	            'body .pp_pic_holder a.pp_close:hover'
            );

            $woo_color_selector = array();
            if(allston_eltdf_is_woocommerce_installed()) {
                $woo_color_selector = array(
	                '.woocommerce-pagination .page-numbers.current',
	                '.woocommerce-pagination .page-numbers:hover',
	                '.woocommerce-page .eltdf-content .eltdf-quantity-buttons .eltdf-quantity-minus:hover',
	                '.woocommerce-page .eltdf-content .eltdf-quantity-buttons .eltdf-quantity-plus:hover',
	                'div.woocommerce .eltdf-quantity-buttons .eltdf-quantity-minus:hover',
	                'div.woocommerce .eltdf-quantity-buttons .eltdf-quantity-plus:hover',
	                '.woocommerce .star-rating span:before',
	                '.eltdf-woo-single-page .eltdf-single-product-summary .product_meta>span a:hover',
	                '.eltdf-woo-single-page .woocommerce-tabs #reviews .comment-respond .stars a.active:after',
	                '.widget.woocommerce.widget_layered_nav ul li.chosen a'
                );
            }

            $color_selector = array_merge($color_selector, $woo_color_selector);

            $background_color_selector = array(
	            '.eltdf-st-loader .pulse',
	            '.eltdf-st-loader .double_pulse .double-bounce1',
	            '.eltdf-st-loader .double_pulse .double-bounce2',
	            '.eltdf-st-loader .cube',
	            '.eltdf-st-loader .rotating_cubes .cube1',
	            '.eltdf-st-loader .rotating_cubes .cube2',
	            '.eltdf-st-loader .stripes>div',
	            '.eltdf-st-loader .wave>div',
	            '.eltdf-st-loader .two_rotating_circles .dot1',
	            '.eltdf-st-loader .two_rotating_circles .dot2',
	            '.eltdf-st-loader .five_rotating_circles .container1>div',
	            '.eltdf-st-loader .five_rotating_circles .container2>div',
	            '.eltdf-st-loader .five_rotating_circles .container3>div',
	            '.eltdf-st-loader .atom .ball-1:before',
	            '.eltdf-st-loader .atom .ball-2:before',
	            '.eltdf-st-loader .atom .ball-3:before',
	            '.eltdf-st-loader .atom .ball-4:before',
	            '.eltdf-st-loader .clock .ball:before',
	            '.eltdf-st-loader .mitosis .ball',
	            '.eltdf-st-loader .lines .line1',
	            '.eltdf-st-loader .lines .line2',
	            '.eltdf-st-loader .lines .line3',
	            '.eltdf-st-loader .lines .line4',
	            '.eltdf-st-loader .fussion .ball',
	            '.eltdf-st-loader .fussion .ball-1',
	            '.eltdf-st-loader .fussion .ball-2',
	            '.eltdf-st-loader .fussion .ball-3',
	            '.eltdf-st-loader .fussion .ball-4',
	            '.eltdf-st-loader .wave_circles .ball',
	            '.eltdf-st-loader .pulse_circles .ball',
	            '#eltdf-back-to-top>span',
	            '.eltdf-social-icons-group-widget.eltdf-square-icons .eltdf-social-icon-widget-holder:hover',
	            '.eltdf-social-icons-group-widget.eltdf-square-icons.eltdf-light-skin .eltdf-social-icon-widget-holder:hover'
            );

            $woo_background_color_selector = array();
            if(allston_eltdf_is_woocommerce_installed()) {
                $woo_background_color_selector = array(
	                '.woocommerce-page .eltdf-content .wc-forward:not(.added_to_cart):not(.checkout-button):hover',
	                '.woocommerce-page .eltdf-content a.added_to_cart:hover',
	                '.woocommerce-page .eltdf-content a.button:hover',
	                '.woocommerce-page .eltdf-content button[type=submit]:not(.eltdf-woo-search-widget-button):hover',
	                '.woocommerce-page .eltdf-content input[type=submit]:hover',
	                'div.woocommerce .wc-forward:not(.added_to_cart):not(.checkout-button):hover',
	                'div.woocommerce a.added_to_cart:hover',
	                'div.woocommerce a.button:hover',
	                'div.woocommerce button[type=submit]:not(.eltdf-woo-search-widget-button):hover',
	                'div.woocommerce input[type=submit]:hover',
	                '.woocommerce .eltdf-new-product',
	                '.woocommerce .eltdf-onsale',
	                '.woocommerce .eltdf-out-of-stock',
	                '.eltdf-shopping-cart-holder .eltdf-header-cart.eltdf-header-cart-icon-pack .eltdf-cart-icon .eltdf-cart-number',
	                '.eltdf-shopping-cart-holder .eltdf-header-cart.eltdf-header-cart-svg-path .eltdf-cart-icon .eltdf-cart-number',
	                '.eltdf-shopping-cart-dropdown .eltdf-cart-bottom .eltdf-view-cart:hover'
                );
            }

            $background_color_selector = array_merge($background_color_selector, $woo_background_color_selector);

            $border_color_selector = array(
	            '.eltdf-st-loader .pulse_circles .ball',
	            '.eltdf-owl-slider+.eltdf-slider-thumbnail>.eltdf-slider-thumbnail-item.active img',
	            '#eltdf-back-to-top>span'
            );

            echo allston_eltdf_dynamic_css($color_selector, array('color' => $first_main_color));
	        echo allston_eltdf_dynamic_css($background_color_selector, array('background-color' => $first_main_color));
	        echo allston_eltdf_dynamic_css($border_color_selector, array('border-color' => $first_main_color));
        }
	
	    $page_background_color = allston_eltdf_options()->getOptionValue( 'page_background_color' );
	    if ( ! empty( $page_background_color ) ) {
		    $background_color_selector = array(
			    'body',
			    '.eltdf-content'
		    );
		    echo allston_eltdf_dynamic_css( $background_color_selector, array( 'background-color' => $page_background_color ) );
	    }
	
	    $selection_color = allston_eltdf_options()->getOptionValue( 'selection_color' );
	    if ( ! empty( $selection_color ) ) {
		    echo allston_eltdf_dynamic_css( '::selection', array( 'background' => $selection_color ) );
		    echo allston_eltdf_dynamic_css( '::-moz-selection', array( 'background' => $selection_color ) );
	    }
	
	    $preload_background_styles = array();
	
	    if ( allston_eltdf_options()->getOptionValue( 'preload_pattern_image' ) !== "" ) {
		    $preload_background_styles['background-image'] = 'url(' . allston_eltdf_options()->getOptionValue( 'preload_pattern_image' ) . ') !important';
	    }
	
	    echo allston_eltdf_dynamic_css( '.eltdf-preload-background', $preload_background_styles );
    }

    add_action('allston_eltdf_style_dynamic', 'allston_eltdf_design_styles');
}

if ( ! function_exists( 'allston_eltdf_content_styles' ) ) {
	function allston_eltdf_content_styles() {
		$content_style = array();
		
		$padding = allston_eltdf_options()->getOptionValue( 'content_padding' );
		if ( $padding !== '' ) {
			$content_style['padding'] = $padding;
		}
		
		$content_selector = array(
			'.eltdf-content .eltdf-content-inner > .eltdf-full-width > .eltdf-full-width-inner',
		);
		
		echo allston_eltdf_dynamic_css( $content_selector, $content_style );
		
		$content_style_in_grid = array();
		
		$padding_in_grid = allston_eltdf_options()->getOptionValue( 'content_padding_in_grid' );
		if ( $padding_in_grid !== '' ) {
			$content_style_in_grid['padding'] = $padding_in_grid;
		}
		
		$content_selector_in_grid = array(
			'.eltdf-content .eltdf-content-inner > .eltdf-container > .eltdf-container-inner',
		);
		
		echo allston_eltdf_dynamic_css( $content_selector_in_grid, $content_style_in_grid );
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_content_styles' );
}

if ( ! function_exists( 'allston_eltdf_h1_styles' ) ) {
	function allston_eltdf_h1_styles() {
		$margin_top    = allston_eltdf_options()->getOptionValue( 'h1_margin_top' );
		$margin_bottom = allston_eltdf_options()->getOptionValue( 'h1_margin_bottom' );
		
		$item_styles = allston_eltdf_get_typography_styles( 'h1' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = allston_eltdf_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = allston_eltdf_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h1'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo allston_eltdf_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_h1_styles' );
}

if ( ! function_exists( 'allston_eltdf_h2_styles' ) ) {
	function allston_eltdf_h2_styles() {
		$margin_top    = allston_eltdf_options()->getOptionValue( 'h2_margin_top' );
		$margin_bottom = allston_eltdf_options()->getOptionValue( 'h2_margin_bottom' );
		
		$item_styles = allston_eltdf_get_typography_styles( 'h2' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = allston_eltdf_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = allston_eltdf_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h2'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo allston_eltdf_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_h2_styles' );
}

if ( ! function_exists( 'allston_eltdf_h3_styles' ) ) {
	function allston_eltdf_h3_styles() {
		$margin_top    = allston_eltdf_options()->getOptionValue( 'h3_margin_top' );
		$margin_bottom = allston_eltdf_options()->getOptionValue( 'h3_margin_bottom' );
		
		$item_styles = allston_eltdf_get_typography_styles( 'h3' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = allston_eltdf_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = allston_eltdf_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h3'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo allston_eltdf_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_h3_styles' );
}

if ( ! function_exists( 'allston_eltdf_h4_styles' ) ) {
	function allston_eltdf_h4_styles() {
		$margin_top    = allston_eltdf_options()->getOptionValue( 'h4_margin_top' );
		$margin_bottom = allston_eltdf_options()->getOptionValue( 'h4_margin_bottom' );
		
		$item_styles = allston_eltdf_get_typography_styles( 'h4' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = allston_eltdf_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = allston_eltdf_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h4'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo allston_eltdf_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_h4_styles' );
}

if ( ! function_exists( 'allston_eltdf_h5_styles' ) ) {
	function allston_eltdf_h5_styles() {
		$margin_top    = allston_eltdf_options()->getOptionValue( 'h5_margin_top' );
		$margin_bottom = allston_eltdf_options()->getOptionValue( 'h5_margin_bottom' );
		
		$item_styles = allston_eltdf_get_typography_styles( 'h5' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = allston_eltdf_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = allston_eltdf_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h5'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo allston_eltdf_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_h5_styles' );
}

if ( ! function_exists( 'allston_eltdf_h6_styles' ) ) {
	function allston_eltdf_h6_styles() {
		$margin_top    = allston_eltdf_options()->getOptionValue( 'h6_margin_top' );
		$margin_bottom = allston_eltdf_options()->getOptionValue( 'h6_margin_bottom' );
		
		$item_styles = allston_eltdf_get_typography_styles( 'h6' );
		
		if ( $margin_top !== '' ) {
			$item_styles['margin-top'] = allston_eltdf_filter_px( $margin_top ) . 'px';
		}
		if ( $margin_bottom !== '' ) {
			$item_styles['margin-bottom'] = allston_eltdf_filter_px( $margin_bottom ) . 'px';
		}
		
		$item_selector = array(
			'h6'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo allston_eltdf_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_h6_styles' );
}

if ( ! function_exists( 'allston_eltdf_text_styles' ) ) {
	function allston_eltdf_text_styles() {
		$item_styles = allston_eltdf_get_typography_styles( 'text' );
		
		$item_selector = array(
			'p'
		);
		
		if ( ! empty( $item_styles ) ) {
			echo allston_eltdf_dynamic_css( $item_selector, $item_styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_text_styles' );
}

if ( ! function_exists( 'allston_eltdf_link_styles' ) ) {
	function allston_eltdf_link_styles() {
		$link_styles      = array();
		$link_color       = allston_eltdf_options()->getOptionValue( 'link_color' );
		$link_font_style  = allston_eltdf_options()->getOptionValue( 'link_fontstyle' );
		$link_font_weight = allston_eltdf_options()->getOptionValue( 'link_fontweight' );
		$link_decoration  = allston_eltdf_options()->getOptionValue( 'link_fontdecoration' );
		
		if ( ! empty( $link_color ) ) {
			$link_styles['color'] = $link_color;
		}
		if ( ! empty( $link_font_style ) ) {
			$link_styles['font-style'] = $link_font_style;
		}
		if ( ! empty( $link_font_weight ) ) {
			$link_styles['font-weight'] = $link_font_weight;
		}
		if ( ! empty( $link_decoration ) ) {
			$link_styles['text-decoration'] = $link_decoration;
		}
		
		$link_selector = array(
			'a',
			'p a'
		);
		
		if ( ! empty( $link_styles ) ) {
			echo allston_eltdf_dynamic_css( $link_selector, $link_styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_link_styles' );
}

if ( ! function_exists( 'allston_eltdf_link_hover_styles' ) ) {
	function allston_eltdf_link_hover_styles() {
		$link_hover_styles     = array();
		$link_hover_color      = allston_eltdf_options()->getOptionValue( 'link_hovercolor' );
		$link_hover_decoration = allston_eltdf_options()->getOptionValue( 'link_hover_fontdecoration' );
		
		if ( ! empty( $link_hover_color ) ) {
			$link_hover_styles['color'] = $link_hover_color;
		}
		if ( ! empty( $link_hover_decoration ) ) {
			$link_hover_styles['text-decoration'] = $link_hover_decoration;
		}
		
		$link_hover_selector = array(
			'a:hover',
			'p a:hover'
		);
		
		if ( ! empty( $link_hover_styles ) ) {
			echo allston_eltdf_dynamic_css( $link_hover_selector, $link_hover_styles );
		}
		
		$link_heading_hover_styles = array();
		
		if ( ! empty( $link_hover_color ) ) {
			$link_heading_hover_styles['color'] = $link_hover_color;
		}
		
		$link_heading_hover_selector = array(
			'h1 a:hover',
			'h2 a:hover',
			'h3 a:hover',
			'h4 a:hover',
			'h5 a:hover',
			'h6 a:hover'
		);
		
		if ( ! empty( $link_heading_hover_styles ) ) {
			echo allston_eltdf_dynamic_css( $link_heading_hover_selector, $link_heading_hover_styles );
		}
	}
	
	add_action( 'allston_eltdf_style_dynamic', 'allston_eltdf_link_hover_styles' );
}

if ( ! function_exists( 'allston_eltdf_smooth_page_transition_styles' ) ) {
	function allston_eltdf_smooth_page_transition_styles( $style ) {
		$id            = allston_eltdf_get_page_id();
		$loader_style  = array();
		$current_style = '';
		
		$background_color = allston_eltdf_get_meta_field_intersect( 'smooth_pt_bgnd_color', $id );
		if ( ! empty( $background_color ) ) {
			$loader_style['background-color'] = $background_color;
		}
		
		$loader_selector = array(
			'.eltdf-smooth-transition-loader'
		);
		
		if ( ! empty( $loader_style ) ) {
			$current_style .= allston_eltdf_dynamic_css( $loader_selector, $loader_style );
		}
		
		$spinner_style = array();
		$spinner_color = allston_eltdf_get_meta_field_intersect( 'smooth_pt_spinner_color', $id );
		if ( ! empty( $spinner_color ) ) {
			$spinner_style['background-color'] = $spinner_color;
		}
		
		$spinner_selectors = array(
			'.eltdf-st-loader .eltdf-rotate-circles > div',
			'.eltdf-st-loader .pulse',
			'.eltdf-st-loader .double_pulse .double-bounce1',
			'.eltdf-st-loader .double_pulse .double-bounce2',
			'.eltdf-st-loader .cube',
			'.eltdf-st-loader .rotating_cubes .cube1',
			'.eltdf-st-loader .rotating_cubes .cube2',
			'.eltdf-st-loader .stripes > div',
			'.eltdf-st-loader .wave > div',
			'.eltdf-st-loader .two_rotating_circles .dot1',
			'.eltdf-st-loader .two_rotating_circles .dot2',
			'.eltdf-st-loader .five_rotating_circles .container1 > div',
			'.eltdf-st-loader .five_rotating_circles .container2 > div',
			'.eltdf-st-loader .five_rotating_circles .container3 > div',
			'.eltdf-st-loader .atom .ball-1:before',
			'.eltdf-st-loader .atom .ball-2:before',
			'.eltdf-st-loader .atom .ball-3:before',
			'.eltdf-st-loader .atom .ball-4:before',
			'.eltdf-st-loader .clock .ball:before',
			'.eltdf-st-loader .mitosis .ball',
			'.eltdf-st-loader .lines .line1',
			'.eltdf-st-loader .lines .line2',
			'.eltdf-st-loader .lines .line3',
			'.eltdf-st-loader .lines .line4',
			'.eltdf-st-loader .fussion .ball',
			'.eltdf-st-loader .fussion .ball-1',
			'.eltdf-st-loader .fussion .ball-2',
			'.eltdf-st-loader .fussion .ball-3',
			'.eltdf-st-loader .fussion .ball-4',
			'.eltdf-st-loader .wave_circles .ball',
			'.eltdf-st-loader .pulse_circles .ball'
		);
		
		if ( ! empty( $spinner_style ) ) {
			$current_style .= allston_eltdf_dynamic_css( $spinner_selectors, $spinner_style );
		}

		$spinner_color_style = array();
		if ( ! empty( $spinner_color ) ) {
			$spinner_color_style['color'] = $spinner_color;
		}
		
		$spinner_color_selectors = array(
			'.edgtf-loader-title-spinner-text'
		);

		if ( ! empty( $spinner_color_style ) ) {
			$current_style .= allston_eltdf_dynamic_css( $spinner_color_selectors, $spinner_color_style );
		}
		
		$current_style = $current_style . $style;
		
		return $current_style;
	}
	
	add_filter( 'allston_eltdf_add_page_custom_style', 'allston_eltdf_smooth_page_transition_styles' );
}