<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Testimonial_For_Elementor_Widget extends Widget_Base {

    public function get_name() {
        return 'testimonial-fe-addons';
    }
    
    public function get_title() {
        return esc_html__( 'Testimonial For Elementor', 'testimonial-fe' );
    }

    public function get_icon() {
        return 'eicon-comments';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'testimonial_content_section',
            [
                'label' => esc_html__( 'Testimonial', 'testimonial-fe' ),
            ]
        );

            $this->add_control(
                'testimonial_style',
                [
                    'label' => esc_html__( 'Style', 'testimonial-fe' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1'   => esc_html__( 'Style One', 'testimonial-fe' ),
                        '2'   => esc_html__( 'Style Two', 'testimonial-fe' ),
                        '3'   => esc_html__( 'Style Three', 'testimonial-fe' ),
                        '4'   => esc_html__( 'Style Four', 'testimonial-fe' ),
                        '5'   => esc_html__( 'Style Five', 'testimonial-fe' ),
                        '6'   => esc_html__( 'Style Six', 'testimonial-fe' ),
                        '7'   => esc_html__( 'Style Seven', 'testimonial-fe' ),
                        '8'   => esc_html__( 'Style Eight', 'testimonial-fe' ),
                        '9'   => esc_html__( 'Style Nine', 'testimonial-fe' ),
                    ],
                ]
            );

            $this->add_control(
                'slider_on',
                [
                    'label' => esc_html__( 'Slider', 'testimonial-fe' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'separator'=>'before',
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'client_name',
                [
                    'label'   => esc_html__( 'Name', 'testimonial-fe' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => esc_html__('Ahnaf Abid Al','testimonial-fe'),
                ]
            );

            $repeater->add_control(
                'client_image',
                [
                    'label' => esc_html__( 'Image', 'testimonial-fe' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

            $repeater->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'client_imagesize',
                    'default' => 'large',
                    'separator' => 'none',
                ]
            );

            $repeater->add_control(
                'client_designation',
                [
                    'label'   => esc_html__( 'Designation', 'testimonial-fe' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => esc_html__('Developer','testimonial-fe'),
                ]
            );

            $repeater->add_control(
                'client_say',
                [
                    'label'   => esc_html__( 'Client Say', 'testimonial-fe' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => esc_html__('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur Excepteur sint occaecat.','testimonial-fe'),
                ]
            );

            $this->add_control(
                'testimonial_list',
                [
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => array_values( $repeater->get_controls() ),
                    'default' => [
                        [
                            'client_name'           => esc_html__('Ahnaf Abid Towhid','testimonial-fe'),
                            'client_designation'    => esc_html__( 'Developer','testimonial-fe' ),
                            'client_say'            => esc_html__( 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable If you are going to use a passage.', 'testimonial-fe' ),
                        ],
                        [
                            'client_name'           => esc_html__('Tamjid Farhana','testimonial-fe'),
                            'client_designation'    => esc_html__( 'Manager','testimonial-fe' ),
                            'client_say'            => esc_html__( 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable If you are going to use a passage.', 'testimonial-fe' ),
                        ],
                        [
                            'client_name'           => esc_html__('Abid Al Raiyan','testimonial-fe'),
                            'client_designation'    => esc_html__( 'Director','testimonial-fe' ),
                            'client_say'            => esc_html__( 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable If you are going to use a passage.', 'testimonial-fe' ),
                        ],
                    ],
                    'title_field' => '{{{ client_name }}}',
                ]
            );

            $this->add_control(
                'client_image_divider',
                [
                    'label' => esc_html__( 'Divider image', 'testimonial-fe' ),
                    'type' => Controls_Manager::MEDIA,
                    'separator' => 'before',
                    'condition' =>[
                        'testimonial_style!' =>'4'
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'client_image_divider_size',
                    'default' => 'large',
                    'separator' => 'none',
                ]
            );

        $this->end_controls_section();

        // Slider setting
        $this->start_controls_section(
            'testimonial-slider-option',
            [
                'label' => esc_html__( 'Slider Option', 'testimonial-fe' ),
                'condition' => [
                    'slider_on' => 'yes',
                ]
            ]
        );

            $this->add_control(
                'slitems',
                [
                    'label' => esc_html__( 'Slider Items', 'testimonial-fe' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slarrows',
                [
                    'label' => esc_html__( 'Slider Arrow', 'testimonial-fe' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slprevicon',
                [
                    'label' => esc_html__( 'Previous icon', 'testimonial-fe' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-angle-left',
                        'library'=>'solid',
                    ],
                    'condition' => [
                        'slider_on' => 'yes',
                        'slarrows' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slnexticon',
                [
                    'label' => esc_html__( 'Next icon', 'testimonial-fe' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-angle-right',
                        'library'=>'solid',
                    ],
                    'condition' => [
                        'slider_on' => 'yes',
                        'slarrows' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'sldots',
                [
                    'label' => esc_html__( 'Slider dots', 'testimonial-fe' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slpause_on_hover',
                [
                    'type' => Controls_Manager::SWITCHER,
                    'label_off' => esc_html__( 'No', 'testimonial-fe'),
                    'label_on' => esc_html__( 'Yes', 'testimonial-fe'),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'label' => esc_html__( 'Pause on Hover?', 'testimonial-fe'),
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slcentermode',
                [
                    'label' => esc_html__( 'Center Mode', 'testimonial-fe' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slcenterpadding',
                [
                    'label' => esc_html__( 'Center padding', 'testimonial-fe' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                    'default' => 50,
                    'condition' => [
                        'slider_on' => 'yes',
                        'slcentermode' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slautolay',
                [
                    'label' => esc_html__( 'Slider auto play', 'testimonial-fe' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'separator' => 'before',
                    'default' => 'no',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slautoplay_speed',
                [
                    'label' => esc_html__('Autoplay speed', 'testimonial-fe'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 3000,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slanimation_speed',
                [
                    'label' => esc_html__('Autoplay animation speed', 'testimonial-fe'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 300,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slscroll_columns',
                [
                    'label' => esc_html__('Slider item to scroll', 'testimonial-fe'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'heading_tablet',
                [
                    'label' => esc_html__( 'Tablet', 'testimonial-fe' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'sltablet_display_columns',
                [
                    'label' => esc_html__('Slider Items', 'testimonial-fe'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'sltablet_scroll_columns',
                [
                    'label' => esc_html__('Slider item to scroll', 'testimonial-fe'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'sltablet_width',
                [
                    'label' => esc_html__('Tablet Resolution', 'testimonial-fe'),
                    'description' => esc_html__('The resolution to tablet.', 'testimonial-fe'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 750,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'heading_mobile',
                [
                    'label' => esc_html__( 'Mobile Phone', 'testimonial-fe' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slmobile_display_columns',
                [
                    'label' => esc_html__('Slider Items', 'testimonial-fe'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slmobile_scroll_columns',
                [
                    'label' => esc_html__('Slider item to scroll', 'testimonial-fe'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slmobile_width',
                [
                    'label' => esc_html__('Mobile Resolution', 'testimonial-fe'),
                    'description' => esc_html__('The resolution to mobile.', 'testimonial-fe'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 480,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

        $this->end_controls_section(); 
        // Slider Option end

        // Style Testimonial area tab section
        $this->start_controls_section(
            'testimonial_style_area',
            [
                'label' => esc_html__( 'Style', 'testimonial-fe' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_responsive_control(
                'testimonial_section_margin',
                [
                    'label' => esc_html__( 'Margin', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'testimonial_section_padding',
                [
                    'label' => esc_html__( 'Padding', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section();

        // Style Testimonial image style start
        $this->start_controls_section(
            'testimonial_image_style',
            [
                'label'     => esc_html__( 'Image', 'testimonial-fe' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'testimonial_image_border',
                    'label' => esc_html__( 'Border', 'testimonial-fe' ),
                    'selector' => '{{WRAPPER}} .testimonal-image img',
                ]
            );

            $this->add_responsive_control(
                'testimonial_image_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .testimonal-image img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_responsive_control(
                'testimonial_image_margin',
                [
                    'label' => esc_html__( 'Margin', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .testimonal img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .tfe-testimonial-style-5 .tfe-testimonal-nav .slick-track' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'testimonial_image_padding',
                [
                    'label' => esc_html__( 'Padding', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .testimonal img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section(); 
        // Style Testimonial image style end

        // Style Testimonial name style start
        $this->start_controls_section(
            'testimonial_name_style',
            [
                'label'     => esc_html__( 'Name', 'testimonial-fe' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_responsive_control(
                'testimonial_name_align',
                [
                    'label' => esc_html__( 'Alignment', 'testimonial-fe' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => esc_html__( 'Justified', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content h4' => 'text-align: {{VALUE}};',
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .clint-info h4' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'center',
                    'separator' =>'before',
                ]
            );

            $this->add_control(
                'testimonial_name_color',
                [
                    'label' => esc_html__( 'Color', 'testimonial-fe' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#3e3e3e',
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content h4' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .clint-info h4' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'testimonial_name_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .tfe-testimonial-area .testimonal .content h4, {{WRAPPER}} .tfe-testimonial-area .testimonal .clint-info h4',
                ]
            );

            $this->add_responsive_control(
                'testimonial_name_margin',
                [
                    'label' => esc_html__( 'Margin', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} {{WRAPPER}} .tfe-testimonial-area .testimonal .clint-info h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'testimonial_name_padding',
                [
                    'label' => esc_html__( 'Padding', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} {{WRAPPER}} .tfe-testimonial-area .testimonal .clint-info h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section(); 
        // Style Testimonial name style end

        // Style Testimonial designation style start
        $this->start_controls_section(
            'testimonial_designation_style',
            [
                'label'     => esc_html__( 'Designation', 'testimonial-fe' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_responsive_control(
                'testimonial_designation_align',
                [
                    'label' => esc_html__( 'Alignment', 'testimonial-fe' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => esc_html__( 'Justified', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content' => 'text-align: {{VALUE}};',
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .clint-info' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'center',
                    'separator' =>'before',
                ]
            );

            $this->add_control(
                'testimonial_designation_color',
                [
                    'label' => esc_html__( 'Color', 'testimonial-fe' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#3e3e3e',
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content span' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .clint-info span' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'testimonial_designation_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .tfe-testimonial-area .testimonal .content span, {{WRAPPER}} .tfe-testimonial-area .testimonal .clint-info span',
                ]
            );

            $this->add_responsive_control(
                'testimonial_designation_margin',
                [
                    'label' => esc_html__( 'Margin', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .clint-info span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'testimonial_designation_padding',
                [
                    'label' => esc_html__( 'Padding', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .clint-info span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section(); 
        // Style Testimonial designation style end

        // Style Testimonial designation style start
        $this->start_controls_section(
            'testimonial_clientsay_style',
            [
                'label'     => esc_html__( 'Client say', 'testimonial-fe' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_responsive_control(
                'testimonial_clientsay_align',
                [
                    'label' => esc_html__( 'Alignment', 'testimonial-fe' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => esc_html__( 'Justified', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content p' => 'text-align: {{VALUE}};',
                        '{{WRAPPER}} .tfe-testimonial-area .tfe-testimonial-for .testimonial-desc p' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'center',
                    'separator' =>'before',
                ]
            );

            $this->add_control(
                'testimonial_clientsay_color',
                [
                    'label' => esc_html__( 'Color', 'testimonial-fe' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#3e3e3e',
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content p' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .tfe-testimonial-area .tfe-testimonial-for .testimonial-desc p' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'testimonial_clientsay_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .tfe-testimonial-area .testimonal .content p, {{WRAPPER}} .tfe-testimonial-area .tfe-testimonial-for .testimonial-desc p',
                ]
            );

            $this->add_responsive_control(
                'testimonial_clientsay_margin',
                [
                    'label' => esc_html__( 'Margin', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .tfe-testimonial-area .tfe-testimonial-for .testimonial-desc p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'testimonial_clientsay_padding',
                [
                    'label' => esc_html__( 'Padding', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .tfe-testimonial-area .tfe-testimonial-for .testimonial-desc p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section(); 
        // Style Testimonial designation style end

        // Style Content style start
        $this->start_controls_section(
            'testimonial_cntntbx_style',
            [
                'label'     => esc_html__( 'Content Box', 'testimonial-fe' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'testimonial_cntntbx_align',
                [
                    'label' => esc_html__( 'Alignment', 'testimonial-fe' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => esc_html__( 'Justified', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'center',
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'testimonial_cntntbx_margin',
                [
                    'label' => esc_html__( 'Margin', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'testimonial_cntntbx_padding',
                [
                    'label' => esc_html__( 'Padding', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tfe-testimonial-area .testimonal .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section(); 
        // Style Content style end

        // Style Divider Shape style start
        $this->start_controls_section(
            'testimonial_dvdrshp_style',
            [
                'label'     => esc_html__( 'Divider/Shape Style', 'testimonial-fe' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'testimonial_dvdrshp_align',
                [
                    'label' => esc_html__( 'Alignment', 'testimonial-fe' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => esc_html__( 'Justified', 'testimonial-fe' ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .testimonal .shape img' => 'text-align: {{VALUE}};',
                        '{{WRAPPER}} .testimonal .shape' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'center',
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'testimonial_dvdrshp_margin',
                [
                    'label' => esc_html__( 'Margin', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .testimonal .shape img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .testimonal .shape' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'testimonial_dvdrshp_padding',
                [
                    'label' => esc_html__( 'Padding', 'testimonial-fe' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .testimonal .shape img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .testimonal .shape' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section(); 
        // Style Divider Shape style end

        // Style Testimonial arrow style start
        $this->start_controls_section(
            'testimonial_arrow_style',
            [
                'label'     => esc_html__( 'Arrow', 'testimonial-fe' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'slider_on' => 'yes',
                    'slarrows'  => 'yes',
                ],
            ]
        );
            
            $this->start_controls_tabs( 'testimonial_arrow_style_tabs' );

                // Normal tab Start
                $this->start_controls_tab(
                    'testimonial_arrow_style_normal_tab',
                    [
                        'label' => esc_html__( 'Normal', 'testimonial-fe' ),
                    ]
                );

                    $this->add_control(
                        'testimonial_arrow_color',
                        [
                            'label' => esc_html__( 'Color', 'testimonial-fe' ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Scheme_Color::get_type(),
                                'value' => Scheme_Color::COLOR_1,
                            ],
                            'default' => '#7d7d7d',
                            'selectors' => [
                                '{{WRAPPER}} .tfe-testimonial-area .slick-arrow' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'testimonial_arrow_fontsize',
                        [
                            'label' => esc_html__( 'Font Size', 'testimonial-fe' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 100,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 20,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .tfe-testimonial-area .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'testimonial_arrow_background',
                            'label' => esc_html__( 'Background', 'testimonial-fe' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .tfe-testimonial-area .slick-arrow',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'testimonial_arrow_border',
                            'label' => esc_html__( 'Border', 'testimonial-fe' ),
                            'selector' => '{{WRAPPER}} .tfe-testimonial-area .slick-arrow',
                        ]
                    );

                    $this->add_responsive_control(
                        'testimonial_arrow_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'testimonial-fe' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .tfe-testimonial-area .slick-arrow' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'testimonial_arrow_height',
                        [
                            'label' => esc_html__( 'Height', 'testimonial-fe' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 36,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .tfe-testimonial-area .slick-arrow' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'testimonial_arrow_width',
                        [
                            'label' => esc_html__( 'Width', 'testimonial-fe' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 36,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .tfe-testimonial-area .slick-arrow' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'testimonial_arrow_padding',
                        [
                            'label' => esc_html__( 'Padding', 'testimonial-fe' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .tfe-testimonial-area .slick-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                $this->end_controls_tab(); 
                // Normal tab end

                // Hover tab Start
                $this->start_controls_tab(
                    'testimonial_arrow_style_hover_tab',
                    [
                        'label' => esc_html__( 'Hover', 'testimonial-fe' ),
                    ]
                );

                    $this->add_control(
                        'testimonial_arrow_hover_color',
                        [
                            'label' => esc_html__( 'Color', 'testimonial-fe' ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Scheme_Color::get_type(),
                                'value' => Scheme_Color::COLOR_1,
                            ],
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .tfe-testimonial-area .slick-arrow:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'testimonial_arrow_hover_background',
                            'label' => esc_html__( 'Background', 'testimonial-fe' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .tfe-testimonial-area .slick-arrow:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'testimonial_arrow_hover_border',
                            'label' => esc_html__( 'Border', 'testimonial-fe' ),
                            'selector' => '{{WRAPPER}} .tfe-testimonial-area .slick-arrow:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'testimonial_arrow_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'testimonial-fe' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .tfe-testimonial-area .slick-arrow:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section(); // Style Testimonial arrow style end


        // Style Testimonial Dots style start
        $this->start_controls_section(
            'testimonial_dots_style',
            [
                'label'     => esc_html__( 'Pagination', 'testimonial-fe' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'slider_on' => 'yes',
                    'sldots'  => 'yes',
                ],
            ]
        );
            
            $this->start_controls_tabs( 'testimonial_dots_style_tabs' );

                // Normal tab Start
                $this->start_controls_tab(
                    'testimonial_dots_style_normal_tab',
                    [
                        'label' => esc_html__( 'Normal', 'testimonial-fe' ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'testimonial_dots_background',
                            'label' => esc_html__( 'Background', 'testimonial-fe' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .tfe-testimonial-area .slick-dots li button',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'testimonial_dots_border',
                            'label' => esc_html__( 'Border', 'testimonial-fe' ),
                            'selector' => '{{WRAPPER}} .tfe-testimonial-area .slick-dots li button',
                        ]
                    );

                    $this->add_responsive_control(
                        'testimonial_dots_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'testimonial-fe' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .tfe-testimonial-area .slick-dots li button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'testimonial_dots_height',
                        [
                            'label' => esc_html__( 'Height', 'testimonial-fe' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 12,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .tfe-testimonial-area .slick-dots li button' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'testimonial_dots_width',
                        [
                            'label' => esc_html__( 'Width', 'testimonial-fe' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 12,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .tfe-testimonial-area .slick-dots li button' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab(); 
                // Normal tab end

                // Hover tab Start
                $this->start_controls_tab(
                    'testimonial_dots_style_hover_tab',
                    [
                        'label' => esc_html__( 'Active', 'testimonial-fe' ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'testimonial_dots_hover_background',
                            'label' => esc_html__( 'Background', 'testimonial-fe' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .tfe-testimonial-area .slick-dots li.slick-active button',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'testimonial_dots_hover_border',
                            'label' => esc_html__( 'Border', 'testimonial-fe' ),
                            'selector' => '{{WRAPPER}} .tfe-testimonial-area .slick-dots li.slick-active button',
                        ]
                    );

                    $this->add_responsive_control(
                        'testimonial_dots_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'testimonial-fe' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .tfe-testimonial-area .slick-dots li.slick-active button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section(); // Style Testimonial dots style end

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        $slider_settings = [
            'arrows' => ('yes' === $settings['slarrows']),
            'arrow_prev_txt' => Tfe_Icon_manager::render_icon( $settings['slprevicon'], [ 'aria-hidden' => 'true' ] ),
            'arrow_next_txt' => Tfe_Icon_manager::render_icon( $settings['slnexticon'], [ 'aria-hidden' => 'true' ] ),
            'dots' => ('yes' === $settings['sldots']),
            'autoplay' => ('yes' === $settings['slautolay']),
            'autoplay_speed' => absint($settings['slautoplay_speed']),
            'animation_speed' => absint($settings['slanimation_speed']),
            'pause_on_hover' => ('yes' === $settings['slpause_on_hover']),
            'center_mode' => ( 'yes' === $settings['slcentermode']),
            'center_padding' => absint($settings['slcenterpadding']),
            'testimonial_style_ck' => absint( $settings['testimonial_style'] ),
        ];

        $slider_responsive_settings = [
            'display_columns' => $settings['slitems'],
            'scroll_columns' => $settings['slscroll_columns'],
            'tablet_width' => $settings['sltablet_width'],
            'tablet_display_columns' => $settings['sltablet_display_columns'],
            'tablet_scroll_columns' => $settings['sltablet_scroll_columns'],
            'mobile_width' => $settings['slmobile_width'],
            'mobile_display_columns' => $settings['slmobile_display_columns'],
            'mobile_scroll_columns' => $settings['slmobile_scroll_columns'],

        ];

        $slider_settings = array_merge( $slider_settings, $slider_responsive_settings );


        $this->add_render_attribute( 'testimonial_area_attr', 'class', 'tfe-testimonial-area' );
        $this->add_render_attribute( 'testimonial_area_attr', 'class', 'tfe-testimonial-style-'.$settings['testimonial_style'] );

        if( $settings['slider_on'] == 'yes'){
            $this->add_render_attribute( 'testimonial_area_attr', 'class', 'tfe-testimonial-activation' );   
            $this->add_render_attribute( 'testimonial_area_attr', 'data-settings', wp_json_encode( $slider_settings ) );   
        }

        if( ( $settings['testimonial_style'] == 3 || $settings['testimonial_style'] == 9 ) && $settings['slider_on'] != 'yes' ){
            $this->add_render_attribute( 'testimonial_area_attr', 'class', 'htb-row' );
        }

        ?>
            <div <?php echo $this->get_render_attribute_string( 'testimonial_area_attr' ); ?>>

                <?php if( $settings['testimonial_style'] == 5 ): ?>

                    <div class="tfe-testimonial-for">
                        <?php 
                            foreach ( $settings['testimonial_list'] as $testimonial ){
                                if( !empty($testimonial['client_say']) ){
                                    echo '<div class="testimonial-desc"><p>'.esc_html__( $testimonial['client_say'],'testimonial-fe' ).'</p></div>';
                                }
                            }
                        ?>
                    </div>

                    <!-- Start Testimonial Nav -->
                    <div class="tfe-testimonal-nav">
                        <?php foreach ( $settings['testimonial_list'] as $testimonial ) :?>
                            <div class="testimonal-img testimonal">
                                <?php
                                    if( !empty($testimonial['client_image']['url']) ){
                                        echo '<div class="testimonal-image">'.Group_Control_Image_Size::get_attachment_image_html( $testimonial, 'client_imagesize', 'client_image' ).'</div>';
                                    } 
                                ?>
                                <div class="content">
                                    <?php
                                        if( !empty($testimonial['client_name']) ){
                                            echo '<h4>'.esc_html__( $testimonial['client_name'],'testimonial-fe' ).'</h4>';
                                        }
                                        if( !empty($testimonial['client_designation']) ){
                                            echo '<span>'.esc_html__( $testimonial['client_designation'],'testimonial-fe' ).'</span>';
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- End Testimonial Nav -->
                    <div class="testimonial-shape">
                        <?php
                            if( !empty( $settings['client_image_divider']['url'] ) ){
                                echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'client_image_divider_size', 'client_image_divider' );
                            }
                        ?>
                    </div>

                <?php
                    else: 
                        foreach ( $settings['testimonial_list'] as $testimonial ) :
                            if( ($settings['testimonial_style'] == 3) && $settings['slider_on'] != 'yes'){ echo '<div class="htb-col-lg-6 htb-col-xl-6 htb-col-sm-12 htb-col-12">';}
                ?>
                    <?php if( $settings['testimonial_style'] == 6 ): ?>
                        <div class="testimonal">
                            <div class="content">
                                <?php
                                    if( !empty($testimonial['client_say']) ){
                                        echo '<p>'.esc_html__( $testimonial['client_say'],'testimonial-fe' ).'</p>';
                                    }
                                ?>
                                <div class="triangle"></div>
                            </div>
                            <div class="clint-info">
                                <?php
                                    if( !empty($testimonial['client_image']['url']) ){
                                        echo '<div class="testimonal-image">'.Group_Control_Image_Size::get_attachment_image_html( $testimonial, 'client_imagesize', 'client_image' ).'</div>';
                                    } 

                                    if( !empty($settings['client_image_divider']['url']) ){
                                        echo '<div class="shape">'.Group_Control_Image_Size::get_attachment_image_html( $settings, 'client_image_divider_size', 'client_image_divider' ).'</div>';
                                    }

                                    if( !empty($testimonial['client_name']) ){
                                        echo '<h4>'.esc_html__( $testimonial['client_name'],'testimonial-fe' ).'</h4>';
                                    }
                                    if( !empty($testimonial['client_designation']) ){
                                        echo '<span>'.esc_html__( $testimonial['client_designation'],'testimonial-fe' ).'</span>';
                                    }
                                ?>
                            </div>
                        </div>

                    <?php elseif( $settings['testimonial_style'] == 7 ): ?>
                        <div class="testimonal">
                            <?php
                                if( !empty($testimonial['client_image']['url']) ){
                                    echo '<div class="testimonal-image">'.Group_Control_Image_Size::get_attachment_image_html( $testimonial, 'client_imagesize', 'client_image' ).'</div>';
                                } 

                                if( !empty($settings['client_image_divider']['url']) ){
                                    echo '<div class="shape">'.Group_Control_Image_Size::get_attachment_image_html( $settings, 'client_image_divider_size', 'client_image_divider' ).'</div>';
                                }
                                if( !empty($testimonial['client_say']) ){
                                    echo ' <div class="content"><p>'.esc_html__( $testimonial['client_say'],'testimonial-fe' ).'</p></div>';
                                }
                            ?>
                            <div class="clint-info">
                                <?php
                                    if( !empty($testimonial['client_name']) ){
                                        echo '<h4>'.esc_html__( $testimonial['client_name'],'testimonial-fe' ).'</h4>';
                                    }
                                    if( !empty($testimonial['client_designation']) ){
                                        echo '<span>'.esc_html__( $testimonial['client_designation'],'testimonial-fe' ).'</span>';
                                    }
                                ?>
                            </div>
                        </div>

                    <?php elseif( $settings['testimonial_style'] == 8 ): ?>
                        <div class="testimonal">
                            <div class="content">
                                <?php
                                    if( !empty( $testimonial['client_image']['url'] ) ){
                                        echo '<div class="testimonal-image">'.Group_Control_Image_Size::get_attachment_image_html( $testimonial, 'client_imagesize', 'client_image' ).'</div>';
                                    } 

                                    if( !empty($settings['client_image_divider']['url']) ){
                                        echo '<div class="shape">'.Group_Control_Image_Size::get_attachment_image_html( $settings, 'client_image_divider_size', 'client_image_divider' ).'</div>';
                                    }
                                ?>
                                <div class="clint-info">
                                    <?php
                                        if( !empty($testimonial['client_name']) ){
                                            echo '<h4>'.esc_html__( $testimonial['client_name'],'testimonial-fe' ).'</h4>';
                                        }
                                        if( !empty($testimonial['client_designation']) ){
                                            echo '<span>'.esc_html__( $testimonial['client_designation'],'testimonial-fe' ).'</span>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                                if( !empty($testimonial['client_say']) ){
                                    echo '<div class="content"><p>'.esc_html__( $testimonial['client_say'],'testimonial-fe' ).'</p></div>';
                                }
                            ?>
                        </div>

                    <?php elseif( ( $settings['testimonial_style'] == 9 ) && $settings['slider_on'] != 'yes' ): ?>
                        <div class="htb-col-xl-4 htb-col-lg-4 htb-col-sm-6 htb-col-12">
                            <div class="testimonal">
                                <div class="content">
                                    <?php
                                        if( !empty($testimonial['client_image']['url']) ){
                                            echo '<div class="testimonal-image">'.Group_Control_Image_Size::get_attachment_image_html( $testimonial, 'client_imagesize', 'client_image' ).'</div>';
                                        } 

                                        if( !empty($settings['client_image_divider']['url']) ){
                                            echo '<div class="shape">'.Group_Control_Image_Size::get_attachment_image_html( $settings, 'client_image_divider_size', 'client_image_divider' ).'</div>';
                                        }
                                    ?>
                                    <div class="clint-info">
                                        <?php
                                            if( !empty($testimonial['client_name']) ){
                                                echo '<h4>'.esc_html__( $testimonial['client_name'],'testimonial-fe' ).'</h4>';
                                            }
                                            if( !empty($testimonial['client_designation']) ){
                                                echo '<span>'.esc_html__( $testimonial['client_designation'],'testimonial-fe' ).'</span>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                    if( !empty($testimonial['client_say']) ){
                                        echo '<div class="content"><p>'.esc_html__( $testimonial['client_say'],'testimonial-fe' ).'</p></div>';
                                    }
                                ?>
                            </div>
                        </div>

                    <?php else:?>
                        <div class="testimonal">
                            <?php
                                if( !empty( $testimonial['client_image']['url'] ) ){
                                    echo '<div class="testimonal-image">'.Group_Control_Image_Size::get_attachment_image_html( $testimonial, 'client_imagesize', 'client_image' ).'</div>';
                                } 

                                if( !empty( $settings['client_image_divider']['url'] ) ){
                                    echo '<div class="shape">'.Group_Control_Image_Size::get_attachment_image_html( $settings, 'client_image_divider_size', 'client_image_divider' ).'</div>';
                                }
                            ?>

                            <?php if( $settings['testimonial_style'] == 3 ):?>
                                <div class="content">
                                    <?php
                                        if( !empty($testimonial['client_say']) ){
                                            echo '<p>'.esc_html__( $testimonial['client_say'],'testimonial-fe' ).'</p>';
                                        }
                                    ?>
                                    <div class="clint-info">
                                        <?php
                                            if( !empty( $testimonial['client_name'] ) ){
                                                echo '<h4>'.esc_html__( $testimonial['client_name'],'testimonial-fe' ).'</h4>';
                                            }
                                            if( !empty( $testimonial['client_designation'] ) ){
                                                echo '<span>'.esc_html__( $testimonial['client_designation'],'testimonial-fe' ).'</span>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            <?php else:?>
                                <div class="content">
                                    <?php
                                        if( !empty( $testimonial['client_say'] ) ) {
                                            echo '<p>'.esc_html__( $testimonial['client_say'],'testimonial-fe' ).'</p>';
                                        }
                                        if( !empty( $testimonial['client_name'] ) ) {
                                            echo '<h4>'.esc_html__( $testimonial['client_name'],'testimonial-fe' ).'</h4>';
                                        }
                                        if( !empty( $testimonial['client_designation'] ) ) {
                                            echo '<span>'.esc_html__( $testimonial['client_designation'],'testimonial-fe' ).'</span>';
                                        }
                                    ?>
                                </div>
                            <?php endif;?>
                        </div>
                    <?php endif;?>

                    <?php
                        if( ( $settings['testimonial_style'] == 3 ) && $settings['slider_on'] != 'yes' ){ echo '</div>'; } 
                        endforeach;
                endif;
                ?>
            </div>
        <?php
    }
}
Plugin::instance()->widgets_manager->register_widget_type( new Testimonial_For_Elementor_Widget() );
