<div <?php allston_eltdf_class_attribute($holder_classes); ?>>
	<div class="eltdf-parallax-info-item">
		<?php if ( !empty( $link ) ) : ?>
			<a class="eltdf-pii-link" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($link_target); ?>"></a>
		<?php endif; ?>
		<?php $classes = array('main','background','foreground'); ?>
		<?php for ($i = 1; $i <= 3; $i++) :  ?>
			<?php	
				$class = $classes[$i - 1];
				$image = ${$class.'_image'};
				if (!empty ($image)) : 
			?>
			<div class="eltdf-pii-image-holder eltdf-pii-<?php echo esc_attr($class); ?>-image-holder" <?php echo allston_eltdf_get_inline_attrs(${'parallax_data_'.$i}); ?>>
		        <img class="eltdf-pii-<?php echo esc_attr($class); ?>-image"
		        	src="<?php echo wp_get_attachment_url($image); ?>" 
		        	alt="<?php echo get_the_title($image); ?>"
		        	/>
			</div>
			<?php endif; ?>
		<?php endfor; ?>
		<?php if ( !empty ( $item_title ) ) : ?>
			<div class="eltdf-pii-title-holder">
				<h5 class="eltdf-pii-title">
					<span class="eltdf-pii-char">/</span>
					<span class="eltdf-pii-title-text">
						<span class="eltdf-pii-title-text-inner">
							<?php echo esc_attr($item_title); ?>
						</span>
					</span>
				</h5>
			</div>
		<?php endif; ?>
	</div>
</div>