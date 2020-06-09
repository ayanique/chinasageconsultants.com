<?php do_action('allston_eltdf_before_page_header'); ?>

<header class="eltdf-page-header">
	<?php do_action('allston_eltdf_after_page_header_html_open'); ?>
	
	<?php if($show_fixed_wrapper) : ?>
		<div class="eltdf-fixed-wrapper">
	<?php endif; ?>
			
	<div class="eltdf-menu-area">
		<?php do_action('allston_eltdf_after_header_menu_area_html_open'); ?>
		
		<?php if($menu_area_in_grid) : ?>
			<div class="eltdf-grid">
		<?php endif; ?>
				
			<div class="eltdf-vertical-align-containers">
				<div class="eltdf-position-left"><!--
				 --><div class="eltdf-position-left-inner">
						<?php if(!$hide_logo) {
							allston_eltdf_get_logo();
						} ?>
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
				
		<?php if($menu_area_in_grid) : ?>
			</div>
		<?php endif; ?>
	</div>
			
	<?php if($show_fixed_wrapper) { ?>
		</div>
	<?php } ?>
	
	<?php if($show_sticky) {
		allston_eltdf_get_sticky_header('minimal', 'header/types/header-minimal');
	} ?>
	
	<?php do_action('allston_eltdf_before_page_header_html_close'); ?>
</header>