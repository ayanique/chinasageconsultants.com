<?php
namespace AllstonCore\CPT\Shortcodes\SectionTitle;

use AllstonCore\Lib;

class SectionTitle implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'eltdf_section_title';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map( array(
				'name'                      => esc_html__( 'Section Title', 'allston-core' ),
				'base'                      => $this->base,
				'category'                  => esc_html__( 'by ALLSTON', 'allston-core' ),
				'icon'                      => 'icon-wpb-section-title extended-custom-icon',
				'allowed_container_element' => 'vc_row',
				'params'                    => array(
					array(
						'type'        => 'textfield',
						'param_name'  => 'custom_class',
						'heading'     => esc_html__( 'Custom CSS Class', 'allston-core' ),
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'type',
						'heading'     => esc_html__( 'Type', 'allston-core' ),
						'value'       => array(
							esc_html__( 'Standard', 'allston-core' )    => 'standard',
							esc_html__( 'Two Columns', 'allston-core' ) => 'two-columns'
						),
						'save_always' => true
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'title_position',
						'heading'     => esc_html__( 'Title - Text Position', 'allston-core' ),
						'value'       => array(
							esc_html__( 'Title Left - Text Right', 'allston-core' ) => 'title-left',
							esc_html__( 'Title Right - Text Left', 'allston-core' ) => 'title-right'
						),
						'save_always' => true,
						'dependency'  => array( 'element' => 'type', 'value' => array( 'two-columns' ) )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'columns_space',
						'heading'     => esc_html__( 'Space Between Columns', 'allston-core' ),
						'value'       => array(
							esc_html__( 'Normal', 'allston-core' ) => 'normal',
							esc_html__( 'Small', 'allston-core' )  => 'small',
							esc_html__( 'Tiny', 'allston-core' )   => 'tiny'
						),
						'save_always' => true,
						'dependency'  => array( 'element' => 'type', 'value' => array( 'two-columns' ) )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'position',
						'heading'     => esc_html__( 'Horizontal Position', 'allston-core' ),
						'value'       => array(
							esc_html__( 'Default', 'allston-core' ) => '',
							esc_html__( 'Left', 'allston-core' )    => 'left',
							esc_html__( 'Center', 'allston-core' )  => 'center',
							esc_html__( 'Right', 'allston-core' )   => 'right'
						),
						'save_always' => true,
						'dependency'  => array( 'element' => 'type', 'value' => array( 'standard' ) )
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'holder_padding',
						'heading'    => esc_html__( 'Holder Side Padding (px or %)', 'allston-core' )
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'title',
						'heading'     => esc_html__( 'Title', 'allston-core' ),
						'admin_label' => true
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'title_tag',
						'heading'     => esc_html__( 'Title Tag', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_title_tag( true ) ),
						'save_always' => true,
						'dependency'  => array( 'element' => 'title', 'not_empty' => true ),
						'group'       => esc_html__( 'Title Style', 'allston-core' )
					),
					array(
						'type'       => 'dropdown',
						'param_name' => 'enable_separator',
						'heading'    => esc_html__( 'Enable Separator', 'allston-core' ),
						'value'      => array_flip( allston_eltdf_get_yes_no_select_array( false, true ) ),
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'separator_top_margin',
						'heading'     => esc_html__( 'Separator Top Margin (px or %)', 'allston-core' ),
						'dependency'  => array( 'element' => 'enable_separator', 'value' => array( 'yes' ) ),
						'save_always' => true
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'separator_bottom_margin',
						'heading'    => esc_html__( 'Separator Bottom Margin (px or %)', 'allston-core' ),
						'dependency' => array( 'element' => 'enable_separator', 'value' => array( 'yes' ) ),
					),
					array(
						'type'       => 'colorpicker',
						'param_name' => 'separator_color',
						'heading'    => esc_html__( 'Separator Color', 'allston-core' ),
						'dependency' => array( 'element' => 'enable_separator', 'value' => array( 'yes' ) ),
					),
					array(
						'type'       => 'colorpicker',
						'param_name' => 'title_color',
						'heading'    => esc_html__( 'Title Color', 'allston-core' ),
						'dependency' => array( 'element' => 'title', 'not_empty' => true ),
						'group'      => esc_html__( 'Title Style', 'allston-core' )
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'title_bold_words',
						'heading'     => esc_html__( 'Words with Bold Font Weight', 'allston-core' ),
						'description' => esc_html__( 'Enter the positions of the words you would like to display in a "bold" font weight. Separate the positions with commas (e.g. if you would like the first, second, and third word to have a light font weight, you would enter "1,2,3")', 'allston-core' ),
						'dependency'  => array( 'element' => 'title', 'not_empty' => true ),
						'group'       => esc_html__( 'Title Style', 'allston-core' )
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'title_light_words',
						'heading'     => esc_html__( 'Words with Light Font Weight', 'allston-core' ),
						'description' => esc_html__( 'Enter the positions of the words you would like to display in a "light" font weight. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to have a light font weight, you would enter "1,3,4")', 'allston-core' ),
						'dependency'  => array( 'element' => 'title', 'not_empty' => true ),
						'group'       => esc_html__( 'Title Style', 'allston-core' )
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'title_break_words',
						'heading'     => esc_html__( 'Position of Line Break', 'allston-core' ),
						'description' => esc_html__( 'Enter the position of the word after which you would like to create a line break (e.g. if you would like the line break after the 3rd word, you would enter "3")', 'allston-core' ),
						'dependency'  => array( 'element' => 'title', 'not_empty' => true ),
						'group'       => esc_html__( 'Title Style', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'disable_break_words',
						'heading'     => esc_html__( 'Disable Line Break for Smaller Screens', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_yes_no_select_array( false ) ),
						'save_always' => true,
						'dependency'  => array( 'element' => 'title', 'not_empty' => true ),
						'group'       => esc_html__( 'Title Style', 'allston-core' )
					),
					array(
						'type'       => 'textarea',
						'param_name' => 'text',
						'heading'    => esc_html__( 'Text', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'text_tag',
						'heading'     => esc_html__( 'Text Tag', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_title_tag( true, array( 'p' => 'p' ) ) ),
						'save_always' => true,
						'dependency'  => array( 'element' => 'text', 'not_empty' => true ),
						'group'       => esc_html__( 'Text Style', 'allston-core' )
					),
					array(
						'type'       => 'colorpicker',
						'param_name' => 'text_color',
						'heading'    => esc_html__( 'Text Color', 'allston-core' ),
						'dependency' => array( 'element' => 'text', 'not_empty' => true ),
						'group'      => esc_html__( 'Text Style', 'allston-core' )
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'text_font_size',
						'heading'    => esc_html__( 'Text Font Size (px)', 'allston-core' ),
						'dependency' => array( 'element' => 'text', 'not_empty' => true ),
						'group'      => esc_html__( 'Text Style', 'allston-core' )
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'text_line_height',
						'heading'    => esc_html__( 'Text Line Height (px)', 'allston-core' ),
						'dependency' => array( 'element' => 'text', 'not_empty' => true ),
						'group'      => esc_html__( 'Text Style', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'text_font_weight',
						'heading'     => esc_html__( 'Text Font Weight', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_font_weight_array( true ) ),
						'save_always' => true,
						'dependency'  => array( 'element' => 'text', 'not_empty' => true ),
						'group'       => esc_html__( 'Text Style', 'allston-core' )
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'text_margin',
						'heading'    => esc_html__( 'Text Top Margin (px)', 'allston-core' ),
						'dependency' => array( 'element' => 'text', 'not_empty' => true ),
						'group'      => esc_html__( 'Text Style', 'allston-core' )
					)
				)
			) );
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'custom_class'            => '',
			'type'                    => 'standard',
			'title_position'          => 'title-left',
			'columns_space'           => 'normal',
			'position'                => '',
			'holder_padding'          => '',
			'enable_separator'        => 'yes',
			'separator_top_margin'    => '',
			'separator_bottom_margin' => '',
			'separator_color'         => '',
			'title'                   => '',
			'title_tag'               => 'h1',
			'title_color'             => '',
			'title_bold_words'        => '',
			'title_light_words'       => '',
			'title_break_words'       => '',
			'disable_break_words'     => '',
			'text'                    => '',
			'text_tag'                => 'p',
			'text_color'              => '',
			'text_font_size'          => '',
			'text_line_height'        => '',
			'text_font_weight'        => '',
			'text_margin'             => ''
		);
		$params = shortcode_atts( $args, $atts );
		
		$params['holder_classes']   = $this->getHolderClasses( $params, $args );
		$params['holder_styles']    = $this->getHolderStyles( $params );
		$params['title']            = $this->getModifiedTitle( $params );
		$params['title_tag']        = ! empty( $params['title_tag'] ) ? $params['title_tag'] : $args['title_tag'];
		$params['title_styles']     = $this->getTitleStyles( $params );
		$params['text_tag']         = ! empty( $params['text_tag'] ) ? $params['text_tag'] : $args['text_tag'];
		$params['text_styles']      = $this->getTextStyles( $params );
		$params['separator_params'] = $this->getSeparatorParams( $params );
		
		$html = allston_core_get_shortcode_module_template_part( 'templates/section-title', 'section-title', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params, $args ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = ! empty( $params['type'] ) ? 'eltdf-st-' . $params['type'] : 'eltdf-st-' . $args['type'];
		$holderClasses[] = ! empty( $params['title_position'] ) ? 'eltdf-st-' . $params['title_position'] : 'eltdf-st-' . $args['title_position'];
		$holderClasses[] = ! empty( $params['columns_space'] ) ? 'eltdf-st-' . $params['columns_space'] . '-space' : 'eltdf-st-' . $args['columns_space'] . '-space';
		$holderClasses[] = $params['disable_break_words'] === 'yes' ? 'eltdf-st-disable-title-break' : '';
		
		return implode( ' ', $holderClasses );
	}
	
	private function getHolderStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['holder_padding'] ) ) {
			$styles[] = 'padding: 0 ' . $params['holder_padding'];
		}
		
		if ( ! empty( $params['position'] ) ) {
			$styles[] = 'text-align: ' . $params['position'];
		}
		
		return implode( ';', $styles );
	}
	
	private function getModifiedTitle( $params ) {
		$title             = $params['title'];
		$title_bold_words  = str_replace( ' ', '', $params['title_bold_words'] );
		$title_light_words = str_replace( ' ', '', $params['title_light_words'] );
		$title_break_words = str_replace( ' ', '', $params['title_break_words'] );
		
		if ( ! empty( $title ) ) {
			$bold_words  = explode( ',', $title_bold_words );
			$light_words = explode( ',', $title_light_words );
			$split_title = explode( ' ', $title );
			
			if ( ! empty( $title_bold_words ) ) {
				foreach ( $bold_words as $value ) {
					if ( ! empty( $split_title[ $value - 1 ] ) ) {
						$split_title[ $value - 1 ] = '<span class="eltdf-st-title-bold">' . $split_title[ $value - 1 ] . '</span>';
					}
				}
			}
			
			if ( ! empty( $title_light_words ) ) {
				foreach ( $light_words as $value ) {
					if ( ! empty( $split_title[ $value - 1 ] ) ) {
						$split_title[ $value - 1 ] = '<span class="eltdf-st-title-light">' . $split_title[ $value - 1 ] . '</span>';
					}
				}
			}
			
			if ( ! empty( $title_break_words ) ) {
				if ( ! empty( $split_title[ $title_break_words - 1 ] ) ) {
					$split_title[ $title_break_words - 1 ] = $split_title[ $title_break_words - 1 ] . '<br />';
				}
			}
			
			$title = implode( ' ', $split_title );
		}
		
		return $title;
	}
	
	private function getTitleStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['title_color'] ) ) {
			$styles[] = 'color: ' . $params['title_color'];
		}
		
		return implode( ';', $styles );
	}
	
	private function getTextStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['text_color'] ) ) {
			$styles[] = 'color: ' . $params['text_color'];
		}
		
		if ( ! empty( $params['text_font_size'] ) ) {
			$styles[] = 'font-size: ' . allston_eltdf_filter_px( $params['text_font_size'] ) . 'px';
		}
		
		if ( ! empty( $params['text_line_height'] ) ) {
			$styles[] = 'line-height: ' . allston_eltdf_filter_px( $params['text_line_height'] ) . 'px';
		}
		
		if ( ! empty( $params['text_font_weight'] ) ) {
			$styles[] = 'font-weight: ' . $params['text_font_weight'];
		}
		
		if ( $params['text_margin'] !== '' ) {
			$styles[] = 'margin-top: ' . allston_eltdf_filter_px( $params['text_margin'] ) . 'px';
		}
		
		return implode( ';', $styles );
	}
	
	private function getSeparatorParams( $params ) {
		$separator_params = array();
		
		if ( ! empty( $params['separator_top_margin'] ) ) {
			$separator_params['top_margin'] = $params['separator_top_margin'];
		}
		
		if ( ! empty( $params['separator_bottom_margin'] ) ) {
			$separator_params['bottom_margin'] = $params['separator_bottom_margin'];
		}
		
		if ( ! empty( $params['separator_color'] ) ) {
			$separator_params['color'] = $params['separator_color'];
		}
		
		return $separator_params;
	}
}