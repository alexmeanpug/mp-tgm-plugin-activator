<?php
/**
 * Template Name: PPC Landing Page - Competitor Matchup
 *
 * Shows a line-by-line matchup of the law firm vs. competitors
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package meanpug-legal-pi-parent-theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<?php get_template_part('template-parts/technical/content', 'header-head'); ?>

<body <?php body_class(); ?>>
    <div id="primary" class="mp-ppc-landing-page mp-ppc-landing-page--matchup">
        <main id="main" class="site-main">
            <?php while ( have_posts() ) : the_post(); ?>
            <!-- Banner -->
            <div class="mp-banner">
                <div class="container mx-auto flex items-center justify-between">
                    <div class="mp-banner__content"><?php the_field('banner_content') ?></div>
                    <div class="mp-banner__close">
                        <?php $image = get_field('banner_close_icon') ?>
                        <button>
                            <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" />
                        </button>
                    </div>
                </div>
            </div>
            <!-- End Banner -->

            <!-- Nav -->
            <?php
            $main_link = get_field('nav_main_link');
            $main_phone = get_field('contact_phone', 'option');
            $phone_icon = get_field('nav_phone_icon');
            ?>
            <nav class="mp-nav mp-nav--bare">
                <div class="container mx-auto flex items-center justify-between">
                    <div class="mp-nav__logo">
                        <?php echo get_custom_logo(); ?>
                    </div>

                    <ul class="mp-nav__items">
                        <li class="hidden md:list-item">
                            <a href="<?php echo $main_link['url'] ?>" class="mp-button mp-button--secondary">
                                <?php echo $main_link['title'] ?>
                            </a>
                        </li>

                        <li class="mp-nav__call">
                            <div class="hidden lg:block">
                                <p><?php _e( 'Free Call 24/7', 'mp' ) ?></p>
                                <a href="<?php echo $main_phone['url'] ?>">
                                    <strong><?php echo $main_phone['title'] ?></strong>
                                </a>
                            </div>

                            <a href="<?php echo $main_phone['url'] ?>" class="block lg:hidden">
                                <img src="<?php echo $phone_icon['url'] ?>" alt="<?php echo $phone_icon['alt'] ?>" class="mp-nav__ctc" />
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="block md:hidden mp-nav__mobile-cta-container">
                    <a href="<?php echo $main_link['url'] ?>" class="mp-button mp-button--secondary">
                        <?php echo $main_link['title'] ?>
                    </a>
                </div>
            </nav>
            <!-- End Nav -->

            <!-- Hero -->
            <?php
            $background = get_field('hero_background_image');
            $cta = get_field('hero_cta');
            ?>
            <section class="mp-hero" style="background-image: url(<?php echo $background['url'] ?>);">
                <div class="container mx-auto">
                    <h1 class="mp-hero__header mp-header mp-header--5">
                        <?php the_field('hero_header') ?>
                    </h1>

                    <div class="mp-hero__subheader mp-text mp-text--main">
                        <?php the_field('hero_subheader') ?>
                    </div>

                    <div class="mp-hero__cta">
                        <a href="<?php echo $cta['url'] ?>" class="mp-button mp-button--primary">
                            <?php echo $cta['title'] ?>
                        </a>
                    </div>
                </div>
            </section>
            <!-- End Hero -->

            <!-- Verdicts -->
            <?php
            $label = get_field('verdicts_label');
            $firm_stats_label = get_field('verdicts_firm_stats_label');
            $firm_stats_content = get_field('verdicts_firm_stats_content');
            $other_firms_stats_label = get_field('verdicts_other_firm_stats_label');
            $other_firms_stats_content = get_field('verdicts_other_firm_stats_content');
            $bg_image = get_field('verdicts_bg_image');
            $cta = get_field('verdicts_cta');
            ?>
            <section class="mp-verdicts">
                <img src="<?php echo $bg_image['url'] ?>" alt="<?php echo $bg_image['alt'] ?>" class="mp-verdicts__bg" />

                <div class="mp-verdicts__label mp-label-box">
                    <?php echo $label ?>
                </div>

                <div class="container mx-auto">
                    <div class="mp-verdicts__stats mp-comparison-boxes">
                        <div class="mp-verdicts__stats__single mp-comparison-box">
                            <p class="mp-verdicts__stats__single-label mp-comparison-box__label mp-label"><?php echo $firm_stats_label ?></p>
                            <div class="mp-verdicts__stats__single-content mp-comparison-box__content">
                                <?php echo $firm_stats_content ?>
                            </div>
                        </div>

                        <div class="mp-verdicts__stats__single mp-comparison-box">
                            <p class="mp-verdicts__stats__single-label mp-comparison-box__label mp-label"><?php echo $other_firms_stats_label ?></p>
                            <div class="mp-verdicts__stats__single-content mp-comparison-box__content">
                                <?php echo $other_firms_stats_content ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mp-verdicts__cta">
                    <a href="<?php echo $cta['url'] ?>" class="mp-button mp-button--primary">
                        <?php echo $cta['title'] ?>
                    </a>
                </div>
            </section>
            <!-- End Verdicts -->

            <!-- Comparison Grid -->
            <?php
            $title = get_field('comparison_grid_title');
            $description = get_field('comparison_grid_description');
            $main_title = get_field('comparison_grid_primary_header_title');
            $cta = get_field('comparison_grid_cta');
            $tooltip_icon = get_field('comparison_grid_tooltip_icon');
            if ( have_rows('comparison_grid_items') ) : ?>
            <section class="mp-comp-grid">
                <div class="container mx-auto">
                    <div class="mp-comp-grid__header" data-inviewport="true">
                        <h2 class="mp-comp-grid__title"><?php echo $title ?></h2>
                        <p class="mp-comp-grid__description"><?php echo $description ?></p>
                    </div>

                    <div class="mp-comp-grid__body">
                        <ul class="mp-comp-grid__table mp-comp-grid__table--titles">
                            <li class="mp-comp-grid__table__header"></li>
                            <?php while ( have_rows('comparison_grid_items') ) : the_row(); ?>
                                <li class="mp-comp-grid__table__cell mp-comp-grid__table__cell--title">
                                    <?php the_sub_field('title') ?>
                                </li>
                            <?php endwhile ?>
                        </ul>

                        <ul class="mp-comp-grid__table mp-comp-grid__table--primary">
                            <li class="mp-comp-grid__table__header mp-comp-grid__table__header--primary">
                                <?php echo $main_title ?>
                            </li>
                            <?php while ( have_rows('comparison_grid_items') ) : the_row(); ?>
                                <li class="mp-comp-grid__table__cell mp-comp-grid__table__cell--primary">
                                    <?php $primary_data = get_sub_field('primary_value'); ?>
                                    <?php if ( $primary_data['value_type'] == 'Text' ) : ?>
                                        <p><?php echo $primary_data['text'] ?></p>
                                    <?php else : ?>
                                        <img src="<?php echo $primary_data['icon'] ?>" alt="<?php echo _e('Comparison Icon', 'mp') ?>" class="mp-comp-grid__icon" />
                                    <?php endif ?>

                                    <?php if ( $primary_data['tooltip'] ) : ?>
                                    <span class="mp-comp-grid__tooltip mp-tooltip mp-tooltip--bottom" data-text="<?php echo $primary_data['tooltip'] ?>">
                                        <img src="<?php echo $tooltip_icon ?>" />
                                    </span>
                                    <?php endif ?>
                                </li>
                            <?php endwhile ?>

                            <li class="mp-comp-grid__table__cell mp-comp-grid__table__cell--cta">
                                <a href="<?php echo $cta['url'] ?>" class="mp-button mp-button--primary">
                                    <?php echo $cta['title'] ?>
                                </a>
                            </li>
                        </ul>
                        <ul>
                            <li class="mp-comp-grid__table__header mp-comp-grid__table__header--secondary">
                                <?php echo _e('Other Firms*', 'mp') ?>
                            </li>
                            <?php while ( have_rows('comparison_grid_items') ) : the_row(); ?>
                            <li class="mp-comp-grid__table__cell mp-comp-grid__table__cell--secondary">
                                <?php $secondary_data = get_sub_field('comparison_value'); ?>
                                <?php if ( $secondary_data['value_type'] == 'Text' ) : ?>
                                    <p><?php echo $secondary_data['text'] ?></p>
                                <?php else : ?>
                                    <img src="<?php echo $secondary_data['icon'] ?>" alt="<?php echo _e('Comparison Icon', 'mp') ?>" class="mp-comp-grid__icon" />
                                <?php endif ?>
                            </li>
                            <?php endwhile ?>

                            <li class="mp-comp-grid__table__cell mp-comp-grid__table__cell--disclaimer">
                                <?php echo _e('* May not be true for every law firm', 'mp') ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <?php endif ?>
            <!-- End Comparison Grid -->

            <!-- Overview -->
            <?php
            $label = get_field('overview_label');
            $badge = get_field('overview_badge');
            $header = get_field('overview_header');
            $content = get_field('overview_content');
            $highlights = get_field('overview_highlights');
            $cta = get_field('overview_cta');
            ?>
            <section class="mp-overview">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center">
                        <p class="mp-overview__label mp-label mp-label--primary"><?php echo $label ?></p>

                        <?php if ($badge) : ?>
                        <img src="<?php echo $badge['url'] ?>" alt="<?php echo $badge['alt'] ?>" class="mp-overview__badge" />
                        <?php endif ?>
                    </div>

                    <div class="mp-overview__container">
                        <div class="mp-overview__header mp-header mp-header--3">
                            <?php echo $header ?>
                        </div>

                        <div class="mp-overview__content mp-text mp-text--main">
                            <?php echo $content ?>
                        </div>
                    </div>

                    <ul class="mp-overview__highlights">
                        <?php $ix_delay_map = array( 0 => '200', 1 => '500', 2 => '700' ); ?>
                       <?php $i = 0; foreach ($highlights as $highlight) : ?>
                       <li class="mp-overview__highlights__single w-full md:w-1/<?php echo sizeof( $highlights ) ?> delay-<?php echo $ix_delay_map[$i] ?>" data-inviewport="fadein">
                           <strong><?php echo $highlight['title'] ?></strong>
                           <p><?php echo $highlight['subtitle'] ?></p>
                       </li>
                       <?php $i++; endforeach ?>
                    </ul>

                    <div class="mp-overview__cta">
                        <a href="<?php echo $cta['url'] ?>" class="mp-button mp-button--primary">
                            <?php echo $cta['title'] ?>
                        </a>
                    </div>
                </div>
            </section>
            <!-- End Overview -->

            <!-- Form -->
            <?php
            $label = get_field('form_label');
            $header = get_field('form_header');
            $shortcode = get_field('form_shortcode');
            ?>
            <section class="mp-form" id="lpForm">
                <div class="container mx-auto">
                    <hr class="mp-form__bar" data-inviewport="expand" />
                    <p class="mp-form__label mp-label mp-label--primary"><?php echo $label ?></p>

                    <div class="flex flex-col md:flex-row justify-between pt-8 md:pt-16">
                        <div class="mp-form__header mp-header mp-header--5">
                            <?php echo $header ?>
                        </div>

                        <div class="mp-form__form">
                            <?php echo do_shortcode( $shortcode ) ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Form -->

            <!-- Comparisons List -->
            <?php
            $firm_value_label = get_field('comparisons_firm_value_label');
            $comparator_value_label = get_field('comparisons_comparator_value_label');
            $comparisons_flex_content = get_field('comparisons_flex_content');
            ?>
            <section class="mp-comparisons">
                <?php
                if( have_rows('comparisons_flex_content') ):
                    $i = 0;
                    while ( have_rows('comparisons_flex_content') ) : the_row();
                        if( get_row_layout() == 'comparison' ):
                            $title = get_sub_field('title');
                            $firm_value_content = get_sub_field('firm_value_content');
                            $comparator_value_content = get_sub_field('comparator_value_content'); ?>
                            <div class="mp-comparisons__comparison<?php if ( $i % 2 == 0 ) { echo ' mp-comparisons__comparison--even'; } ?> container mx-auto">
                                <div class="mp-comparisons__comparison__header mp-header mp-header--3">
                                    <?php echo $title ?>
                                </div>

                                <div class="mp-comparison-boxes delay-500" data-inviewport="fadein">
                                    <div class="mp-comparisons__comparison__single mp-comparison-box">
                                        <p class="mp-comparisons__comparison__single-label mp-comparison-box__label mp-label"><?php echo $firm_value_label ?></p>
                                        <div class="mp-comparisons__comparison__single-content mp-comparison-box__content">
                                            <?php echo $firm_value_content ?>
                                        </div>
                                    </div>

                                    <div class="mp-comparisons__comparison__single mp-comparison-box">
                                        <p class="mp-comparisons__comparison__single-label mp-comparison-box__label mp-label"><?php echo $comparator_value_label ?></p>
                                        <div class="mp-comparisons__comparison__single-content mp-comparison-box__content">
                                            <?php echo $comparator_value_content ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endif;
                        $i++;
                    endwhile;
                endif;
                ?>
            </section>
            <!-- End Comparisons List -->

            <!-- Call Marquee -->
            <?php
            $icon = get_field('call_marquee_icon');
            $text = get_field('call_marquee_text');
            $bg_image = get_field('call_marquee_background_image');
            $main_phone = get_field('contact_phone', 'option');
            ?>
            <section class="mp-call-marquee" style="background-image: url(<?php echo $bg_image ?>);">
                <div class="w-full md:w-1/2 mx-auto">
                    <img src="<?php echo $icon['url'] ?>" alt="<?php echo $icon['alt'] ?>" class="mp-call-marquee__icon" />

                    <div class="mp-call-marquee__text">
                        <?php echo $text ?>
                    </div>

                    <hr class="mp-call-marquee__divider" />
                </div>

                <div class="mp-call-marquee__marquee mp-marquee" data-per-page="1" data-per-page-xl="2">
                    <ul class="mp-marquee__content">
                        <li class="mp-marquee__item"><?php echo $main_phone['title'] ?></li>
                        <li class="mp-marquee__item"><?php echo $main_phone['title'] ?></li>
                    </ul>
                </div>
            </section>
            <!-- End Call Marquee -->

            <!-- Testimonials -->
            <?php
            $label = get_field('testimonials_label');
            $header = get_field('testimonials_header');
            $caption = get_field('testimonials_caption') ?: __('5 Star Reviews', 'mp');
            $bg_image = get_field('testimonials_background_image');
            $selected_testimonials = get_field('testimonials_selected');
            if (!$selected_testimonials) {
                $selected_testimonials = get_posts(array('post_type' => 'testimonials'));
            }
            $left_icon = get_field('testimonials_left_icon');
            $right_icon = get_field('testimonials_right_icon');
            $open_quote_icon = get_field('testimonials_open_quote_icon');
            $close_quote_icon = get_field('testimonials_close_quote_icon');
            ?>
            <section class="mp-testimonials">
                <div class="container mx-auto">
                    <div class="mp-testimonials__label mp-label mp-label--primary">
                        <p><?php echo $label ?></p>
                    </div>

                    <div class="mp-testimonials__header mp-testimonials__content-wrap mp-header mp-header--5">
                        <?php echo $header ?>
                    </div>
                </div>

                <div class="mp-testimonials__items" style="background-image: url(<?php echo $bg_image ?>);">
                    <div class="container mx-auto">
                        <div class="mp-carousel mp-testimonials__carousel glide mp-testimonials__content-wrap">
                            <img src="<?php echo $open_quote_icon['url'] ?>" alt="<?php echo $open_quote_icon['alt'] ?>" class="mp-testimonials__quote top-0 left-0 mt-8 lg:ml-32 z-10" />
                            <img src="<?php echo $close_quote_icon['url'] ?>" alt="<?php echo $close_quote_icon['alt'] ?>" class="mp-testimonials__quote bottom-0 right-0 mb-8 lg:mr-32 z-10" />

                            <div class="glide__arrows" data-glide-el="controls">
                                <button class="glide__arrow glide__arrow--left mp-testimonials__items__arrow" data-glide-dir="<">
                                    <img src="<?php echo $left_icon['url'] ?>" alt="<?php echo $left_icon['alt'] ?>" />
                                </button>
                                <button class="glide__arrow glide__arrow--right mp-testimonials__items__arrow" data-glide-dir=">">
                                    <img src="<?php echo $right_icon['url'] ?>" alt="<?php echo $right_icon['alt'] ?>" />
                                </button>
                            </div>

                            <div class="glide__track" data-glide-el="track">
                                <ul class="glide__slides">
                                    <?php foreach ($selected_testimonials as $testimonial) : ?>
                                    <li class="glide__slide mp-testimonials__testimonial">
                                        <p class="mp-testimonials__testimonial__review mp-text mp-text--main">
                                            <?php echo get_the_content(null, null, $testimonial) ?>
                                        </p>

                                        <strong class="mp-testimonials__testimonial__reviewer">
                                            <?php echo get_field('reviewer', $testimonial)['name'] ?>
                                        </strong>
                                    </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Testimonials -->

            <!-- Awards -->
            <?php
            $label = get_field('awards_label');
            $header = get_field('awards_header');
            $cta = get_field('awards_cta');
            $left_icon = get_field('awards_left_arrow_icon');
            $right_icon = get_field('awards_right_arrow_icon');
            $awards_list = get_field('awards_list');
            ?>
            <section class="mp-awards">
                <div class="container mx-auto">
                    <p class="mp-awards__label mp-label mp-label--primary"><?php echo $label ?></p>

                    <div class="flex flex-col md:flex-row items-start">
                        <div class="w-full md:w-5/12 md:pr-12">
                            <div class="mp-awards__header mp-header mp-header--3">
                                <?php echo $header ?>
                            </div>

                            <a href="<?php echo $cta['url'] ?>" class="mp-button mp-button--primary mp-awards__desktop-cta">
                                <?php echo $cta['title'] ?>
                            </a>
                        </div>

                        <div class="mp-carousel mp-awards__carousel glide w-full md:w-7/12">
                            <div class="glide__arrows" data-glide-el="controls">
                                <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                                    <img src="<?php echo $left_icon['url'] ?>" alt="<?php echo $left_icon['alt'] ?>" />
                                </button>
                                <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                                    <img src="<?php echo $right_icon['url'] ?>" alt="<?php echo $right_icon['alt'] ?>" />
                                </button>
                            </div>

                            <div class="glide__track" data-glide-el="track">
                                <ul class="glide__slides">
                                    <?php foreach ($awards_list as $award) : ?>
                                        <li class="glide__slide mp-awards__award">
                                            <img src="<?php echo $award['image']['url'] ?>" alt="<?php echo $award['image']['alt'] ?>" class="mp-awards__award__image" />
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="block md:hidden pt-8 text-center">
                        <a href="<?php echo $cta['url'] ?>" class="mp-button mp-button--primary">
                            <?php echo $cta['title'] ?>
                        </a>
                    </div>
                </div>
            </section>
            <!-- End Awards -->

            <?php endwhile; // End of the loop.?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
