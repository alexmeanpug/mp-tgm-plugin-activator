<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package infra
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ( is_plugin_active( 'luckywp-table-of-contents/luckywp-table-of-contents.php' ) ) : ?>
    <div class="block mt-8 lg:hidden order-0">
        <?php echo do_shortcode('[lwptoc]') ?>
    </div>
    <?php endif ?>

    <?php the_content() ?>
</article><!-- #post-<?php the_ID(); ?> -->
