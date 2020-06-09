<?php
namespace AllstonCore\CPT\Shortcodes\ClientsGrid;

use AllstonCore\Lib;

class ClientsGrid implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'eltdf_clients_grid';
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map( array(
					'name'      => esc_html__( 'Clients Grid', 'allston-core' ),
					'base'      => $this->base,
					'icon'      => 'icon-wpb-clients-grid extended-custom-icon',
					'category'  => esc_html__( 'by ALLSTON', 'allston-core' ),
					'as_parent' => array( 'only' => 'eltdf_clients_carousel_item' ),
					'js_view'   => 'VcColumnView',
					'params'    => array(
						array(
							'type'        => 'dropdown',
							'param_name'  => 'number_of_columns',
							'heading'     => esc_html__( 'Number Of Columns', 'allston-core' ),
							'value'       => array(
								esc_html__( '2 Columns', 'allston-core' ) => 'two',
								esc_html__( '3 Columns', 'allston-core' ) => 'three',
								esc_html__( '4 Columns', 'allston-core' ) => 'four',
								esc_html__( '5 Columns', 'allston-core' ) => 'five',
								esc_html__( '6 Columns', 'allston-core' ) => 'six'
							),
							'save_always' => true
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'space_between_items',
							'heading'     => esc_html__( 'Space Between Items', 'allston-core' ),
							'value'       => array_flip( allston_eltdf_get_space_between_items_array() ),
							'save_always' => true
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'image_alignment',
							'heading'     => esc_html__( 'Items Horizontal Alignment', 'allston-core' ),
							'value'       => array(
								esc_html__( 'Default Center', 'allston-core' ) => '',
								esc_html__( 'Left', 'allston-core' )           => 'left',
								esc_html__( 'Right', 'allston-core' )          => 'right'
							),
							'save_always' => true
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'items_hover_animation',
							'heading'     => esc_html__( 'Items Hover Animation', 'allston-core' ),
							'value'       => array(
								esc_html__( 'Switch Images', 'allston-core' ) => 'switch-images',
								esc_html__( 'Roll Over', 'allston-core' )     => 'roll-over',
								esc_html__( 'Zoom In', 'allston-core' )       => 'zoom-in',
							),
							'save_always' => true
						)
					)
				) );
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'number_of_columns'     => 'three',
			'space_between_items'   => 'normal',
			'image_alignment'       => '',
			'items_hover_animation' => '',
		);
		$params = shortcode_atts( $args, $atts );
		
		$params['holder_classes'] = $this->getHolderClasses( $params, $args );
		$params['content']        = $content;
		
		$html = allston_core_get_shortcode_module_template_part( 'templates/clients-grid', 'clients-grid', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params, $args ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['number_of_columns'] ) ? 'eltdf-cg-' . $params['number_of_columns'] . '-columns' : 'eltdf-cg-' . $args['number_of_columns'] . '-columns';
		$holderClasses[] = ! empty( $params['space_between_items'] ) ? 'eltdf-' . $params['space_between_items'] . '-space' : 'eltdf-' . $args['space_between_items'] . '-space';
		$holderClasses[] = ! empty( $params['image_alignment'] ) ? 'eltdf-cg-alignment-' . $params['image_alignment'] : '';
		$holderClasses[] = ! empty( $params['items_hover_animation'] ) ? 'eltdf-cc-hover-' . $params['items_hover_animation'] : 'eltdf-cc-hover-' . $args['items_hover_animation'];
		
		return implode( ' ', $holderClasses );
	}
}
