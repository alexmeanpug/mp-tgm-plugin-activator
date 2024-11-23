<?php

class PolygonMap_Module extends Module {
  public static string $name = 'polygon-map';
  public static bool $has_style = true;

  static function render_html($args) {
    $defaults = array(
      'map_id' => null,
      'place_id' => null,
      'feature_layer_category' => null,
      'center' => array(), //lat,lng
      'styles' => array(
        'stroke_color'   => '#810FCB',
        'fill_color'     => '#810FCB'
      ),
    );
    extract(wp_parse_args($args, $defaults));

    $unique_id = wp_unique_id('mp-pmap_');

    mp_load_google_maps_sdk();

    $extra_classes = array();
    ?>
    <div class="mp-module mp-module-polygon-map <?php echo join(' ', $extra_classes) ?>" id="<?php echo $unique_id ?>">
      <script>
        (function() {
          let map;
          let featureLayer;

          async function initMap() {
            // Request needed libraries.
            const { Map } = await google.maps.importLibrary("maps");

            map = new Map(document.getElementById("<?php echo $unique_id ?>"), {
              center: {lat: <?php echo $center[0] ?>, lng: <?php echo $center[1] ?>},
              zoom: 12,
              mapId: "<?php echo $map_id ?>",
            });

            featureLayer = map.getFeatureLayer("<?php echo $feature_layer_category ?>");

            // Define a style with purple fill and border.
            const featureStyleOptions = {
              strokeColor: "<?php echo $styles['stroke_color'] ?>",
              strokeOpacity: 1.0,
              strokeWeight: 3.0,
              fillColor: "<?php echo $styles['fill_color'] ?>",
              fillOpacity: 0.5,
            };

            // Apply the style to a single boundary.
            featureLayer.style = (options) => {
              if (options.feature.placeId == "<?php echo $place_id ?>") {
                return featureStyleOptions;
              }
            };
          }

          initMap();
        }());
      </script>
    </div>
    <?php
  }
}
