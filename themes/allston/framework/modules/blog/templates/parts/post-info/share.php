<?php
$share_type = isset($share_type) ? $share_type : 'list';
$title = esc_html__( 'Share:', 'allston' );
?>
<?php if(allston_eltdf_options()->getOptionValue('enable_social_share') === 'yes' && allston_eltdf_options()->getOptionValue('enable_social_share_on_post') === 'yes') { ?>
    <div class="eltdf-blog-share">
        <?php echo allston_eltdf_get_social_share_html(array('type' => $share_type, 'title' => $title)); ?>
    </div>
<?php } ?>