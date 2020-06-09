<div class="eltdf-section-title-holder <?php echo esc_attr($holder_classes); ?>" <?php echo allston_eltdf_get_inline_style($holder_styles); ?>>
	<div class="eltdf-st-inner">
		<?php if(!empty($title)) { ?>
			<<?php echo esc_attr($title_tag); ?> class="eltdf-st-title" <?php echo allston_eltdf_get_inline_style($title_styles); ?>>
				<?php echo wp_kses($title, array('br' => true, 'span' => array('class' => true))); ?>
			</<?php echo esc_attr($title_tag); ?>>
		<?php } ?>
		<?php if($enable_separator == 'yes') { ?>
			<?php echo allston_eltdf_execute_shortcode( 'eltdf_separator', $separator_params ); ?>
		<?php } ?>
		<?php if(!empty($text)) { ?>
			<<?php echo esc_attr($text_tag); ?> class="eltdf-st-text" <?php echo allston_eltdf_get_inline_style($text_styles); ?>>
				<?php echo wp_kses($text, array('br' => true)); ?>
			</<?php echo esc_attr($text_tag); ?>>
		<?php } ?>
	</div>
</div>