import $ from 'jquery';
import { screenSizes } from '../lib/devices';

const $affixElements = $('.inf-affix');
const windowHeight = $(window).height();
const windowWidth = $(window).width();
const affixMinWidth = screenSizes.md;

class Affix {
    constructor($element, $container, opts = {}) {
        this.$element = $element;
        this.$container = $container;

        this.affixPosition = opts.affixPosition || 'top';
        this.affixBuffer = opts.affixBuffer || 20;

        this.originalYOffset = null;
    }

    init() {
        this.originalYOffset = this.$element.offset().top;
        this.affixContainerTopOffset = this.$container ? this.$container.offset().top : Infinity;
        this.affixContainerBottomOffset = this.$container ? this.affixContainerTopOffset + this.$container.height() : Infinity;
    }

    handleScroll() {
        const currentScrollTop = $(window).scrollTop();
        this.maybeAffix(currentScrollTop);
    }

    maybeAffix(currentScrollTop) {
        const isTopAffix = this.affixPosition === 'top';
        const bottomViewportOffset = currentScrollTop + windowHeight;

        // we are either at the appropriate offset to start affixing, have scrolled up to an elements original position and
        // should remove the affix, or have scrolled down past the affix container where we should place the elements in a
        // resting position
        const shouldEndAffix = !this.$element.data('affixEnd') && (bottomViewportOffset > this.affixContainerBottomOffset);
        const shouldAffix = !this.$element.data('affixOn') && bottomViewportOffset <= this.affixContainerBottomOffset && (
            isTopAffix
                ? (bottomViewportOffset - this.originalYOffset - this.affixBuffer) >= windowHeight
                : bottomViewportOffset >= this.originalYOffset + this.affixBuffer
        );
        const shouldRemoveAffix = this.$element.data('affixOn') && (
            isTopAffix
                ? (bottomViewportOffset - this.originalYOffset - this.affixBuffer) < windowHeight
                : bottomViewportOffset < this.originalYOffset + this.affixBuffer
        );

        const isReattachingAffix = this.$element.data('affixEnd') && shouldAffix;

        // if we are coming at the element from the bottom (i.e. the affix was ended), we use the elements' absolute positioning
        // to determine where its affixed positioning should be. Coming from the top, we use its original offset as the baseline
        let affixOffset = isTopAffix ? this.originalYOffset - currentScrollTop : bottomViewportOffset - this.originalYOffset - this.$element.height();
        if (isReattachingAffix) {
            affixOffset = isTopAffix ? this.$element.offset().top - currentScrollTop : bottomViewportOffset - this.$element.offset().top - this.$element.height();
        }

        if (shouldAffix) {
            console.log(`preparing to affix element to ${this.affixPosition}`);
            this.toggleAffix(affixOffset, true);
        } else if (shouldRemoveAffix) {
            console.log(`preparing to remove affix from ${this.affixPosition}`);
            this.toggleAffix(affixOffset, false);
        } else if (shouldEndAffix) {
            console.log('preparing to end affixing for element');
            this.endAffix();
        }
    }

    toggleAffix(affixOffset, toggleOn) {
        if (toggleOn) {
            if (this.$element.data('affixEnd')) {
                this.$element.removeClass('affixed--end');
                this.$element.removeData('affixEnd');
                this.$element.css({ top: '' });
            }

            this.$element.data('affixOn', true);
            this.$element.addClass('affixed');
            this.$element.css({ [this.affixPosition]: `${affixOffset}px` });
        } else {
            this.$element.removeData('affixOn');
            this.$element.removeClass('affixed');
            this.$element.css({ [this.affixPosition]: '0px' });
        }
    }

    endAffix() {
        const elementDistanceFromTop = this.affixContainerTopOffset !== Infinity ? this.$element.offset().top - this.affixContainerTopOffset : this.$element.offset().top;

        this.$element.addClass('affixed--end');
        this.$element.css({ top: `${elementDistanceFromTop}px` });

        this.$element.removeData('affixOn');
        this.$element.data('affixEnd', true);
    }
}

// avoid expensive calculations if possible
if ($affixElements.length > 0 && (!affixMinWidth || windowWidth >= affixMinWidth)) {
    const affixes = [];
    $affixElements.each(function () {
        const $container = $(this).closest('.ps-affix-container');

        const affix = new Affix($(this), $container.length > 0 ? $container : null, {
            affixPosition: $(this).data('affixPosition'),
            affixBuffer: $(this).data('affixBuffer') || 20
        });
        affix.init();

        affixes.push(affix);
    });

    $(window).scroll(function () {
        affixes.forEach(affix => affix.handleScroll());
    });
}


/* Sample Markup
<div class="md:w-1/2 border-r-2 border-green max-md:order-2">
    <div class="mx-auto relative h-full inf-affix-container px-4 lg:px-0" data-affix-max-width="768">
        <div class="md:h-[400pxs]">
            <p class="text-2xl font-serif font-normal leading-relaxed text-green-black pt-4 md:pt-32 lg:pt-48 inf-affix" data-affix-position="top" data-affix-buffer="20"><?php the_field('left_text') ?></p>
        </div>

        <div class="text-center pt-8 md:pt-96">
            <div class="inf-affix inf-block-progression-list__button" data-affix-position="bottom" data-affix-buffer="200">
                <a href="<?php echo get_field('left_cta_top')['url'] ?>">
                    <span><?php echo get_field('left_cta_top')['title'] ?></span>
                </a>
            </div>
        </div>
    </div>
</div>
 */
