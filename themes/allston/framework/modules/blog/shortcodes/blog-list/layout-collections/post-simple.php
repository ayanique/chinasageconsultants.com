<li class="eltdf-bl-item eltdf-item-space clearfix">
	<div class="eltdf-bli-inner">
		<?php if ( $post_info_image == 'yes' ) {
			allston_eltdf_get_module_template_part( 'templates/parts/media', 'blog', '', $params );
		} ?>
		<div class="eltdf-bli-content">
			<?php allston_eltdf_get_module_template_part( 'templates/parts/post-info/date', 'blog', '', $params ); ?>
			<?php allston_eltdf_get_module_template_part( 'templates/parts/title', 'blog', '', $params ); ?>
		</div>
	</div>
</li>