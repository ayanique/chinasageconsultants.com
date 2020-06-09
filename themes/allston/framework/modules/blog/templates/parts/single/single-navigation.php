<?php
$blog_single_navigation = allston_eltdf_options()->getOptionValue('blog_single_navigation') === 'no' ? false : true;
$blog_navigation_through_same_category = allston_eltdf_options()->getOptionValue('blog_navigation_through_same_category') === 'no' ? false : true;
?>
<?php if($blog_single_navigation){ ?>
	<div class="eltdf-blog-single-navigation">
		<div class="eltdf-blog-single-navigation-inner clearfix">
			<?php
				/* Single navigation section - SETTING PARAMS */
				$post_navigation = array(
					'prev' => array(
						'mark' => '<span class="eltdf-blog-single-nav-mark icon-arrows-left"></span>',
						'label' => '<span class="eltdf-blog-single-nav-label">'.esc_html__('previous', 'allston').'</span>'
					),
					'next' => array(
						'mark' => '<span class="eltdf-blog-single-nav-mark icon-arrows-right"></span>',
						'label' => '<span class="eltdf-blog-single-nav-label">'.esc_html__('next', 'allston').'</span>'
					)
				);
			
				if($blog_navigation_through_same_category){
					if(get_previous_post(true) !== ""){
						$post_navigation['prev']['post'] = get_previous_post(true);
					}
					if(get_next_post(true) !== ""){
						$post_navigation['next']['post'] = get_next_post(true);
					}
				} else {
					if(get_previous_post() !== ""){
						$post_navigation['prev']['post'] = get_previous_post();
					}
					if(get_next_post() !== ""){
						$post_navigation['next']['post'] = get_next_post();
					}
				}

				/* Single navigation section - RENDERING */
				foreach (array('prev', 'next') as $nav_type) {
					if (isset($post_navigation[$nav_type]['post'])) { ?>
						<a itemprop="url" class="eltdf-blog-single-<?php echo esc_attr($nav_type); ?>" href="<?php echo get_permalink($post_navigation[$nav_type]['post']->ID); ?>">
							<?php echo wp_kses($post_navigation[$nav_type]['mark'], array('span' => array('class' => true))); ?>
						</a>
					<?php }
				}
			?>
		</div>
	</div>
<?php } ?>