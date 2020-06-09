<?php if(allston_eltdf_options()->getOptionValue('portfolio_single_enable_categories') === 'yes') : ?>
    <?php
    $categories   = wp_get_post_terms(get_the_ID(), 'portfolio-category');
    if(is_array($categories) && count($categories)) : ?>
        <div class="eltdf-ps-info-item eltdf-ps-categories">
            <span class="eltdf-ps-info-title"><?php esc_html_e('Category:', 'allston-core'); ?></span>
            <?php foreach($categories as $cat) { ?>
                <a itemprop="url" class="eltdf-ps-info-category" href="<?php echo esc_url(get_term_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
            <?php } ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
