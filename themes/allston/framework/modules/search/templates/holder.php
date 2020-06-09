<div class="eltdf-grid-row">
	<div <?php echo allston_eltdf_get_content_sidebar_class(); ?>>
		<div class="eltdf-search-page-holder">
			<?php allston_eltdf_get_search_page_layout(); ?>
		</div>
		<?php do_action( 'allston_eltdf_page_after_content' ); ?>
	</div>
	<?php if ( $sidebar_layout !== 'no-sidebar' ) { ?>
		<div <?php echo allston_eltdf_get_sidebar_holder_class(); ?>>
			<?php get_sidebar(); ?>
		</div>
	<?php } ?>
</div>