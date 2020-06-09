<div class="eltdf-portfolio-fullscreen-slider-holder <?php echo esc_attr($holder_classes); ?>" <?php echo esc_attr($holder_data);?>>
	<div class="eltdf-pfs-articles-holder">
		<?php
			if($query_results->have_posts()):
				$image_html = '';
				$i = 0; ?>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    	<?php
						while ( $query_results->have_posts() ) : $query_results->the_post();
							$i++;
							$params['order'] = $i;
							echo allston_core_get_cpt_shortcode_module_template_part('portfolio','portfolio-fullscreen-slider', 'portfolio-item-fullscreen-slider', '', $params);
							$image_html .=allston_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-fullscreen-slider', 'parts/image-fullscreen-slider', '', $params);;
						endwhile; ?>
					</div>
				</div>
			<?php else:
				echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-fullscreen-slider', 'parts/posts-not-found');
			endif;
		
			wp_reset_postdata();
		?>
	</div>
	<div class="eltdf-pfs-image-holder">
		<?php echo ($image_html); ?>
	</div>
</div>