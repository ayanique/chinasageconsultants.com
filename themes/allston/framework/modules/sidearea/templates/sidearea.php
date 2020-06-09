<section class="eltdf-side-menu">
	<a <?php allston_eltdf_class_attribute( $side_area_close_icon_class ); ?> href="#">
		<?php echo allston_eltdf_get_side_area_close_icon_html(); ?>
	</a>
	<?php if ( is_active_sidebar( 'sidearea' ) ) {
		dynamic_sidebar( 'sidearea' );
	} ?>
</section>