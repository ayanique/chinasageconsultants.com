<?php
$day = get_the_time('d');
$month = get_the_time('F');
$year = get_the_time('Y');
$title = get_the_title();
?>
<div itemprop="dateCreated" class="eltdf-post-info-date-separated entry-date published updated">
    <?php if(empty($title) && allston_eltdf_blog_item_has_link()) { ?>
    <a itemprop="url" href="<?php the_permalink() ?>">
        <?php } else { ?>
        <a itemprop="url" href="<?php echo get_month_link($year, $month); ?>">
            <?php } ?>
            <div class="eltdf-post-day"><?php echo esc_html($day) ?></div>
            <div class="eltdf-post-month"><?php echo esc_html($month) ?></div>
        </a>
        <meta itemprop="interactionCount" content="UserComments: <?php echo get_comments_number(allston_eltdf_get_page_id()); ?>"/>
</div>