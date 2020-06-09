<?php
$eltdf_blog_type = allston_eltdf_get_archive_blog_list_layout();
allston_eltdf_include_blog_helper_functions( 'lists', $eltdf_blog_type );
$eltdf_holder_params = allston_eltdf_get_holder_params_blog();

get_header();
allston_eltdf_get_title();
do_action('allston_eltdf_before_main_content');
?>

<div class="<?php echo esc_attr( $eltdf_holder_params['holder'] ); ?>">
	<?php do_action( 'allston_eltdf_after_container_open' ); ?>
	
	<div class="<?php echo esc_attr( $eltdf_holder_params['inner'] ); ?>">
		<?php allston_eltdf_get_blog( $eltdf_blog_type ); ?>
	</div>
	
	<?php do_action( 'allston_eltdf_before_container_close' ); ?>
</div>

<?php do_action( 'allston_eltdf_blog_list_additional_tags' ); ?>
<?php get_footer(); ?>