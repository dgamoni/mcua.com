<?php
/**
 * Daca a fost selectat sa fie harta in header, optinem harta
 * in functia tfuse_get_header_content() ce se afla in
 * theme_config/theme_includes/THEME_HEADER_CONTENT.php
 * setarile pentru harta se transmit prin variabila globala $header_map
 */
global $header_map;
if ( empty($header_map['lat'])) $header_map['lat']  = 0;
if ( empty($header_map['long'])) $header_map['long']  = 0;
if ( empty($header_map['zoom'])) $header_map['zoom']  = 3;

        $template_directory = get_template_directory_uri();

        wp_enqueue_script('maps.google.com');
        wp_enqueue_script('jquery.gmap');
        ?>

    <!-- top Slider/Image -->
    <div class="header_image">

        <div class="topimage">
            <div id="header_map" class="map frame_box" style="width: 100%; height: 276px; border: none; overflow: hidden;"></div>
        </div>

    </div>
    <!--/ top Slider/Image -->
    <?php
              if ($header_map['type'] == 'map2') {
                  echo '<script type="text/javascript">
                            var $j = jQuery.noConflict();
                            $j(window).load(function(){
                                $j("#header_map").gMap({
                                    markers: [{
                                        latitude: ' . $header_map['lat'] . ',
                                        longitude: ' . $header_map['long'] . '}],
                                    maptype: google.maps.MapTypeId.HYBRID,
                                    zoom: ' . $header_map['zoom'] . '
                                    });
                            });
                        </script>';
              } elseif ($header_map['type'] == 'map3') {
                  $htmlAddress = '';
                  if (!empty($header_map['address'])) $htmlAddress = 'html: "' . $header_map['address'] . '",';

                  echo '<script type="text/javascript">
                            var $j = jQuery.noConflict();
                            $j(window).load(function(){
                                $j("#header_map").gMap({
                                    markers: [{
                                        latitude: ' .  $header_map['lat'] . ',
                                        longitude: ' . $header_map['long'] . ','
                                        . $htmlAddress .'
                                        title: "",
                                        popup: true}],
                                    zoom: ' . $header_map['zoom'] . '
                                    });
                            });
                        </script>';
              } else {
                  echo '<script type="text/javascript">
                            var $j = jQuery.noConflict();
                            $j(window).load(function(){
                                $j("#header_map").gMap({
                                    markers: [{
                                        latitude: ' . $header_map['lat'] . ',
                                        longitude: ' . $header_map['long'] . '}],
                                    zoom: ' . $header_map['zoom'] . '
                                    });
                            });
                        </script>';
              }
    ?>