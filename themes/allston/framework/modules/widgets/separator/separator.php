<?php

class AllstonEltdfSeparatorWidget extends AllstonEltdfWidget {
	public function __construct() {
		parent::__construct(
			'eltdf_separator_widget',
			esc_html__( 'Elated Separator Widget', 'allston' ),
			array( 'description' => esc_html__( 'Add a separator element to your widget areas', 'allston' ) )
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
					'normal'     => esc_html__( 'Normal', 'allston' ),
					'full-width' => esc_html__( 'Full Width', 'allston' )
				)
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'position',
				'title'   => esc_html__( 'Position', 'allston' ),
				'options' => array(
					'center' => esc_html__( 'Center', 'allston' ),
					'left'   => esc_html__( 'Left', 'allston' ),
					'right'  => esc_html__( 'Right', 'allston' )
				)
			),
			array(
				'type'    => 'dropdown',
				'name'    => 'border_style',
				'title'   => esc_html__( 'Style', 'allston' ),
				'options' => array(
					'solid'  => esc_html__( 'Solid', 'allston' ),
					'dashed' => esc_html__( 'Dashed', 'allston' ),
					'dotted' => esc_html__( 'Dotted', 'allston' )
				)
			),
			array(
				'type'  => 'colorpicker',
				'name'  => 'color',
				'title' => esc_html__( 'Color', 'allston' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'width',
				'title' => esc_html__( 'Width (px or %)', 'allston' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'thickness',
				'title' => esc_html__( 'Thickness (px)', 'allston' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'top_margin',
				'title' => esc_html__( 'Top Margin (px or %)', 'allston' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'bottom_margin',
				'title' => esc_html__( 'Bottom Margin (px or %)', 'allston' )
			)
		);
	}
	
	public function widget( $args, $instance ) {
		if ( ! is_array( $instance ) ) {
			$instance = array();
		}
		
		//prepare variables
		$params = '';
		
		//is instance empty?
		if ( is_array( $instance ) && count( $instance ) ) {
			//generate shortcode params
			foreach ( $instance as $key => $value ) {
				$params .= " $key='$value' ";
			}
		}
		
		echo '<div class="widget eltdf-separator-widget">';
			echo do_shortcode( "[eltdf_separator $params]" ); // XSS OK
		echo '</div>';
	}
}