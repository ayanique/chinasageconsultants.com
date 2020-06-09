<?php
namespace AllstonCore\CPT\Shortcodes\AnimationHolder;

use AllstonCore\Lib;

class AnimationHolder implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'eltdf_animation_holder';
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                    => esc_html__( 'Animation Holder', 'allston-core' ),
					'base'                    => $this->base,
					"as_parent"               => array( 'except' => 'vc_row' ),
					'content_element'         => true,
					'category'                => esc_html__( 'by ALLSTON', 'allston-core' ),
					'icon'                    => 'icon-wpb-animation-holder extended-custom-icon',
					'show_settings_on_create' => true,
					'js_view'                 => 'VcColumnView',
					'params'                  => array(
						array(
							'type'        => 'dropdown',
							'param_name'  => 'animation',
							'heading'     => esc_html__( 'Animation Type', 'allston-core' ),
							'value'       => array(
								esc_html__( 'Element Grow In', 'allston-core' )          => 'eltdf-grow-in',
								esc_html__( 'Element Fade In Down', 'allston-core' )     => 'eltdf-fade-in-down',
								esc_html__( 'Element From Fade', 'allston-core' )        => 'eltdf-element-from-fade',
								esc_html__( 'Element From Left', 'allston-core' )        => 'eltdf-element-from-left',
								esc_html__( 'Element From Right', 'allston-core' )       => 'eltdf-element-from-right',
								esc_html__( 'Element From Top', 'allston-core' )         => 'eltdf-element-from-top',
								esc_html__( 'Element From Bottom', 'allston-core' )      => 'eltdf-element-from-bottom',
								esc_html__( 'Element Flip In', 'allston-core' )          => 'eltdf-flip-in',
								esc_html__( 'Element X Rotate', 'allston-core' )         => 'eltdf-x-rotate',
								esc_html__( 'Element Z Rotate', 'allston-core' )         => 'eltdf-z-rotate',
								esc_html__( 'Element Y Translate', 'allston-core' )      => 'eltdf-y-translate',
								esc_html__( 'Element Fade In X Rotate', 'allston-core' ) => 'eltdf-fade-in-left-x-rotate',
							),
							'save_always' => true
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'animation_delay',
							'heading'    => esc_html__( 'Animation Delay (ms)', 'allston-core' )
						)
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args = array(
			'animation'       => '',
			'animation_delay' => ''
		);
		extract( shortcode_atts( $args, $atts ) );
		
		$html = '<div class="eltdf-animation-holder ' . esc_attr( $animation ) . '" data-animation="' . esc_attr( $animation ) . '" data-animation-delay="' . esc_attr( $animation_delay ) . '"><div class="eltdf-animation-inner">' . do_shortcode( $content ) . '</div></div>';
		
		return $html;
	}
}