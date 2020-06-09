<?php
namespace AllstonCore\CPT\Shortcodes\ImageMarquee;

use AllstonCore\Lib;

class ImageMarquee implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'eltdf_image_marquee';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Image Marquee', 'allston-core' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by ALLSTON', 'allston-core' ),
					'icon'                      => 'icon-wpb-image-marquee extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
							'type'       => 'dropdown',
							'param_name' => 'marquee_layout',
							'heading'    => esc_html__( 'Marquee Layout', 'allston-core' ),
							'value'      => array(
								esc_html__( 'Default', 'allston-core' )		=> 'default',
								esc_html__( 'Full Height', 'allston-core' )	=> 'full-height'
							),
							'admin_label' => true
						),
						array(
							'type'			=> 'attach_image',
							'param_name'	=> 'marquee_image',
							'heading'		=> esc_html__( 'Marquee Image', 'allston-core' ),
							'description'	=> esc_html__( 'Select image from media library', 'allston-core' )
						),
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'marquee_layout'	=> 'default',
			'marquee_image' 	=> '',
		);
		
		$params = shortcode_atts( $args, $atts );

		$params['holder_classes'] 	= $this->getHolderClasses( $params, $args );

		$html = allston_core_get_shortcode_module_template_part( 'templates/image-marquee-template', 'image-marquee', '', $params );
		
		return $html;
	}

	private function getHolderClasses( $params ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['marquee_layout'] ) ? 'eltdf-im-' . $params['marquee_layout'] : '';
		
		return implode( ' ', $holderClasses );
	}
}