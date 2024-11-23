<?php

function inf_add_reviews_schema_for_post( $content ) {
    if ( is_singular( array( 'practice-area' ) ) ) {
        $testimonials = get_field( 'testimonials' );

        if ( $testimonials ) {
            $review_schema_array = array();
            foreach ( $testimonials as $testimonial ) {
                $review_schema = inf_review_schema_for_testimonial( $testimonial );
                array_push( $review_schema_array, $review_schema );
            }

            $output_schema = array(
                "@context"  => "http://schema.org",
                "@graph"    => $review_schema_array
            );

            $html_segment = sprintf( '<script type="application/ld+json" id="inf-post-reviews-schema">%s</script>', wp_json_encode( $output_schema ));
            $content = $content . $html_segment;
        }
    }

    return $content;
}

add_filter( 'the_content', 'inf_add_reviews_schema_for_post' );
