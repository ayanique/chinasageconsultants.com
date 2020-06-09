<?php
$image_src   = get_the_post_thumbnail_url( get_the_ID() );
$image_style = ! empty( $image_src ) ? 'background-image:url(' . esc_url( $image_src ) . ')' : '';
$excerpt     = get_the_excerpt() !== '' ? substr( get_the_excerpt(), 0, 120 ) : '';
$categories  = wp_get_post_terms(get_the_ID(), 'portfolio-category');
$tags        = wp_get_post_terms(get_the_ID(), 'portfolio-tag');
$share_on    = allston_eltdf_options()->getOptionValue('enable_social_share') == 'yes' && allston_eltdf_options()->getOptionValue('enable_social_share_on_portfolio-item') == 'yes';
?>
<div class="eltdf-pli-image" <?php allston_eltdf_inline_style($image_style); ?>></div>
<div class="eltdf-pli-text-holder">
	<div class="eltdf-pli-text-wrapper">
		<div class="eltdf-pli-text">
			<div class="eltdf-pli-text-inner">
				<a class="eltdf-pli-up-arrow" href="#"><i class="fa fa fa-chevron-up"></i></a>
				<h2 itemprop="name" class="eltdf-pli-title entry-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_attr( get_the_title() ); ?></a></h2>
				
				<div class="eltdf-pli-date"><?php the_time( get_option( 'date_format' ) ); ?></div>
				
				<div class="eltdf-pli-info-holder">
					<?php if ( ! empty( $excerpt ) ) { ?>
						<p itemprop="description" class="eltdf-pli-excerpt-info"><?php echo esc_html( $excerpt ); ?></p>
					<?php } ?>

					<?php if ( ! empty( $categories ) ) { ?>
						<div class="eltdf-pli-category-info eltdf-pli-info">
							<h5 class="eltdf-pli-info-title"><?php esc_html_e( 'Category:', 'orkan' ); ?></h5>
							<p>
								<?php foreach ( $categories as $cat ) { ?>
									<a itemprop="url" href="<?php echo esc_url( get_term_link( $cat->term_id ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
								<?php } ?>
							</p>
						</div>
					<?php } ?>
					
					<div class="eltdf-pli-date-info eltdf-pli-info">
						<h5 class="eltdf-pli-info-title"><?php esc_html_e( 'Date:', 'orkan' ); ?></h5>
						<p><?php the_time( get_option( 'date_format' ) ); ?></p>
					</div>
					
					<?php if ( ! empty( $tags ) ) { ?>
						<div class="eltdf-pli-tag-info eltdf-pli-info">
							<h5 class="eltdf-pli-info-title"><?php esc_html_e( 'Tag:', 'orkan' ); ?></h5>
							<p>
								<?php foreach ( $tags as $tag ) { ?>
									<a itemprop="url" href="<?php echo esc_url( get_term_link( $tag->term_id ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
								<?php } ?>
							</p>
						</div>
					<?php } ?>
					
					<?php if ( $share_on ) { ?>
						<div class="eltdf-pli-share-info eltdf-pli-info">
							<h4 class="eltdf-pli-share-title"><?php esc_html_e( 'Share:', 'orkan' ); ?></h4>
							<?php echo allston_eltdf_get_social_share_html() ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>