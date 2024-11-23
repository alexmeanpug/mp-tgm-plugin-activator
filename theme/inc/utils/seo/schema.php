<?php
/**
 * Global:
 *  - Generate "LocalBusiness" schema
 *
 * Testimonials Archive:
 *  - Generate "Review" schema
 *
 * Practice Area:
 *  - Generate "Review" schema for attached testimonials
 *  - Generate "Product" schema for post
 *  - Editors should set their own FAQ markup based on page headers
 *
 * Office:
 *  - Generate "LocalBusiness" schema
 *
 * Attorney:
 *  - Nothing for now
 *
 * FAQ Category:
 *  - FAQ
 *
 * Result:
 *  - Nothing for now
 *
 * Area Served:
 *  - Nothing for now, but we should markup with FAQs
 */

function mp_generate_office_schema( $office ) {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $location = get_field( 'address', $office );
    $geopoint = get_field( 'geopoint', $office );

    $schema = array(
        '@context' => "http://schema.org",
        '@type' => "LocalBusiness",
        'additionalType' => "LegalService",
        'name' => get_bloginfo( 'name' ),
        'description' => get_bloginfo( 'description' ),
        'url'   => get_site_url(),
        'image' => wp_get_attachment_image_url( $custom_logo_id, 'full' ),
        'telephone' => get_field('contact_phone', 'option')['title'],
        'email' => get_field('contact_email', 'option')['title'],
        'address' => array(
            'type'  => 'PostalAddress',
            'addressLocality'  => $location['city'],
            'addressRegion' => $location['state'],
            'postalCode'    => $location['postal_code'],
            'streetAddress' => $location['street'] . ($location['street2'] ? ', ' . $location['street2'] : '')
        ),
        'geo'   => array(
            'type'  => 'GeoCoordinates',
            'latitude'  => $geopoint['lat'],
            'longitude' => $geopoint['lng']
        ),
        'priceRange' => 'Free consultation',
        'openingHours' => 'Mo-Su,all day'
    );

    $sameas = [];
    $social_profiles = get_field('social_profiles', 'option');
    foreach ( $social_profiles as $profile ) {
        $sameas[] = $profile['url'];
    }
    $schema['sameAs'] = $sameas;

    echo '<!-- SCHEMA: Office -->';
    echo '<script type="application/ld+json">';
    echo json_encode( $schema );
    echo '</script>';
}

/**
 * schema that should appear on every page
 * @param office - if set, we use fields from the given office for business address/contact info instead of the defaults
 */
function mp_generate_local_business_schema( $office = null ) {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $location = get_field('contact_main_address', 'option');

    if ($location) {
      $schema = array(
          '@context' => "http://schema.org",
          '@type' => "LocalBusiness",
          'additionalType' => "LegalService",
          'name' => get_bloginfo( 'name' ),
          'description' => get_bloginfo( 'description' ),
          'url'   => get_site_url(),
          'image' => wp_get_attachment_image_url( $custom_logo_id, 'full' ),
          'telephone' => get_field('contact_phone', 'option')['title'],
          'email' => get_field('contact_email', 'option')['title'],
          'address' => array(
              'type'  => 'PostalAddress',
              'addressLocality'  => $location['city'],
              'addressRegion' => $location['state'],
              'postalCode'    => $location['post_code'],
              'streetAddress' => $location['street_number'] . ' ' . $location['street_name']
          ),
          'geo'   => array(
              'type'  => 'GeoCoordinates',
              'latitude'  => $location['lat'],
              'longitude' => $location['lng']
          ),
          'priceRange' => 'Free consultation',
          'openingHours' => 'Mo-Su,all day'
      );

      $sameas = [];
      $social_profiles = get_field('social_profiles', 'option');
      foreach ( $social_profiles as $profile ) {
          $sameas[] = $profile['url'];
      }
      $schema['sameAs'] = $sameas;

      echo '<!-- SCHEMA: Local Business -->';
      echo '<script type="application/ld+json">';
      echo json_encode( $schema );
      echo '</script>';
    }
}

function mp_generate_testimonial_schema( $testimonial, $print_out = false ) {
    $reviewer = get_field( 'reviewer', $testimonial);
    $schema = array(
        '@type' => 'Review',
        'author' => array(
            'type'  => 'Person',
            'name'  => $reviewer['name']
        ),
        'datePublished' => get_the_date( 'Y-m-d', $testimonial ),
        'reviewBody' => get_the_content( null, null, $testimonial ),
        'name' =>  get_the_title( $testimonial ),
        'reviewRating' => array(
            '@type' => 'Rating',
            'bestRating' => '5',
            'ratingValue' => '5',
            'worstRating'   => '0'
        ),
    );

    if ( $print_out ) {
        echo '<!-- SCHEMA: Testimonial -->';
        echo '<script type="application/ld+json">';
        echo json_encode( $schema );
        echo '</script>';
    }

    return $schema;
}

/**
 * @param $testimonials array
 * @param $agg_values array
 */
function mp_generate_testimonials_schema($testimonials, $name_override = null, $description_override = null, $agg_values = null) {
    $custom_logo_id = get_theme_mod( 'custom_logo' );

    $schema = array(
        '@context' => "http://schema.org",
        '@type' => "Product",
        'description' => $description_override ?: get_bloginfo( 'description' ),
        'name' => $name_override ?: get_bloginfo( 'name' ),
        'image' => wp_get_attachment_image_url( $custom_logo_id, 'full' ),
        'review' => [],
    );

    if ( $agg_values ) {
        $schema['aggregateRating'] = array(
            '@type' => 'AggregateRating',
            'ratingValue' => $agg_values['value'],
            'reviewCount' => $agg_values['count'],
        );
    }

    foreach ( $testimonials as $testimonial ) {
        array_push( $schema['review'], mp_generate_testimonial_schema( $testimonial ) );
    }

    echo '<!-- SCHEMA: Testimonials -->';
    echo '<script type="application/ld+json">';
    echo json_encode( $schema );
    echo '</script>';
}

/**
 * generates the schema markup for a practice area
 * @param $practice_area
 */
function mp_generate_practice_area_schema( $practice_area, $agg_values = null ) {
    $pa_testimonials = get_field( 'testimonials', $practice_area );

    $schema = array(
        '@context' => "http://schema.org",
        '@type' => "Product",
        'description' => get_post_meta($practice_area->ID, '_yoast_wpseo_metadesc', true),
        'name' => get_the_title($practice_area),
        'image' => get_the_post_thumbnail_url( $practice_area ),
        'brand' => array(
            'name'  => get_bloginfo( 'name' ),
            'type'  => 'Organization'
        )
    );

    if ( $agg_values ) {
        $schema['aggregateRating'] = array(
            '@type' => 'AggregateRating',
            'ratingValue' => $agg_values['value'],
            'ratingCount' => $agg_values['count'],
            'reviewCount' => $agg_values['count'],
        );
    }

    if ($pa_testimonials && sizeof( $pa_testimonials ) > 0 ) {
        $sample_review = $pa_testimonials[0];
        $schema['review'] = mp_generate_testimonial_schema( $sample_review );
    }

    echo '<!-- SCHEMA: Practice Area -->';
    echo '<script type="application/ld+json">';
    echo json_encode( $schema );
    echo '</script>';
}

/**
 * generates Question+Answer schema markup for a given question and answer string
 * @param $question
 * @param $answer
 * @param false $print_out
 */
function mp_generate_question_answer_schema( $question, $answer, $print_out = false ) {
    $schema = array(
        '@context' => "http://schema.org",
        '@type' => "Question",
        'name' => $question,
        'acceptedAnswer' => array(
            '@type' => 'Answer',
            'text'  => $answer
        )
    );

    if ( $print_out ) {
        echo '<!-- SCHEMA: FAQ -->';
        echo '<script type="application/ld+json">';
        echo json_encode( $schema );
        echo '</script>';
    }

    return $schema;
}

function mp_generate_faq_page_schema( $faq_markup, $comment = '' ) {
    $schema = array(
        '@context' => "http://schema.org",
        '@type' => "FAQPage",
        'mainEntity' => $faq_markup
    );

    printf('<!-- SCHEMA: %s -->', $comment );
    echo '<script type="application/ld+json">';
    echo json_encode( $schema );
    echo '</script>';
}
