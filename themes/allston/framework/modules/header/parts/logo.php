<?php
	$attachment_meta = allston_eltdf_get_attachment_meta_from_url($logo_image);
	$hwstring = !empty($attachment_meta) ? image_hwstring( $attachment_meta['width'], $attachment_meta['height'] ) : '';

	if(!empty($logo_image_dark)) {
		$attachment_meta_dark = allston_eltdf_get_attachment_meta_from_url($logo_image_dark);
		$hwstring_dark = !empty($attachment_meta_dark) ? image_hwstring($attachment_meta_dark['width'], $attachment_meta_dark['height']) : '';
	}

	if(!empty($logo_image_light)) {
		$attachment_meta_light = allston_eltdf_get_attachment_meta_from_url( $logo_image_light );
		$hwstring_light = !empty($attachment_meta_light) ? image_hwstring($attachment_meta_light['width'], $attachment_meta_light['height']) : '';
	}
?>

<?php do_action('allston_eltdf_before_site_logo'); ?>

<div class="eltdf-logo-wrapper">
    <a itemprop="url" href="<?php echo esc_url(home_url('/')); ?>" <?php allston_eltdf_inline_style($logo_styles); ?>>
        <img itemprop="image" class="eltdf-normal-logo" src="<?php echo esc_url($logo_image); ?>" <?php echo wp_kses($hwstring, array('width' => true, 'height' => true)); ?> alt="<?php esc_attr_e('logo','allston'); ?>"/>
        <?php if(!empty($logo_image_dark)){ ?><img itemprop="image" class="eltdf-dark-logo" src="<?php echo esc_url($logo_image_dark); ?>" <?php echo wp_kses($hwstring_dark, array('width' => true, 'height' => true)); ?> alt="<?php esc_attr_e('dark logo','allston'); ?>"/><?php } ?>
        <?php if(!empty($logo_image_light)){ ?><img itemprop="image" class="eltdf-light-logo" src="<?php echo esc_url($logo_image_light); ?>" <?php echo wp_kses($hwstring_light, array('width' => true, 'height' => true)); ?> alt="<?php esc_attr_e('light logo','allston'); ?>"/><?php } ?>
    </a>
</div>

<?php do_action('allston_eltdf_after_site_logo'); ?>