<?php
class inf_PracticeAreas_Widget extends WP_Widget
{
  /**
   * Register widget with WordPress.
   */
  function __construct()
  {
    parent::__construct(
      'related_practice_areas',
      esc_html__('Related Practice Areas', 'inf'),
      array('description' => esc_html__('Related Practice Areas Widget', 'inf'),)
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
  public function widget($args, $instance)
  {
    global $post;

    $current_page_id = get_the_ID();
    $current_page = get_post($current_page_id);
    $parent_id = $current_page->post_parent;

    $practice_areas = null;
    $practice_areas_args = array(
      'post_type' => 'practice-area',
      'posts_per_page' => -1,
      'post_parent' => $parent_id,
      'post_status' => 'publish',
      'orderby' => 'menu_order',
      'order' => 'ASC',
    );

    $uncategorized_term_id = '1';
    if (is_singular('practice-area')) {
      $practice_areas = get_posts($practice_areas_args);
    } elseif (is_singular('post') || is_singular('team') || is_singular('local')) {
      $practice_areas = get_field('practice_areas', $current_page_id);

      if (!$practice_areas && (is_singular('post') || is_singular('local'))) {
        $categories = wp_get_post_categories($current_page_id, array('fields' => 'ids'));
        if (!in_array($uncategorized_term_id, $categories)) {
          $cat_related_practice_areas_args = array(
            'post_type' => 'practice-area',
            'posts_per_page' => -1,
            'tax_query' => array(
              array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $categories,
              ),
            ),
          );

          $practice_areas = get_posts($cat_related_practice_areas_args);
        }
      }

      if (!$practice_areas) {
        $practice_areas = get_posts($practice_areas_args);
      }
    }

    if (!empty($practice_areas)) :
      echo $args['before_widget']; ?>

      <div class="inf-widget inf-practice-areas-widget">
      </div>

      <?php
      echo $args['after_widget'];
    endif;
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form($instance)
  {
    $title = !empty($instance['title']) ? $instance['title'] : esc_html__('', 'gd');
    ?>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'gd'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
    </p>
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
  public function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);

    return $instance;
  }
}

add_action('widgets_init', function () {
  register_widget('inf_PracticeAreas_Widget');
});
