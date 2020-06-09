<div class="eltdf-pe-image" <?php allston_eltdf_inline_style($image_holder_styles); ?>>
	<div class="eltdf-responsive-image">
		<?php echo wp_get_attachment_image($section_image, 'full'); ?>
	</div>
	<div class="eltdf-pe-info-holder">
		<span class="eltdf-pe-info eltdf-pe-info-title"><?php echo esc_html($product_title); ?></span>
		<span class="eltdf-pe-info eltdf-pe-info-description"><?php echo esc_html($product_description); ?></span>
		<span class="eltdf-pe-info eltdf-pe-info-price"><?php echo esc_html($product_price); ?></span>
	</div>
</div>