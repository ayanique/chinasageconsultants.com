<div class="eltdf-portfolio-list-holder <?php echo esc_attr($holder_classes); ?>" <?php echo wp_kses($holder_data, array('data')); ?>>
	<?php echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/filter', '', $params); ?>
	<div class="eltdf-pl-inner eltdf-outer-space <?php echo esc_attr($holder_inner_classes); ?> clearfix">
		<?php if ($item_style == 'full-screen') : ?>
		<div class="swiper-container"><div class="swiper-wrapper">
		<?php endif; ?>
		<?php
			if($query_results->have_posts()):
				while ( $query_results->have_posts() ) : $query_results->the_post();
					echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'portfolio-item', $item_type, $params);
				endwhile;
			else:
				echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/posts-not-found');
			endif;
		
			wp_reset_postdata();
		?>
		<?php if ($item_style == 'full-screen') : ?>
		</div>
			<?php if ($enable_navigation == 'yes') : ?>
				<span class="eltdf-prev"><span class="eltdf-prev-icon fa fa-chevron-top"></span></span>
				<span class="eltdf-next"><span class="eltdf-next-icon fa fa-chevron-bottom"></span></span>
			<?php endif; ?>
		</div>
		<div id="eltdf-ptf-info-block">
			<div class="eltdf-pli-text-holder">
				<div class="eltdf-pli-text-wrapper">
					<div class="eltdf-pli-text">
						<div class="eltdf-pli-text-inner">
							<a class="eltdf-pli-up-arrow" href="#"><i class="fa fa fa-chevron-up"></i></a>
							<h2 itemprop="name" class="eltdf-pli-title entry-title"></h2>
							<div class="eltdf-pli-excerpt"></div>
							<div class="eltdf-pli-info-holder">
								<p itemprop="description" class="eltdf-pli-excerpt"></p>
								<div class="eltdf-pli-category-info eltdf-pli-info">
									<h5 class="eltdf-pli-info-title"><?php esc_html_e('Category:', 'allston-core'); ?></h5>
									<p><a itemprop="url" href="#"></a></p>
								</div>
								<div class="eltdf-pli-date-info eltdf-pli-info">
									<h5 class="eltdf-pli-info-title"><?php esc_html_e('Date:', 'allston-core'); ?></h5>
									<p></p>
								</div>
								<div class="eltdf-pli-tag-info eltdf-pli-info">
									<h5 class="eltdf-pli-info-title"><?php esc_html_e('Tag:', 'allston-core'); ?></h5>
									<p><a itemprop="url" href="#"></a></p>
								</div>
								<div class="eltdf-pli-share-info eltdf-pli-info">
									<h4 class="eltdf-pli-share-title"><?php esc_html_e('Share:', 'allston-core'); ?></h4>
									<div class="eltdf-social-share-holder eltdf-list">
										<ul>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	</div>
	
	<?php echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'pagination/'.$pagination_type, '', $params, $additional_params); ?>
</div>