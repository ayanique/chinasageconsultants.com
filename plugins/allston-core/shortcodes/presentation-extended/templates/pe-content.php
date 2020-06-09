<?php
$i    = 0;
$rand = rand(0,1000);
?>
<div class="eltdf-pe-content" <?php allston_eltdf_inline_style($content_holder_styles); ?>>
	<?php if(!empty($title)) { ?>
		<<?php echo esc_attr($title_tag); ?> class="eltdf-pe-title">
			<?php echo esc_html($title); ?>
		</<?php echo esc_attr($title_tag); ?>>
	<?php } ?>
	<?php if($enable_separator == 'yes') :
		echo do_shortcode( '[eltdf_separator]' );
	endif; ?>
	<?php if(!empty($text)) { ?>
		<p class="eltdf-pe-text">
			<?php echo esc_html($text); ?>
		</p>
	<?php } ?>
	<?php if( $content_type == 'signature-image' && !empty( $signature_image ) ) { ?>
		<span class="eltdf-pe-signature">
			<?php echo wp_get_attachment_image($signature_image, 'full'); ?>
		</span>
	<?php } else if( $content_type == 'list-items' && !empty( $list_items ) ) { ?>
		<ul class="eltdf-pe-list-items">
			<?php foreach( $list_items as $item ) { ?>
				<li>
					<span class="eltdf-pe-item-icon icon_box-checked"></span>
					<span class="eltdf-pe-item-value"><?php echo esc_html($item['text']) ?></span>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>
	<?php if( !empty( $small_gal_images ) ) { ?>
		<span class="eltdf-pe-content-gallery clearfix">
			<?php foreach ($small_gal_images as $image) { ?>
			<a itemprop="image" class="eltdf-pe-lightbox" href="<?php echo esc_url($image['url']); ?>" data-rel="prettyPhoto[image_gallery_pretty_photo-<?php echo esc_attr($rand); ?>]" title="<?php echo esc_attr($image['title']); ?>">
				<?php echo wp_get_attachment_image($image['image_id'], 'allston_eltdf_square'); ?>
			</a>
			<?php } ?>
		</span>
	<?php } ?>
</div>