<?php

if ( class_exists( 'AllstonEltdfWidget' ) ) {
	class AllstonEltdfWoocommerceDropdownCart extends AllstonEltdfWidget
	{
		public function __construct()
		{
			parent::__construct(
				'eltdf_woocommerce_dropdown_cart',
				esc_html__('Elated Woocommerce Dropdown Cart', 'allston'),
				array('description' => esc_html__('Display a shop cart icon with a dropdown that shows products that are in the cart', 'allston'),)
			);

			$this->setParams();
		}

		protected function setParams()
		{
			$this->params = array(
				array(
					'type' => 'textfield',
					'name' => 'woocommerce_dropdown_cart_margin',
					'title' => esc_html__('Icon Margin', 'allston'),
					'description' => esc_html__('Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'allston')
				)
			);
		}

		public function widget($args, $instance)
		{
			extract($args);

			global $woocommerce;

			$icon_styles = array();

			if ($instance['woocommerce_dropdown_cart_margin'] !== '') {
				$icon_styles[] = 'padding: ' . $instance['woocommerce_dropdown_cart_margin'];
			}

			$cart_is_empty = sizeof($woocommerce->cart->get_cart()) <= 0;

			$dropdown_cart_icon_class = allston_eltdf_get_dropdown_cart_icon_class();
			?>
			<div class="eltdf-shopping-cart-holder" <?php allston_eltdf_inline_style($icon_styles) ?>>
				<div class="eltdf-shopping-cart-inner">
					<a itemprop="url" <?php allston_eltdf_class_attribute($dropdown_cart_icon_class); ?>
					   href="<?php echo esc_url(wc_get_cart_url()); ?>">
                    <span class="eltdf-cart-icon">
	                    <?php echo allston_eltdf_get_dropdown_cart_icon_html(); ?>
						<span class="eltdf-cart-number"><?php echo sprintf(_n('%d', '%d', WC()->cart->cart_contents_count, 'allston'), WC()->cart->cart_contents_count); ?></span>
                    </span>
					</a>
					<div class="eltdf-shopping-cart-dropdown">
						<ul>
							<?php if (!$cart_is_empty) : ?>
								<?php foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) :
									$_product = $cart_item['data'];
									// Only display if allowed
									if (!$_product->exists() || $cart_item['quantity'] == 0) {
										continue;
									}
									// Get price
									$product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? wc_get_price_excluding_tax($_product) : wc_get_price_including_tax($_product);
									?>
									<li>
										<div class="eltdf-item-image-holder">
											<a itemprop="url"
											   href="<?php echo esc_url(get_permalink($cart_item['product_id'])); ?>">
												<?php echo wp_kses($_product->get_image('thumbnail'), array(
													'img' => array(
														'src' => true,
														'width' => true,
														'height' => true,
														'class' => true,
														'alt' => true,
														'title' => true,
														'id' => true
													)
												)); ?>
											</a>
										</div>
										<div class="eltdf-item-info-holder">
											<h5 itemprop="name" class="eltdf-product-title">
												<a itemprop="url"
												   href="<?php echo esc_url(get_permalink($cart_item['product_id'])); ?>"><?php echo apply_filters('allston_eltdf_woo_widget_cart_product_title', $_product->get_name(), $_product); ?></a>
											</h5>
											<?php if (apply_filters('allston_eltdf_woo_cart_enable_quantity', true)) { ?>
												<span class="eltdf-quantity"><?php esc_html_e('Quantity: ', 'allston');
													echo esc_html($cart_item['quantity']); ?></span>
											<?php } ?>
											<?php echo apply_filters('allston_eltdf_woo_cart_item_price_html', wc_price($product_price), $cart_item, $cart_item_key); ?>
											<?php echo apply_filters('allston_eltdf_woo_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s"><span class="icon-arrows-remove"></span></a>', esc_url(wc_get_cart_remove_url($cart_item_key)), esc_html__('Remove this item', 'allston')), $cart_item_key); ?>
										</div>
									</li>
								<?php endforeach; ?>
								<li class="eltdf-cart-bottom">
									<div class="eltdf-subtotal-holder clearfix">
										<span class="eltdf-total"><?php esc_html_e('Subtotal:', 'allston'); ?></span>
										<span class="eltdf-total-amount">
										<?php echo wp_kses($woocommerce->cart->get_cart_subtotal(), array(
											'span' => array(
												'class' => true,
												'id' => true
											)
										)); ?>
									</span>
									</div>
									<div class="eltdf-btn-holder clearfix">
										<a itemprop="url" href="<?php echo esc_url(wc_get_cart_url()); ?>"
										   class="eltdf-view-cart"><?php esc_html_e('View Cart & Checkout', 'allston'); ?></a>
									</div>
								</li>
							<?php else : ?>
								<li class="eltdf-empty-cart"><?php esc_html_e('No products in the cart.', 'allston'); ?></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
			<?php
		}
	}

	add_filter('woocommerce_add_to_cart_fragments', 'allston_eltdf_woocommerce_header_add_to_cart_fragment');

	function allston_eltdf_woocommerce_header_add_to_cart_fragment($fragments)
	{
		global $woocommerce;

		ob_start();

		$cart_is_empty = sizeof($woocommerce->cart->get_cart()) <= 0;

		$dropdown_cart_icon_class = allston_eltdf_get_dropdown_cart_icon_class();

		?>
		<div class="eltdf-shopping-cart-inner">
			<a itemprop="url" <?php allston_eltdf_class_attribute($dropdown_cart_icon_class); ?>
			   href="<?php echo esc_url(wc_get_cart_url()); ?>">
            <span class="eltdf-cart-icon">
	            <?php echo allston_eltdf_get_dropdown_cart_icon_html(); ?>
				<span class="eltdf-cart-number"><?php echo sprintf(_n('%d', '%d', WC()->cart->cart_contents_count, 'allston'), WC()->cart->cart_contents_count); ?></span>
            </span>
			</a>
			<div class="eltdf-shopping-cart-dropdown">
				<ul>
					<?php if (!$cart_is_empty) : ?>
						<?php foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) :
							$_product = $cart_item['data'];
							// Only display if allowed
							if (!$_product->exists() || $cart_item['quantity'] == 0) {
								continue;
							}
							// Get price
							$product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? wc_get_price_excluding_tax($_product) : wc_get_price_including_tax($_product);
							?>
							<li>
								<div class="eltdf-item-image-holder">
									<a itemprop="url"
									   href="<?php echo esc_url(get_permalink($cart_item['product_id'])); ?>">
										<?php echo wp_kses($_product->get_image('thumbnail'), array(
											'img' => array(
												'src' => true,
												'width' => true,
												'height' => true,
												'class' => true,
												'alt' => true,
												'title' => true,
												'id' => true
											)
										)); ?>
									</a>
								</div>
								<div class="eltdf-item-info-holder">
									<h5 itemprop="name" class="eltdf-product-title">
										<a itemprop="url"
										   href="<?php echo esc_url(get_permalink($cart_item['product_id'])); ?>"><?php echo apply_filters('allston_eltdf_woo_widget_cart_product_title', $_product->get_name(), $_product); ?></a>
									</h5>
									<?php if (apply_filters('allston_eltdf_woo_cart_enable_quantity', true)) { ?>
										<span class="eltdf-quantity"><?php esc_html_e('Quantity: ', 'allston');
											echo esc_html($cart_item['quantity']); ?></span>
									<?php } ?>
									<?php echo apply_filters('allston_eltdf_woo_cart_item_price_html', wc_price($product_price), $cart_item, $cart_item_key); ?>
									<?php echo apply_filters('allston_eltdf_woo_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s"><span class="icon-arrows-remove"></span></a>', esc_url(wc_get_cart_remove_url($cart_item_key)), esc_html__('Remove this item', 'allston')), $cart_item_key); ?>
								</div>
							</li>
						<?php endforeach; ?>
						<li class="eltdf-cart-bottom">
							<div class="eltdf-subtotal-holder clearfix">
								<span class="eltdf-total"><?php esc_html_e('Subtotal:', 'allston'); ?></span>
								<span class="eltdf-total-amount">
								<?php echo wp_kses($woocommerce->cart->get_cart_subtotal(), array(
									'span' => array(
										'class' => true,
										'id' => true
									)
								)); ?>
							</span>
							</div>
							<div class="eltdf-btn-holder clearfix">
								<a itemprop="url" href="<?php echo esc_url(wc_get_cart_url()); ?>"
								   class="eltdf-view-cart"><?php esc_html_e('View Cart & Checkout', 'allston'); ?></a>
							</div>
						</li>
					<?php else : ?>
						<li class="eltdf-empty-cart"><?php esc_html_e('No products in the cart.', 'allston'); ?></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<?php
		$fragments['div.eltdf-shopping-cart-inner'] = ob_get_clean();

		return $fragments;
	}
}

?>