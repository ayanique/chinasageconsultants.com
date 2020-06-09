<div class="eltdf-banner-holder <?php echo esc_attr($holder_classes); ?>">
    <div class="eltdf-banner-image">
        <?php echo wp_get_attachment_image($image, 'full'); ?>
    </div>
    <div class="eltdf-banner-text-holder">
	    <div class="eltdf-banner-text-outer">
		    <div class="eltdf-banner-text-inner" <?php echo allston_eltdf_get_inline_style($content_styles); ?>>
			    <?php if(!empty($title)) { ?>
				    <<?php echo esc_attr($title_tag); ?> class="eltdf-banner-title" <?php echo allston_eltdf_get_inline_style($title_styles); ?>>
				    <?php echo wp_kses($title, array('span' => array('class' => true))); ?>
			    </<?php echo esc_attr($title_tag); ?>>
			    <?php } ?>
			    <?php if(!empty($title_second)) { ?>
				    <<?php echo esc_attr($title_tag); ?> class="eltdf-banner-title eltdf-banner-title-second" <?php echo allston_eltdf_get_inline_style($title_styles); ?>>
					    <?php echo wp_kses($title_second, array('span' => array('class' => true))); ?>
				    </<?php echo esc_attr($title_tag); ?>>
			    <?php } ?>
		        <?php if(!empty($subtitle)) { ?>
		            <<?php echo esc_attr($subtitle_tag); ?> class="eltdf-banner-subtitle" <?php echo allston_eltdf_get_inline_style($subtitle_styles); ?>>
			            <?php echo esc_html($subtitle); ?>
		            </<?php echo esc_attr($subtitle_tag); ?>>
		        <?php } ?>
			</div>
		</div>
	</div>
	<?php if (!empty($link)) { ?>
        <a itemprop="url" class="eltdf-banner-link" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>"></a>
    <?php } ?>
</div>