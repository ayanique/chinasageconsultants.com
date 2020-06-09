<div class="eltdf-image-marquee-holder <?php echo esc_attr($holder_classes); ?>">
	<?php 
	    $element_types = array('original','aux');
	?>
	<div class="eltdf-image-marquee">
	    <?php foreach ($element_types as $element_type) : ?>
	        <div class="eltdf-image eltdf-<?php echo esc_attr($element_type); ?>">
	            <img src="<?php echo wp_get_attachment_url($marquee_image); ?>" alt="<?php echo get_the_title($marquee_image) ?>" />
	        </div>
		<?php endforeach; ?>
    </div>
</div>