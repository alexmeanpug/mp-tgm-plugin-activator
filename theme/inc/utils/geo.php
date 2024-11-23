<?php
function rad($x) {
    return $x * pi() / 180;
}

/**
 * https://stackoverflow.com/questions/1502590/calculate-distance-between-two-points-in-google-maps-v3
 * @param $p1
 * @param $p2
 * @return float|int
 */
function haversineDistance($p1, $p2) {
    $R = 6378137; # Earth’s mean radius in meter
    $dLat = rad($p2['latitude'] - $p1['latitude']);
    $dLong = rad($p2['longitude'] - $p1['longitude']);
    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(rad($p1['latitude'])) * cos(rad($p2['latitude'])) *
        sin($dLong / 2) * sin($dLong / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $d = $R * $c;

    return $d; // returns the distance in meter
};

function mp_load_google_maps_sdk() {
    ?>
    <script>
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
            key: "<?php the_field('technical_google_maps_api_key', 'option') ?>",
            v: "weekly",
        });
    </script>
    <?php
}
