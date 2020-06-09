<article class="eltdf-fpg-item">
	<div class="eltdf-fpg-item-inner">
		<div class="eltdf-fpg-item-table">
			<div class="eltdf-fpg-item-table-cell">
				<?php echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'fullscreen-portfolio-grid', 'parts/category', '', $params); ?>

				<?php echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'fullscreen-portfolio-grid', 'parts/title', '', $params); ?>
			</div>
		</div>
		
		<a itemprop="url" class="eltdf-fpgi-link eltdf-block-drag-link" href="<?php echo esc_url($this_object->getItemLink($params)); ?>" target="<?php echo esc_attr($this_object->getItemLinkTarget($params)); ?>"></a>
	</div>
</article>