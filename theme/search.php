<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package infra
 */
get_header();

$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
global $wp_query;
$post_count = $wp_query->found_posts;
$posts_per_page = $wp_query->query_vars['posts_per_page'];
$min_post = $page === 1 ? 1 : $posts_per_page / ($page - 1);
$max_post = min($min_post + $posts_per_page, $post_count);
?>
    <section id="primary" class="content-area">
        <main id="main" class="site-main inf-search-page">
            <header class="bg-green text-white min-h-[55vh] lg:min-h-[50vh] py-8 flex flex-col justify-center relative">
                <div class="container">
                    <div class="inf-breadcrumbs text-white">
                        <?php echo do_shortcode('[wpseo_breadcrumb]') ?>
                    </div>

                    <div class="pt-20 md:pt-32 pb-32 md:max-w-[72rem] mx-auto text-center relative z-10">
                        <h1 class="text-sm uppercase tracking-wider"><?php _e('Search Results', 'inf') ?></h1>

                        <div class="pt-8 pb-12">
                            <strong class="text-7xl md:text-10xl lg:text-12xl pt-8 pb-12">
                                <?php printf('Search Results for "%s"', esc_html(get_search_query())) ?>
                            </strong>
                        </div>

                        <div class="text-sm uppercase tracking-widest font-normal">
                            <strong class="font-normal"><?php _e('Showing Results', 'inf') ?></strong>

                            <p>
                                <?php printf('%s - %s of %s', $min_post, $max_post, $post_count); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </header>

            <?php if ( have_posts() ) : ?>
            <article class="container pt-12 md:pt-24">
                <?php  while ( have_posts() ) : the_post(); ?>
                <div class="border-2 border-green relative md:pt-32 mb-6 group hover:bg-green transition-colors duration-500" data-inviewport="fadein-slideup">
                    <!-- Code -->
                </div>
                <?php
                endwhile;
                echo '<nav class="inf-pagination py-16 lg:py-20">';
                the_posts_pagination();
                echo '</nav>';
                ?>
            </article>
            <?php
            else :
                get_template_part( 'template-parts/content', 'none' );
            endif;
            ?>
        </main><!-- #main -->
    </section><!-- #primary -->
<?php
get_footer();
