<?php
/**
 * Template part for displaying a gallery of images
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package infra
 */

?>
<article id="post-<?php the_ID(); ?>">
    <!-- banner -->
    <header>
        <?php
        $default_service = MP_Service::get_featured_services( 1 )[0];
        $hero = new MP_Hero_Image( array(
            'extra_css' => 'hero-image--lg',
            'image' => MP_Service::get_featured_image( $default_service ),
            'header' => get_the_title()
        ) );
        $hero->render();
        ?>
    </header>
    <!-- #banner -->

    <!-- content -->
    <div class="container py-5">
        <?php the_content() ?>
    </div>
    <!-- #content -->

    <!-- consultation -->
    <?php
    if ( get_field( 'default_evaluation_form_header', 'option' ) ) {
        $section = new MP_Consultation_Section();
        $section->render();
    }
    ?>
    <!-- #consultation -->
</article><!-- #post-<?php the_ID(); ?> -->
