<?php

if ( ! function_exists( 'allston_eltdf_map_general_meta' ) ) {
	function allston_eltdf_map_general_meta() {
		
		$general_meta_box = allston_eltdf_meta_box_add(
			array(
				'scope' => apply_filters( 'allston_eltdf_set_scope_for_meta_boxes', array( 'page', 'post' ), 'general_meta' ),
				'title' => esc_html__( 'General', 'allston' ),
				'name'  => 'general_meta'
			)
		);
		
		/***************** Slider Layout - begin **********************/
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_page_slider_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Slider Shortcode', 'allston' ),
				'description' => esc_html__( 'Paste your slider shortcode here', 'allston' ),
				'parent'      => $general_meta_box
			)
		);
		
		/***************** Slider Layout - begin **********************/
		
		/***************** Content Layout - begin **********************/
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_page_content_behind_header_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Always put content behind header', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will put page content behind page header', 'allston' ),
				'parent'        => $general_meta_box
			)
		);
		
		$eltdf_content_padding_group = allston_eltdf_add_admin_group(
			array(
				'name'        => 'content_padding_group',
				'title'       => esc_html__( 'Content Style', 'allston' ),
				'description' => esc_html__( 'Define styles for Content area', 'allston' ),
				'parent'      => $general_meta_box
			)
		);
		
			$eltdf_content_padding_row = allston_eltdf_add_admin_row(
				array(
					'name'   => 'eltdf_content_padding_row',
					'next'   => true,
					'parent' => $eltdf_content_padding_group
				)
			);
		
				allston_eltdf_meta_box_add_field(
					array(
						'name'   => 'eltdf_page_content_padding',
						'type'   => 'textsimple',
						'label'  => esc_html__( 'Content Padding (e.g. 10px 5px 10px 5px)', 'allston' ),
						'parent' => $eltdf_content_padding_row,
					)
				);
				
				allston_eltdf_meta_box_add_field(
					array(
						'name'    => 'eltdf_page_content_padding_mobile',
						'type'    => 'textsimple',
						'label'   => esc_html__( 'Content Padding for mobile (e.g. 10px 5px 10px 5px)', 'allston' ),
						'parent'  => $eltdf_content_padding_row,
					)
				);
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_page_background_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Page Background Color', 'allston' ),
				'description' => esc_html__( 'Choose background color for page content', 'allston' ),
				'parent'      => $general_meta_box
			)
		);
		
		/***************** Content Layout - end **********************/
		
		/***************** Boxed Layout - begin **********************/
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'    => 'eltdf_boxed_meta',
				'type'    => 'select',
				'label'   => esc_html__( 'Boxed Layout', 'allston' ),
				'parent'  => $general_meta_box,
				'options' => allston_eltdf_get_yes_no_select_array()
			)
		);
		
			$boxed_container_meta = allston_eltdf_add_admin_container(
				array(
					'parent'          => $general_meta_box,
					'name'            => 'boxed_container_meta',
					'dependency' => array(
						'hide' => array(
							'eltdf_boxed_meta'  => array('','no')
						)
					)
				)
			);
		
				allston_eltdf_meta_box_add_field(
					array(
						'name'        => 'eltdf_page_background_color_in_box_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Page Background Color', 'allston' ),
						'description' => esc_html__( 'Choose the page background color outside box', 'allston' ),
						'parent'      => $boxed_container_meta
					)
				);
				
				allston_eltdf_meta_box_add_field(
					array(
						'name'        => 'eltdf_boxed_background_image_meta',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Image', 'allston' ),
						'description' => esc_html__( 'Choose an image to be displayed in background', 'allston' ),
						'parent'      => $boxed_container_meta
					)
				);
				
				allston_eltdf_meta_box_add_field(
					array(
						'name'        => 'eltdf_boxed_pattern_background_image_meta',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Pattern', 'allston' ),
						'description' => esc_html__( 'Choose an image to be used as background pattern', 'allston' ),
						'parent'      => $boxed_container_meta
					)
				);
				
				allston_eltdf_meta_box_add_field(
					array(
						'name'          => 'eltdf_boxed_background_image_attachment_meta',
						'type'          => 'select',
						'default_value' => 'fixed',
						'label'         => esc_html__( 'Background Image Attachment', 'allston' ),
						'description'   => esc_html__( 'Choose background image attachment', 'allston' ),
						'parent'        => $boxed_container_meta,
						'options'       => array(
							''       => esc_html__( 'Default', 'allston' ),
							'fixed'  => esc_html__( 'Fixed', 'allston' ),
							'scroll' => esc_html__( 'Scroll', 'allston' )
						)
					)
				);
		
		/***************** Boxed Layout - end **********************/
		
		/***************** Passepartout Layout - begin **********************/
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_paspartu_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Passepartout', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will display passepartout around site content', 'allston' ),
				'parent'        => $general_meta_box,
				'options'       => allston_eltdf_get_yes_no_select_array(),
			)
		);
		
			$paspartu_container_meta = allston_eltdf_add_admin_container(
				array(
					'parent'          => $general_meta_box,
					'name'            => 'eltdf_paspartu_container_meta',
					'dependency' => array(
						'hide' => array(
							'eltdf_paspartu_meta'  => array('','no')
						)
					)
				)
			);
		
				allston_eltdf_meta_box_add_field(
					array(
						'name'        => 'eltdf_paspartu_color_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Passepartout Color', 'allston' ),
						'description' => esc_html__( 'Choose passepartout color, default value is #ffffff', 'allston' ),
						'parent'      => $paspartu_container_meta
					)
				);
				
				allston_eltdf_meta_box_add_field(
					array(
						'name'        => 'eltdf_paspartu_width_meta',
						'type'        => 'text',
						'label'       => esc_html__( 'Passepartout Size', 'allston' ),
						'description' => esc_html__( 'Enter size amount for passepartout', 'allston' ),
						'parent'      => $paspartu_container_meta,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px or %'
						)
					)
				);
		
				allston_eltdf_meta_box_add_field(
					array(
						'name'        => 'eltdf_paspartu_responsive_width_meta',
						'type'        => 'text',
						'label'       => esc_html__( 'Responsive Passepartout Size', 'allston' ),
						'description' => esc_html__( 'Enter size amount for passepartout for smaller screens (tablets and mobiles view)', 'allston' ),
						'parent'      => $paspartu_container_meta,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px or %'
						)
					)
				);
				
				allston_eltdf_meta_box_add_field(
					array(
						'parent'        => $paspartu_container_meta,
						'type'          => 'select',
						'default_value' => '',
						'name'          => 'eltdf_disable_top_paspartu_meta',
						'label'         => esc_html__( 'Disable Top Passepartout', 'allston' ),
						'options'       => allston_eltdf_get_yes_no_select_array(),
					)
				);
		
				allston_eltdf_meta_box_add_field(
					array(
						'parent'        => $paspartu_container_meta,
						'type'          => 'select',
						'default_value' => '',
						'name'          => 'eltdf_enable_fixed_paspartu_meta',
						'label'         => esc_html__( 'Enable Fixed Passepartout', 'allston' ),
						'description'   => esc_html__( 'Enabling this option will set fixed passepartout for your screens', 'allston' ),
						'options'       => allston_eltdf_get_yes_no_select_array(),
					)
				);
		
		/***************** Passepartout Layout - end **********************/
		
		/***************** Content Width Layout - begin **********************/
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_initial_content_width_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Initial Width of Content', 'allston' ),
				'description'   => esc_html__( 'Choose the initial width of content which is in grid (Applies to pages set to "Default Template" and rows set to "In Grid")', 'allston' ),
				'parent'        => $general_meta_box,
				'options'       => array(
					''                => esc_html__( 'Default', 'allston' ),
					'eltdf-grid-1100' => esc_html__( '1100px', 'allston' ),
					'eltdf-grid-1300' => esc_html__( '1300px', 'allston' ),
					'eltdf-grid-1200' => esc_html__( '1200px', 'allston' ),
					'eltdf-grid-1000' => esc_html__( '1000px', 'allston' ),
					'eltdf-grid-800'  => esc_html__( '800px', 'allston' )
				)
			)
		);
		
		/***************** Content Width Layout - end **********************/
		
		/***************** Smooth Page Transitions Layout - begin **********************/
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'          => 'eltdf_smooth_page_transitions_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Smooth Page Transitions', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will perform a smooth transition between pages when clicking on links', 'allston' ),
				'parent'        => $general_meta_box,
				'options'       => allston_eltdf_get_yes_no_select_array()
			)
		);
		
			$page_transitions_container_meta = allston_eltdf_add_admin_container(
				array(
					'parent'          => $general_meta_box,
					'name'            => 'page_transitions_container_meta',
					'dependency' => array(
						'hide' => array(
							'eltdf_smooth_page_transitions_meta'  => array('','no')
						)
					)
				)
			);
		
				allston_eltdf_meta_box_add_field(
					array(
						'name'        => 'eltdf_page_transition_preloader_meta',
						'type'        => 'select',
						'label'       => esc_html__( 'Enable Preloading Animation', 'allston' ),
						'description' => esc_html__( 'Enabling this option will display an animated preloader while the page content is loading', 'allston' ),
						'parent'      => $page_transitions_container_meta,
						'options'     => allston_eltdf_get_yes_no_select_array()
					)
				);
				
				$page_transition_preloader_container_meta = allston_eltdf_add_admin_container(
					array(
						'parent'          => $page_transitions_container_meta,
						'name'            => 'page_transition_preloader_container_meta',
						'dependency' => array(
							'hide' => array(
								'eltdf_page_transition_preloader_meta'  => array('','no')
							)
						)
					)
				);
				
					allston_eltdf_meta_box_add_field(
						array(
							'name'   => 'eltdf_smooth_pt_bgnd_color_meta',
							'type'   => 'color',
							'label'  => esc_html__( 'Page Loader Background Color', 'allston' ),
							'parent' => $page_transition_preloader_container_meta
						)
					);
					
					$group_pt_spinner_animation_meta = allston_eltdf_add_admin_group(
						array(
							'name'        => 'group_pt_spinner_animation_meta',
							'title'       => esc_html__( 'Loader Style', 'allston' ),
							'description' => esc_html__( 'Define styles for loader spinner animation', 'allston' ),
							'parent'      => $page_transition_preloader_container_meta
						)
					);
					
					$row_pt_spinner_animation_meta = allston_eltdf_add_admin_row(
						array(
							'name'   => 'row_pt_spinner_animation_meta',
							'parent' => $group_pt_spinner_animation_meta
						)
					);
					
					allston_eltdf_meta_box_add_field(
						array(
							'type'    => 'selectsimple',
							'name'    => 'eltdf_smooth_pt_spinner_type_meta',
							'label'   => esc_html__( 'Spinner Type', 'allston' ),
							'parent'  => $row_pt_spinner_animation_meta,
							'options' => array(
								''                      => esc_html__( 'Default', 'allston' ),
								'loading_title'         => esc_html__( 'Loading Title', 'allston' ),
								'rotate_circles'        => esc_html__( 'Rotate Circles', 'allston' ),
								'pulse'                 => esc_html__( 'Pulse', 'allston' ),
								'double_pulse'          => esc_html__( 'Double Pulse', 'allston' ),
								'cube'                  => esc_html__( 'Cube', 'allston' ),
								'rotating_cubes'        => esc_html__( 'Rotating Cubes', 'allston' ),
								'stripes'               => esc_html__( 'Stripes', 'allston' ),
								'wave'                  => esc_html__( 'Wave', 'allston' ),
								'two_rotating_circles'  => esc_html__( '2 Rotating Circles', 'allston' ),
								'five_rotating_circles' => esc_html__( '5 Rotating Circles', 'allston' ),
								'atom'                  => esc_html__( 'Atom', 'allston' ),
								'clock'                 => esc_html__( 'Clock', 'allston' ),
								'mitosis'               => esc_html__( 'Mitosis', 'allston' ),
								'lines'                 => esc_html__( 'Lines', 'allston' ),
								'fussion'               => esc_html__( 'Fussion', 'allston' ),
								'wave_circles'          => esc_html__( 'Wave Circles', 'allston' ),
								'pulse_circles'         => esc_html__( 'Pulse Circles', 'allston' )
							)
						)
					);

					allston_eltdf_meta_box_add_field(
					    array(
					        'type'          => 'textsimple',
					        'name'          => 'eltdf_loading_title_text_meta',
					        'default_value' => esc_html__('Allston', 'allston'),
					        'label'         => esc_html__('Loading Title Text', 'allston'),
					        'parent'        => $row_pt_spinner_animation_meta,
					        'dependency' => array(
					        	'show' => array(
					        		'eltdf_smooth_pt_spinner_type_meta' => 'loading_title'
				        		)
				        	)
					    )
					);
					
					allston_eltdf_meta_box_add_field(
						array(
							'type'   => 'colorsimple',
							'name'   => 'eltdf_smooth_pt_spinner_color_meta',
							'label'  => esc_html__( 'Spinner Color', 'allston' ),
							'parent' => $row_pt_spinner_animation_meta
						)
					);
					
					allston_eltdf_meta_box_add_field(
						array(
							'name'        => 'eltdf_page_transition_fadeout_meta',
							'type'        => 'select',
							'label'       => esc_html__( 'Enable Fade Out Animation', 'allston' ),
							'description' => esc_html__( 'Enabling this option will turn on fade out animation when leaving page', 'allston' ),
							'options'     => allston_eltdf_get_yes_no_select_array(),
							'parent'      => $page_transitions_container_meta
						
						)
					);
		
		/***************** Smooth Page Transitions Layout - end **********************/
		
		/***************** Comments Layout - begin **********************/
		
		allston_eltdf_meta_box_add_field(
			array(
				'name'        => 'eltdf_page_comments_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Show Comments', 'allston' ),
				'description' => esc_html__( 'Enabling this option will show comments on your page', 'allston' ),
				'parent'      => $general_meta_box,
				'options'     => allston_eltdf_get_yes_no_select_array()
			)
		);
		
		/***************** Comments Layout - end **********************/
	}
	
	add_action( 'allston_eltdf_meta_boxes_map', 'allston_eltdf_map_general_meta', 10 );
}