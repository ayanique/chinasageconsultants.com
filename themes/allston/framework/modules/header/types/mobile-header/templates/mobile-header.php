<?php do_action('allston_eltdf_before_mobile_header'); ?>

<header class="eltdf-mobile-header">
	<?php do_action('allston_eltdf_after_mobile_header_html_open'); ?>
	
	<div class="eltdf-mobile-header-inner">
		<div class="eltdf-mobile-header-holder">
			<div class="eltdf-grid">
				<div class="eltdf-vertical-align-containers">
					<div class="eltdf-vertical-align-containers">
						<?php if($show_navigation_opener) : ?>
							<div <?php allston_eltdf_class_attribute( $mobile_icon_class ); ?>>
								<a href="javascript:void(0)">
									<span class="eltdf-mobile-menu-icon">
										<?php echo allston_eltdf_get_mobile_navigation_icon_html(); ?>
									</span>
									<?php if(!empty($mobile_menu_title)) { ?>
										<h5 class="eltdf-mobile-menu-text"><?php echo esc_attr($mobile_menu_title); ?></h5>
									<?php } ?>
								</a>
							</div>
						<?php endif; ?>
						<div class="eltdf-position-center"><!--
						 --><div class="eltdf-position-center-inner">
								<?php allston_eltdf_get_mobile_logo(); ?>
							</div>
						</div>
						<div class="eltdf-position-right"><!--
						 --><div class="eltdf-position-right-inner">
								<?php if(is_active_sidebar('eltdf-right-from-mobile-logo')) {
									dynamic_sidebar('eltdf-right-from-mobile-logo');
								} ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php allston_eltdf_get_mobile_nav(); ?>
	</div>
	
	<?php do_action('allston_eltdf_before_mobile_header_html_close'); ?>
</header>

<?php do_action('allston_eltdf_after_mobile_header'); ?>