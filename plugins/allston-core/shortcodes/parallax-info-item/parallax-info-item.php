<?php
namespace AllstonCore\CPT\Shortcodes\ParallaxInfoItem;

use AllstonCore\Lib;

class ParallaxInfoItem implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'eltdf_parallax_info_item';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Parallax Info Item', 'allston-core' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by ALLSTON', 'allston-core' ),
					'icon'                      => 'icon-wpb-parallax-info-item extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
							'type'			=> 'attach_image',
							'param_name'	=> 'main_image',
							'heading'		=> esc_html__( 'Main Image', 'allston-core' ),
						),
						array(
							'type'			=> 'attach_image',
							'param_name'	=> 'background_image',
							'heading'		=> esc_html__( 'Background Image', 'allston-core' ),
						),
						array(
							'type'			=> 'attach_image',
							'param_name'	=> 'foreground_image',
							'heading'     => esc_html__( 'Foreground Image', 'allston-core' ),
						),
						array(
							'type'			=> 'textfield',
							'param_name'	=> 'item_title',
							'heading'		=> esc_html__( 'Item Title', 'allston-core' ),
							'admin_label' => true
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'layout',
							'heading'     => esc_html__( 'Layout', 'allston-core' ),
							'value'       => array(
								esc_html__( 'Left-Aligned', 'allston-core' )  => 'left-aligned',
								esc_html__( 'Right-Aligned', 'allston-core' ) => 'right-aligned'
							),
							'admin_label' => true,
							'save_always' => true
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'link',
							'heading'    => esc_html__( 'Link', 'allston-core' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'target',
							'heading'     => esc_html__( 'Link Target', 'allston-core' ),
							'value'       => array_flip( allston_eltdf_get_link_target_array() ),
							'save_always' => true,
							'dependency' => array( 'element' => 'link', 'not_empty' => true ),
						)
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'main_image'	=> '',
			'background_image'	=> '',
			'foreground_image' 	=> '',
			'item_title'  	=> '',
			'layout' 		=> '',
			'link'			=> '',
			'link_target'   => ''
		);
		
		$params = shortcode_atts( $args, $atts );

		$params['holder_classes'] = $this->getHolderClasses( $params );
		$params['parallax_data_1'] = $this->getParallaxData1();
		$params['parallax_data_2'] = $this->getParallaxData2();
		$params['parallax_data_3'] = $this->getParallaxData3();

		$html = allston_core_get_shortcode_module_template_part( 'templates/parallax-info-item-template', 'parallax-info-item', '', $params );
		
		return $html;
	}

	private function getHolderClasses( $params ) {
		$holderClasses = array( 'eltdf-parallax-info-item-holder');

		$holderClasses[] = ! empty( $params['layout'] ) ? 'eltdf-pii-' . esc_attr( $params['layout'] ) : '';
		
		return $holderClasses;
	}

	public function getParallaxData1() {
		$parallaxData = array();

	    $y_absolute = -50;
	    $smoothness = 20; //1 is for linear, non-animated parallax

	    $parallaxData['data-parallax']= '{&quot;y&quot;: '.$y_absolute.', &quot;smoothness&quot;: '.$smoothness.'}';

		return $parallaxData;
	}

	public function getParallaxData2() {
		$parallaxData = array();

	    $y_absolute = -130;
	    $smoothness = 20; //1 is for linear, non-animated parallax

	    $parallaxData['data-parallax']= '{&quot;y&quot;: '.$y_absolute.', &quot;smoothness&quot;: '.$smoothness.'}';

		return $parallaxData;
	}

	public function getParallaxData3() {
		$parallaxData = array();

	    $y_absolute = 60;
	    $smoothness = 20; //1 is for linear, non-animated parallax

	    $parallaxData['data-parallax']= '{&quot;y&quot;: '.$y_absolute.', &quot;smoothness&quot;: '.$smoothness.'}';

		return $parallaxData;
	}
}