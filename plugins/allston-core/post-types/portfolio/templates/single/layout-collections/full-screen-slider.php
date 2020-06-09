<div class="eltdf-portfolio-slider-content">
    <span class="eltdf-control eltdf-open">
	    <span class="icon-arrows-right"></span>
	    <span class="icon-arrows-left"></span>
    </span>
	<span class="eltdf-control eltdf-close">
	    <span class="icon-arrows-right"></span>
	    <span class="icon-arrows-left"></span>
    </span>

    <div class="eltdf-description">
        <div class="eltdf-ptf-table">
            <div class="eltdf-ptf-table-cell">
                <h3 class="eltdf-portfolio-title"><?php the_title(); ?></h3>
	            <?php allston_core_get_cpt_single_module_template_part('templates/single/parts/content', 'portfolio', $item_layout); ?>
            </div>
        </div>
    </div>

    <div class="eltdf-portfolio-slider-content-info eltdf-ps-info-holder">
        <div class="eltdf-ptf-table">
            <div class="eltdf-ptf-table-cell">
                <div class="eltdf-ptf-content-holder">
	                <h3 class="eltdf-portfolio-title"><?php the_title(); ?></h3>
                    <?php allston_core_get_cpt_single_module_template_part('templates/single/parts/content', 'portfolio', $item_layout); ?>
	                <?php allston_core_get_cpt_single_module_template_part('templates/single/parts/button', 'portfolio', $item_layout); ?>
                </div>
                <div class="eltdf-portfolio-info-holder">
                    <?php
                    //get portfolio custom fields section
                    allston_core_get_cpt_single_module_template_part('templates/single/parts/custom-fields', 'portfolio', $item_layout);

                    //get portfolio categories section
                    allston_core_get_cpt_single_module_template_part('templates/single/parts/categories', 'portfolio', $item_layout);

                    //get portfolio date section
                    allston_core_get_cpt_single_module_template_part('templates/single/parts/date', 'portfolio', $item_layout);

                    //get portfolio tags section
                    allston_core_get_cpt_single_module_template_part('templates/single/parts/tags', 'portfolio', $item_layout);

                    //get portfolio share section
                    allston_core_get_cpt_single_module_template_part('templates/single/parts/social', 'portfolio', $item_layout);
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="eltdf-full-screen-slider-holder">
    <?php
    $media = allston_core_get_portfolio_single_media();

    if(is_array($media) && count($media)) : ?>
        <div class="eltdf-portfolio-full-screen-slider">
            <?php foreach($media as $single_media) : ?>
                <div class="eltdf-portfolio-single-media">
                    <?php allston_core_get_portfolio_single_media_html($single_media); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>


