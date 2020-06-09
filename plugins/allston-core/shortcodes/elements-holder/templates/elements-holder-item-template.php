<div class="eltdf-eh-item <?php echo esc_attr($holder_classes); ?>" <?php echo allston_eltdf_get_inline_style($holder_styles); ?> <?php echo allston_eltdf_get_inline_attrs($holder_data); ?>>
	<?php if (!empty($background_image) && !empty($background_color)) : ?>
		<div class="eltdf-eh-item-color-overlay" style="background-color: <?php echo esc_attr($background_color) ?>"></div>
	<?php endif; ?>
	<div class="eltdf-eh-item-inner">
		<div class="eltdf-eh-item-content <?php echo esc_attr($holder_rand_class); ?>" <?php echo allston_eltdf_get_inline_style($content_styles); ?>>
			<?php echo do_shortcode($content); ?>
		</div>
	</div>
</div>

