<article class="eltdf-pfs-item swiper-slide">
	<div class="eltdf-pfs-item-inner">

		<div class="eltdf-pfs-order eltdf-pfs-item-table-cell">
			<?php echo esc_html($order.'.'); ?>
		</div>
		<div class="eltdf-pfs-title eltdf-pfs-item-table-cell">
			<?php echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-fullscreen-slider', 'parts/title', '', $params); ?>
		</div>
		<div class="eltdf-pfs-category eltdf-pfs-item-table-cell">
			<?php echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-fullscreen-slider', 'parts/category', '', $params); ?>
		</div>
	</div>
	<a itemprop="url" class="eltdf-pfs-link eltdf-block-drag-link" href="<?php echo esc_url($this_object->getItemLink($params)); ?>" target="<?php echo esc_attr($this_object->getItemLinkTarget($params)); ?>"></a>
</article>