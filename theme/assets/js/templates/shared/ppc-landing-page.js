import $ from 'jquery';
import { Scrollstyler, Marquee, Carousel } from '@meanpug-llc/wp-core/src/interactions';
import LinkScrollTo from '../interactions/linkScrollTo';

const scrollstyler = new Scrollstyler({ selector: '[data-inviewport]', activeClass: 'is-inviewport' });
scrollstyler.init();

const marquee = new Marquee($('.mp-call-marquee__marquee'), {
    breakpoints: {
        xl: 1024
    },
    speed: 15
});
marquee.init();

const testimonialsCarousel = new Carousel({ selector: '.mp-testimonials__carousel', providerOpts: {} });
testimonialsCarousel.init();

const awardsCarousel = new Carousel({
    selector: '.mp-awards__carousel',
    providerOpts: {
        perView: 3,
        breakpoints: {
            480: {
                perView: 2
            }
        }
    }
});
awardsCarousel.init();

const linkScrollTo = new LinkScrollTo('#lpForm');
linkScrollTo.init();

$('.mp-banner__close').on('click', () => {
    $('.mp-banner').addClass('closed');
});
