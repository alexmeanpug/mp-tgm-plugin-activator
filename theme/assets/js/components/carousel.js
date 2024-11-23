import { interactions } from '@meanpug-llc/wp-core';

const createCarousel = (selector, providerOpts) => {
  if ($(selector).length === 0) {
    console.debug(`selector ${selector} not found, not creating carousel`);
    return;
  }

  const carousel = new interactions.Carousel({
    selector,
    providerOpts
  });

  // you likely need this method of binding forward/backward instead of using data-glide-controls because of this
  // known issue: https://github.com/glidejs/glide/issues/417
  $(selector).on('click', '.inf-carousel-control--prev', () => carousel.provider.go('<'));
  $(selector).on('click', '.inf-carousel-control--next', () => carousel.provider.go('>'));

  carousel.init();
};

createCarousel('.mp-carousel', {
  perView: 1
});

/* SAMPLE MARKUP
<div class="mp-carousel glide">
  <div class="glide__track" data-glide-el="track">
    <ul class="glide__slides">
      <li class="glide__slide">0</li>
      <li class="glide__slide">1</li>
      <li class="glide__slide">2</li>
    </ul>
  </div>
</div>
 */
