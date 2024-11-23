<?php
$children = get_children(array(
    'post_type' => 'practice-area',
    'post_parent' => get_the_ID(),
    'posts_per_page' => -1
));
if ($children && sizeof($children) > 0) :
?>
<div class="bg-gray py-6 my-4">
    <nav class="container inf-accordion group">
        <div class="flex items-center justify-between inf-accordion__trigger">
            <h2 class="text-2xl md:text-5xl text-green leading-tight pr-4"><?php printf('%s Topics', get_the_title()) ?></h2>
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icons/ic-caret-down-green.svg' ?>" alt="<?php _e('Down Caret Icon', 'ps') ?>" class="w-6 md:w-8 transform-rotate duration-300 group-[.open]:rotate-180"/>
        </div>

        <div class="inf-accordion__body inf-dynamic-image">
            <div class="pt-6 md:pt-12 flex">
                <div class="max-md:hidden inf-dynamic-image__selected w-1/4 h-[300px]"></div>

                <ul class="md:w-3/4 md:pl-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-4">
                    <?php foreach ($children as $topic) : ?>
                        <li class="ps-dynamic-image__trigger" data-image="<?php echo get_the_post_thumbnail_url($topic, 'large') ?>" data-id="<?php echo $topic->ID ?>">
                            <a href="<?php echo get_permalink($topic) ?>" class="text-green font-sans font-bold text-sm hover:underline">
                                <?php echo get_the_title($topic) ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </nav>
</div>
<?php endif; ?>
