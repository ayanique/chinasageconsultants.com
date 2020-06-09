<?php

namespace AllstonCore\CPT\Shortcodes\Portfolio;

use AllstonCore\Lib;

class PortfolioFullscreenSlider implements Lib\ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'eltdf_portfolio_fullscreen_slider';

		add_action( 'vc_before_init', array( $this, 'vcMap' ) );

		//Portfolio category filter
		add_filter( 'vc_autocomplete_eltdf_portfolio_fullscreen_slider_category_callback', array( &$this, 'portfolioCategoryAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array

		//Portfolio category render
		add_filter( 'vc_autocomplete_eltdf_portfolio_fullscreen_slider_category_render', array( &$this, 'portfolioCategoryAutocompleteRender', ), 10, 1 ); // Get suggestion(find). Must return an array

		//Portfolio selected projects filter
		add_filter( 'vc_autocomplete_eltdf_portfolio_fullscreen_slider_selected_projects_callback', array( &$this, 'portfolioIdAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array

		//Portfolio selected projects render
		add_filter( 'vc_autocomplete_eltdf_portfolio_fullscreen_slider_selected_projects_render', array( &$this, 'portfolioIdAutocompleteRender', ), 10, 1 ); // Render exact portfolio. Must return an array (label,value)

		//Portfolio tag filter
		add_filter( 'vc_autocomplete_eltdf_portfolio_fullscreen_slider_tag_callback', array( &$this, 'portfolioTagAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array

		//Portfolio tag render
		add_filter( 'vc_autocomplete_eltdf_portfolio_fullscreen_slider_tag_render', array( &$this, 'portfolioTagAutocompleteRender', ), 10, 1 ); // Get suggestion(find). Must return an array
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map( array(
					'name'     => esc_html__( 'Portfolio Fullscreen Slider', 'allston-core' ),
					'base'     => $this->getBase(),
					'category' => esc_html__( 'by ALLSTON', 'allston-core' ),
					'icon'     => 'icon-wpb-portfolio-fullscreen-slider extended-custom-icon',
					'params'   => array(
						array(
							'type'        => 'textfield',
							'param_name'  => 'number_of_items',
							'heading'     => esc_html__( 'Number of Portfolios', 'allston-core' ),
							'description' => esc_html__( 'Set number of items. Enter -1 to show all.', 'allston-core' ),
							'value'       => '-1'
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'item_type',
							'heading'    => esc_html__( 'Click Behavior', 'allston-core' ),
							'value'      => array(
								esc_html__( 'Open portfolio single page on click', 'allston-core' )   => '',
								esc_html__( 'Open custom link', 'allston-core' )   => 'custom-link'
							)
						),
						array(
							'type'        => 'autocomplete',
							'param_name'  => 'category',
							'heading'     => esc_html__( 'One-Category Portfolio Slider', 'allston-core' ),
							'description' => esc_html__( 'Enter one category slug (leave empty for showing all categories)', 'allston-core' )
						),
						array(
							'type'        => 'autocomplete',
							'param_name'  => 'selected_projects',
							'heading'     => esc_html__( 'Show Only Projects with Listed IDs', 'allston-core' ),
							'settings'    => array(
								'multiple'      => true,
								'sortable'      => true,
								'unique_values' => true
							),
							'description' => esc_html__( 'Delimit ID numbers by comma (leave empty for all)', 'allston-core' )
						),
						array(
							'type'        => 'autocomplete',
							'param_name'  => 'tag',
							'heading'     => esc_html__( 'One-Tag Portfolio Slider', 'allston-core' ),
							'description' => esc_html__( 'Enter one tag slug (leave empty for showing all tags)', 'allston-core' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'orderby',
							'heading'     => esc_html__( 'Order By', 'allston-core' ),
							'value'       => array_flip( allston_eltdf_get_query_order_by_array() ),
							'save_always' => true
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'order',
							'heading'     => esc_html__( 'Order', 'allston-core' ),
							'value'       => array_flip( allston_eltdf_get_query_order_array() ),
							'save_always' => true
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'title_tag',
							'heading'    => esc_html__( 'Title Tag', 'allston-core' ),
							'value'      => array_flip( allston_eltdf_get_title_tag( true ) ),
							'group'      => esc_html__( 'Content Layout', 'allston-core' )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'title_text_transform',
							'heading'    => esc_html__( 'Title Text Transform', 'allston-core' ),
							'value'      => array_flip( allston_eltdf_get_text_transform_array( true ) ),
							'group'      => esc_html__( 'Content Layout', 'allston-core' )
						)
					)
				)
			);
		}
	}

	public function render( $atts, $content = null ) {
		$args   = array(
			'number_of_columns'        => '4',
			'number_of_items'          => '-1',
			'item_type'                => '',
			'category'                 => '',
			'selected_projects'        => '',
			'tag'                      => '',
			'orderby'                  => 'date',
			'order'                    => 'ASC',
			'title_tag'                => 'h3',
			'title_text_transform'     => '',
			'enable_title'             => 'yes',
			'enable_category'          => 'yes'
		);
		$params = shortcode_atts( $args, $atts );

		/***
		 * @params query_results
		 * @params holder_data
		 * @params holder_classes
		 * @params holder_inner_classes
		 */
		$additional_params = array();

		$query_array                        = $this->getQueryArray( $params );
		$query_results                      = new \WP_Query( $query_array );
		$additional_params['query_results'] = $query_results;

		$number_of_posts_shown = count($query_results->posts);

		$additional_params['holder_classes']       = $this->getHolderClasses( $params );
		$additional_params['holder_data']          = $this->getHolderData( $params, $number_of_posts_shown );

		$params['this_object'] = $this;

		$html = allston_core_get_cpt_shortcode_module_template_part( 'portfolio', 'portfolio-fullscreen-slider', 'portfolio-fullscreen-slider-holder', '', $params, $additional_params );

		return $html;
	}

	public function getQueryArray( $params ) {
		$query_array = array(
			'post_status'    => 'publish',
			'post_type'      => 'portfolio-item',
			'posts_per_page' => $params['number_of_items'],
			'orderby'        => $params['orderby'],
			'order'          => $params['order']
		);

		if ( ! empty( $params['category'] ) ) {
			$query_array['portfolio-category'] = $params['category'];
		}

		$project_ids = null;
		if ( ! empty( $params['selected_projects'] ) ) {
			$project_ids             = explode( ',', $params['selected_projects'] );
			$query_array['post__in'] = $project_ids;
		}

		if ( ! empty( $params['tag'] ) ) {
			$query_array['portfolio-tag'] = $params['tag'];
		}

		if ( ! empty( $params['next_page'] ) ) {
			$query_array['paged'] = $params['next_page'];
		} else {
			$query_array['paged'] = 1;
		}

		return $query_array;
	}

	public function getHolderClasses( $params ) {
		$classes = array();

		return implode( ' ', $classes );
	}

	public function getHolderData( $params, $number_of_posts_shown ) {
		$data = array();

		return implode( ' ', $data );
	}

	public function getTitleStyles( $params ) {
		$styles = array();

		if ( ! empty( $params['title_text_transform'] ) ) {
			$styles[] = 'text-transform: ' . $params['title_text_transform'];
		}

		return implode( ';', $styles );
	}
	
	public function getItemLink( $params ) {
		$portfolio_link_meta = get_post_meta( get_the_ID(), 'portfolio_external_link', true );
		$custom_link = ! empty( $params['item_type'] ) && $params['item_type'] == 'custom-link' ? true : false;
		$portfolio_link      = ! empty( $portfolio_link_meta ) && $custom_link ? $portfolio_link_meta : get_permalink( get_the_ID() );
		
		return apply_filters( 'allston_eltdf_portfolio_external_link', $portfolio_link );
	}
	
	public function getItemLinkTarget( $params ) {
		$portfolio_link_meta   = get_post_meta( get_the_ID(), 'portfolio_external_link', true );
		$custom_link = ! empty( $params['item_type'] ) && $params['item_type'] == 'custom-link' ? true : false;
		$portfolio_link_target = ! empty( $portfolio_link_meta ) && $custom_link ? '_blank' : '_self';
		
		return apply_filters( 'allston_eltdf_portfolio_external_link_target', $portfolio_link_target );
	}

	public function getItemBackgroundImage() {

		$image_src = get_the_post_thumbnail_url( get_the_ID() );
		$image = 'background-image: url('.esc_url($image_src).')';

		return $image;
	}

	public function getItemDescription() {

		$description = get_post_meta( get_the_ID(), 'portfolio_short_description', true );

		return $description;
	}

	/**
	 * Filter portfolio categories
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function portfolioCategoryAutocompleteSuggester( $query ) {
		global $wpdb;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.slug AS slug, a.name AS portfolio_category_title
					FROM {$wpdb->terms} AS a
					LEFT JOIN ( SELECT term_id, taxonomy  FROM {$wpdb->term_taxonomy} ) AS b ON b.term_id = a.term_id
					WHERE b.taxonomy = 'portfolio-category' AND a.name LIKE '%%%s%%'", stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['slug'];
				$data['label'] = ( ( strlen( $value['portfolio_category_title'] ) > 0 ) ? esc_html__( 'Category', 'allston-core' ) . ': ' . $value['portfolio_category_title'] : '' );
				$results[]     = $data;
			}
		}

		return $results;
	}

	/**
	 * Find portfolio category by slug
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function portfolioCategoryAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get portfolio category
			$portfolio_category = get_term_by( 'slug', $query, 'portfolio-category' );
			if ( is_object( $portfolio_category ) ) {

				$portfolio_category_slug  = $portfolio_category->slug;
				$portfolio_category_title = $portfolio_category->name;

				$portfolio_category_title_display = '';
				if ( ! empty( $portfolio_category_title ) ) {
					$portfolio_category_title_display = esc_html__( 'Category', 'allston-core' ) . ': ' . $portfolio_category_title;
				}

				$data          = array();
				$data['value'] = $portfolio_category_slug;
				$data['label'] = $portfolio_category_title_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}

	/**
	 * Filter portfolios by ID or Title
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function portfolioIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$portfolio_id    = (int) $query;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT ID AS id, post_title AS title
					FROM {$wpdb->posts} 
					WHERE post_type = 'portfolio-item' AND ( ID = '%d' OR post_title LIKE '%%%s%%' )", $portfolio_id > 0 ? $portfolio_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'allston-core' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'allston-core' ) . ': ' . $value['title'] : '' );
				$results[]     = $data;
			}
		}

		return $results;
	}

	/**
	 * Find portfolio by id
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function portfolioIdAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get portfolio
			$portfolio = get_post( (int) $query );
			if ( ! is_wp_error( $portfolio ) ) {

				$portfolio_id    = $portfolio->ID;
				$portfolio_title = $portfolio->post_title;

				$portfolio_title_display = '';
				if ( ! empty( $portfolio_title ) ) {
					$portfolio_title_display = ' - ' . esc_html__( 'Title', 'allston-core' ) . ': ' . $portfolio_title;
				}

				$portfolio_id_display = esc_html__( 'Id', 'allston-core' ) . ': ' . $portfolio_id;

				$data          = array();
				$data['value'] = $portfolio_id;
				$data['label'] = $portfolio_id_display . $portfolio_title_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}

	/**
	 * Filter portfolio tags
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function portfolioTagAutocompleteSuggester( $query ) {
		global $wpdb;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.slug AS slug, a.name AS portfolio_tag_title
					FROM {$wpdb->terms} AS a
					LEFT JOIN ( SELECT term_id, taxonomy  FROM {$wpdb->term_taxonomy} ) AS b ON b.term_id = a.term_id
					WHERE b.taxonomy = 'portfolio-tag' AND a.name LIKE '%%%s%%'", stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['slug'];
				$data['label'] = ( ( strlen( $value['portfolio_tag_title'] ) > 0 ) ? esc_html__( 'Tag', 'allston-core' ) . ': ' . $value['portfolio_tag_title'] : '' );
				$results[]     = $data;
			}
		}

		return $results;
	}

	/**
	 * Find portfolio tag by slug
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function portfolioTagAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get portfolio category
			$portfolio_tag = get_term_by( 'slug', $query, 'portfolio-tag' );
			if ( is_object( $portfolio_tag ) ) {

				$portfolio_tag_slug  = $portfolio_tag->slug;
				$portfolio_tag_title = $portfolio_tag->name;

				$portfolio_tag_title_display = '';
				if ( ! empty( $portfolio_tag_title ) ) {
					$portfolio_tag_title_display = esc_html__( 'Tag', 'allston-core' ) . ': ' . $portfolio_tag_title;
				}

				$data          = array();
				$data['value'] = $portfolio_tag_slug;
				$data['label'] = $portfolio_tag_title_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}
}