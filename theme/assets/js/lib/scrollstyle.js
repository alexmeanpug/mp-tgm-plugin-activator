import { interactions } from '@meanpug-llc/wp-core';

const scrollstyler = new interactions.Scrollstyler({ selector: '[data-inviewport]', activeClass: 'is-inviewport' });
scrollstyler.init();

/* SAMPLE MARKUP
<div class="outer-element">
  <h2 data-inviewport="opacity-100">This will fadein</h2>
</div>
 */
