<?php $author_team_profile = $args['profile'] ?: get_field('team_profile', 'user_' . get_the_author_meta("ID")); ?>
<div class="my-8 md:my-16">
    <div class="bg-red py-8 text-white pl-4 md:pl-8">
        <strong class="text-2xl uppercase font-normal tracking-wider font-serif"><?php _e('About the Author', 'pr') ?></strong>
    </div>

    <div class="flex max-md:flex-col md:pt-8 items-start md:pl-8">
        <div class="md:w-2/3 pr-12 max-md:pt-4">
            <address class="text-4xl md:text-7xl text-black">
                <a class="not-italic font-serif capitalize" rel="author" href="<?php echo get_permalink($author_team_profile) ?>"><?php the_author_meta('display_name') ?></a>
            </address>
            <p class="text-red uppercase tracking-wide font-light font-sans text-base md:text-xl"><?php echo get_field('role', $author_team_profile) ?></p>

            <p class="py-4 md:py-8 text-black leading-relaxed text-base">
                <?php the_author_meta('user_description') ?>
            </p>

            <div class="flex flex-col xl:flex-row xl:items-center text-red text-base">
                <a href="mailto:<?php echo get_field('email', $author_team_profile) ?>" class="xl:border-r border-red pr-4 mr-4 underline">
                    <?php the_field('email', $author_team_profile) ?>
                </a>

                <a href="<?php echo get_field('phone', $author_team_profile)['url'] ?>" class="underline">
                    <?php echo get_field('phone', $author_team_profile)['title'] ?>
                </a>
            </div>
        </div>

        <img src="<?php echo get_the_post_thumbnail_url($author_team_profile) ?>" alt="<?php printf('%s Author Headshot', get_the_author_meta('display_name')) ?>" class="w-full md:w-1/3 order-first md:order-last" />
    </div>
</div>
