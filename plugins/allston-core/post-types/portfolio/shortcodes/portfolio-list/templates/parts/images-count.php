<?php

if ( $item_type === 'gallery' ) {
	$gallery = allston_core_get_portfolio_single_media();
	if ( $enable_count_images === 'yes' && is_array( $gallery ) && count( $gallery ) > 0 ) {
		$counter = 0;
		if ( has_post_thumbnail() ) {
			$featured = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		}
		if ( ! empty( $featured ) ) {
			$counter ++;
		}
		
		$counter += count( $gallery );
		
		?>
		<div class="eltdf-gli-number-of-images-holder">
			<span><?php echo esc_attr( $counter ) . esc_html__( ' pics', 'allston-core' ); ?></span>
		</div>
	<?php }
}