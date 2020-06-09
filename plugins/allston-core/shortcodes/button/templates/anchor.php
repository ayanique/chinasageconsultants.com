<a itemprop="url" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>" <?php allston_eltdf_inline_style($button_styles); ?> <?php allston_eltdf_class_attribute($button_classes); ?> <?php echo allston_eltdf_get_inline_attrs($button_data); ?> <?php echo allston_eltdf_get_inline_attrs($button_custom_attrs); ?>>
    <span class="eltdf-btn-text"><?php echo esc_html($text); ?></span>
    <?php echo allston_eltdf_icon_collections()->renderIcon($icon, $icon_pack); ?>
</a>