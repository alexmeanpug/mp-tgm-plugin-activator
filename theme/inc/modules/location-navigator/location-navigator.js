const $ = window.jQuery;
const { interactions } = window.MeanPug;

class StateCityLocationNavigator {
    constructor($root, options={}) {
        this.$root = $root;
        this.activeFilter = null;
    }

    get $cities() {
        return this.$root.find('.mp-location-navigator--state-city__list--cities li');
    }

    get $filters() {
        return this.$root.find('.mp-location-navigator--state-city__filter a');
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        this.$filters.on('click', evt => {
            const $filter = $(evt.currentTarget);
            const filterHref = $filter.attr('href').replace('#', '');

            if (filterHref === this.activeFilter) {
                return;
            }

            this.$filters.removeClass('active');
            $filter.addClass('active');

            this.filterCitiesForLetter(filterHref === 'all-cities' ? null : filterHref.replace('-cities', ''));

            this.activeFilter = filterHref;
        })
    }

    filterCitiesForLetter(letter) {
        console.log(`filtering cities for letter ${letter}`);

        // if the letter is null, show all cities
        if (letter === null) {
            this.$cities.addClass('active');
        } else {
            this.$cities.each(function() {
                if ($(this).data('letter') === letter) {
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }
            });
        }
    }
}

class DefaultLocationNavigator {
    constructor($root, officeCarouselSelector = '#mp-location-navigator-office-carousel') {
        this.$root = $root;
        this.officeCarouselSelector = officeCarouselSelector;
    }

    init() {
        this.createOfficeCarousel();
    }

    createOfficeCarousel() {
        if (this.$root.find(this.officeCarouselSelector).length === 0) {
            console.warn('no office carousel selector found in loc navigator so not creating a carousel');
            return;
        }

        const carousel = new interactions.Carousel({
            selector: this.officeCarouselSelector,
            providerOpts: {
                type: 'slider',
                perView: 3,
                breakpoints: {
                    1023: {
                        perView: 2
                    }
                }
            }
        });
        carousel.init();

        this.$root.find('.mp-carousel-btn--prev').on('click', () => carousel.provider.go('<'));
        this.$root.find('.mp-carousel-btn--next').on('click', () => carousel.provider.go('>'));
    }
}

/** Default Init **/
$('.mp-location-navigator--state-city').each(function() {
    const navigator = new StateCityLocationNavigator($(this));
    navigator.init();
});

$('.mp-location-navigator-module--default-layout').each(function() {
    const navigator = new DefaultLocationNavigator($(this));
    navigator.init();
});
