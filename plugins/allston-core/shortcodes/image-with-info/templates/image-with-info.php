<div class="eltdf-image-with-info <?php echo esc_attr($holder_classes); ?>">
	<div class="eltdf-image-with-info-inner">
		<div class="eltdf-iwi-image">
			<?php echo wp_get_attachment_image($image, 'full'); ?>
			<div class="eltdf-iwi-icons">
				<?php foreach( $social_icons as $social_icon ) { ?>
					<?php if(!empty($social_icon['icon_link'])) : ?>
						<a itemprop="url" class="eltdf-iwi-icon" href="<?php echo esc_url($social_icon['icon_link']); ?>" target="<?php echo esc_attr($social_icon['icon_target']); ?>">
					<?php endif; ?>
					<?php
						$iconPackName = allston_eltdf_icon_collections()->getIconCollectionParamNameByKey( $social_icon['icon_pack'] );
						$icon         = $social_icon[ $iconPackName ];
						$icon_pack    = $social_icon['icon_pack'];
						echo allston_eltdf_icon_collections()->renderIcon($icon, $icon_pack);
					?>
					<?php if(!empty($social_icon['icon_link'])) : ?>
						</a>
					<?php endif; ?>
				<?php } ?>
			</div>
		</div>
		<div class="eltdf-iwi-content">
			<?php if( ! empty( $title ) ) { ?>
				<span class="eltdf-iwi-title">
					<?php echo esc_html($title); ?>
				</span>
			<?php } ?>
			<?php if($enable_separator == 'yes') :
				echo do_shortcode( '[eltdf_separator]' );
			endif; ?>
			<?php if( ! empty( $text ) ) { ?>
				<p class="eltdf-iwi-text">
					<?php echo esc_html($text); ?>
				</p>
			<?php } ?>
			<?php if(!empty($button_text)) { ?>
				<span class="eltdf-iwi-button">
					<?php echo allston_eltdf_get_button_html(array(
						'text'  => $button_text,
						'link'  => $button_link,
						'target'=> $button_target,
						'type'  => $button_type,
						'size'  => 'small',
					)); ?>
				</span>
			<?php } ?>
		</div>
	</div>
</div>