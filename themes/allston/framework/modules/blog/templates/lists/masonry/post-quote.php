<?php
$post_classes[] = 'eltdf-item-space';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
    <div class="eltdf-post-content">
        <div class="eltdf-post-text">
            <div class="eltdf-post-text-inner">
                <div class="eltdf-post-text-main">
                    <div class="eltdf-post-mark">
                        <span class="icon_quotations_alt2 eltdf-quote-mark"></span>
                    </div>
                    <?php allston_eltdf_get_module_template_part('templates/parts/post-type/quote', 'blog', '', $part_params); ?>
                </div>
            </div>
        </div>
    </div>
</article>