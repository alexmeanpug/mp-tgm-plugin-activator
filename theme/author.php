<?php
/**
 * The template for displaying author pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package infra
 */

get_header();
?>

<div id="primary" class="content-area bsb-archive bsb-author">
    <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    ?>
    <section class="bsb-author-header">
        <div class="container pt-5 pb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-4 text-center">
                    <?php
                    $avatar_args = array (
                            'size' => 150
                    );
                    ?>
                    <img class="rounded-circle" src="<?php echo meanpug_avatar( $avatar_args ) ?>" alt="<?php the_author_meta( 'display_name' ) ?>" />
                </div>

                <div class="col-12 col-md-8 pt-4 pt-md-0 text-center text-md-left">
                    <h1><?php the_author_meta( 'display_name' ) ?></h1>
                    <p><?php the_author_meta( 'description' ) ?></p>
                </div>
            </div>
        </div>
    </section>

    <main id="main" class="site-main">
        <?php
        if ( have_posts() ) {
            $post_counter = 0;
            /* Start the Loop */
            while ( have_posts() ) :
                the_post();
                $post_counter++;

                if ( $post_counter === 1 ) {
                    get_template_part( 'template-parts/content', 'archive-big' );
                } else {
                    get_template_part( 'template-parts/content', 'archive' );
                }
            endwhile;
        ?>
            <div class="container py-4">
                <?php inf_load_more_button(); ?>
            </div>
        <?php
        } else {
            get_template_part( 'template-parts/content', 'none' );
        }
        ?>

    </main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();
