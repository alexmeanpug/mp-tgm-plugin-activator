<?php
/**
 * infra functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package infra
 */

define('ACF_EARLY_ACCESS', '5');

if ( ! function_exists( 'inf_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function inf_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on MeanPug, use a find and replace
		 * to change 'inf' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'inf', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'inf_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

    /**
    * Add Post Formats support
    *
    * @link https://codex.wordpress.org/Post_Formats
    */
    add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

    /**
    * SAMPLE: additional post thumbnail sizes
    * add_image_size('attorney-headshot-square', 720, 720 );
    * add_image_size('attorney-headshot-tall', 600, 625 );
    */
	}
endif;
add_action( 'after_setup_theme', 'inf_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function inf_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'inf_content_width', 640 );
}
add_action( 'after_setup_theme', 'inf_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function inf_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'inf' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'inf' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'inf_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function inf_scripts() {
	global $wp_query;

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/vendor/jquery-3.6.0.min.js', false, NULL, true );
  wp_enqueue_script( 'jquery' );

  wp_enqueue_script( 'mp-core-script', 'https://static.meanpugdigital.com/2.4.4/main.js', array('jquery'), null, true);
  wp_enqueue_style( 'mp-core-style', 'https://static.meanpugdigital.com/2.4.4/main.css', array(), null);

  wp_enqueue_style( 'inf-theme-style', get_stylesheet_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css') );
	wp_enqueue_style( 'inf-critical-style', get_stylesheet_directory_uri() . '/critical.css', array('inf-theme-style'), filemtime(get_stylesheet_directory() . '/critical.css'));

	wp_enqueue_script( 'inf-critical-scripts', get_stylesheet_directory_uri() . '/critical.js', array('jquery'), filemtime(get_stylesheet_directory() . '/critical.js'), true);
  wp_enqueue_script( 'inf-main-scripts', get_stylesheet_directory_uri() . '/main.js', array('jquery', 'mp-core-script'), filemtime(get_stylesheet_directory() . '/main.js'), true);

  wp_dequeue_style('megamenu-genericons');
  wp_dequeue_style('megamenu-fontawesome6');
  wp_dequeue_style('classic-theme-styles');
	// if we're not in an admin session, dequeue the blocks library
  if ( ! is_admin() ) {
      wp_dequeue_style( 'wp-block-library' );
      wp_dequeue_style( 'wp-block-library-theme' );
      wp_dequeue_style( 'wc-blocks-style' );
  }

  $theme_options = array();
	$theme_options['ajax_url'] = admin_url( 'admin-ajax.php' );
  $theme_options['staticfiles_base'] = get_template_directory_uri();

	wp_localize_script( 'inf-main-scripts', 'theme', $theme_options );
}
add_action( 'wp_enqueue_scripts', 'inf_scripts' );

function inf_add_footer_styles() {
	wp_enqueue_style( 'inf-main-style', get_template_directory_uri() . '/main.css', array(), filemtime(get_template_directory() . '/main.css') );
};
add_action( 'get_footer', 'inf_add_footer_styles' );

/**
 * Get Blocks
 */
function inf_get_blocks() {
    $theme = wp_get_theme();
    $blocks = get_option( 'inf_wp_blocks' );
    $version = get_option( 'inf_wp_blocks_version' );
    if ( empty( $blocks ) || version_compare( $theme->get( 'Version' ), $version ) || ( function_exists( 'wp_get_environment_type' ) && 'production' !== wp_get_environment_type() ) ) {
        $blocks = scandir( get_template_directory() . '/blocks/' );
        $blocks = array_values( array_diff( $blocks, array( '..', '.', '.DS_Store', '_base-block' ) ) );

        update_option( 'inf_wp_blocks', $blocks );
        update_option( 'inf_wp_blocks_version', $theme->get('Version'));
    }

    return $blocks;
}

function inf_load_blocks() {
    $theme = wp_get_theme();
    $blocks = inf_get_blocks();

    foreach( $blocks as $block ) {
        if ( file_exists( get_template_directory() . '/blocks/' . $block . '/block.json' ) ) {
            register_block_type( get_template_directory() . '/blocks/' . $block . '/block.json' );

            $block_css_path = '/dist/' . $block . '/' . $block . '.min.css';
            $block_js_path = '/dist/' . $block . '/' . $block . '.min.js';
            wp_register_style( 'blocks/' . $block . '-style', get_template_directory_uri() . $block_css_path, null, filemtime(get_template_directory() . $block_css_path) );
            wp_register_script( 'blocks/' . $block . '-script', get_template_directory_uri() . $block_js_path, array('mp-core-script'), filemtime(get_template_directory() . $block_js_path) );

//            if ( file_exists( get_template_directory() . '/blocks/' . $block . '/init.php' ) ) {
//                include_once get_template_directory() . '/blocks/' . $block . '/init.php';
//            }
        }
    }
}
add_action( 'init', 'inf_load_blocks' );

// havent seen this documented anywhere, but when it isn't set all block styles are being rendered even when the block
// isn't used on the page
add_filter('should_load_separate_core_block_assets', '__return_true');

require_once __DIR__ . '/inc/filters.php';
require_once __DIR__ . '/inc/hooks.php';
require_once __DIR__ . '/inc/template_functions.php';

require_once __DIR__ . '/inc/cpt/all.php';
require_once __DIR__ . '/inc/tax/all.php';
require_once __DIR__ . '/inc/menus/all.php';
require_once __DIR__ . '/inc/settings/all.php';
require_once __DIR__ . '/inc/sidebars/all.php';
require_once __DIR__ . '/inc/widgets/all.php';
require_once __DIR__ . '/inc/modules/all.php';
require_once __DIR__ . '/inc/utils/all.php';
require_once __DIR__ . '/inc/services/all.php';

