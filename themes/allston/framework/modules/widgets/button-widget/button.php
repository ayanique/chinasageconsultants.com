<?php

class AllstonEltdfButtonWidget extends AllstonEltdfWidget {
	public function __construct() {
		parent::__construct(
			'eltdf_button_widget',
			esc_html__( 'Elated Button Widget', 'allston' ),
			array( 'description' => esc_html__( 'Add button element to widget areas', 'allston' ) )
		);
		
		$this->setParams();
	}
	
	protected function setParams() {
		$this->params = array(
			array(
				'type'    => 'dropdown',
				'name'    => 'type',
				'title'   => esc_html__( 'Type', 'allston' ),
				'options' => array(
					'solid'   => esc_html__( 'Solid', 'allston' ),
					'outline' => esc_html__( 'Outline', 'allston' ),
					'simple'  => esc_html__( 'Simple', 'allston' )
				)
			),
			array(
				'type'        => 'dropdown',
				'name'        => 'size',
				'title'       => esc_html__( 'Size', 'allston' ),
				'options'     => array(
					'small'  => esc_html__( 'Small', 'allston' ),
					'medium' => esc_html__( 'Medium', 'allston' ),
					'large'  => esc_html__( 'Large', 'allston' ),
					'huge'   => esc_html__( 'Huge', 'allston' )
				),
				'description' => esc_html__( 'This option is only available for solid and outline button type', 'allston' )
			),
			array(
				'type'    => 'textfield',
				'name'    => 'text',
				'title'   => esc_html__( 'Text', 'allston' ),
				'default' => esc_html__( 'Button Text', 'allston' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'link',
				'title' => esc_html__( 'Link', 'allston' )
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'target',
				'title'   => esc_html__( 'Link Target', 'allston' ),
				'options' => allston_eltdf_get_link_target_array()
			),
			array(
				'type'  => 'colorpicker',
				'name'  => 'color',
				'title' => esc_html__( 'Color', 'allston' )
			),
			array(
				'type'  => 'colorpicker',
				'name'  => 'hover_color',
				'title' => esc_html__( 'Hover Color', 'allston' )
			),
			array(
				'type'        => 'colorpicker',
				'name'        => 'background_color',
				'title'       => esc_html__( 'Background Color', 'allston' ),
				'description' => esc_html__( 'This option is only available for solid button type', 'allston' )
			),
			array(
				'type'        => 'colorpicker',
				'name'        => 'hover_background_color',
				'title'       => esc_html__( 'Hover Background Color', 'allston' ),
				'description' => esc_html__( 'This option is only available for solid button type', 'allston' )
			),
			array(
				'type'        => 'colorpicker',
				'name'        => 'border_color',
				'title'       => esc_html__( 'Border Color', 'allston' ),
				'description' => esc_html__( 'This option is only available for solid and outline button type', 'allston' )
			),
			array(
				'type'        => 'colorpicker',
				'name'        => 'hover_border_color',
				'title'       => esc_html__( 'Hover Border Color', 'allston' ),
				'description' => esc_html__( 'This option is only available for solid and outline button type', 'allston' )
			),
			array(
				'type'        => 'textfield',
				'name'        => 'margin',
				'title'       => esc_html__( 'Margin', 'allston' ),
				'description' => esc_html__( 'Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'allston' )
			)
		);
	}
	
	public function widget( $args, $instance ) {
		$params = '';
		
		if ( ! is_array( $instance ) ) {
			$instance = array();
		}
		
		// Filter out all empty params
		$instance = array_filter( $instance, function ( $array_value ) {
			return trim( $array_value ) != '';
		} );
		
		// Default values
		if ( ! isset( $instance['text'] ) ) {
			$instance['text'] = 'Button Text';
		}
		
		// Generate shortcode params
		foreach ( $instance as $key => $value ) {
			$params .= " $key='$value' ";
		}
		
		echo '<div class="widget eltdf-button-widget">';
			echo do_shortcode( "[eltdf_button $params]" ); // XSS OK
		echo '</div>';
	}
}