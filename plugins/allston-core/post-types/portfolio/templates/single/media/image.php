<?php if(!empty($lightbox)) : ?>
    <a itemprop="image" title="<?php echo esc_attr($media['title']); ?>" data-rel="prettyPhoto[single_pretty_photo]" href="<?php echo esc_url($media['image_url']); ?>">
<?php endif; ?>

<?php if($full_screen_slider){ ?>
	<span class="eltdf-portfolio-slide-image" style="background-image:url('<?php echo esc_url($media['image_url']); ?>');"></span>
<?php } else { ?>
	<img itemprop="image" src="<?php echo esc_url($media['image_url']); ?>" alt="<?php echo esc_attr($media['description']); ?>" />
<?php } ?>

<?php if(!empty($lightbox)) : ?>
    </a>
<?php endif; ?>