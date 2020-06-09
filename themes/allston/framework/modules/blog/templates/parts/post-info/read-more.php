<?php if ( ! allston_eltdf_post_has_read_more() && ! post_password_required() ) { ?>
	<div class="eltdf-post-read-more-button">
		<?php
		$button_params = array(
			'type'         => 'simple',
			'link'         => get_the_permalink(),
			'text'         => esc_html__( 'Read More', 'allston' ),
			'icon_pack'    => 'ion_icons',
			'ion_icon'     => 'ion-ios-arrow-right',
			'custom_class' => 'eltdf-blog-list-button'
		);
		
		echo allston_eltdf_return_button_html( $button_params );
		?>
	</div>
<?php } ?>