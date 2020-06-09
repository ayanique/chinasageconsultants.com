<div class="eltdf-iib-item <?php echo esc_attr($holder_classes); ?>">
    <div class="eltdf-iib-background-image" <?php echo allston_eltdf_get_inline_style($holder_styles); ?>>
        <div class="eltdf-iib-content-holder">
            <div class="eltdf-iib-content-holder-inner">
                <h1 class="eltdf-iib-title" <?php echo allston_eltdf_get_inline_style($title_styles); ?>><?php echo esc_html($title); ?></h1>
                <?php echo do_shortcode( '[eltdf_separator]' ); ?>
                <div class="eltdf-iib-text" <?php echo allston_eltdf_get_inline_style($text_styles); ?>><?php echo esc_html($text); ?></div>
                <?php
                if(!empty($button_text)) { ?>
                    <div class="eltdf-iib-button">
                        <?php echo allston_eltdf_get_button_html(array(
                            'link' => $link,
                            'text' => $button_text,
                            'type' => 'simple',
                            'size' => 'large',
                            'icon_pack' => 'ion_icons',
                            'ion_icon' => 'ion-ios-arrow-right'
                        )); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>