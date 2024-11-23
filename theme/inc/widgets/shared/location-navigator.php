<?php

class MP_LocationNavigator_Widget extends WP_Widget {
    /**+
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'location_navigator',
            esc_html__( 'Location Navigator', 'mp' ),
            array( 'description' => esc_html__( 'Location Navigator Widget', 'mp' ), )
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $widget_id = $args['widget_id'];
        $widget_selector = 'widget_' . $widget_id;
        $icons = get_field( 'icons', $widget_selector );

        mp_load_google_maps_sdk();

        echo $args['before_widget']; ?>

        <div class="mp-location-navigator-widget">
            <div class="mp-location-navigator-widget__info-icon">
                <?php echo wp_get_attachment_image( $icons['information'] ); ?>
            </div>

            <div class="mp-location-navigator-widget__top">
                <?php the_field( 'header', $widget_selector ) ?>
            </div>

            <div class="mp-location-navigator-widget__search">
                <div class="mp-location-navigator-widget__input">
                    <input type="text" placeholder="<?php echo __( 'Search', 'mp' ) ?>" />

                    <div class="mp-location-navigator-widget__cta">
                        <?php echo wp_get_attachment_image( $icons['magnifying_glass'] ); ?>
                    </div>
                </div>
            </div>

            <div class="mp-location-navigator-widget__results" data-loader="<?php the_field( 'loading_spinner', $widget_selector ) ?>">
                <?php
                $areas_served = get_posts(array(
                    'post_type' => 'local',
                    'posts_per_page' => -1,
                    'meta_key' => 'content_type',
                    'meta_value' => 'Area Served'
                ));

                if (get_field('group_by_state', $widget_selector)) {
                    $grouped_links = array();
                    # start by populating with posts with no parent (top level)
                    foreach ( $areas_served as $area ) {
                        $parent_id = wp_get_post_parent_id($area);
                        if (!$parent_id) {
                            $grouped_links[$area->ID] = array();
                        }
                    }

                    foreach ( $areas_served as $area ) {
                        $parent_id = wp_get_post_parent_id($area);
                        if ($parent_id) {
                            $grouped_links[$parent_id][] = array(
                                'url' => get_permalink($area),
                                'title' => get_the_title($area)
                            );
                        }
                    }

                    mp_location_navigator_search_results_grouped( $grouped_links );
                } else {
                    $links = array();
                    foreach ( $areas_served as $area ) {
                        $links[] = array(
                            'url' => get_permalink($area),
                            'title' => get_the_title($area)
                        );
                    }

                    mp_location_navigator_search_results_flat( $links );
                }
                ?>
            </div>

            <div class="mp-location-navigator-widget__bottom">
                <?php $cta = get_field( 'cta', $widget_selector ); ?>

                <?php if ( $cta ) : ?>
                <a href="<?php echo $cta['url'] ?>" class="mp-location-navigator-widget__cta">
                    <?php echo $cta['title'] ?>
                </a>
                <?php endif ?>

                <div class="pt-8">
                    <?php echo wp_get_attachment_image( $icons['pin'] ); ?>

                    <a href="#location" class="mp-location-navigator-widget__link mp-location-navigator-widget__link--highlighted mp-location-navigator-widget__link--use-location">
                        <?php echo __( 'use my location', 'mp' ) ?>
                    </a>
                </div>
            </div>
        </div>

        <?php
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        ?>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $new_instance;
        return $instance;
    }
}

add_action( 'widgets_init', function() {
    register_widget( 'MP_LocationNavigator_Widget' );
} );
