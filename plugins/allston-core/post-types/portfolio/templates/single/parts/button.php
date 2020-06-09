<?php
$portfolio_link_meta = get_post_meta( get_the_ID(), 'portfolio_external_link', true );
if ( ! empty ( $portfolio_link_meta ) ) { ?>
	<div class="eltdf-ps-button-holder">
		<?php
			$button_params = array(
				'type'         => 'solid',
				'link'         => $portfolio_link_meta,
				'target'       => '_blank',
				'text'         => esc_html__( 'Read More', 'allston-core' ),
				'custom_class' => 'eltdf-ps-button'
			);
			
			echo allston_eltdf_get_button_html( $button_params );
		?>
	</div>
<?php }