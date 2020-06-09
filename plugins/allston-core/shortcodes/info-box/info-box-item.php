<?php
namespace AllstonCore\CPT\Shortcodes\InfoBox;

use AllstonCore\Lib;

class InfoBoxItem implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'eltdf_info_box_item';
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map( array(
					'name'                      => esc_html__( 'Info Box Item', 'allston-core' ),
					'base'                      => $this->base,
					'icon'                      => 'icon-wpb-icon-with-text extended-custom-icon',
					'category'                  => esc_html__( 'by ALLSTON', 'allston-core' ),
					'allowed_container_element' => 'vc_row',
					'as_child'                  => array( 'only' => 'eltdf_info_box' ),
					'params'                    => array_merge( array(
						array(
							'type'       => 'colorpicker',
							'param_name' => 'box_background_color',
							'heading'    => esc_html__( 'Box Background Color', 'allston-core' )
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'custom_class',
							'heading'     => esc_html__( 'Custom CSS Class', 'allston-core' ),
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'allston-core' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'icon_source',
							'heading'     => esc_html__( 'Icon Source', 'allston-core' ),
							'value'       => array(
								esc_html__( 'Icon Font', 'allston-core' )  => 'icon-font',
								esc_html__( 'SVG Icon', 'allston-core' )   => 'svg-icon'
							),
							'save_always' => true
						),

						array(
						    'type' => 'textarea_raw_html',
						    'param_name' => 'svg_path',
						    'heading' => esc_html__('SVG Path', 'edgtf-core'),
						    'dependency' => array(
						        'element' => 'icon_source',
						        'value' => 'svg-icon',
						    ),
							'description' => esc_html__( 'Paste in <svg> HTML tag with its inner <path> tags.', 'allston-core' )
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'svg_animation_duration',
							'heading'    => esc_html__( 'SVG Animation Duration (ms)', 'allston-core' ),
							'dependency' => array(
							    'element' => 'icon_source',
							    'value' => 'svg-icon',
							),
						),
						array(
							'type'       => 'textfield',
							'param_name' => 'svg_animation_delay',
							'heading'    => esc_html__( 'SVG Animation Delay (ms)', 'allston-core' ),
							'dependency' => array(
							    'element' => 'icon_source',
							    'value' => 'svg-icon',
							),
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'type',
							'heading'     => esc_html__( 'Type', 'allston-core' ),
							'value'       => array(
								esc_html__( 'Icon Left From Text', 'allston-core' )  => 'icon-left',
								esc_html__( 'Icon Left From Title', 'allston-core' ) => 'icon-left-from-title',
								esc_html__( 'Icon Top', 'allston-core' )             => 'icon-top'
							),
							'save_always' => true
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'enable_separator',
							'heading'    => esc_html__( 'Enable Separator', 'allston-core' ),
							'value'      => array_flip( allston_eltdf_get_yes_no_select_array( false ) ),
						),
					), allston_eltdf_icon_collections()->getVCParamsArray(
							array(
	                            'element' => 'icon_source',
	                            'value' => array('icon-font')
	                        )
                        ),
						array(
							array(
								'type'       => 'attach_image',
								'param_name' => 'custom_icon',
								'heading'    => esc_html__( 'Custom Icon', 'allston-core' ),
								'dependency'  => array( 'element' => 'icon_source', 'value' => 'icon-font' )
							),
							array(
								'type'       => 'dropdown',
								'param_name' => 'icon_type',
								'heading'    => esc_html__( 'Icon Type', 'allston-core' ),
								'value'      => array(
									esc_html__( 'Normal', 'allston-core' ) => 'eltdf-normal',
									esc_html__( 'Circle', 'allston-core' ) => 'eltdf-circle',
									esc_html__( 'Square', 'allston-core' ) => 'eltdf-square'
								),
								'dependency'  => array( 'element' => 'icon_source', 'value' => 'icon-font' ),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'dropdown',
								'param_name' => 'icon_size',
								'heading'    => esc_html__( 'Icon Size', 'allston-core' ),
								'value'      => array(
									esc_html__( 'Medium', 'allston-core' )     => 'eltdf-icon-medium',
									esc_html__( 'Tiny', 'allston-core' )       => 'eltdf-icon-tiny',
									esc_html__( 'Small', 'allston-core' )      => 'eltdf-icon-small',
									esc_html__( 'Large', 'allston-core' )      => 'eltdf-icon-large',
									esc_html__( 'Very Large', 'allston-core' ) => 'eltdf-icon-huge'
								),
								'dependency'  => array( 'element' => 'icon_source', 'value' => 'icon-font' ),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'textfield',
								'param_name' => 'custom_icon_size',
								'heading'    => esc_html__( 'Custom Icon Size (px)', 'allston-core' ),
								'dependency'  => array( 'element' => 'icon_source', 'value' => 'icon-font' ),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'textfield',
								'param_name' => 'shape_size',
								'heading'    => esc_html__( 'Shape Size (px)', 'allston-core' ),
								'dependency'  => array( 'element' => 'icon_source', 'value' => 'icon-font' ),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'icon_color',
								'heading'    => esc_html__( 'Icon Color', 'allston-core' ),
								'dependency'  => array( 'element' => 'icon_source', 'value' => 'icon-font' ),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'icon_hover_color',
								'heading'    => esc_html__( 'Icon Hover Color', 'allston-core' ),
								'dependency'  => array( 'element' => 'icon_source', 'value' => 'icon-font' ),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'icon_background_color',
								'heading'    => esc_html__( 'Icon Background Color', 'allston-core' ),
								'dependency' => array(
									'element' => 'icon_type',
									'value'   => array( 'eltdf-square', 'eltdf-circle' )
								),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'icon_hover_background_color',
								'heading'    => esc_html__( 'Icon Hover Background Color', 'allston-core' ),
								'dependency' => array(
									'element' => 'icon_type',
									'value'   => array( 'eltdf-square', 'eltdf-circle' )
								),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'icon_border_color',
								'heading'    => esc_html__( 'Icon Border Color', 'allston-core' ),
								'dependency' => array(
									'element' => 'icon_type',
									'value'   => array( 'eltdf-square', 'eltdf-circle' )
								),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'icon_border_hover_color',
								'heading'    => esc_html__( 'Icon Border Hover Color', 'allston-core' ),
								'dependency' => array(
									'element' => 'icon_type',
									'value'   => array( 'eltdf-square', 'eltdf-circle' )
								),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'textfield',
								'param_name' => 'icon_border_width',
								'heading'    => esc_html__( 'Border Width (px)', 'allston-core' ),
								'dependency' => array(
									'element' => 'icon_type',
									'value'   => array( 'eltdf-square', 'eltdf-circle' )
								),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'dropdown',
								'param_name' => 'icon_animation',
								'heading'    => esc_html__( 'Icon Animation', 'allston-core' ),
								'value'      => array_flip( allston_eltdf_get_yes_no_select_array( false ) ),
								'dependency'  => array( 'element' => 'icon_source', 'value' => 'icon-font' ),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'textfield',
								'param_name' => 'icon_animation_delay',
								'heading'    => esc_html__( 'Icon Animation Delay (ms)', 'allston-core' ),
								'dependency' => array( 'element' => 'icon_animation', 'value' => array( 'yes' ) ),
								'group'      => esc_html__( 'Icon Settings', 'allston-core' )
							),
							array(
								'type'       => 'textfield',
								'param_name' => 'title',
								'heading'    => esc_html__( 'Title', 'allston-core' )
							),
							array(
								'type'        => 'dropdown',
								'param_name'  => 'title_tag',
								'heading'     => esc_html__( 'Title Tag', 'allston-core' ),
								'value'       => array_flip( allston_eltdf_get_title_tag( true ) ),
								'save_always' => true,
								'dependency'  => array( 'element' => 'title', 'not_empty' => true ),
								'group'       => esc_html__( 'Text Settings', 'allston-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'title_color',
								'heading'    => esc_html__( 'Title Color', 'allston-core' ),
								'dependency' => array( 'element' => 'title', 'not_empty' => true ),
								'group'      => esc_html__( 'Text Settings', 'allston-core' )
							),
							array(
								'type'       => 'textfield',
								'param_name' => 'title_top_margin',
								'heading'    => esc_html__( 'Title Top Margin (px)', 'allston-core' ),
								'dependency' => array( 'element' => 'title', 'not_empty' => true ),
								'group'      => esc_html__( 'Text Settings', 'allston-core' )
							),
							array(
								'type'       => 'textarea',
								'param_name' => 'text',
								'heading'    => esc_html__( 'Text', 'allston-core' )
							),
							array(
								'type'       => 'colorpicker',
								'param_name' => 'text_color',
								'heading'    => esc_html__( 'Text Color', 'allston-core' ),
								'dependency' => array( 'element' => 'text', 'not_empty' => true ),
								'group'      => esc_html__( 'Text Settings', 'allston-core' )
							),
							array(
								'type'       => 'textfield',
								'param_name' => 'text_top_margin',
								'heading'    => esc_html__( 'Text Top Margin (px)', 'allston-core' ),
								'dependency' => array( 'element' => 'text', 'not_empty' => true ),
								'group'      => esc_html__( 'Text Settings', 'allston-core' )
							),
							array(
								'type'        => 'textfield',
								'param_name'  => 'link',
								'heading'     => esc_html__( 'Link', 'allston-core' ),
								'description' => esc_html__( 'Set link around icon and title', 'allston-core' )
							),
							array(
								'type'       => 'dropdown',
								'param_name' => 'target',
								'heading'    => esc_html__( 'Target', 'allston-core' ),
								'value'      => array_flip( allston_eltdf_get_link_target_array() ),
								'dependency' => array( 'element' => 'link', 'not_empty' => true ),
							),
							array(
								'type'        => 'textfield',
								'param_name'  => 'text_padding',
								'heading'     => esc_html__( 'Text Padding (px)', 'allston-core' ),
								'description' => esc_html__( 'Set left or top padding dependence of type for your text holder. Default value is 13 for left type and 25 for top icon with text type', 'allston-core' ),
								'dependency'  => array(
									'element' => 'type',
									'value'   => array( 'icon-left', 'icon-top' )
								),
								'group'       => esc_html__( 'Text Settings', 'allston-core' )
							)
						) )
				) );
		}
	}
	
	public function render( $atts, $content = null ) {
		$default_atts = array(
			'box_background_color'        => '',
			'custom_class'                => '',
			'icon_source'				  => 'icon-font',
			'svg_path'				  	  => '',
			'svg_animation_duration'  	  => '',
			'svg_animation_delay'  	  	  => '',
			'type'                        => 'icon-left',
			'custom_icon'                 => '',
			'enable_separator'            => '',
			'icon_type'                   => 'eltdf-normal',
			'icon_size'                   => 'eltdf-icon-medium',
			'custom_icon_size'            => '',
			'shape_size'                  => '',
			'icon_color'                  => '',
			'icon_hover_color'            => '',
			'icon_background_color'       => '',
			'icon_hover_background_color' => '',
			'icon_border_color'           => '',
			'icon_border_hover_color'     => '',
			'icon_border_width'           => '',
			'icon_animation'              => '',
			'icon_animation_delay'        => '',
			'title'                       => '',
			'title_tag'                   => 'h3',
			'title_color'                 => '',
			'title_top_margin'            => '',
			'text'                        => '',
			'text_color'                  => '',
			'text_top_margin'             => '',
			'link'                        => '',
			'target'                      => '_self',
			'text_padding'                => ''
		);
		$default_atts = array_merge( $default_atts, allston_eltdf_icon_collections()->getShortcodeParams() );
		$params       = shortcode_atts( $default_atts, $atts );
		
		$style = '';
		if ( !empty( $params['box_background_color'] ) ) {
			$style = 'background-color: ' . $params['box_background_color'];
		}
		
		$html = '<div class="eltdf-item-space eltdf-info-box-item-holder"><div class="eltdf-info-box-item-holder-inner" ' . allston_eltdf_get_inline_style($style) . '>';
		$html .= allston_eltdf_execute_shortcode( 'eltdf_icon_with_text', $params );
		$html .= '</div></div>';
		
		return $html;
	}
	
}