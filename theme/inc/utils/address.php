<?php

function inf_format_address( $postal_code, $state, $city, $address1, $address2 = null ) {
    $formatted = $address1;
    if ($address2) {
        $formatted .= ', ' . $address2;
    }

    $formatted .= '<br />';

    $formatted .= sprintf('%s, %s %s', $city, $state, $postal_code);

    return $formatted;
}
