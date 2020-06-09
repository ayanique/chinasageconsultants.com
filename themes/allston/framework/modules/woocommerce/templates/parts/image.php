<?php
$product = allston_eltdf_return_woocommerce_global_variable();

if ( $product->is_on_sale() ) { ?>
	<span class="eltdf-<?php echo esc_attr( $class_name ); ?>-onsale"><?php esc_html_e( 'Sale', 'allston' ); ?></span>
<?php } ?>

<?php if ( ! $product->is_in_stock() ) { ?>
	<span class="eltdf-<?php echo esc_attr( $class_name ); ?>-out-of-stock"><?php esc_html_e( 'Sold', 'allston' ); ?></span>
<?php }

$new = get_post_meta( get_the_ID(), 'eltdf_show_new_sign_woo_meta', true );

if ( $new === 'yes' ) { ?>
	<span class="eltdf-<?php echo esc_attr( $class_name ); ?>-new-product"><?php esc_html_e( 'New', 'allston' ); ?></span>
<?php }

$product_image_size = 'shop_catalog';
if ( $image_size === 'full' ) {
	$product_image_size = 'full';
} else if ( $image_size === 'square' ) {
	$product_image_size = 'allston_eltdf_square';
} else if ( $image_size === 'landscape' ) {
	$product_image_size = 'allston_eltdf_landscape';
} else if ( $image_size === 'portrait' ) {
	$product_image_size = 'allston_eltdf_portrait';
} else if ( $image_size === 'medium' ) {
	$product_image_size = 'medium';
} else if ( $image_size === 'large' ) {
	$product_image_size = 'large';
} else if ( $image_size === 'shop_thumbnail' ) {
	$product_image_size = 'shop_thumbnail';
}

if ( has_post_thumbnail() ) {
	the_post_thumbnail( apply_filters( 'allston_eltdf_product_list_image_size', $product_image_size ) );
}