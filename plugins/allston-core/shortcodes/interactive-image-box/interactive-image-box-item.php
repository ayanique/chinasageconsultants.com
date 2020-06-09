<?php
namespace AllstonCore\CPT\Shortcodes\ImageInteractiveBox;

use AllstonCore\Lib;

class ImageInteractiveBoxItem implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'eltdf_interactive_image_box_item';
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map( array(
					'name'                      => esc_html__( 'Interactive Image Box Item', 'allston-core' ),
					'base'                      => $this->base,
					'icon'                      => 'icon-wpb-interactive-image-box-item extended-custom-icon',
					'category'                  => esc_html__( 'by ALLSTON', 'allston-core' ),
					'allowed_container_element' => 'vc_row',
					'as_child'                  => array( 'only' => 'eltdf_interactive_image_box' ),
					'params'                    => array(
						array(
							'type'        => 'textfield',
							'param_name'  => 'custom_class',
							'heading'     => esc_html__( 'Custom CSS Class', 'allston-core' ),
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'allston-core' )
						),
						array(
							'type'       => 'colorpicker',
							'param_name' => 'background_color',
							'heading'    => esc_html__( 'Background Color', 'allston-core' )
						),
						array(
							'type'       => 'attach_image',
							'param_name' => 'background_image',
							'heading'    => esc_html__( 'Background Image', 'allston-core' )
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'title',
							'heading'     => esc_html__( 'Title', 'allston-core' ),
							'value'       => esc_html__( 'Basic Plan', 'allston-core' ),
							'save_always' => true
						),
						array(
							'type'       => 'colorpicker',
							'param_name' => 'title_color',
							'heading'    => esc_html__( 'Title Color', 'allston-core' ),
							'dependency' => array( 'element' => 'title', 'not_empty' => true )
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'text',
							'heading'    => esc_html__( 'Text', 'allston-core' )
						),
						array(
							'type'       => 'colorpicker',
							'param_name' => 'text_color',
							'heading'    => esc_html__( 'Text Color', 'allston-core' ),
							'dependency' => array( 'element' => 'text', 'not_empty' => true )
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'button_text',
							'heading'     => esc_html__( 'Button Text', 'allston-core' ),
							'value'       => esc_html__( 'Read more', 'allston-core' ),
							'save_always' => true
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'link',
							'heading'    => esc_html__( 'Button Link', 'allston-core' ),
							'dependency' => array( 'element' => 'button_text', 'not_empty' => true )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'button_type',
							'heading'     => esc_html__( 'Button Type', 'allston-core' ),
							'value'       => array(
								esc_html__( 'Solid', 'allston-core' )   => 'solid',
								esc_html__( 'Outline', 'allston-core' ) => 'outline'
							),
							'save_always' => true,
							'dependency'  => array( 'element' => 'button_text', 'not_empty' => true )
						),
					)
				) );
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'custom_class'     => '',
			'background_color' => '',
			'background_image' => '',
			'title'            => '',
			'title_color'      => '',
			'text'             => '',
			'text_color'       => '',
			'button_text'      => '',
			'link'             => '',
			'button_type'      => 'outline'
		);
		$params = shortcode_atts( $args, $atts );
		
		$params['content']        = $content;
		$params['holder_classes'] = $this->getHolderClasses( $params );
		$params['holder_styles']  = $this->getHolderStyles( $params );
		$params['title_styles']   = $this->getTitleStyles( $params );
		$params['text_styles']    = $this->getTextStyles( $params );
		$params['button_type']    = ! empty( $params['button_type'] ) ? $params['button_type'] : $args['button_type'];
		
		$html = allston_core_get_shortcode_module_template_part( 'templates/interactive-image-box-template', 'interactive-image-box', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		
		return implode( ' ', $holderClasses );
	}
	
	private function getHolderStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['background_color'] ) ) {
			$styles[] = 'background-color: ' . $params['background_color'];
		}
		
		if ( ! empty( $params['background_image'] ) ) {
			$styles[] = 'background-image: url(' . wp_get_attachment_url( $params['background_image'] ) . ')';
		}
		
		return implode( ';', $styles );
	}
	
	private function getTitleStyles( $params ) {
		$itemStyle = array();
		
		if ( ! empty( $params['title_color'] ) ) {
			$itemStyle[] = 'color: ' . $params['title_color'];
		}
		
		if ( ! empty( $params['title_background_color'] ) ) {
			$itemStyle[] = 'background-color: ' . $params['title_background_color'];
		}
		
		if ( ! empty( $params['title_border_color'] ) ) {
			$itemStyle[] = 'border-color: ' . $params['title_border_color'];
		}
		
		return implode( ';', $itemStyle );
	}
	
	private function getTextStyles( $params ) {
		$itemStyle = array();
		
		if ( ! empty( $params['text_color'] ) ) {
			$itemStyle[] = 'color: ' . $params['price_color'];
		}
		
		return implode( ';', $itemStyle );
	}
}