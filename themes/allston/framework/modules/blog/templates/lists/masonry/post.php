<?php
$post_classes[] = 'eltdf-item-space';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
    <div class="eltdf-post-content">
        <div class="eltdf-post-heading">
            <?php allston_eltdf_get_module_template_part('templates/parts/media', 'blog', $post_format, $part_params); ?>
            <?php
	            if( isset($date_format) && $date_format == 'simple' ) {
		            allston_eltdf_get_module_template_part( 'templates/parts/post-info/date-single', 'blog', '', $part_params );
	            }
            ?>
        </div>
        <div class="eltdf-post-text">
            <div class="eltdf-post-text-inner">
                <div class="eltdf-post-info-top">
                    <?php allston_eltdf_get_module_template_part('templates/parts/post-info/author', 'blog', '', $part_params); ?>
                    <?php allston_eltdf_get_module_template_part('templates/parts/post-info/category', 'blog', '', $part_params); ?>
	                <?php if( isset($date_format) && $date_format == 'standard' ) {
	                    allston_eltdf_get_module_template_part( 'templates/parts/post-info/date', 'blog', '', $part_params );
	                }
	                ?>
                </div>
                <div class="eltdf-post-text-main">
                    <?php allston_eltdf_get_module_template_part('templates/parts/title', 'blog', '', $part_params); ?>
                    <?php echo do_shortcode( '[eltdf_separator]' ); ?>
                    <?php allston_eltdf_get_module_template_part('templates/parts/excerpt', 'blog', '', $part_params); ?>
                    <?php allston_eltdf_get_module_template_part('templates/parts/post-info/read-more', 'blog', '', $part_params); ?>
                </div>
            </div>
        </div>
    </div>
</article>