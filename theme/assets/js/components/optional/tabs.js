import $ from 'jquery';

const WRAPPER_BUFFER = 30;

class Tabs {
    constructor($root) {
        this.$root = $root;
        this.activeTabTarget = this.getTabTarget(this.$root.find('.inf-tabs__tab.active'));
    }

    get $controls() {
        return this.$root.find('.inf-tabs__tab');
    }

    get $wrapper() {
        return this.$root.find('.inf-tabs__contents-wrapper');
    }

    get $contents() {
        return this.$root.find('.inf-tabs__body');
    }

    init() {
        this.setWrapperHeightForActiveTab();
        this.bindEvents();
    }

    setWrapperHeightForActiveTab() {
        const $contents = this.getContentsForTabTarget(this.activeTabTarget);
        this.$wrapper.height($contents.height() + WRAPPER_BUFFER);
    }

    bindEvents() {
        this.$controls.on('click', evt => this.activateTab($(evt.currentTarget)));
    }

    getTabTarget($tab) {
        return $tab.data('target');
    }

    getContentsForTabTarget(target) {
        return this.$root.find(`.inf-tabs__body#${target}`);
    }

    activateTab($clickedTab) {
        const tabTarget = this.getTabTarget($clickedTab);
        if (tabTarget === this.activeTabTarget) {
            return;
        }

        this.$controls.removeClass('active');
        $clickedTab.addClass('active');

        this.$contents.removeClass('active');
        const $contents = this.getContentsForTabTarget(tabTarget);
        $contents.addClass('active');

        this.activeTabTarget = tabTarget;

        this.setWrapperHeightForActiveTab();
    }
}

$('.inf-tabs').each(function() {
    const tabs = new Tabs($(this));
    tabs.init();
});

/* SAMPLE MARKUP
<div class="af-tabs">
    <nav class="flex justify-start md:justify-center whitespace-nowrap af-noscrollbars overflow-x-scroll md:overflow-x-visible px-8 md:px-0 py-4 md:py-0">
        <button class="af-tabs__tab mx-4 uppercase active" data-target="item-1">Item 1</button>
        <button class="af-tabs__tab mx-4 uppercase" data-target="item-2">Item 2</button>
        <button class="af-tabs__tab mx-4 uppercase" data-target="item-4">Item 3</button>
    </nav>

    <div class="lg:px-24 xl:px-56 pt-16">
        <div class="af-tabs__contents-wrapper">
            <div class="af-tabs__body active" id="item-1">
                <p>Item contents</p>
            </div>
            <div class="af-tabs__body" id="item-2">
                <p>Item contents</p>
            </div>
            <div class="af-tabs__body" id="item-3">
                <p>Item contents</p>
            </div>
        </div>
    </div>
</div>
 */
