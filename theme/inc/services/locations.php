<?php

function mp_location_navigator_search_init() {
    $q = $_POST['q'] ? $_POST['q'] : '';
    $post_type = $_POST['post_type'] ? $_POST['post_type'] : '';
    $user_geopoint = $_POST['user_loc'] ? $_POST['user_loc'] : null;

    $links = array();

    if ( $user_geopoint ) {
        # max distance in meters (200km)
        $MAX_DISTANCE = 200 * 1000;

        $areas_served = get_posts(array(
            'post_type' => 'local',
            'posts_per_page' => -1,
            'meta_key' => 'content_type',
            'meta_value' => 'Area Served'
        ));

        foreach ( $areas_served as $area ) {
            $area_geopoint = get_field('geopoint', $area);
            $area_geopoint = array( 'latitude' => $area_geopoint['lat'], 'longitude' => $area_geopoint['lng'] );

            if ( haversineDistance($area_geopoint, $user_geopoint) <= $MAX_DISTANCE) {
                $links[] = array(
                    'url' => get_permalink($area),
                    'title' => get_the_title($area)
                );
            }
        }
    } else {
        $areas_served = get_posts(array(
            'post_type' => 'local',
            'posts_per_page' => -1,
            'meta_key' => 'content_type',
            'meta_value' => 'Area Served',
            's' => $q,
        ));

        foreach ( $areas_served as $area ) {
            $links[] = array(
                'url' => get_permalink($area),
                'title' => get_the_title($area)
            );
        }
    }

    // if we're currently on a practice area single, then "locations" should really be other location-aware practice areas.
    // i.e. if on a Car Accident PA page, the locations returned would be links to other local Car Accident PA pages
    // NOTE: We need a tie between global practice areas and their local counterparts for this to function correctly
//    if ( $post_type == 'practice_area') {
//        foreach ( $as_terms as $term ) {
//            $pa_posts = get_posts( array(
//                'post_type' => $post_type,
//                'tax_query' => [
//                    [
//                        'taxonomy' => 'area-served',
//                        'terms'    => array( $term->term_id ),
//                        'operator' => 'IN'
//                    ]
//                ]
//            ) );
//
//            if ( sizeof($pa_posts) > 0 ) {
//            }
//        }
//    } else {
//        // if we're not on a PA single, the links are simply pointers to the area served terms
//        $links = get_terms( array(
//            'taxonomy' => 'area-served',
//            'hide_empty' => false,
//        ) );
//    }
    $header = null;
    if ( $q ) {
        $header = sprintf( 'Results for "%s"', esc_html( $q ) );
        $header .= sprintf( '<p>showing %s %s</p>', sizeof( $links ), sizeof( $links ) === 1 ? 'result' : 'results' );
    }
    mp_location_navigator_search_results_flat( $links, $header );

    die;
}

add_action('wp_ajax_mp_location_navigator_search', 'mp_location_navigator_search_init'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_mp_location_navigator_search', 'mp_location_navigator_search_init'); // wp_ajax_nopriv_{action}

function mp_location_navigator_search_results_flat( $result_links, $header = null ) {
    if ( $header ) : ?>
    <div class="mp-location-navigator-widget__results-header">
        <?php echo $header ?>
    </div>
    <?php endif ?>
    <ul>
        <?php foreach ( $result_links as $link ) : ?>
            <li>
                <a href="<?php echo $link['url'] ?>" class="mp-link mp-link--underline">
                    <?php echo $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
    <?php
}

function mp_location_navigator_search_results_grouped( $result_link_groups, $header = null ) {
    if ( $header ) : ?>
    <div class="mp-location-navigator-widget__results-header">
        <?php echo $header ?>
    </div>
    <?php endif ?>
    <ul>
    <?php foreach ( $result_link_groups as $parent_id => $child_links ) : ?>
        <li class="mp-location-navigator-widget__results__group">
            <a href="<?php echo get_permalink($parent_id) ?>" class="mp-link mp-link--underline mp-link--big">
                <strong><?php echo get_the_title($parent_id) ?></strong>
            </a>

            <ul class="mp-location-navigator-widget__results__group__children">
                <?php foreach ( $child_links as $link ) : ?>
                    <li>
                        <a href="<?php echo $link['url'] ?>" class="mp-link mp-link--underline">
                            <?php echo $link['title'] ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </li>
    <?php endforeach ?>
    </ul>
    <?php
}
