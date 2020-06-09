<?php if(comments_open()) { ?>
	<div class="eltdf-post-info-comments-holder">
		<a itemprop="url" class="eltdf-post-info-comments" href="<?php comments_link(); ?>">
			<?php comments_number('0 ' . esc_html__('Comments','allston'), '1 '.esc_html__('Comment','allston'), '% '.esc_html__('Comments','allston') ); ?>
		</a>
	</div>
<?php } ?>