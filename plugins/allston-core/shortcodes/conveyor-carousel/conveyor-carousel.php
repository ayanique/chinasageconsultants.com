<?php
namespace AllstonCore\CPT\Shortcodes\ConveyorCarousel;

use AllstonCore\Lib;

class ConveyorCarousel implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'eltdf_conveyor_carousel_section';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Conveyor Carousel', 'allston-core' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by ALLSTON', 'allston-core' ),
					'icon'                      => 'icon-wpb-conveyor-carousel extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
						    'type' => 'param_group',
						    'heading' => esc_html__( 'Items', 'allston-core' ),
						    'param_name' => 'items',
						    'params' => array(
						    	array(
						    	    'type'        => 'attach_image',
						    	    'param_name'  => 'image',
						    	    'heading'     => esc_html__( 'Image', 'allston-core' ),
						    	),
						    )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'behavior',
							'heading'     => esc_html__( 'Behavior', 'allston-core' ),
							'value'       => array(
								esc_html__( 'Default', 'allston-core' )  => 'default',
								esc_html__( 'Lightbox', 'allston-core' ) => 'lightbox'
							),
							'save_always' => true
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'title',
							'heading'     => esc_html__( 'Title', 'allston-core' ),
							'admin_label' => true
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'description',
							'heading'     => esc_html__( 'Description', 'allston-core' ),
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'enable_navigation',
							'heading'    => esc_html__( 'Enable Navigation', 'allston-core' ),
							'value'      => array_flip( allston_eltdf_get_yes_no_select_array( false, true ) ),
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'enable_separator',
							'heading'    => esc_html__( 'Enable Separator', 'allston-core' ),
							'value'      => array_flip( allston_eltdf_get_yes_no_select_array( false, true ) ),
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'left_offset',
							'value'		  => '16%',
							'heading'     => esc_html__( 'Left Offset', 'allston-core' ),
				    	    'description' => esc_html__( 'Enter Left Offset as a percentage value in relation to the shortcode width. Default value is 16%.', 'allston-core' ),
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'slide_width',
							'value'		  => '390px',
							'heading'     => esc_html__( 'Slide Width', 'allston-core' ),
				    	    'description' => esc_html__( 'Enter slide width in pixels. Default value is 390px.', 'allston-core' ),
						),
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'items'				=> '',
			'behavior'			=> '',
			'title'				=> '',
			'description'		=> '',
			'enable_separator'  => 'yes',
			'enable_navigation' => 'yes',
			'left_offset'		=> '16%',
			'slide_width'		=> '390px'
		);
		
		$params = shortcode_atts( $args, $atts );
        $params['content'] = $content;
        $params['holder_classes']  = $this->getHolderClasses( $params );
        $params['content_styles']  = $this->getContentStyles( $params );
        $params['items'] = json_decode( urldecode( $params['items']), true );

		$html = allston_core_get_shortcode_module_template_part( 'templates/conveyor-carousel-template', 'conveyor-carousel', '', $params );
		
		return $html;
	}

	private function getHolderClasses( $params ) {
		$holderClasses = array( 'eltdf-conveyor-carousel');

		$holderClasses[] = ! empty( $params['behavior'] ) ? 'eltdf-cc-' . esc_attr( $params['behavior'] ) . '-behavior' : '';
		$holderClasses[] = $params['enable_navigation'] == 'yes' ? 'eltdf-cc-with-nav' : '';
		$holderClasses[] = $params['enable_separator'] == 'yes' ? 'eltdf-cc-with-sep' : '';
		
		return $holderClasses;
	}

	private function getContentStyles( $params ) {
		$styles = array();
		
		if ( $params['left_offset'] !== '' ) {
			$styles[] = 'padding-left: ' . allston_eltdf_filter_percentage( $params['left_offset'] ) . '%';
		}
		
		return implode( ';', $styles );
	}
}