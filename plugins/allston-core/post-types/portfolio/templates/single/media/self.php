<div class="eltdf-self-hosted-video-holder">
    <div class="mobile-video-image" style="background-image: url(<?php echo esc_url($media['video_cover']); ?>);"></div>
    <div class="eltdf-video-wrap">
        <video class="eltdf-self-hosted-video" poster="<?php echo esc_url($media['video_cover']); ?>" preload="auto">
            <source type="video/mp4" src="<?php echo esc_url($media['video_url']['mp4']); ?>">
            <object width="320" height="240" type="application/x-shockwave-flash" data="<?php echo esc_url(get_template_directory_uri().'/js/flashmediaelement.swf'); ?>">
                <param name="movie" value="<?php echo esc_url(get_template_directory_uri().'/js/flashmediaelement.swf'); ?>"/>
                <param name="flashvars" value="controls=true&file=<?php echo esc_url($media['video_url']['mp4']); ?>"/>
                <img itemprop="image" src="<?php echo esc_url($media['video_cover']); ?>" width="1920" height="800" title="<?php esc_attr_e('No video playback capabilities', 'allston-core'); ?>" alt="<?php esc_attr_e('video thumb', 'allston-core'); ?>"/>
            </object>
        </video>
    </div>
</div>