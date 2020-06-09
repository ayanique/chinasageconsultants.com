<?php
$overlay_styles = $this_object->getOverlayStyles($params);

echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/image', $item_style, $params); ?>

<div class="eltdf-pli-text-holder" <?php allston_eltdf_inline_style($overlay_styles); ?>>
	<div class="eltdf-pli-text-wrapper">
		<div class="eltdf-pli-text">
			<?php echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/title', $item_style, $params); ?>

			<?php echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/category', $item_style, $params); ?>

			<?php echo allston_core_get_cpt_shortcode_module_template_part('portfolio', 'portfolio-list', 'parts/images-count', $item_style, $params); ?>
		</div>
	</div>
</div>