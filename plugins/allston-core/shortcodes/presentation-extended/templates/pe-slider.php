<?php if ($slider_uncover_mask != '') : ?>
	<div class="eltdf-pe-slider-mask" <?php echo allston_eltdf_inline_style($slider_mask_styles); ?>></div>
<?php endif; ?>
<div class="eltdf-pe-slider eltdf-owl-slider" <?php echo allston_eltdf_get_inline_attrs($slider_data); ?>>
	<?php foreach ($slider_images as $image) { ?>
		<?php $slider_image_holder_styles = $this_object->getImageHolderStyles($image['image_id']); ?>
		<div class="eltdf-pe-slider-image" <?php allston_eltdf_inline_style($slider_image_holder_styles); ?>>
			<div class="eltdf-pe-slider-responsive-image">
				<?php echo wp_get_attachment_image($image['image_id'], 'full'); ?>
			</div>
		</div>
	<?php } ?>
</div>