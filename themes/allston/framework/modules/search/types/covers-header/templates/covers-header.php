<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="eltdf-search-cover" method="get">
	<?php if ( $search_in_grid ) { ?>
	<div class="eltdf-container">
		<div class="eltdf-container-inner clearfix">
	<?php } ?>
			<div class="eltdf-form-holder-outer">
				<div class="eltdf-form-holder">
					<div class="eltdf-form-holder-inner">
						<input type="text" placeholder="<?php esc_attr_e( 'Search', 'allston' ); ?>" name="s" class="eltdf_search_field" autocomplete="off" />
						<a <?php allston_eltdf_class_attribute( $search_close_icon_class ); ?> href="#">
							<?php echo allston_eltdf_get_search_close_icon_html(); ?>
						</a>
					</div>
				</div>
			</div>
	<?php if ( $search_in_grid ) { ?>
		</div>
	</div>
	<?php } ?>
</form>