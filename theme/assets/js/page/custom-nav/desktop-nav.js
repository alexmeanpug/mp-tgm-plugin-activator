import $ from 'jquery';

class DesktopNav {
    constructor($menu) {
        this.$menu = $menu;
        this.$activeMenuItem = null;
        this.selectedImageSrc = null;
        this.selectedImageHasBeenAdded = false;
    }

    get $container() {
        return this.$menu.parent();
    }

    get $selectedImage() {
        return this.$container.find('.inf-menu__selected-image');
    }

    init() {
        this.bindEvents();
        this.createImageContainer();
    }

    createImageContainer() {
        const imageContainerHtml = `<div class="inf-menu__selected-image"></div>`
        this.$container.append(imageContainerHtml);
    }

    bindEvents() {
      // set a timeout on load before our bindings are set in order to avoid the scenario where the page initializes with the menu open
      setTimeout(() => {
        this.$menu.on('mouseenter', '.menu-item', evt => this.showMenuItemImage($(evt.currentTarget)));
        this.$menu.on('mouseover', '.menu-item-has-children', evt => this.activateMenuItem($(evt.currentTarget)));
        this.$menu.on('mouseout', '> .menu-item-has-children .menu-item-has-children', evt => this.deactivateMenuItem(this.$activeMenuItem));
        this.$menu.on('mouseout', '> .menu-item-has-children', evt => this.deactivateMenuItemDelayed($(evt.currentTarget)));
      }, 500);
    }

    deactivateAllMenuItems() {
        this.$menu.find('.menu-item.active').removeClass('active');
    }

    deactivateSiblingMenuItems($menuItem) {
        $menuItem.closest('.sub-menu').find('> .menu-item.active').removeClass('active');
    }

    deactivateChildMenuItems($menuItem) {
        $menuItem.find('.menu-item.active').removeClass('active');
    }

    deactivateMenuItem($menuItem) {
        $menuItem.removeClass('active');
        this.deactivateChildMenuItems($menuItem);

        this.$activeMenuItem = null;
    }

    deactivateMenuItemDelayed($menuItem) {
        // this has to happen instantly to properly accomodate switching between menus (as opposed to a straight toggle-off)
        this.hideMenuItemImage();
        setTimeout(() => {
            if (!$menuItem.is(':hover')) {
                this.deactivateMenuItem($menuItem);
            }
        }, 400);
    }

    activateMenuItem($menuItem) {
        if ($menuItem === this.$activeMenuItem || $menuItem.hasClass('active')) {
            return;
        }

        this.deactivateSiblingMenuItems($menuItem);
        $menuItem.addClass('active');

        this.$activeMenuItem = $menuItem;
    }

    showMenuItemImage($menuItem) {
        const image = $menuItem.find('a').data('image');

        if (!image && !this.selectedImageSrc) {
            $menuItem.find('.menu-item');
            // find a nested menu item that has a hover image to use for display
            const $nestedItemLinks = $menuItem.find('.menu-item a');
            const _this = this;
            $nestedItemLinks.each(function () {
                if ($(this).data('image')) {
                    _this.renderSelectedImage($(this).data('image'));
                    return false;
                }
            })
        } else if (image && image !== this.selectedImageSrc) {
            this.renderSelectedImage(image);
        }
    }

    renderSelectedImage(image) {
        if (this.selectedImageHasBeenAdded) {
            this.$selectedImage.find('img').attr('src', image);
        } else {
            this.$selectedImage.html(`<img src="${image}" class="w-full" />`)
        }

        this.$selectedImage.addClass('active');
        this.selectedImageSrc = image;
        this.selectedImageHasBeenAdded = true;
    }

    hideMenuItemImage() {
        this.$selectedImage.removeClass('active');
        this.selectedImageSrc = null;
    }
}

export default DesktopNav;
