<div class="eltdf-fullscreen-portfolio-grid-holder <?php echo esc_attr($holder_classes); ?>" <?php echo esc_attr($holder_data);?>>
	<div class="eltdf-fpg-holder-inner">
		<?php
			if($query_results->have_posts()):
				$image_html = '';
				while ( $query_results->have_posts() ) : $query_results->the_post();
					echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'fullscreen-portfolio-grid', 'portfolio-item-grid', '', $params);
					$image_html .=allston_core_get_cpt_shortcode_module_template_part('portfolio', 'fullscreen-portfolio-grid', 'parts/image-url', '', $params);;
				endwhile;
			else:
				echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'fullscreen-portfolio-grid', 'parts/posts-not-found');
			endif;
		
			wp_reset_postdata();
		?>
	</div>
	<div class="eltdf-fpg-image-holder">
		<?php echo ($image_html); ?>
	</div>
</div>