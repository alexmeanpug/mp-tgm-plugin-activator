<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package infra
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
            <article id="404">
                <!-- banner -->
                <header>
                </header>
                <!-- #banner -->

                <!-- content -->
                <div class="container py-6">
                    <h1 class="text-center">Oops! The page you are looking for doesn't exist.</h1>
                </div>
                <!-- #content -->

            </article><!-- #post-<?php the_ID(); ?> -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
