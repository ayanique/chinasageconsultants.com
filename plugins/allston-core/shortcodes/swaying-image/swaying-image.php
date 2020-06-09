<?php
namespace AllstonCore\CPT\Shortcodes\SwayingImage;

use AllstonCore\Lib;

class SwayingImage implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'eltdf_swaying_image';
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                    => esc_html__( 'Swaying Image', 'allston-core' ),
					'base'                    => $this->base,
					'as_child'                => array( 'only' => 'eltdf_elements_holder_item' ),
					'category'                => esc_html__( 'by ALLSTON', 'allston-core' ),
					'icon'                    => 'icon-wpb-swaying-image extended-custom-icon',
					'show_settings_on_create' => true,
					'params'                  => array(
						array(
							'type'       => 'attach_image',
							'param_name' => 'image',
							'heading'    => esc_html__( 'Image', 'allston-core' )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'direction',
							'heading'    => esc_html__( 'Direction', 'allston-core' ),
							'value'      => array(
								esc_html__( 'To Right', 'allston-core' ) => 'right',
								esc_html__( 'To Left', 'allston-core' )  => 'left',
							),
							'save_always' => true,
							'admin_label' => true,
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'enable_border',
							'heading'    => esc_html__( 'Enable Border', 'allston-core' ),
							'value'      => array_flip( allston_eltdf_get_yes_no_select_array( false, true ) ),
						),
						array(
							'type'       => 'colorpicker',
							'param_name' => 'border_color',
							'heading'    => esc_html__( 'Border Color', 'allston-core' ),
							'dependency'  => array( 'element' => 'enable_border', 'value' => array('yes') )
						),
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'image'           => '',
			'direction'           => 'right',
			'enable_border'       => 'yes',
			'border_color'       => '',
		);
		$params = shortcode_atts( $args, $atts );
			
		$params['holder_classes']  = $this->getHolderClasses( $params );
		$params['inner_styles']    = $this->getInnerStyles( $params );
		
		$html = allston_core_get_shortcode_module_template_part( 'templates/swaying-image-template', 'swaying-image', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params ) {
		$holderClasses = array();
		
		$holderClasses[] = $params['enable_border'] == 'yes' ? 'eltdf-si-with-border' : '';
		$holderClasses[] = ! empty( $params['direction'] ) ? 'eltdf-si-to-'.$params['direction'].'' : '';
		
		return implode( ' ', $holderClasses );
	}
	
	private function getInnerStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['border_color'] ) ) {
			$styles[] = 'border-color: ' . $params['border_color'];
		}
		
		return implode( ';', $styles );
	}
}
