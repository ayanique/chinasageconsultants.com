<?php
get_header();
allston_eltdf_get_title();
do_action( 'allston_eltdf_before_main_content' ); ?>
<div class="eltdf-container eltdf-default-page-template">
	<?php do_action( 'allston_eltdf_after_container_open' ); ?>
	<div class="eltdf-container-inner clearfix">
		<?php
			$allston_taxonomy_id   = get_queried_object_id();
			$allston_taxonomy_type = is_tax( 'portfolio-tag' ) ? 'portfolio-tag' : 'portfolio-category';
			$allston_taxonomy      = ! empty( $allston_taxonomy_id ) ? get_term_by( 'id', $allston_taxonomy_id, $allston_taxonomy_type ) : '';
			$allston_taxonomy_slug = ! empty( $allston_taxonomy ) ? $allston_taxonomy->slug : '';
			$allston_taxonomy_name = ! empty( $allston_taxonomy ) ? $allston_taxonomy->taxonomy : '';
			
			allston_core_get_archive_portfolio_list( $allston_taxonomy_slug, $allston_taxonomy_name );
		?>
	</div>
	<?php do_action( 'allston_eltdf_before_container_close' ); ?>
</div>
<?php get_footer(); ?>
