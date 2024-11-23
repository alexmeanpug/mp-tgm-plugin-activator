<?php

##-- Defaults
# ACF
add_filter('acf/settings/save_json', function() {
    return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function($paths) {
    $paths[] = get_template_directory() . '/acf-json';

    if(is_child_theme()) {
        $paths[] = get_stylesheet_directory() . '/acf-json';
    }

    return $paths;
});

##-- GForms
add_filter( 'gform_notification', 'inf_filter_form_notifications', 10, 3 );
function inf_filter_form_notifications( $notification, $form, $entry ) {
    //There is no concept of admin notifications anymore, so we will need to target notifications based on other criteria, such as name
    if ( $notification['name'] == 'Admin Notification' ) {
        // toType can be routing or email
        $notification['toType'] = 'email';
        $notification['to'] = '<PUT RECIPIENTS HERE>';
        $notification['from'] = 'noreply@<PUT DOMAIN HERE>';
    }

    return $notification;
}

add_filter('gform_disable_css', '__return_true');

# Menus
add_filter('nav_menu_link_attributes', 'inf_filter_menu_link_attributes', 10, 4);
function inf_filter_menu_link_attributes( $atts, $menu_item, $args, $depth ) {
    $thumbnail_url = get_the_post_thumbnail_url($menu_item->object_id);
    $atts['data-image'] = $thumbnail_url;
    return $atts;
}

##-- WP Core
add_action( 'pre_get_posts', 'inf_filter_posts_query', 1);
function inf_filter_posts_query($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->is_search()) {
        $query->set('posts_per_page', 8);
    }
}

##-- WP Rocket
add_filter( 'rocket_lrc_exclusions', function( $exclusions ) {
  $exclusions[] = 'mp-marquee';
  return $exclusions;
} );


##-- MP Managed
# Google Maps
function mp_acf_google_map_api( $api ){
    $api['key'] = get_field('technical_google_maps_api_key', 'option');
    return $api;
}
add_filter('acf/fields/google_map/api', 'mp_acf_google_map_api');

# Allow SVG
function mp_filter_mimetypes( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    $mimes['vcf'] = 'text/vcard';
    $mimes['vcard'] = 'text/vcard';
    return $mimes;
}
add_filter( 'upload_mimes', 'mp_filter_mimetypes', 10, 1 );
