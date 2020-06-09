<?php do_action('allston_eltdf_before_mobile_header'); ?>

<header class="eltdf-mobile-header">
	<?php do_action('allston_eltdf_after_mobile_header_html_open'); ?>
	
	<div class="eltdf-mobile-header-inner">
		<div class="eltdf-mobile-header-holder">
			<div class="eltdf-grid">
				<div class="eltdf-vertical-align-containers">
					<div class="eltdf-position-left"><!--
					 --><div class="eltdf-position-left-inner">
							<?php allston_eltdf_get_mobile_logo(); ?>
						</div>
					</div>
					<div class="eltdf-position-right"><!--
					 --><div class="eltdf-position-right-inner">
							<a href="javascript:void(0)" <?php allston_eltdf_class_attribute( $fullscreen_menu_icon_class ); ?>>
								<span class="eltdf-fullscreen-menu-close-icon">
									<?php echo allston_eltdf_get_fullscreen_menu_close_icon_html(); ?>
								</span>
								<span class="eltdf-fullscreen-menu-opener-icon">
									<?php echo allston_eltdf_get_fullscreen_menu_icon_html(); ?>
								</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php do_action('allston_eltdf_before_mobile_header_html_close'); ?>
</header>

<?php do_action('allston_eltdf_after_mobile_header'); ?>