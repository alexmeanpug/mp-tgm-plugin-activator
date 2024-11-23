import { interactions } from '@meanpug-llc/wp-core';
import { screenSizes } from '../lib/devices';

const marquee = new interactions.Marquee($('.mp-marquee'), {
  speed: 15,
  breakpoints: {
    xl: screenSizes.xl
  }
});
marquee.init();

/* SAMPLE MARKUP
<div class="mp-marquee" data-per-page="2" data-per-page-xl="3">
  <ul class="mp-marquee__content">
    <li class="mp-marquee__item">Item 1</li>
    <li class="mp-marquee__item">Item 2</li>
    <li class="mp-marquee__item">Item 3</li>
  </ul>
</div>
 */
