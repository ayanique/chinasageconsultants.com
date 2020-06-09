<div class="eltdf-testimonials-holder clearfix <?php echo esc_attr($holder_classes); ?>">
    <div class="eltdf-testimonials eltdf-owl-slider" <?php echo allston_eltdf_get_inline_attrs( $data_attr ) ?>>

    <?php if ( $query_results->have_posts() ):
        while ( $query_results->have_posts() ) : $query_results->the_post();
            $title    = get_post_meta( get_the_ID(), 'eltdf_testimonial_title', true );
            $text     = get_post_meta( get_the_ID(), 'eltdf_testimonial_text', true );
            $author   = get_post_meta( get_the_ID(), 'eltdf_testimonial_author', true );
            $position = get_post_meta( get_the_ID(), 'eltdf_testimonial_author_position', true );

            $current_id = get_the_ID();
    ?>

            <div class="eltdf-testimonial-content" id="eltdf-testimonials-<?php echo esc_attr( $current_id ) ?>">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="eltdf-testimonial-image">
                        <?php echo get_the_post_thumbnail( get_the_ID(), array( 102, 102 ) ); ?>
                    </div>
                <?php } ?>
                <div class="eltdf-testimonial-text-holder">
                    <?php if ( ! empty( $title ) ) { ?>
                        <h3 itemprop="name" class="eltdf-testimonial-title entry-title"><?php echo esc_html( $title ); ?></h3>
                    <?php } ?>
                    <?php if ( ! empty( $text ) ) { ?>
                        <p class="eltdf-testimonial-text"><?php echo esc_html( $text ); ?></p>
                    <?php } ?>
                    <?php if ( ! empty( $author ) ) { ?>
                        <p class="eltdf-testimonial-author">
                            <span class="eltdf-testimonials-author-name"><?php echo esc_html( $author ); ?></span>
                            <?php if ( ! empty( $position ) ) { ?>
                                <span class="eltdf-testimonials-author-job"><?php echo esc_html( $position ); ?></span>
                            <?php } ?>
                        </p>
                    <?php } ?>
                </div>
            </div>

    <?php
        endwhile;
    else:
        echo esc_html__( 'Sorry, no posts matched your criteria.', 'allston-core' );
    endif;

    wp_reset_postdata();
    ?>

    </div>
</div>