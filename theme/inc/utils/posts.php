<?php

/**
 * maps an internal post type name to a canonical name for the post type
 * @param $post_type
 * @return mixed|string
 */
function inf_canonical_post_type_name($post_type) {
    $canonical_map = array(
        'practice-area' => 'Practice Area',
        'post' => 'Blog Post',
        'team' => 'Attorney',
    );

    return $canonical_map[$post_type] ?: $post_type;
}
