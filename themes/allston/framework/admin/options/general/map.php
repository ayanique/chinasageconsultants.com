<?php

if ( ! function_exists( 'allston_eltdf_general_options_map' ) ) {
	/**
	 * General options page
	 */
	function allston_eltdf_general_options_map() {
		
		allston_eltdf_add_admin_page(
			array(
				'slug'  => '',
				'title' => esc_html__( 'General', 'allston' ),
				'icon'  => 'fa fa-institution'
			)
		);
		
		$panel_design_style = allston_eltdf_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_design_style',
				'title' => esc_html__( 'Design Style', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'google_fonts',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Google Font Family', 'allston' ),
				'description'   => esc_html__( 'Choose a default Google font for your site', 'allston' ),
				'parent'        => $panel_design_style
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'additional_google_fonts',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Additional Google Fonts', 'allston' ),
				'parent'        => $panel_design_style
			)
		);
		
		$additional_google_fonts_container = allston_eltdf_add_admin_container(
			array(
				'parent'          => $panel_design_style,
				'name'            => 'additional_google_fonts_container',
				'dependency' => array(
					'show' => array(
						'additional_google_fonts'  => 'yes'
					)
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'additional_google_font1',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'allston' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'allston' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'additional_google_font2',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'allston' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'allston' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'additional_google_font3',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'allston' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'allston' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'additional_google_font4',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'allston' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'allston' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'additional_google_font5',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'allston' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'allston' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'google_font_weight',
				'type'          => 'checkboxgroup',
				'default_value' => '',
				'label'         => esc_html__( 'Google Fonts Style & Weight', 'allston' ),
				'description'   => esc_html__( 'Choose a default Google font weights for your site. Impact on page load time', 'allston' ),
				'parent'        => $panel_design_style,
				'options'       => array(
					'100'  => esc_html__( '100 Thin', 'allston' ),
					'100i' => esc_html__( '100 Thin Italic', 'allston' ),
					'200'  => esc_html__( '200 Extra-Light', 'allston' ),
					'200i' => esc_html__( '200 Extra-Light Italic', 'allston' ),
					'300'  => esc_html__( '300 Light', 'allston' ),
					'300i' => esc_html__( '300 Light Italic', 'allston' ),
					'400'  => esc_html__( '400 Regular', 'allston' ),
					'400i' => esc_html__( '400 Regular Italic', 'allston' ),
					'500'  => esc_html__( '500 Medium', 'allston' ),
					'500i' => esc_html__( '500 Medium Italic', 'allston' ),
					'600'  => esc_html__( '600 Semi-Bold', 'allston' ),
					'600i' => esc_html__( '600 Semi-Bold Italic', 'allston' ),
					'700'  => esc_html__( '700 Bold', 'allston' ),
					'700i' => esc_html__( '700 Bold Italic', 'allston' ),
					'800'  => esc_html__( '800 Extra-Bold', 'allston' ),
					'800i' => esc_html__( '800 Extra-Bold Italic', 'allston' ),
					'900'  => esc_html__( '900 Ultra-Bold', 'allston' ),
					'900i' => esc_html__( '900 Ultra-Bold Italic', 'allston' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'google_font_subset',
				'type'          => 'checkboxgroup',
				'default_value' => '',
				'label'         => esc_html__( 'Google Fonts Subset', 'allston' ),
				'description'   => esc_html__( 'Choose a default Google font subsets for your site', 'allston' ),
				'parent'        => $panel_design_style,
				'options'       => array(
					'latin'        => esc_html__( 'Latin', 'allston' ),
					'latin-ext'    => esc_html__( 'Latin Extended', 'allston' ),
					'cyrillic'     => esc_html__( 'Cyrillic', 'allston' ),
					'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'allston' ),
					'greek'        => esc_html__( 'Greek', 'allston' ),
					'greek-ext'    => esc_html__( 'Greek Extended', 'allston' ),
					'vietnamese'   => esc_html__( 'Vietnamese', 'allston' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'        => 'first_color',
				'type'        => 'color',
				'label'       => esc_html__( 'First Main Color', 'allston' ),
				'description' => esc_html__( 'Choose the most dominant theme color. Default color is #00bbb3', 'allston' ),
				'parent'      => $panel_design_style
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'        => 'page_background_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Page Background Color', 'allston' ),
				'description' => esc_html__( 'Choose the background color for page content. Default color is #ffffff', 'allston' ),
				'parent'      => $panel_design_style
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'        => 'selection_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Text Selection Color', 'allston' ),
				'description' => esc_html__( 'Choose the color users see when selecting text', 'allston' ),
				'parent'      => $panel_design_style
			)
		);
		
		/***************** Passepartout Layout - begin **********************/
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'boxed',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Boxed Layout', 'allston' ),
				'parent'        => $panel_design_style
			)
		);
		
			$boxed_container = allston_eltdf_add_admin_container(
				array(
					'parent'          => $panel_design_style,
					'name'            => 'boxed_container',
					'dependency' => array(
						'show' => array(
							'boxed'  => 'yes'
						)
					)
				)
			);
		
				allston_eltdf_add_admin_field(
					array(
						'name'        => 'page_background_color_in_box',
						'type'        => 'color',
						'label'       => esc_html__( 'Page Background Color', 'allston' ),
						'description' => esc_html__( 'Choose the page background color outside box', 'allston' ),
						'parent'      => $boxed_container
					)
				);
				
				allston_eltdf_add_admin_field(
					array(
						'name'        => 'boxed_background_image',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Image', 'allston' ),
						'description' => esc_html__( 'Choose an image to be displayed in background', 'allston' ),
						'parent'      => $boxed_container
					)
				);
				
				allston_eltdf_add_admin_field(
					array(
						'name'        => 'boxed_pattern_background_image',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Pattern', 'allston' ),
						'description' => esc_html__( 'Choose an image to be used as background pattern', 'allston' ),
						'parent'      => $boxed_container
					)
				);
				
				allston_eltdf_add_admin_field(
					array(
						'name'          => 'boxed_background_image_attachment',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Background Image Attachment', 'allston' ),
						'description'   => esc_html__( 'Choose background image attachment', 'allston' ),
						'parent'        => $boxed_container,
						'options'       => array(
							''       => esc_html__( 'Default', 'allston' ),
							'fixed'  => esc_html__( 'Fixed', 'allston' ),
							'scroll' => esc_html__( 'Scroll', 'allston' )
						)
					)
				);
		
		/***************** Boxed Layout - end **********************/
		
		/***************** Passepartout Layout - begin **********************/
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'paspartu',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Passepartout', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will display passepartout around site content', 'allston' ),
				'parent'        => $panel_design_style
			)
		);
		
			$paspartu_container = allston_eltdf_add_admin_container(
				array(
					'parent'          => $panel_design_style,
					'name'            => 'paspartu_container',
					'dependency' => array(
						'show' => array(
							'paspartu'  => 'yes'
						)
					)
				)
			);
		
				allston_eltdf_add_admin_field(
					array(
						'name'        => 'paspartu_color',
						'type'        => 'color',
						'label'       => esc_html__( 'Passepartout Color', 'allston' ),
						'description' => esc_html__( 'Choose passepartout color, default value is #ffffff', 'allston' ),
						'parent'      => $paspartu_container
					)
				);
				
				allston_eltdf_add_admin_field(
					array(
						'name'        => 'paspartu_width',
						'type'        => 'text',
						'label'       => esc_html__( 'Passepartout Size', 'allston' ),
						'description' => esc_html__( 'Enter size amount for passepartout', 'allston' ),
						'parent'      => $paspartu_container,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px or %'
						)
					)
				);
		
				allston_eltdf_add_admin_field(
					array(
						'name'        => 'paspartu_responsive_width',
						'type'        => 'text',
						'label'       => esc_html__( 'Responsive Passepartout Size', 'allston' ),
						'description' => esc_html__( 'Enter size amount for passepartout for smaller screens (tablets and mobiles view)', 'allston' ),
						'parent'      => $paspartu_container,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px or %'
						)
					)
				);
				
				allston_eltdf_add_admin_field(
					array(
						'parent'        => $paspartu_container,
						'type'          => 'yesno',
						'default_value' => 'no',
						'name'          => 'disable_top_paspartu',
						'label'         => esc_html__( 'Disable Top Passepartout', 'allston' )
					)
				);
		
				allston_eltdf_add_admin_field(
					array(
						'parent'        => $paspartu_container,
						'type'          => 'yesno',
						'default_value' => 'no',
						'name'          => 'enable_fixed_paspartu',
						'label'         => esc_html__( 'Enable Fixed Passepartout', 'allston' ),
						'description' => esc_html__( 'Enabling this option will set fixed passepartout for your screens', 'allston' )
					)
				);
		
		/***************** Passepartout Layout - end **********************/
		
		/***************** Content Layout - begin **********************/
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'initial_content_width',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Initial Width of Content', 'allston' ),
				'description'   => esc_html__( 'Choose the initial width of content which is in grid (Applies to pages set to "Default Template" and rows set to "In Grid")', 'allston' ),
				'parent'        => $panel_design_style,
				'options'       => array(
					'eltdf-grid-1100' => esc_html__( '1100px - default', 'allston' ),
					'eltdf-grid-1300' => esc_html__( '1300px', 'allston' ),
					'eltdf-grid-1200' => esc_html__( '1200px', 'allston' ),
					'eltdf-grid-1000' => esc_html__( '1000px', 'allston' ),
					'eltdf-grid-800'  => esc_html__( '800px', 'allston' )
				)
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'preload_pattern_image',
				'type'          => 'image',
				'label'         => esc_html__( 'Preload Pattern Image', 'allston' ),
				'description'   => esc_html__( 'Choose preload pattern image to be displayed until images are loaded', 'allston' ),
				'parent'        => $panel_design_style
			)
		);
		
		/***************** Content Layout - end **********************/
		
		$panel_settings = allston_eltdf_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_settings',
				'title' => esc_html__( 'Settings', 'allston' )
			)
		);
		
		/***************** Smooth Scroll Layout - begin **********************/
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'page_smooth_scroll',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Smooth Scroll', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will perform a smooth scrolling effect on every page (except on Mac and touch devices)', 'allston' ),
				'parent'        => $panel_settings
			)
		);
		
		/***************** Smooth Scroll Layout - end **********************/
		
		/***************** Smooth Page Transitions Layout - begin **********************/
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'smooth_page_transitions',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Smooth Page Transitions', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will perform a smooth transition between pages when clicking on links', 'allston' ),
				'parent'        => $panel_settings
			)
		);
		
			$page_transitions_container = allston_eltdf_add_admin_container(
				array(
					'parent'          => $panel_settings,
					'name'            => 'page_transitions_container',
					'dependency' => array(
						'show' => array(
							'smooth_page_transitions'  => 'yes'
						)
					)
				)
			);
		
				allston_eltdf_add_admin_field(
					array(
						'name'          => 'page_transition_preloader',
						'type'          => 'yesno',
						'default_value' => 'no',
						'label'         => esc_html__( 'Enable Preloading Animation', 'allston' ),
						'description'   => esc_html__( 'Enabling this option will display an animated preloader while the page content is loading', 'allston' ),
						'parent'        => $page_transitions_container
					)
				);
				
				$page_transition_preloader_container = allston_eltdf_add_admin_container(
					array(
						'parent'          => $page_transitions_container,
						'name'            => 'page_transition_preloader_container',
						'dependency' => array(
							'show' => array(
								'page_transition_preloader'  => 'yes'
							)
						)
					)
				);
		
		
					allston_eltdf_add_admin_field(
						array(
							'name'   => 'smooth_pt_bgnd_color',
							'type'   => 'color',
							'label'  => esc_html__( 'Page Loader Background Color', 'allston' ),
							'parent' => $page_transition_preloader_container
						)
					);
					
					$group_pt_spinner_animation = allston_eltdf_add_admin_group(
						array(
							'name'        => 'group_pt_spinner_animation',
							'title'       => esc_html__( 'Loader Style', 'allston' ),
							'description' => esc_html__( 'Define styles for loader spinner animation', 'allston' ),
							'parent'      => $page_transition_preloader_container
						)
					);
					
					$row_pt_spinner_animation = allston_eltdf_add_admin_row(
						array(
							'name'   => 'row_pt_spinner_animation',
							'parent' => $group_pt_spinner_animation
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'type'          => 'selectsimple',
							'name'          => 'smooth_pt_spinner_type',
							'default_value' => '',
							'label'         => esc_html__( 'Spinner Type', 'allston' ),
							'parent'        => $row_pt_spinner_animation,
							'options'       => array(
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
					

					allston_eltdf_add_admin_field(
					    array(
					        'type'          => 'textsimple',
					        'name'          => 'loading_title_text',
					        'default_value' => esc_html__('Allston', 'allston'),
					        'label'         => esc_html__('Loading Title Text', 'allston'),
					        'parent'        => $row_pt_spinner_animation,
					        'dependency' => array(
					        	'show' => array(
					        		'smooth_pt_spinner_type' => 'loading_title'
				        		)
				        	)
					    )
					);

					allston_eltdf_add_admin_field(
						array(
							'type'          => 'colorsimple',
							'name'          => 'smooth_pt_spinner_color',
							'default_value' => '',
							'label'         => esc_html__( 'Spinner Color', 'allston' ),
							'parent'        => $row_pt_spinner_animation,
						)
					);
					
					allston_eltdf_add_admin_field(
						array(
							'name'          => 'page_transition_fadeout',
							'type'          => 'yesno',
							'default_value' => 'no',
							'label'         => esc_html__( 'Enable Fade Out Animation', 'allston' ),
							'description'   => esc_html__( 'Enabling this option will turn on fade out animation when leaving page', 'allston' ),
							'parent'        => $page_transitions_container
						)
					);
		
		/***************** Smooth Page Transitions Layout - end **********************/
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'show_back_button',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show "Back To Top Button"', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will display a Back to Top button on every page', 'allston' ),
				'parent'        => $panel_settings
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'          => 'responsiveness',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Responsiveness', 'allston' ),
				'description'   => esc_html__( 'Enabling this option will make all pages responsive', 'allston' ),
				'parent'        => $panel_settings
			)
		);
		
		$panel_custom_code = allston_eltdf_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_custom_code',
				'title' => esc_html__( 'Custom Code', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'        => 'custom_js',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Custom JS', 'allston' ),
				'description' => esc_html__( 'Enter your custom Javascript here', 'allston' ),
				'parent'      => $panel_custom_code
			)
		);
		
		$panel_google_api = allston_eltdf_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_google_api',
				'title' => esc_html__( 'Google API', 'allston' )
			)
		);
		
		allston_eltdf_add_admin_field(
			array(
				'name'        => 'google_maps_api_key',
				'type'        => 'text',
				'label'       => esc_html__( 'Google Maps Api Key', 'allston' ),
				'description' => esc_html__( 'Insert your Google Maps API key here. For instructions on how to create a Google Maps API key, please refer to our to our documentation.', 'allston' ),
				'parent'      => $panel_google_api
			)
		);
	}
	
	add_action( 'allston_eltdf_options_map', 'allston_eltdf_general_options_map', 1 );
}

if ( ! function_exists( 'allston_eltdf_page_general_style' ) ) {
	/**
	 * Function that prints page general inline styles
	 */
	function allston_eltdf_page_general_style( $style ) {
		$current_style = '';
		$page_id       = allston_eltdf_get_page_id();
		$class_prefix  = allston_eltdf_get_unique_page_class( $page_id );
		
		$boxed_background_style = array();
		
		$boxed_page_background_color = allston_eltdf_get_meta_field_intersect( 'page_background_color_in_box', $page_id );
		if ( ! empty( $boxed_page_background_color ) ) {
			$boxed_background_style['background-color'] = $boxed_page_background_color;
		}
		
		$boxed_page_background_image = allston_eltdf_get_meta_field_intersect( 'boxed_background_image', $page_id );
		if ( ! empty( $boxed_page_background_image ) ) {
			$boxed_background_style['background-image']    = 'url(' . esc_url( $boxed_page_background_image ) . ')';
			$boxed_background_style['background-position'] = 'center 0px';
			$boxed_background_style['background-repeat']   = 'no-repeat';
		}
		
		$boxed_page_background_pattern_image = allston_eltdf_get_meta_field_intersect( 'boxed_pattern_background_image', $page_id );
		if ( ! empty( $boxed_page_background_pattern_image ) ) {
			$boxed_background_style['background-image']    = 'url(' . esc_url( $boxed_page_background_pattern_image ) . ')';
			$boxed_background_style['background-position'] = '0px 0px';
			$boxed_background_style['background-repeat']   = 'repeat';
		}
		
		$boxed_page_background_attachment = allston_eltdf_get_meta_field_intersect( 'boxed_background_image_attachment', $page_id );
		if ( ! empty( $boxed_page_background_attachment ) ) {
			$boxed_background_style['background-attachment'] = $boxed_page_background_attachment;
		}
		
		$boxed_background_selector = $class_prefix . '.eltdf-boxed .eltdf-wrapper';
		
		if ( ! empty( $boxed_background_style ) ) {
			$current_style .= allston_eltdf_dynamic_css( $boxed_background_selector, $boxed_background_style );
		}
		
		$paspartu_style     = array();
		$paspartu_res_style = array();
		$paspartu_res_start = '@media only screen and (max-width: 1024px) {';
		$paspartu_res_end   = '}';
		
		$paspartu_header_selector                = array(
			'.eltdf-paspartu-enabled .eltdf-page-header .eltdf-fixed-wrapper.fixed',
			'.eltdf-paspartu-enabled .eltdf-sticky-header',
			'.eltdf-paspartu-enabled .eltdf-mobile-header.mobile-header-appear .eltdf-mobile-header-inner'
		);
		$paspartu_header_appear_selector         = array(
			'.eltdf-paspartu-enabled.eltdf-fixed-paspartu-enabled .eltdf-page-header .eltdf-fixed-wrapper.fixed',
			'.eltdf-paspartu-enabled.eltdf-fixed-paspartu-enabled .eltdf-sticky-header.header-appear',
			'.eltdf-paspartu-enabled.eltdf-fixed-paspartu-enabled .eltdf-mobile-header.mobile-header-appear .eltdf-mobile-header-inner'
		);
		
		$paspartu_header_style                   = array();
		$paspartu_header_appear_style            = array();
		$paspartu_header_responsive_style        = array();
		$paspartu_header_appear_responsive_style = array();
		
		$paspartu_color = allston_eltdf_get_meta_field_intersect( 'paspartu_color', $page_id );
		if ( ! empty( $paspartu_color ) ) {
			$paspartu_style['background-color'] = $paspartu_color;
		}
		
		$paspartu_width = allston_eltdf_get_meta_field_intersect( 'paspartu_width', $page_id );
		if ( $paspartu_width !== '' ) {
			if ( allston_eltdf_string_ends_with( $paspartu_width, '%' ) || allston_eltdf_string_ends_with( $paspartu_width, 'px' ) ) {
				$paspartu_style['padding'] = $paspartu_width;
				
				$paspartu_clean_width      = allston_eltdf_string_ends_with( $paspartu_width, '%' ) ? allston_eltdf_filter_suffix( $paspartu_width, '%' ) : allston_eltdf_filter_suffix( $paspartu_width, 'px' );
				$paspartu_clean_width_mark = allston_eltdf_string_ends_with( $paspartu_width, '%' ) ? '%' : 'px';
				
				$paspartu_header_style['left']              = $paspartu_width;
				$paspartu_header_style['width']             = 'calc(100% - ' . ( 2 * $paspartu_clean_width ) . $paspartu_clean_width_mark . ')';
				$paspartu_header_appear_style['margin-top'] = $paspartu_width;
			} else {
				$paspartu_style['padding'] = $paspartu_width . 'px';
				
				$paspartu_header_style['left']              = $paspartu_width . 'px';
				$paspartu_header_style['width']             = 'calc(100% - ' . ( 2 * $paspartu_width ) . 'px)';
				$paspartu_header_appear_style['margin-top'] = $paspartu_width . 'px';
			}
		}
		
		$paspartu_selector = $class_prefix . '.eltdf-paspartu-enabled .eltdf-wrapper';
		
		if ( ! empty( $paspartu_style ) ) {
			$current_style .= allston_eltdf_dynamic_css( $paspartu_selector, $paspartu_style );
		}
		
		if ( ! empty( $paspartu_header_style ) ) {
			$current_style .= allston_eltdf_dynamic_css( $paspartu_header_selector, $paspartu_header_style );
			$current_style .= allston_eltdf_dynamic_css( $paspartu_header_appear_selector, $paspartu_header_appear_style );
		}
		
		$paspartu_responsive_width = allston_eltdf_get_meta_field_intersect( 'paspartu_responsive_width', $page_id );
		if ( $paspartu_responsive_width !== '' ) {
			if ( allston_eltdf_string_ends_with( $paspartu_responsive_width, '%' ) || allston_eltdf_string_ends_with( $paspartu_responsive_width, 'px' ) ) {
				$paspartu_res_style['padding'] = $paspartu_responsive_width;
				
				$paspartu_clean_width      = allston_eltdf_string_ends_with( $paspartu_responsive_width, '%' ) ? allston_eltdf_filter_suffix( $paspartu_responsive_width, '%' ) : allston_eltdf_filter_suffix( $paspartu_responsive_width, 'px' );
				$paspartu_clean_width_mark = allston_eltdf_string_ends_with( $paspartu_responsive_width, '%' ) ? '%' : 'px';
				
				$paspartu_header_responsive_style['left']              = $paspartu_responsive_width;
				$paspartu_header_responsive_style['width']             = 'calc(100% - ' . ( 2 * $paspartu_clean_width ) . $paspartu_clean_width_mark . ')';
				$paspartu_header_appear_responsive_style['margin-top'] = $paspartu_responsive_width;
			} else {
				$paspartu_res_style['padding'] = $paspartu_responsive_width . 'px';
				
				$paspartu_header_responsive_style['left']              = $paspartu_responsive_width . 'px';
				$paspartu_header_responsive_style['width']             = 'calc(100% - ' . ( 2 * $paspartu_responsive_width ) . 'px)';
				$paspartu_header_appear_responsive_style['margin-top'] = $paspartu_responsive_width . 'px';
			}
		}
		
		if ( ! empty( $paspartu_res_style ) ) {
			$current_style .= $paspartu_res_start . allston_eltdf_dynamic_css( $paspartu_selector, $paspartu_res_style ) . $paspartu_res_end;
		}
		
		if ( ! empty( $paspartu_header_responsive_style ) ) {
			$current_style .= $paspartu_res_start . allston_eltdf_dynamic_css( $paspartu_header_selector, $paspartu_header_responsive_style ) . $paspartu_res_end;
			$current_style .= $paspartu_res_start . allston_eltdf_dynamic_css( $paspartu_header_appear_selector, $paspartu_header_appear_responsive_style ) . $paspartu_res_end;
		}
		
		$current_style = $current_style . $style;
		
		return $current_style;
	}
	
	add_filter( 'allston_eltdf_add_page_custom_style', 'allston_eltdf_page_general_style' );
}