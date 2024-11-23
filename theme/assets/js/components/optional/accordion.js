import $ from 'jquery';

class Accordion {
    constructor($root) {
        this.$root = $root;
        this.isOpen = $root.hasClass('open');
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        this.$root.on('click', '.inf-accordion__trigger', this.toggleOpen.bind(this));
    }

    toggleOpen() {
        this.isOpen ? this.$root.removeClass('open') : this.$root.addClass('open');
        this.isOpen = !this.isOpen;
    }
}

$('.inf-accordion').each(function() {
    const accordion = new Accordion($(this));
    accordion.init();
});

/* SAMPLE MARKUP
<div class="af-accordion group">
  <div class="flex items-center justify-between af-accordion__trigger">
    <p>FAQ Header</p>

    <div>
      <hr class="w-8 border-t border-blue" />
      <hr class="w-8 transform-rotate duration-300 rotate-90 group-[.open]:rotate-0 border-t border-blue" />
    </div>
  </div>

  <div class="af-accordion__body">
    <div class="pt-12">
      <p>Inner Accordion Content</p>
    </div>
  </div>
</div>
 */
