<?php
namespace AllstonCore\CPT\Shortcodes\ImageWithInfo;

use AllstonCore\Lib;

class ImageWithInfo implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'eltdf_image_with_info';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map( array(
				'name'                      => esc_html__( 'Image With Info', 'allston-core' ),
				'base'                      => $this->getBase(),
				'category'                  => esc_html__( 'by ALLSTON', 'allston-core' ),
				'icon'                      => 'icon-wpb-image-with-info extended-custom-icon',
				'allowed_container_element' => 'vc_row',
				'params'                    => array(
					array(
						'type'        => 'dropdown',
						'param_name'  => 'layout',
						'heading'     => esc_html__( 'Layout', 'allston-core' ),
						'value'       => array(
							esc_html__( 'Social Right - Content Left', 'allston-core' ) => 'content-left',
							esc_html__( 'Social Left - Content Right', 'allston-core' ) => 'content-right'
						),
						'save_always' => true,
						'dependency'  => array( 'element' => 'button_text', 'not_empty' => true )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'content_layout',
						'heading'     => esc_html__( 'Content Layout', 'allston-core' ),
						'value'       => array(
							esc_html__( 'Edge of Image', 'allston-core' ) => 'edge-of-image',
							esc_html__( 'Over Image', 'allston-core' )    => 'over-image'
						),
						'save_always' => true,
						'dependency'  => array( 'element' => 'button_text', 'not_empty' => true )
					),
					array(
						'type'        => 'attach_image',
						'param_name'  => 'image',
						'heading'     => esc_html__( 'Image', 'allston-core' ),
						'description' => esc_html__( 'Select image from media library', 'allston-core' )
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'title',
						'heading'    => esc_html__( 'Title', 'allston-core' )
					),
					array(
						'type'       => 'dropdown',
						'param_name' => 'enable_separator',
						'heading'    => esc_html__( 'Enable Separator', 'allston-core' ),
						'value'      => array_flip( allston_eltdf_get_yes_no_select_array( true, true ) )
					),
					array(
						'type'       => 'textarea',
						'param_name' => 'text',
						'heading'    => esc_html__( 'Text', 'allston-core' )
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'button_text',
						'heading'     => esc_html__( 'Button Text', 'allston-core' ),
						'value'       => esc_html__( 'Read More', 'allston-core' ),
						'save_always' => true
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'button_link',
						'heading'    => esc_html__( 'Button Link', 'allston-core' ),
						'dependency' => array( 'element' => 'button_text', 'not_empty' => true )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'button_target',
						'heading'     => esc_html__( 'Link Target', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_link_target_array() ),
						'save_always' => true
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'button_type',
						'heading'     => esc_html__( 'Button Type', 'allston-core' ),
						'value'       => array(
							esc_html__( 'Outline', 'allston-core' ) => 'outline',
							esc_html__( 'Solid', 'allston-core' )   => 'solid'
						),
						'save_always' => true,
						'dependency'  => array( 'element' => 'button_text', 'not_empty' => true )
					),
					array(
						'type'       => 'param_group',
						'param_name' => 'social_icons',
						'heading'    => esc_html__( 'Social Icons', 'allston-core' ),
						'params'     => array_merge( array(
							array(
								'type'       => 'textfield',
								'param_name' => 'icon_link',
								'heading'    => esc_html__( 'Icon Link', 'allston-core' ),
								'dependency' => array( 'element' => 'button_text', 'not_empty' => true )
							),
							array(
								'type'        => 'dropdown',
								'param_name'  => 'icon_target',
								'heading'     => esc_html__( 'Icon Link Target', 'allston-core' ),
								'value'       => array_flip( allston_eltdf_get_link_target_array() ),
								'save_always' => true
							)
						), \AllstonEltdfIconCollections::get_instance()->getSocialVCParamsArray() )
					),
				)
			) );
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'layout'           => 'content-left',
			'content_layout'   => 'edge-of-image',
			'image'            => '',
			'title'            => '',
			'enable_separator' => 'yes',
			'text'             => '',
			'button_text'      => 'Read More',
			'button_link'      => '',
			'button_target'    => '_self',
			'button_type'      => 'outline',
			'social_icons'     => '',
		);
		$params = shortcode_atts( $args, $atts );
		
		$params['holder_classes'] = $this->getHolderClasses( $params, $args );
		$params['button_type']    = ! empty( $params['button_type'] ) ? $params['button_type'] : $args['button_type'];
		$params['social_icons']   = vc_param_group_parse_atts( $params['social_icons'] );
		$params['this_object']    = $this;
		
		$html = allston_core_get_shortcode_module_template_part( 'templates/image-with-info', 'image-with-info', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params, $args ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = ! empty( $params['layout'] ) ? 'eltdf-iwi-layout-' . $params['layout'] : $args['layout'];
		$holderClasses[] = ! empty( $params['content_layout'] ) ? 'eltdf-iwi-content-layout-' . $params['content_layout'] : $args['content_layout'];
		
		return implode( ' ', $holderClasses );
	}
}