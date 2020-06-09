<div class="eltdf-grid-row">
    <div class="eltdf-grid-col-9">
        <div class="eltdf-ps-image-holder">
            <div class="eltdf-ps-image-inner">
                <?php
                $media = allston_core_get_portfolio_single_media();
                
                if(is_array($media) && count($media)) : ?>
                    <?php foreach($media as $single_media) : ?>
                        <div class="eltdf-ps-image">
                            <?php allston_core_get_portfolio_single_media_html($single_media); ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="eltdf-grid-col-3">
        <div class="eltdf-ps-info-holder eltdf-ps-single-info eltdf-ps-info-sticky-holder">
            <?php
            //get portfolio title section
            allston_core_get_cpt_single_module_template_part('templates/single/parts/title', 'portfolio', $item_layout);

            //get portfolio content section
            allston_core_get_cpt_single_module_template_part('templates/single/parts/content', 'portfolio', $item_layout);

            //get button with external link
            allston_core_get_cpt_single_module_template_part('templates/single/parts/button', 'portfolio', $item_layout);

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