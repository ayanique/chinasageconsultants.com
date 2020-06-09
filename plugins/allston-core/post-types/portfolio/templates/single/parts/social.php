<?php if(allston_eltdf_options()->getOptionValue('enable_social_share') == 'yes' && allston_eltdf_options()->getOptionValue('enable_social_share_on_portfolio-item') == 'yes') : ?>
    <div class="eltdf-ps-info-item eltdf-ps-social-share">
        <span class="eltdf-ps-info-title"><?php esc_html_e('Share:', 'allston-core'); ?></span>
        <?php echo allston_eltdf_get_social_share_html() ?>
    </div>
<?php endif; ?>