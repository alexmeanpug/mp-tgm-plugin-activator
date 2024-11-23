<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package infra
 */

get_header();

$post_type = get_post_type();

$sidebar_for_post_type = array(
    'team'  => 'attorney-sidebar'
);
$header_for_post_type = array(
    'team'  => 'attorney-header'
);

$has_breadcrumbs_in_main = false;
$has_child_topics_explorer = $post_type == 'practice-area';
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
      <?php while ( have_posts() ) : the_post();
        $current_sidebar = $sidebar_for_post_type[$post_type] ?: 'default-sidebar';
        $current_header = $header_for_post_type[$post_type] ?: 'default-header';
      ?>
      <header>
          <?php get_template_part( 'template-parts/headers/content', $current_header ); ?>
      </header>

      <?php
        if ($$has_child_topics_explorer) {
          get_template_part( 'template-parts/snippets/content', 'topics-accordion' );
        }
      ?>
       <div class="flex max-lg:flex-col py-8 lg:py-12 container">
          <div id="main" class="site-main lg:w-2/3 lg:pr-16">
              <?php if ($has_breadcrumbs_in_main) : ?>
              <div class="inf-breadcrumbs lg:pb-16">
                  <?php echo do_shortcode('[wpseo_breadcrumb]'); ?>
              </div>
              <?php endif ?>

              <div class="inf-post__content">
                  <?php get_template_part( 'template-parts/content', 'single' ); ?>
              </div>
          </div><!-- #main -->

          <aside class="lg:w-1/3">
              <?php dynamic_sidebar($current_sidebar) ?>
          </aside>
      </div>
      <?php endwhile; ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
