<li class="eltdf-bl-item eltdf-item-space clearfix">
	<div class="eltdf-bli-inner">
		<?php if ( $post_info_image == 'yes' ) {
			allston_eltdf_get_module_template_part( 'templates/parts/media', 'blog', '', $params );
			if ( $post_info_date == 'yes' ) {
				allston_eltdf_get_module_template_part( 'templates/parts/post-info/date', 'blog', 'single', $params );
			}
		} ?>
        <div class="eltdf-bli-content">
            <?php if ($post_info_section == 'yes') { ?>
                <div class="eltdf-bli-info">
	                <?php

		                if ( $post_info_category == 'yes' ) {
			                allston_eltdf_get_module_template_part( 'templates/parts/post-info/category', 'blog', '', $params );
		                }
		                if ( $post_info_author == 'yes' ) {
			                allston_eltdf_get_module_template_part( 'templates/parts/post-info/author', 'blog', '', $params );
		                }
		                if ( $post_info_comments == 'yes' ) {
			                allston_eltdf_get_module_template_part( 'templates/parts/post-info/comments', 'blog', '', $params );
		                }
		                if ( $post_info_like == 'yes' ) {
			                allston_eltdf_get_module_template_part( 'templates/parts/post-info/like', 'blog', '', $params );
		                }
		                if ( $post_info_share == 'yes' ) {
			                allston_eltdf_get_module_template_part( 'templates/parts/post-info/share', 'blog', '', $params );
		                }
	                ?>
                </div>
            <?php } ?>
	
	        <?php allston_eltdf_get_module_template_part( 'templates/parts/title', 'blog', '', $params ); ?>
			<?php echo do_shortcode( '[eltdf_separator]' ); ?>
	
	        <div class="eltdf-bli-excerpt">
		        <?php allston_eltdf_get_module_template_part( 'templates/parts/excerpt', 'blog', '', $params ); ?>
		        <?php allston_eltdf_get_module_template_part( 'templates/parts/post-info/read-more', 'blog', '', $params ); ?>
	        </div>
        </div>
	</div>
</li>