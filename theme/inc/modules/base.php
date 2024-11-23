<?php
class Module {
  public static string $name = '';
  public static bool $has_style = false;
  public static bool $has_script = false;

  static function enqueue_style() {
    if (static::$has_style) {
      wp_enqueue_style( sprintf('inf-%s-style', static::$name), sprintf('%s/dist/%s/%s.min.css', get_stylesheet_directory_uri(), static::$name, static::$name), array(), null);
    }
  }

  static function enqueue_script() {
    if (static::$has_script) {
      wp_enqueue_script( sprintf('inf-%s-script', static::$name), sprintf('%s/dist/%s/%s.min.js', get_stylesheet_directory_uri(), static::$name, static::$name), array('jquery', 'mp-core-script'), null, true);
    }
  }

  static function render($args) {
    self::enqueue_style();
    self::enqueue_script();
    static::render_html($args);
  }

  static function render_html($args) {
    //subclassess should implement this
  }
}
