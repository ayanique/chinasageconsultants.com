<div class="eltdf-full-width">
    <div class="eltdf-full-width-inner">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="eltdf-portfolio-single-holder <?php echo esc_attr($holder_classes); ?>">
                <?php if(post_password_required()) {
                    echo get_the_password_form();
                } else {
                    do_action('allston_code_portfolio_page_before_content');

                    allston_core_get_cpt_single_module_template_part('templates/single/layout-collections/'.$item_layout, 'portfolio', '', $params);

                    do_action('allston_core_portfolio_page_after_content');
                    ?>

                    <div class="eltdf-container">
                        <div class="eltdf-container-inner clearfix">
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php endwhile; endif; ?>
    </div>
</div>