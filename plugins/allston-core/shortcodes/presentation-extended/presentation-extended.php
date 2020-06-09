<?php
namespace AllstonCore\CPT\Shortcodes\PresentationExtended;

use AllstonCore\Lib;

class PresentationExtended implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'eltdf_presentation_extended';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map( array(
				'name'                      => esc_html__( 'Presentation Extended', 'allston-core' ),
				'base'                      => $this->getBase(),
				'category'                  => esc_html__( 'by ALLSTON', 'allston-core' ),
				'icon'                      => 'icon-wpb-presentation-extended extended-custom-icon',
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
						'heading'     => esc_html__( 'Presentation Type', 'allston-core' ),
						'value'       => array(
							esc_html__( 'Image - Content - Slider', 'allston-core' ) => 'slider-right',
							esc_html__( 'Slider - Content - Image', 'allston-core' ) => 'slider-left'
						),
						'save_always' => true
					),
					array(
						'type'       => 'colorpicker',
						'param_name' => 'background_color',
						'heading'    => esc_html__( 'Background Color', 'allston-core' ),
						'group'      => esc_html__( 'Content', 'allston-core' )
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'title',
						'heading'    => esc_html__( 'Title', 'allston-core' ),
						'group'      => esc_html__( 'Content', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'title_tag',
						'heading'     => esc_html__( 'Title Tag', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_title_tag( true ) ),
						'save_always' => true,
						'dependency'  => array( 'element' => 'title', 'not_empty' => true ),
						'group'       => esc_html__( 'Content', 'allston-core' )
					),
					array(
						'type'       => 'dropdown',
						'param_name' => 'enable_separator',
						'heading'    => esc_html__( 'Enable Separator', 'allston-core' ),
						'value'      => array_flip( allston_eltdf_get_yes_no_select_array( true, true ) ),
						'group'      => esc_html__( 'Content', 'allston-core' )
					),
					array(
						'type'       => 'textarea',
						'param_name' => 'text',
						'heading'    => esc_html__( 'Text', 'allston-core' ),
						'group'      => esc_html__( 'Content', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'content_type',
						'heading'     => esc_html__( 'Content Type', 'allston-core' ),
						'value'       => array(
							esc_html__( 'List Items', 'allston-core' )      => 'list-items',
							esc_html__( 'Signature Image', 'allston-core' ) => 'signature-image'
						),
						'save_always' => true,
						'group'       => esc_html__( 'Content', 'allston-core' )
					),
					array(
						'type'       => 'attach_image',
						'param_name' => 'signature_image',
						'heading'    => esc_html__( 'Signature Image', 'allston-core' ),
						'dependency' => array(
							'element' => 'content_type',
							'value'   => array( 'signature-image' )
						),
						'group'      => esc_html__( 'Content', 'allston-core' )
					),
					array(
						'type'       => 'param_group',
						'heading'    => esc_html__( 'List Items', 'allston-core' ),
						'param_name' => 'list_items',
						'value'      => '',
						'params'     => array(
							array(
								'type'       => 'textfield',
								'param_name' => 'text',
								'heading'    => esc_html__( 'Text', 'allston-core' )
							)
						),
						'dependency' => array(
							'element' => 'content_type',
							'value'   => array( 'list-items' )
						),
						'group'      => esc_html__( 'Content', 'allston-core' )
					),
					array(
						'type'        => 'attach_images',
						'param_name'  => 'small_gal_images',
						'heading'     => esc_html__( 'Small Images', 'allston-core' ),
						'description' => esc_html__( 'Select images from media library', 'allston-core' ),
						'group'       => esc_html__( 'Content', 'allston-core' )
					),
					array(
						'type'       => 'attach_image',
						'param_name' => 'section_image',
						'heading'    => esc_html__( 'Section Image', 'allston-core' ),
						'group'      => esc_html__( 'Image', 'allston-core' )
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'product_title',
						'heading'    => esc_html__( 'Product Title', 'allston-core' ),
						'group'      => esc_html__( 'Image', 'allston-core' )
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'product_description',
						'heading'    => esc_html__( 'Product Description', 'allston-core' ),
						'group'      => esc_html__( 'Image', 'allston-core' )
					),
					array(
						'type'       => 'textfield',
						'param_name' => 'product_price',
						'heading'    => esc_html__( 'Product Price', 'allston-core' ),
						'group'      => esc_html__( 'Image', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'info_position',
						'heading'     => esc_html__( 'Info Position', 'allston-core' ),
						'value'       => array(
							esc_html__( 'Top', 'allston-core' )    => 'top',
							esc_html__( 'Bottom', 'allston-core' ) => 'bottom'
						),
						'save_always' => true,
						'group'       => esc_html__( 'Image', 'allston-core' )
					),
					array(
						'type'        => 'attach_images',
						'param_name'  => 'slider_images',
						'heading'     => esc_html__( 'Images', 'allston-core' ),
						'description' => esc_html__( 'Select images from media library', 'allston-core' ),
						'group'       => esc_html__( 'Slider', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'slider_loop',
						'heading'     => esc_html__( 'Enable Slider Loop', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_yes_no_select_array( false, true ) ),
						'save_always' => true,
						'group'       => esc_html__( 'Slider', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'slider_autoplay',
						'heading'     => esc_html__( 'Enable Slider Autoplay', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_yes_no_select_array( false, true ) ),
						'save_always' => true,
						'group'       => esc_html__( 'Slider', 'allston-core' )
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'slider_speed',
						'heading'     => esc_html__( 'Slide Duration', 'allston-core' ),
						'description' => esc_html__( 'Default value is 5000 (ms)', 'allston-core' ),
						'group'       => esc_html__( 'Slider', 'allston-core' )
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'slider_speed_animation',
						'heading'     => esc_html__( 'Slide Animation Duration', 'allston-core' ),
						'description' => esc_html__( 'Speed of slide animation in milliseconds. Default value is 600.', 'allston-core' ),
						'group'       => esc_html__( 'Slider', 'allston-core' )
					),
					array(
						'type'        => 'dropdown',
						'param_name'  => 'slider_navigation',
						'heading'     => esc_html__( 'Enable Slider Navigation Arrows', 'allston-core' ),
						'value'       => array_flip( allston_eltdf_get_yes_no_select_array( false, true ) ),
						'save_always' => true,
						'group'       => esc_html__( 'Slider', 'allston-core' )
					),
					array(
						'type'        => 'colorpicker',
						'param_name'  => 'slider_uncover_mask',
						'heading'     => esc_html__( 'Slider Uncover Mask', 'allston-core' ),
						'group'       => esc_html__( 'Slider', 'allston-core' )
					),
				)
			) );
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'custom_class'           => '',
			'type'                   => 'slider-right',
			'background_color'       => '',
			'title'                  => '',
			'title_tag'              => 'h1',
			'enable_separator'       => 'yes',
			'text'                   => '',
			'content_type'           => 'list-items',
			'signature_image'        => '',
			'list_items'             => '',
			'small_gal_images'       => '',
			'section_image'          => '',
			'product_title'          => '',
			'product_description'    => '',
			'product_price'          => '',
			'info_position'          => 'top',
			'slider_images'          => 'slider_images',
			'slider_loop'            => 'yes',
			'slider_autoplay'        => 'yes',
			'slider_speed'           => '5000',
			'slider_speed_animation' => '600',
			'slider_navigation'      => 'yes',
			'slider_uncover_mask'	 => ''
		
		);
		$params = shortcode_atts( $args, $atts );
		
		$params['holder_classes']        = $this->getHolderClasses( $params, $args );
		$params['title_tag']             = ! empty( $params['title_tag'] ) ? $params['title_tag'] : $args['title_tag'];
		$params['list_items']            = json_decode( urldecode( $params['list_items'] ), true );
		$params['content_holder_styles'] = $this->getContentHolderStyles( $params );
		$params['small_gal_images']      = $this->getGalleryImages( $params, 'small_gal_images' );
		$params['image_holder_styles']   = $this->getImageHolderStyles( $params['section_image'] );
		$params['slider_data']           = $this->getSliderData( $params );
		$params['slider_images']         = $this->getGalleryImages( $params, 'slider_images' );
		$params['slider_mask_styles']    = $this->getSliderMaskStyles( $params );
		
		$params['this_object'] = $this;
		
		$html = allston_core_get_shortcode_module_template_part( 'templates/pe-holder', 'presentation-extended', '', $params );
		
		return $html;
	}
	
	public function getHolderClasses( $params, $args ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = ! empty( $params['type'] ) ? 'eltdf-pe-type-' . esc_attr( $params['type'] ) : 'eltdf-pe-type-slider-right';
		$holderClasses[] = ! empty( $params['info_position'] ) ? 'eltdf-pe-info-pos-' . esc_attr( $params['info_position'] ) : 'eltdf-pe-info-pos-top';
		$holderClasses[] = ! empty( $params['slider_uncover_mask'] ) ? 'eltdf-pe-slider-uncover' : '';

		return implode( ' ', $holderClasses );
	}
	
	public function getContentHolderStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['background_color'] ) ) {
			$styles[] = 'background-color: ' . $params['background_color'];
		}
		
		return implode( ';', $styles );
	}

	public function getSliderMaskStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['slider_uncover_mask'] ) ) {
			$styles[] = 'background-color: ' . $params['slider_uncover_mask'];
		}
		
		return implode( ';', $styles );
	}
	
	public function getGalleryImages( $params, $field ) {
		$image_ids = array();
		$images    = array();
		$i         = 0;
		
		if ( $params[$field] !== '' ) {
			$image_ids = explode( ',', $params[$field] );
		}
		
		foreach ( $image_ids as $id ) {
			
			$image['image_id'] = $id;
			$image_original    = wp_get_attachment_image_src( $id, 'full' );
			$image['url']      = $image_original[0];
			$image['title']    = get_the_title( $id );
			$image['alt']      = get_post_meta( $id, '_wp_attachment_image_alt', true );
			
			$images[ $i ] = $image;
			$i ++;
		}
		
		return $images;
	}
	
	public function getImageHolderStyles( $image ) {
		$styles = array();
		if ( ! empty( $image ) ) {
			$styles[] = 'background-image: url(' . wp_get_attachment_url( $image ) . ')';
		}
		
		return implode( ';', $styles );
	}
	
	public function getSliderData( $params ) {
		$slider_data = array();
		
		$slider_data['data-number-of-items']        = '1';
		$slider_data['data-enable-loop']            = ! empty( $params['slider_loop'] ) ? $params['slider_loop'] : '';
		$slider_data['data-enable-autoplay']        = ! empty( $params['slider_autoplay'] ) ? $params['slider_autoplay'] : '';
		$slider_data['data-slider-speed']           = ! empty( $params['slider_speed'] ) ? $params['slider_speed'] : '5000';
		$slider_data['data-slider-speed-animation'] = ! empty( $params['slider_speed_animation'] ) ? $params['slider_speed_animation'] : '600';
		$slider_data['data-enable-navigation']      = ! empty( $params['slider_navigation'] ) ? $params['slider_navigation'] : '';
		$slider_data['data-enable-pagination']      = 'no';
		
		return $slider_data;
	}
}