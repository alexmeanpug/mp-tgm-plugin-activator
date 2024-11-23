import $ from 'jquery';

class LocationNavigatorWidget {
    constructor(args = {}) {
        const defaults = {
            $el: null
        };
        const opts = { ...defaults, ...args};

        this.$el = opts.$el;
        this.$resultsContainer = this.$el.find('.mp-location-navigator-widget__results');
        this.loadingSpinner = this.$resultsContainer.data('loader');
        this.q = null;
        this.userLocation = null;

        this.bindSearchInput();
        this.bindShareLocationClick();
    }

    bindSearchInput() {
        this.$el.find('input').on('keyup', evt => {
            this.q = $(evt.currentTarget).val();
            this.userLocation = null;
            this.executeSearch();
        });
    }

    bindShareLocationClick() {
        this.$el.find('.mp-location-navigator-widget__link--use-location').on('click', this.requestUserLocation.bind(this));
    }

    executeSearch() {
        this.$resultsContainer.html(`<img src="${this.loadingSpinner}" class="w-16 mx-auto" />`);

        $.ajax({
            url: theme.ajax_url,
            data: {
                q: this.q,
                post_type: null,
                user_loc: this.userLocation,
                action: 'mp_location_navigator_search'
            },
            type: 'POST',
            beforeSend: () => {
                this.$el.addClass('ajax-loading');
            },
            success: (data) => {
                if (data) {
                    this.$resultsContainer.html(data);
                }
            }
        });

        // do not submit the form
        return false;
    }

    requestUserLocation() {
        this.$resultsContainer.html(`<img src="${this.loadingSpinner}" class="w-16 mx-auto" />`);

        const options = {
            timeout: 5000,
            maximumAge: 0
        };

        navigator.geolocation.getCurrentPosition(
            pos => this.retrieveLinksForLocation(pos.coords),
            err => console.warn(`ERROR(${err.code}): ${err.message}`),
            options
        );
    }

    retrieveLinksForLocation(loc) {
        this.userLocation = { latitude: loc.latitude, longitude: loc.longitude };
        this.executeSearch();
    }
}

const $el = $('.mp-location-navigator-widget');
if ($el.length > 0) {
    new LocationNavigatorWidget({ $el })
}
