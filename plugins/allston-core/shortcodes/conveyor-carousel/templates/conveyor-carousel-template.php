<?php  
	$rand = rand(0,1000);
?>
<div <?php allston_eltdf_class_attribute($holder_classes); ?>>
	<div class="eltdf-cc-content-holder" <?php allston_eltdf_inline_style($content_styles); ?>>
		<div class="eltdf-cc-content-inner">
			<?php if (!empty($title)) : ?>
				<div class="eltdf-cc-title-holder">
					<h1 class="eltdf-cc-title"><?php echo esc_attr($title) ?></h1>
				</div>
			<?php endif; ?>
			<?php if($enable_separator == 'yes') :
				echo do_shortcode( '[eltdf_separator]' );
			endif; ?>
			<?php if (!empty($description)) : ?>
			<div class="eltdf-cc-description-holder">
				<p class="eltdf-cc-description"><?php echo esc_attr($description) ?></p>
			</div>
			<?php endif; ?>
			<?php if ($enable_navigation == 'yes') : ?>
				<div class="eltdf-cc-nav">
					<span class="eltdf-cc-prev icon icon-arrows-left"></span>
					<span class="eltdf-cc-next icon icon-arrows-right"></span>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="eltdf-cc-images-holder">
		<div class="swiper-container">
		    <div class="swiper-wrapper">
				<?php if (!empty($items)) : ?>
					<?php $i = 1; ?>
					<?php foreach ($items as $item) : ?>
						<div class="eltdf-cc-image swiper-slide">
							<?php 
								$id =  $item['image'];
								$url = wp_get_attachment_url( $item['image'] );
								$title = get_the_title( $item['image']);
								$slide_width = allston_eltdf_filter_px( $slide_width ) . 'px';
							?>
							<?php if ($behavior === 'lightbox') : ?>
								<a itemprop="image" class="eltdf-cc-lightbox-link" href="<?php echo esc_url( $url ); ?>" 
									data-rel="prettyPhoto[image_gallery_pretty_photo-<?php echo esc_attr( $rand ); ?>]" 
									title="<?php echo esc_attr( $title ); ?>"></a>
							<?php endif; ?>
							<?php  
								echo allston_eltdf_generate_thumbnail($id, null, $slide_width, $slide_width);
							?>
						</div>
						<?php $i++; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>


