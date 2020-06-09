<?php
namespace AllstonCore\CPT\Shortcodes\Banner;

use AllstonCore\Lib;

class Banner implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'eltdf_banner';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map( array(
				'name'                      => esc_html__( 'Banner', 'allston-core' ),
				'base'                      => $this->getBase(),
				'category'                  => esc_html__( 'by ALLSTON', 'allston-core' ),
				'icon'                      => 'icon-wpb-banner extended-custom-icon',
				'allowed_container_element' => 'vc_row',
				'params'                    => array(
					array(
						'type'        => 'textfield',
						'param_name'  => 'custom_class',
						'heading'     => esc_html__( 'Custom CSS Class', 'allston-core' ),
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'allston-core' )
					),
					array(
						'type'        => 'attach_image',
						'param_name'  => 'image',
						'heading'     => esc_html__( 'Image', 'allston-core' ),
						'description' => esc_html__( 'Select image from media library', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'layout',
						'heading'     => esc_html__( 'Layout', 'allston-core' ),
						'value'       => array(
							esc_html__( 'Square Info', 'allston-core' ) => 'square-info',
							esc_html__( 'Circle Info', 'allston-core' ) => 'circle-info'
						),
						'save_always' => true
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'info_position',
						'heading'     => esc_html__( 'Info Position', 'allston-core' ),
						'value'       => array(
							esc_html__( 'Default', 'allston-core' )  => 'default',
							esc_html__( 'Centered', 'allston-core' ) => 'centered'
						),
						'save_always' => true
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'subtitle',
						'heading'    => esc_html__( 'Subtitle', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'subtitle_tag',
						'heading'     => esc_html__( 'Subtitle Tag', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_title_tag( true, array( 'p' => 'p' ) ) ),
						'save_always' => true,
						'dependency'  => array( 'element' => 'subtitle', 'not_empty' => true )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'subtitle_text_transform',
						'heading'     => esc_html__( 'Text Transform', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_text_transform_array( true ) ),
						'save_always' => true
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'subtitle_font_weight',
						'heading'     => esc_html__( 'Font Weight', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_font_weight_array( true ) ),
						'save_always' => true
					),
					array(
						'type'       => 'colorpicker',
						'param_name' => 'subtitle_color',
						'heading'    => esc_html__( 'Subtitle Color', 'allston-core' ),
						'dependency' => array( 'element' => 'subtitle', 'not_empty' => true )
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'title',
						'heading'    => esc_html__( 'Title', 'allston-core' )
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'title_second',
						'heading'    => esc_html__( 'Second Title', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'title_tag',
						'heading'     => esc_html__( 'Title Tag', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_title_tag( true, array( 'p' => 'p' ) ) ),
						'save_always' => true,
						'dependency'  => array( 'element' => 'title', 'not_empty' => true )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'title_text_transform',
						'heading'     => esc_html__( 'Text Transform', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_text_transform_array( true ) ),
						'save_always' => true
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'title_font_weight',
						'heading'     => esc_html__( 'Font Weight', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_font_weight_array( true ) ),
						'save_always' => true
					),
					array(
						'type'       => 'colorpicker',
						'param_name' => 'title_color',
						'heading'    => esc_html__( 'Title Color', 'allston-core' ),
						'dependency' => array( 'element' => 'title', 'not_empty' => true )
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'item_padding',
						'heading'     => esc_html__( 'Padding', 'allston-core' ),
						'description' => esc_html__( 'Please insert padding in format 0px 10px 0px 10px', 'allston-core' )
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'link',
						'heading'    => esc_html__( 'Link', 'allston-core' )
					),
					array(
						'type'       => 'dropdown',
						'param_name' => 'target',
						'heading'    => esc_html__( 'Target', 'allston-core' ),
						'value'      => array_flip( allston_eltdf_get_link_target_array() ),
						'dependency' => array( 'element' => 'link', 'not_empty' => true )
					)
				)
			) );
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'custom_class'            => '',
			'image'                   => '',
			'layout'                  => 'square-info',
			'subtitle'                => '',
			'subtitle_tag'            => 'h3',
			'subtitle_text_transform' => '',
			'subtitle_font_weight'    => '',
			'subtitle_color'          => '',
			'title'                   => '',
			'title_second'            => '',
			'title_tag'               => 'h3',
			'title_text_transform'    => '',
			'title_font_weight'       => '',
			'title_color'             => '',
			'item_padding'            => '',
			'link'                    => '',
			'target'                  => '_self'
		);
		$params = shortcode_atts( $args, $atts );
		
		$params['holder_classes']  = $this->getHolderClasses( $params, $args );
		$params['subtitle_tag']    = ! empty( $params['subtitle_tag'] ) ? $params['subtitle_tag'] : $args['subtitle_tag'];
		$params['subtitle_styles'] = $this->getSubitleStyles( $params );
		$params['title_tag']       = ! empty( $params['title_tag'] ) ? $params['title_tag'] : $args['title_tag'];
		$params['title_styles']    = $this->getTitleStyles( $params );
		$params['content_styles']  = $this->getContentStyles( $params );
		
		$html = allston_core_get_shortcode_module_template_part( 'templates/banner', 'banner', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params, $args ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = ! empty( $params['layout'] ) ? 'eltdf-banner-layout-' . $params['layout'] : 'eltdf-banner-layout-' . $args['layout'];
		
		return implode( ' ', $holderClasses );
	}
	
	private function getSubitleStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['subtitle_color'] ) ) {
			$styles[] = 'color: ' . $params['subtitle_color'];
		}
		
		if ( ! empty( $params['subtitle_font_weight'] ) ) {
			$styles[] = 'font-weight: ' . $params['subtitle_font_weight'];
		}
		
		if ( ! empty( $params['subtitle_text_transform'] ) ) {
			$styles[] = 'text-transform: ' . $params['subtitle_text_transform'];
		}
		
		return implode( ';', $styles );
	}
	
	private function getTitleStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['title_color'] ) ) {
			$styles[] = 'color: ' . $params['title_color'];
		}
		
		if ( ! empty( $params['title_font_weight'] ) ) {
			$styles[] = 'font-weight: ' . $params['title_font_weight'];
		}
		
		if ( ! empty( $params['title_text_transform'] ) ) {
			$styles[] = 'text-transform: ' . $params['title_text_transform'];
		}
		
		return implode( ';', $styles );
	}
	
	private function getContentStyles( $params ) {
		$styles = array();
		
		if ( $params['item_padding'] !== '' ) {
			$styles[] = 'padding: ' . $params['item_padding'];
		}
		
		return implode( ';', $styles );
	}
}