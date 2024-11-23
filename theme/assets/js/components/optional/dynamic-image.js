import $ from 'jquery';

class DynamicImage {
    constructor($container) {
        this.$container = $container;
        this.selectedId = null;
    }

    init() {
        this.bindEvents();
        this.selectImage($(this.$triggers.get(0)));
    }

    get $img() {
        return this.$selectedContainer.find('img');
    }

    get $selectedContainer() {
        return this.$container.find('.inf-dynamic-image__selected');
    }

    get $triggers() {
        return this.$container.find('.inf-dynamic-image__trigger');
    }

    bindEvents() {
        this.$triggers.on('mouseover click', (evt) => this.selectImage($(evt.currentTarget)));
    }

    selectImage($trigger) {
        const selectedImage = $trigger.data('image');
        const selectedId = $trigger.data('id');

        if (this.selectedId === selectedId) {
            return;
        }

        this.$triggers.removeClass('active');
        $trigger.addClass('active');

        this.swapContainerImage(selectedImage);

        this.selectedId = selectedId;
    }

    swapContainerImage(newImageSrc, fullSwap = true) {
        if (!fullSwap && this.$img.length > 0) {
            const img = this.$img.get(0);
            img.src = newImageSrc;
            // make sure we restart the animation
            img.classList.remove('inf-dynamic-image__active');
            setTimeout(() => img.classList.add('inf-dynamic-image__active'), 1);
        } else {
            const img = document.createElement('img');
            img.src = newImageSrc;
            img.classList.add('inf-dynamic-image__active');

            this.$selectedContainer.html(img);
        }
    }
}

$('.ps-dynamic-image').each(function () {
    const dynamicImage = new DynamicImage($(this));
    dynamicImage.init();
});

export default DynamicImage;

/* SAMPLE MARKUP
<div class="inf-dynamic-image">
    <div class="pt-6 md:pt-12 flex">
        <div class="max-md:hidden inf-dynamic-image__selected w-1/4 h-[300px]"></div>

        <ul class="md:w-3/4 md:pl-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-4">
            <?php foreach ($children as $topic) : ?>
                <li class="inf-dynamic-image__trigger" data-image="<?php echo get_the_post_thumbnail_url($topic, 'large') ?>" data-id="<?php echo $topic->ID ?>">
                    <a href="<?php echo get_permalink($topic) ?>" class="text-green font-sans font-bold text-sm hover:underline">
                        <?php echo get_the_title($topic) ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
 */
