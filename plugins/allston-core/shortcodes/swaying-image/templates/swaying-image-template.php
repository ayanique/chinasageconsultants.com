<div class="eltdf-swaying-image-holder <?php echo esc_attr($holder_classes); ?>">
	<?php 
		$bgrnd_img_url = wp_get_attachment_url( $image );
	?>
	<div class="eltdf-swaying-image" style="background-image: url(<?php echo esc_url($bgrnd_img_url); ?>)"></div>
	<?php if ($enable_border == 'yes') : ?>
		<div class="eltdf-si-border"  <?php echo allston_eltdf_get_inline_style($inner_styles); ?>></div>
	<?php endif; ?>
</div>