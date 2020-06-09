<?php if($query_results->max_num_pages > 1) {
	$holder_styles = $this_object->getLoadMoreStyles($params);
	?>
	<div class="eltdf-pl-loading">
		<div class="eltdf-pl-loading-bounce1"></div>
		<div class="eltdf-pl-loading-bounce2"></div>
		<div class="eltdf-pl-loading-bounce3"></div>
	</div>
	<div class="eltdf-pl-load-more-holder">
		<div class="eltdf-pl-load-more" <?php allston_eltdf_inline_style($holder_styles); ?>>
			<?php 
				echo allston_eltdf_get_button_html(array(
					'link' => 'javascript: void(0)',
					'size' => 'large',
					'text' => esc_html__('LOAD MORE', 'allston-core')
				));
			?>
		</div>
	</div>
<?php }