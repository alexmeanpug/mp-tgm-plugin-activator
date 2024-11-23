<?php

function inf_get_asset_url($path) {
    return sprintf('%s/assets/%s', get_template_directory_uri(), $path);
}

function inf_acf_link($link_field, $class='') {
  printf('<a href=%s class="%s">%s</a>', $link_field['url'], $class, $link_field['title']);
}
