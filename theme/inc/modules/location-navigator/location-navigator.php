<?php

function mp_location_navigator_areas_served_tabs_layout($args) {
    $defaults = array(
        'header'    => null,
        'locations_page_link'   => array(),
        'icons' => array()
    );

    $opts = wp_parse_args($args, $defaults);

    $local_content = get_posts(array(
        'post_type' => 'local',
        'posts_per_page' => -1,
        'meta_key'      => 'content_type',
        'meta_value'    => 'Area Served'
    ));
    // split the posts into buckets given by area_type
    $area_buckets = array();
    foreach ( $local_content as $area_served ) {
        $area_type = get_field( 'area_type', $area_served );
        if ( $area_buckets[$area_type] ) {
            $area_buckets[$area_type][] = $area_served;
        } else {
            $area_buckets[$area_type] = array( $area_served );
        }
    }
    ?>
    <div>
        <div class="text-center py-8">
            <strong class="mp-location-navigator__label"><?php echo $opts['header'] ?></strong>
        </div>

        <div class="mp-location-navigator__tabs-container mp-tabs">
            <ul class="mp-location-navigator__tabs mp-tabs__buttons">
                <?php $i = 0; foreach( array_keys( $area_buckets ) as $bucket ) : ?>
                    <li class="mp-location-navigator__tab mp-tab<?php if ( $i === 0 ) { echo ' active'; } ?>" data-tab-target="#navigator-tab-<?php echo sanitize_title( $bucket ) ?>">
                        <strong class="mp-location-navigator__label"><?php printf( __('By %s'), $bucket ) ?></strong>
                    </li>
                    <?php $i++; endforeach; ?>
            </ul>

            <div class="mp-location-navigator__tab-contents mp-tabs__contents">
                <?php $i = 0; foreach ( $area_buckets as $bucket => $bucket_posts ) : ?>
                    <div class="mp-location-navigator__tab-content mp-tab__content<?php if ( $i === 0 ) { echo ' active'; } ?>" id="navigator-tab-<?php echo sanitize_title( $bucket ) ?>">
                        <ul class="mp-location-navigator__list">
                            <?php foreach ( $bucket_posts as $area ) : ?>
                            <li class="mp-location-navigator__list-item">
                                <a href="<?php echo get_permalink( $area ) ?>" class="mp-location-navigator__link"><?php echo get_the_title($area) ?></a>
                            </li>
                            <?php endforeach ?>
                        </ul>

                        <?php if ( $opts['locations_page_link'] ) : ?>
                            <div class="pt-12 text-center mp-location-navigator__archive">
                                <a href="<?php echo $opts['locations_page_link']['url'] ?>" class="mp-location-navigator__link mp-location-navigator__link--highlight flex items-center justify-center">
                                    <span><?php echo $opts['locations_page_link']['title'] ?></span>
                                    <img src="<?php echo $opts['icons']['down_caret'] ?>" class="w-3 ml-2" />
                                </a>
                            </div>
                        <?php endif ?>
                    </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>
    </div>
<?php
}

function mp_location_navigator_areas_served_hierarchichal_layout($args) {
    $defaults = array(
        'header'    => null,
        'locations_page_link'   => array(),
        'icons' => array()
    );

    $opts = wp_parse_args($args, $defaults);

    $areas_served = get_posts(array(
        'post_type' => 'local',
        'posts_per_page' => -1,
        'post_parent' => 0,
        'meta_key'      => 'content_type',
        'meta_value'    => 'Area Served'
    ));
    ?>
    <div>
        <div class="text-center py-8">
            <strong class="mp-location-navigator__label"><?php echo $opts['header'] ?></strong>
        </div>
        <div class="mp-location-navigator__list-container">
            <ul class="mp-location-navigator__list">
                <?php foreach ($areas_served as $area) : ?>
                    <li class="text-center mp-location-navigator__list-item py-6">
                        <a href="<?php echo get_permalink($area) ?>" class="mp-location-navigator__link">
                            <strong class="mp-location-navigator__label mp-location-navigator__label--highlight mp-anim--pu mp-anim--pu--12 py-3"><?php echo get_the_title($area) ?></strong>
                        </a>

                        <ul class="mp-location-navigator__list mp-location-navigator__list--nested">
                            <?php
                            $child_areas = get_children(array(
                                'post_type' => 'local',
                                'posts_per_page' => -1,
                                'post_parent' => $area->ID,
                                'meta_key'      => 'content_type',
                                'meta_value'    => 'Area Served'
                            ));
                            foreach ( $child_areas as $child_area ) : ?>
                                <li class="mp-location-navigator__list-item">
                                    <a href="<?php echo get_permalink($child_area) ?>" class="mp-location-navigator__link">
                                        <?php echo get_the_title($child_area) ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endforeach ?>
            </ul>

            <?php if ( $opts['locations_page_link'] ) : ?>
                <div class="pt-12 text-center mp-location-navigator__archive">
                    <a href="<?php echo $opts['locations_page_link']['url'] ?>" class="mp-location-navigator__link mp-location-navigator__link--highlight flex items-center justify-center">
                        <span><?php echo $opts['locations_page_link']['title'] ?></span>
                        <img src="<?php echo $opts['icons']['down_caret'] ?>" class="w-3 ml-2" />
                    </a>
                </div>
            <?php endif ?>
        </div>
    </div>
<?php
}

function mp_location_navigator_areas_served_state_city_layout($args) {
    $defaults = array(
        'states_header' => __('All States', 'mp'),
        'cities_header' => __('Cities', 'mp'),
    );

    $opts = wp_parse_args($args, $defaults);

    $areas_served = get_posts(array(
        'post_type' => 'local',
        'posts_per_page' => -1,
        'meta_key'      => 'content_type',
        'meta_value'    => 'Area Served'
    ));

    $state_posts = array();
    $city_posts = array();

    foreach ($areas_served as $area) {
        if (get_field('area_type', $area) === 'State') {
            $state_posts[] = $area;
        } else {
            $city_posts[] = $area;
        }
    }
    ?>
    <div class="mp-location-navigator--state-city">
        <div class="mp-location-navigator--state-city__panel">
            <h3 class="mp-location-navigator--state-city__header"><?php echo $opts['states_header'] ?></h3>

            <ul class="mp-location-navigator--state-city__list mp-location-navigator--state-city__list--states">
                <?php foreach ($state_posts as $state) : ?>
                <li>
                    <a href="<?php echo get_permalink($state) ?>">
                        <?php echo get_the_title($state) ?>
                    </a>
                </li>
                <?php endforeach ?>
            </ul>
        </div>

        <div class="mp-location-navigator--state-city__panel">
            <h3 class="mp-location-navigator--state-city__header"><?php echo $opts['cities_header'] ?></h3>

            <nav class="mp-location-navigator--state-city__filter">
                <a href="#all-cities"><?php _e('All', 'mp') ?></a>
                <?php foreach (range('A', 'Z') as $letter) : ?>
                <a href="#<?php printf('%s-cities', $letter) ?>">
                    <?php echo $letter ?>
                </a>
                <?php endforeach ?>
            </nav>

            <ul class="mp-location-navigator--state-city__list mp-location-navigator--state-city__list--cities">
                <?php foreach ($city_posts as $city) : ?>
                    <li data-letter="<?php echo get_the_title($city)[0] ?>" class="active">
                        <a href="<?php echo get_permalink($city) ?>">
                            <?php echo get_the_title($city) ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
<?php
}

class LocationNavigator_Module extends Module {
  public static string $name = 'location-navigator';
  public static bool $has_style = true;
  public static bool $has_script = true;

  public static function render_html($args) {
    $defaults = array(
      'caption'   => null,
      'header'    => null,
      'display_type' => null,
      'offices_section' => array(
        'header'  => null,
        'use_carousel' => true,
      ),
      'areas_served_section'  => array(
        'header'  => null,
        'locations_page_link' => array()
      ),
      'background_image'  => array(),
      'icons' => array(
        'right_arrow' => null,
        'right_caret' => null,
        'left_caret' => null,
        'down_caret' => null,
      ),
      'primary_cta'  => array()
    );

    $opts = wp_parse_args($args, $defaults);
    ?>
  <div class="mp-module mp-location-navigator-module<?php if ($opts['display_type'] !== 'State/City') { echo ' mp-location-navigator-module--default-layout'; } ?>">
    <div class="text-center">
      <strong class="mp-location-navigator__caption"><?php echo $opts['caption'] ?></strong>
      <h2 class="mp-location-navigator__header"><?php echo $opts['header'] ?></h2>
    </div>

    <?php if ( $opts['background_image'] ) : ?>
    <img src="<?php echo $opts['background_image'] ?>" class="absolute left-0 top-0 mt-16 z-0 max-h-96" />
    <?php endif ?>

    <div class="container mx-auto relative z-10">
    <?php
    $offices_data = $opts['offices_section'];
    $office_settings = get_field('contact_offices', 'option');
    $use_carousel = $offices_data['use_carousel'];
    if ($opts['display_type'] !== 'State/City' && $office_settings && sizeof($office_settings) > 0) : ?>
      <div class="mp-location-navigator__offices flex flex-col md:flex-row items-start">
        <div class="w-full md:w-1/4 shrink-0 flex md:block items-center justify-between">
          <strong class="mp-location-navigator__label"><?php echo $offices_data['header'] ?></strong>
        </div>

    <?php if ($use_carousel) : ?>
    <div class="glide relative pt-4 md:pt-0 w-full md:w-3/4" id="mp-location-navigator-office-carousel">
      <div class="glide__track" data-glide-el="track">
        <?php else : ?>
        <div class="relative pt-4 md:pt-0 w-full md:w-3/4"><div>
            <?php endif ?>
            <ul class="mp-location-navigator__carousel w-3/4<?php if ($use_carousel) echo ' glide__slides' ?>">
              <?php foreach ($office_settings as $office) : ?>
                <li class="mp-location-navigator__carousel-item<?php if ($use_carousel) echo ' glide__slide' ?>">
                  <strong class="mp-location-navigator__caption"><?php echo $office['name'] ?></strong>

                  <div class="mp-location-navigator__content">
                    <?php echo $office['address'] ?>
                  </div>

                  <?php if ($phone_number = $office['phone_number']) : ?>
                    <div class="mp-location-navigator__tel">
                      <a href="<?php echo $phone_number['url'] ?>">
                        <?php echo $phone_number['title'] ?>
                      </a>
                    </div>
                  <?php endif ?>

                  <a href="<?php echo $office['directions_link'] ?>" class="mp-location-navigator__link mp-location-navigator__link--directions pt-4">
                    <?php _e('Get Directions'); ?>
                  </a>
                </li>
              <?php endforeach ?>
            </ul>

            <?php if ($use_carousel) : ?>
              <div class="hidden lg:flex items-center absolute right-0 top-0">
                <button class="mp-carousel-btn--prev">
                  <img src="<?php echo $opts['icons']['left_caret'] ?>" alt="<?php echo __('Previous Caret') ?>" class="w-3" />
                </button>

                <button class="ml-4 mp-carousel-btn--next">
                  <img src="<?php echo $opts['icons']['right_caret'] ?>" alt="<?php echo __('Next Caret') ?>" class="w-3" />
                </button>
              </div>
            <?php endif ?>
        </div>
    </div>
  </div>
  <?php endif ?>

  <?php $areas_data = $opts['areas_served_section'] ?>
  <div class="mp-location-navigator__areas">
    <?php
    if ( $opts['display_type'] === 'Tabs' ) {
      mp_location_navigator_areas_served_tabs_layout(array(
        'header' => $areas_data['header'],
        'locations_page_link' => $areas_data['locations_page_link'],
        'icons' => $opts['icons'],
      ));
    } else if ( $opts['display_type'] === 'State/City' ) {
      mp_location_navigator_areas_served_state_city_layout(array());
    } else {
      mp_location_navigator_areas_served_hierarchichal_layout(array(
        'header' => $areas_data['header'],
        'locations_page_link' => $areas_data['locations_page_link'],
        'icons' => $opts['icons'],
      ));
    }
    ?>
  </div>

  <?php if ($opts['primary_cta']) : ?>
    <div class="pt-8 text-center">
      <a href="<?php echo $opts['primary_cta']['url'] ?>" class="mp-location-navigator__link mp-location-navigator__link--cta">
        <?php echo $opts['primary_cta']['title'] ?>
      </a>
    </div>
  <?php endif ?>
  </div>
  </div>
<?php
  }
}
