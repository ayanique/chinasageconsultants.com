<div class="eltdf-process-item <?php echo esc_attr( $holder_classes ); ?>">
	<div class="eltdf-pi-content">
        <?php if(!empty($image)) { ?>
            <div class="eltdf-pi-image-holder">
                <?php echo wp_get_attachment_image($image, 'full'); ?>
	            <?php if(!empty($text)) { ?>
		            <div class="eltdf-pi-text-holder">
			            <div class="eltdf-pi-text-holder-inner">
				            <span class="eltdf-pi-text" <?php echo allston_eltdf_get_inline_style($text_styles); ?>>
					            <?php echo esc_html($text); ?>
				            </span>
			            </div>
		            </div>
	            <?php } ?>
            </div>
        <?php } ?>
		<?php if(!empty($title)) { ?>
			<<?php echo esc_attr($title_tag); ?> class="eltdf-pi-title" <?php echo allston_eltdf_get_inline_style($title_styles); ?>><?php echo esc_html($title); ?></<?php echo esc_attr($title_tag); ?>>
		<?php } ?>
	</div>
</div>