<?php
function mp_reverse_acf_post_object_query($dest_post_type, $acf_post_obj_field, $post_id = null) {
  $post_id = $post_id ?: get_the_ID();

  return get_posts(array(
    'post_type' => $dest_post_type,
    'meta_key' => $acf_post_obj_field,
    'meta_value' => $post_id,
  ));
}

function mp_reverse_acf_relationship_query($dest_post_type, $acf_relationship_field, $post_id = null) {
  $post_id = $post_id ?: get_the_ID();

  return get_posts(array(
    'post_type' => $dest_post_type,
    'meta_query' => array(
      array(
        'key' => $acf_relationship_field,
        'value' => '"' . $post_id . '"',
        'compare' => 'LIKE'
      )
    )
  ));
}
