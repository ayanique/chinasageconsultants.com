<div class="eltdf-pe-holder <?php echo esc_attr($holder_classes); ?>">
	<div class="eltdf-pe-holder-inner">
		<?php if($type == 'slider-right') { ?>
			<div class="eltdf-pe-section eltdf-pe-image-holder">
				<?php echo allston_core_get_shortcode_module_template_part( 'templates/pe-image', 'presentation-extended', '', $params ); ?>
			</div>
		<?php } else { ?>
			<div class="eltdf-pe-section eltdf-pe-slider-holder">
				<?php echo allston_core_get_shortcode_module_template_part( 'templates/pe-slider', 'presentation-extended', '', $params ); ?>
			</div>
		<?php } ?>
		<div class="eltdf-pe-section eltdf-pe-content-holder">
			<?php echo allston_core_get_shortcode_module_template_part( 'templates/pe-content', 'presentation-extended', '', $params ); ?>
		</div>
		<?php if($type == 'slider-right') { ?>
			<div class="eltdf-pe-section eltdf-pe-slider-holder">
				<?php echo allston_core_get_shortcode_module_template_part( 'templates/pe-slider', 'presentation-extended', '', $params ); ?>
			</div>
		<?php } else { ?>
			<div class="eltdf-pe-section eltdf-pe-image-holder">
				<?php echo allston_core_get_shortcode_module_template_part( 'templates/pe-image', 'presentation-extended', '', $params ); ?>
			</div>
		<?php } ?>
	</div>
</div>