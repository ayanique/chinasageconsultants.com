<?php $icon_html = allston_eltdf_icon_collections()->renderIcon($icon, $icon_pack, $params); ?>
<div class="eltdf-icon-list-holder <?php echo esc_attr($holder_classes); ?>" <?php echo allston_eltdf_get_inline_style($holder_styles); ?>>
	<div class="eltdf-il-icon-holder">
		<?php echo wp_kses_post($icon_html); ?>
	</div>
	<p class="eltdf-il-text" <?php echo allston_eltdf_get_inline_style($title_styles); ?>><?php echo esc_html($title); ?></p>
</div>