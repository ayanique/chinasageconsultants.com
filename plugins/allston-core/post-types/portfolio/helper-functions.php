<?php

if ( ! function_exists( 'allston_core_portfolio_meta_box_functions' ) ) {
	function allston_core_portfolio_meta_box_functions( $post_types ) {
		$post_types[] = 'portfolio-item';
		
		return $post_types;
	}
	
	add_filter( 'allston_eltdf_meta_box_post_types_save', 'allston_core_portfolio_meta_box_functions' );
	add_filter( 'allston_eltdf_meta_box_post_types_remove', 'allston_core_portfolio_meta_box_functions' );
}

if ( ! function_exists( 'allston_core_portfolio_scope_meta_box_functions' ) ) {
	function allston_core_portfolio_scope_meta_box_functions( $post_types ) {
		$post_types[] = 'portfolio-item';
		
		return $post_types;
	}
	
	add_filter( 'allston_eltdf_set_scope_for_meta_boxes', 'allston_core_portfolio_scope_meta_box_functions' );
}

if ( ! function_exists( 'allston_core_portfolio_add_social_share_option' ) ) {
	function allston_core_portfolio_add_social_share_option( $container ) {
		allston_eltdf_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'enable_social_share_on_portfolio-item',
				'default_value' => 'no',
				'label'         => esc_html__( 'Portfolio Item', 'allston-core' ),
				'description'   => esc_html__( 'Show Social Share for Portfolio Items', 'allston-core' ),
				'parent'        => $container
			)
		);
	}
	
	add_action( 'allston_eltdf_post_types_social_share', 'allston_core_portfolio_add_social_share_option', 10, 1 );
}

if ( ! function_exists( 'allston_core_register_portfolio_cpt' ) ) {
	function allston_core_register_portfolio_cpt( $cpt_class_name ) {
		$cpt_class = array(
			'AllstonCore\CPT\Portfolio\PortfolioRegister'
		);
		
		$cpt_class_name = array_merge( $cpt_class_name, $cpt_class );
		
		return $cpt_class_name;
	}
	
	add_filter( 'allston_core_filter_register_custom_post_types', 'allston_core_register_portfolio_cpt' );
}

if ( ! function_exists( 'allston_core_get_archive_portfolio_list' ) ) {
	function allston_core_get_archive_portfolio_list( $allston_taxonomy_slug = '', $allston_taxonomy_name = '' ) {
		
		$number_of_items        = 12;
		$number_of_items_option = allston_eltdf_options()->getOptionValue( 'portfolio_archive_number_of_items' );
		if ( ! empty( $number_of_items_option ) ) {
			$number_of_items = $number_of_items_option;
		}
		
		$number_of_columns        = 4;
		$number_of_columns_option = allston_eltdf_options()->getOptionValue( 'portfolio_archive_number_of_columns' );
		if ( ! empty( $number_of_columns_option ) ) {
			$number_of_columns = $number_of_columns_option;
		}
		
		$space_between_items        = 'normal';
		$space_between_items_option = allston_eltdf_options()->getOptionValue( 'portfolio_archive_space_between_items' );
		if ( ! empty( $space_between_items_option ) ) {
			$space_between_items = $space_between_items_option;
		}
		
		$image_size        = 'landscape';
		$image_size_option = allston_eltdf_options()->getOptionValue( 'portfolio_archive_image_size' );
		if ( ! empty( $image_size_option ) ) {
			$image_size = $image_size_option;
		}
		
		$item_layout        = 'standard-shader';
		$item_layout_option = allston_eltdf_options()->getOptionValue( 'portfolio_archive_item_layout' );
		if ( ! empty( $item_layout_option ) ) {
			$item_layout = $item_layout_option;
		}
		
		$category = $allston_taxonomy_name === 'portfolio-category' && ! empty( $allston_taxonomy_slug ) ? $allston_taxonomy_slug : '';
		$tag      = $allston_taxonomy_name === 'portfolio-tag' && ! empty( $allston_taxonomy_slug ) ? $allston_taxonomy_slug : '';
		
		$params = array(
			'type'                => 'gallery',
			'number_of_items'     => $number_of_items,
			'number_of_columns'   => $number_of_columns,
			'space_between_items' => $space_between_items,
			'image_proportions'   => $image_size,
			'category'            => $category,
			'tag'                 => $tag,
			'item_layout'         => $item_layout,
			'pagination_type'     => 'load-more'
		);
		
		$html = allston_eltdf_execute_shortcode( 'eltdf_portfolio_list', $params );

		echo allston_eltdf_get_module_part($html);
	}
}

// Load portfolio shortcodes
if(!function_exists('allston_core_include_portfolio_shortcodes_files')) {
    /**
     * Loades all shortcodes by going through all folders that are placed directly in shortcodes folder
     */
    function allston_core_include_portfolio_shortcodes_files() {
        foreach(glob(ALLSTON_CORE_CPT_PATH.'/portfolio/shortcodes/*/load.php') as $shortcode_load) {
            include_once $shortcode_load;
        }
    }

    add_action('allston_core_action_include_shortcodes_file', 'allston_core_include_portfolio_shortcodes_files');
}

if ( ! function_exists( 'allston_core_set_portfolio_single_info_follow_body_class' ) ) {
	/**
	 * Function that adds follow portfolio info class to body if sticky sidebar is enabled on portfolio single layouts
	 *
	 * @param $classes array of body classes
	 *
	 * @return array with follow portfolio info class body class added
	 */
	function allston_core_set_portfolio_single_info_follow_body_class( $classes ) {
		if ( is_singular( 'portfolio-item' ) && allston_eltdf_options()->getOptionValue( 'portfolio_single_sticky_sidebar' ) == 'yes' ) {
			$classes[] = 'eltdf-follow-portfolio-info';
		}
		
		return $classes;
	}
	
	add_filter( 'body_class', 'allston_core_set_portfolio_single_info_follow_body_class' );
}

if ( ! function_exists( 'allston_core_single_portfolio_title_display' ) ) {
	/**
	 * Function that checks option for single portfolio title and overrides it with filter
	 */
	function allston_core_single_portfolio_title_display( $show_title_area ) {
		if ( is_singular( 'portfolio-item' ) ) {
			//Override displaying title based on portfolio option
			$show_title_area_meta = allston_eltdf_get_meta_field_intersect( 'show_title_area_portfolio_single' );
			
			if ( ! empty( $show_title_area_meta ) ) {
				$show_title_area = $show_title_area_meta == 'yes' ? true : false;
			}
		}
		
		return $show_title_area;
	}
	
	add_filter( 'allston_eltdf_show_title_area', 'allston_core_single_portfolio_title_display' );
}

if ( ! function_exists( 'allston_core_set_breadcrumbs_output_for_portfolio' ) ) {
	function allston_core_set_breadcrumbs_output_for_portfolio( $childContent, $delimiter, $before, $after ) {
		
		if ( is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tag' ) ) {
			$childContent = '';
			
			$allston_taxonomy_id        = get_queried_object_id();
			$allston_taxonomy_type      = is_tax( 'portfolio-tag' ) ? 'portfolio-tag' : 'portfolio-category';
			$allston_taxonomy           = ! empty( $allston_taxonomy_id ) ? get_term_by( 'id', $allston_taxonomy_id, $allston_taxonomy_type ) : '';
			$allston_taxonomy_parent_id = isset( $allston_taxonomy->parent ) && $allston_taxonomy->parent !== 0 ? $allston_taxonomy->parent : '';
			$allston_taxonomy_parent    = $allston_taxonomy_parent_id !== '' ? get_term_by( 'id', $allston_taxonomy_parent_id, $allston_taxonomy_type ) : '';
		
			if ( ! empty( $allston_taxonomy_parent ) ) {
				$childContent .= '<a itemprop="url" href="' . get_term_link( $allston_taxonomy_parent->term_id ) . '">' . $allston_taxonomy_parent->name . '</a>' . $delimiter;
			}
			
			if ( ! empty( $allston_taxonomy ) ) {
				$childContent .= $before . esc_attr( $allston_taxonomy->name ) . $after;
			}
			
		} elseif ( is_singular( 'portfolio-item' ) ) {
			$portfolio_categories = wp_get_post_terms( allston_eltdf_get_page_id(), 'portfolio-category' );
			$childContent         = '';
			
			if ( ! empty( $portfolio_categories ) && count( $portfolio_categories ) ) {
				foreach ( $portfolio_categories as $cat ) {
					$childContent .= '<a itemprop="url" href="' . get_term_link( $cat->term_id ) . '">' . $cat->name . '</a>' . $delimiter;
				}
			}
			
			$childContent .= $before . get_the_title() . $after;
		}
		
		return $childContent;
	}
	
	add_filter( 'allston_eltdf_breadcrumbs_title_child_output', 'allston_core_set_breadcrumbs_output_for_portfolio', 10, 4 );
}

if ( ! function_exists( 'allston_core_set_single_portfolio_comments_enabled' ) ) {
	function allston_core_set_single_portfolio_comments_enabled( $comments ) {
		if ( is_singular( 'portfolio-item' ) && allston_eltdf_options()->getOptionValue( 'portfolio_single_comments' ) == 'yes' ) {
			$comments = true;
		}
		
		return $comments;
	}
	
	add_filter( 'allston_eltdf_post_type_comments', 'allston_core_set_single_portfolio_comments_enabled', 10, 1 );
}

if ( ! function_exists( 'allston_core_get_single_portfolio' ) ) {
	function allston_core_get_single_portfolio() {
		$portfolio_template = allston_eltdf_get_meta_field_intersect( 'portfolio_single_template' );
		
		$params = array(
			'holder_classes' => 'eltdf-ps-' . $portfolio_template . '-layout',
			'item_layout'    => $portfolio_template
		);
		
		allston_core_get_cpt_single_module_template_part( 'templates/single/holder', 'portfolio', $portfolio_template, $params );
	}
}

if ( ! function_exists( 'allston_core_set_single_portfolio_style' ) ) {
	/**
	 * Function that return padding for content
	 */
	function allston_core_set_single_portfolio_style( $style ) {
		$page_id      = allston_eltdf_get_page_id();
		$class_prefix = allston_eltdf_get_unique_page_class( $page_id );
		
		$current_styles = '';
		$current_style  = array();
		
		$current_selector = array(
			$class_prefix . ' .eltdf-portfolio-single-holder .eltdf-ps-info-holder'
		);
		
		$info_padding_top = get_post_meta( $page_id, 'portfolio_info_top_padding', true );
		
		if ( ! empty( $info_padding_top ) ) {
			$current_style['padding-top'] = allston_eltdf_filter_px( $info_padding_top ) . 'px';
			
			$current_styles .= allston_eltdf_dynamic_css( $current_selector, $current_style );
		}
		
		$current_style = $current_styles . $style;
		
		return $current_style;
	}
	
	add_filter( 'allston_eltdf_add_page_custom_style', 'allston_core_set_single_portfolio_style' );
}

if ( ! function_exists( 'allston_core_add_portfolio_attachment_custom_field' ) ) {
	function allston_core_add_portfolio_attachment_custom_field( $form_fields, $post = null ) {
		if ( wp_attachment_is_image( $post->ID ) ) {
			$field_value = get_post_meta( $post->ID, 'portfolio_single_masonry_image_size', true );
			
			$form_fields['portfolio_single_masonry_image_size'] = array(
				'input' => 'html',
				'label' => esc_html__( 'Image Size', 'allston-core' ),
				'helps' => esc_html__( 'Choose image size for portfolio single item - Masonry layout', 'allston-core' )
			);
			
			$form_fields['portfolio_single_masonry_image_size']['html'] = "<select name='attachments[{$post->ID}][portfolio_single_masonry_image_size]'>";
			$form_fields['portfolio_single_masonry_image_size']['html'] .= '<option ' . selected( $field_value, '', false ) . ' value="">' . esc_html__( 'Default', 'allston-core' ) . '</option>';
			$form_fields['portfolio_single_masonry_image_size']['html'] .= '<option ' . selected( $field_value, 'small', false ) . ' value="small">' . esc_html__( 'Small', 'allston-core' ) . '</option>';
			$form_fields['portfolio_single_masonry_image_size']['html'] .= '<option ' . selected( $field_value, 'large-width', false ) . ' value="large-width">' . esc_html__( 'Large Width', 'allston-core' ) . '</option>';
			$form_fields['portfolio_single_masonry_image_size']['html'] .= '<option ' . selected( $field_value, 'large-height', false ) . ' value="large-height">' . esc_html__( 'Large Height', 'allston-core' ) . '</option>';
			$form_fields['portfolio_single_masonry_image_size']['html'] .= '<option ' . selected( $field_value, 'large-width-height', false ) . ' value="large-width-height">' . esc_html__( 'Large Width Height', 'allston-core' ) . '</option>';
			$form_fields['portfolio_single_masonry_image_size']['html'] .= '</select>';
		}
		
		return $form_fields;
	}
	
	add_filter( 'attachment_fields_to_edit', 'allston_core_add_portfolio_attachment_custom_field', 10, 2 );
}

if ( ! function_exists( 'allston_core_save_image_portfolio_attachment_fields' ) ) {
	/**
	 * @param array $post
	 * @param array $attachment
	 *
	 * @return array
	 */
	function allston_core_save_image_portfolio_attachment_fields( $post, $attachment ) {
		
		if ( isset( $attachment['portfolio_single_masonry_image_size'] ) ) {
			update_post_meta( $post['ID'], 'portfolio_single_masonry_image_size', $attachment['portfolio_single_masonry_image_size'] );
		}
		
		return $post;
	}
	
	add_filter( 'attachment_fields_to_save', 'allston_core_save_image_portfolio_attachment_fields', 10, 2 );
}

if ( ! function_exists( 'allston_core_get_portfolio_single_media' ) ) {
	function allston_core_get_portfolio_single_media() {
		$image_ids       = get_post_meta( get_the_ID(), 'eltdf-portfolio-image-gallery', true );
		$single_upload   = get_post_meta( get_the_ID(), 'eltdf_portfolio_single_upload', true );
		$portfolio_media = array();
		
		if ( $image_ids !== '' ) {
			$image_ids = explode( ',', $image_ids );
			
			foreach ( $image_ids as $image_id ) {
				$media                   = array();
				$media['title']          = get_the_title( $image_id );
				$media['type']           = 'image';
				$media['description']    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				$media['image_src']      = wp_get_attachment_image_src( $image_id, 'full' );
				$media['holder_classes'] = '';
				
				$image_size = get_post_meta( $image_id, 'portfolio_single_masonry_image_size', true );
				
				if ( ! empty ( $image_size ) ) {
					$media['holder_classes'] = 'eltdf-masonry-size-' . esc_attr( $image_size );
				}
				
				$portfolio_media[] = $media;
			}
		}
		
		if ( is_array( $single_upload ) && count( $single_upload ) ) {
			foreach ( $single_upload as $item ) {
				$media = array();
				
				if ( $item['file_type'] == 'video' ) {
					$media['type']        = $item['video_type'];
					$media['description'] = 'video';
					$media['video_url']   = allston_core_get_portfolio_video_url( $item );
					
					if ( $item['video_type'] == 'self' ) {
						$media['video_cover'] = ! empty( $item['video_cover_image'] ) ? $item['video_cover_image'] : '';
					}
					
					if ( $item['video_type'] !== 'self' ) {
						$media['video_id'] = $item['video_id'];
					}
				} elseif ( $item['file_type'] == 'image' ) {
					$media['type']      = 'image';
					$media['image_src'] = $item['single_image'];
				}

				//fallback if description is not set for media
				$media['title'] = get_the_title();
				
				$portfolio_media[] = $media;
			}
		}
		
		return $portfolio_media;
	}
}

if ( ! function_exists( 'allston_core_get_portfolio_video_url' ) ) {
	function allston_core_get_portfolio_video_url( $video ) {
		switch ( $video['video_type'] ) {
			case 'youtube':
				return 'https://www.youtube.com/embed/' . $video['video_id'] . '?wmode=transparent';
				break;
			case 'vimeo';
				return 'https://player.vimeo.com/video/' . $video['video_id'] . '?title=0&amp;byline=0&amp;portrait=0';
				break;
			case 'self':
				$return_array = array();
				
				if ( ! empty( $video['video_mp4'] ) ) {
					$return_array['mp4'] = $video['video_mp4'];
				}
				
				return $return_array;
				
				break;
		}
	}
}

if(!function_exists('allston_core_get_portfolio_single_type')) {
	function allston_core_get_portfolio_single_type() {
		return allston_eltdf_get_meta_field_intersect('portfolio_single_template');
	}
}

if ( ! function_exists( 'allston_core_get_portfolio_single_media_html' ) ) {
	function allston_core_get_portfolio_single_media_html( $media ) {
		$params = array();
		
		$params['full_screen_slider'] = (allston_core_get_portfolio_single_type() == 'full-screen-slider') ? true : false;
		
		if ( $media['type'] == 'image' ) {
			$params['lightbox'] = allston_eltdf_options()->getOptionValue( 'portfolio_single_lightbox_images' ) == 'yes';
			
			$media['image_url'] = is_array( $media['image_src'] ) ? $media['image_src'][0] : $media['image_src'];
			if ( empty( $media['description'] ) ) {
				$media['description'] = $media['title'];
			}
		}
		
		if ( in_array( $media['type'], array( 'youtube', 'vimeo' ) ) ) {
			$params['lightbox'] = allston_eltdf_options()->getOptionValue( 'portfolio_single_lightbox_videos' ) == 'yes';
			
			if ( $params['lightbox'] ) {
				switch ( $media['type'] ) {
					case 'vimeo':
						$url      = 'https://vimeo.com/api/v2/video/' . $media['video_id'] . '.php';
						$request  = wp_remote_get($url);
						$response = unserialize( wp_remote_retrieve_body( $request ) );
						
						$params['video_title']    = $response[0]['title'];
						$params['lightbox_thumb'] = $response[0]['thumbnail_large'];
						break;
					case 'youtube':
						$params['video_title'] = $media['title'];
						
						$params['lightbox_thumb'] = 'https://img.youtube.com/vi/' . trim( $media['video_id'] ) . '/sddefault.jpg';
						break;
				}
			}
		}
		
		$params['media'] = $media;
		
		allston_core_get_cpt_single_module_template_part( 'templates/single/media/' . $media['type'], 'portfolio', '', $params );
	}
}

if ( ! function_exists( 'allston_core_get_portfolio_single_related_posts' ) ) {
	/**
	 * Function for returning portfolio single related posts
	 *
	 * @param $post_id
	 *
	 * @return WP_Query
	 */
	function allston_core_get_portfolio_single_related_posts( $post_id ) {
		//Get tags
		$tags = wp_get_object_terms( $post_id, 'portfolio-tag' );
		
		//Get categories
		$categories = wp_get_object_terms( $post_id, 'portfolio-category' );
		
		$tag_ids = array();
		if ( $tags ) {
			foreach ( $tags as $tag ) {
				$tag_ids[] = $tag->term_id;
			}
		}
		
		$category_ids = array();
		if ( $categories ) {
			foreach ( $categories as $category ) {
				$category_ids[] = $category->term_id;
			}
		}
		
		$hasRelatedByTag = false;
		
		if ( $tag_ids ) {
			$related_by_tag = allston_core_get_portfolio_single_related_posts_by_param( $post_id, $tag_ids, 'portfolio-tag' );
			
			if ( ! empty( $related_by_tag->posts ) ) {
				$hasRelatedByTag = true;
				
				return $related_by_tag;
			}
		}
		
		if ( $categories && ! $hasRelatedByTag ) {
			$related_by_category = allston_core_get_portfolio_single_related_posts_by_param( $post_id, $category_ids, 'portfolio-category' );
			
			if ( ! empty( $related_by_category->posts ) ) {
				return $related_by_category;
			}
		}
	}
}

if ( ! function_exists( 'allston_core_get_portfolio_single_related_posts_by_param' ) ) {
	/**
	 * @param $post_id - Post ID
	 * @param $term_ids - Category or Tag IDs
	 * @param $taxonomy
	 *
	 * @return WP_Query
	 */
	function allston_core_get_portfolio_single_related_posts_by_param( $post_id, $term_ids, $taxonomy ) {
		$args = array(
			'post_status'    => 'publish',
			'post__not_in'   => array( $post_id ),
			'order'          => 'DESC',
			'orderby'        => 'date',
			'posts_per_page' => '4',
			'tax_query'      => array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => $term_ids,
				),
			)
		);
		
		$related_by_taxonomy = new WP_Query( $args );
		
		return $related_by_taxonomy;
	}
}

if ( ! function_exists( 'allston_core_add_portfolio_to_search_types' ) ) {
	function allston_core_add_portfolio_to_search_types( $post_types ) {
		
		$post_types['portfolio-item'] = esc_html__( 'Portfolio', 'allston-core' );
		
		return $post_types;
	}
	
	add_filter( 'allston_eltdf_search_post_type_widget_params_post_type', 'allston_core_add_portfolio_to_search_types' );
}

/**
 * Loads more function for portfolio.
 */
if ( ! function_exists( 'allston_core_portfolio_ajax_load_more' ) ) {
	function allston_core_portfolio_ajax_load_more() {
		$shortcode_params = array();
		
		if ( ! empty( $_POST ) ) {
			foreach ( $_POST as $key => $value ) {
				if ( $key !== '' ) {
					$addUnderscoreBeforeCapitalLetter = preg_replace( '/([A-Z])/', '_$1', $key );
					$setAllLettersToLowercase         = strtolower( $addUnderscoreBeforeCapitalLetter );
					
					$shortcode_params[ $setAllLettersToLowercase ] = $value;
				}
			}
		}
		
		$port_list = new \AllstonCore\CPT\Shortcodes\Portfolio\PortfolioList();
		
		$query_array                     = $port_list->getQueryArray( $shortcode_params );
		$query_results                   = new \WP_Query( $query_array );
		$shortcode_params['this_object'] = $port_list;
		
		$html = '';
		if ( $query_results->have_posts() ):
			while ( $query_results->have_posts() ) : $query_results->the_post();
				$html .= allston_core_get_cpt_shortcode_module_template_part( 'portfolio', 'portfolio-list', 'portfolio-item', $shortcode_params['item_type'], $shortcode_params );
			endwhile;
		else:
			$html .= allston_core_get_cpt_shortcode_module_template_part( 'portfolio', 'portfolio-list', 'parts/posts-not-found', '', $shortcode_params );
		endif;
		
		wp_reset_postdata();
		
		$return_obj = array(
			'html' => $html,
		);
		
		echo json_encode( $return_obj );
		exit;
	}
}

add_action( 'wp_ajax_nopriv_allston_core_portfolio_ajax_load_more', 'allston_core_portfolio_ajax_load_more' );
add_action( 'wp_ajax_allston_core_portfolio_ajax_load_more', 'allston_core_portfolio_ajax_load_more' );