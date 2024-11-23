import $ from 'jquery';
import AjaxLoad from './ajax-load';
import debounce from './debounce';

const ajaxLoader = new AjaxLoad();

class AjaxFilters {
    constructor($root, action) {
        this.$root = $root;
        this.filterValues = {};
        this.loader = () => ajaxLoader.load(action, this.filterValues);
    }

    init() {
        this.bindEvents();
    }

    get $controls() {
        return this.$root.find('.inf-filters__control');
    }

    get $resultsContainer() {
        return this.$root.find('.inf-filters__results');
    }

    get $defaultResults() {
        return this.$root.find('.inf-filters__defaults');
    }

    get isAnyFiltersApplied() {
        return Object.entries(this.filterValues).some(([k, v]) => v && v !== 'all');
    }

    /**
     * manually add a filter and optionally immediately apply it
     * @param filterName
     * @param filterValue
     * @param apply whether to immediately invoke
     */
    setFilter(filterName, filterValue, apply = true) {
        this.addFilterValue(filterName, filterValue);
        if (apply) {
            this.applyFilters();
        }
    }

    getFilterValue(filterName) {
        return this.filterValues[filterName];
    }

    bindEvents() {
        this.$controls.on('change keyup', debounce((evt) => {
            const $field = $(evt.currentTarget);
            this.addFilterValue($field.attr('name'), $field.val());
            this.applyFilters();
        }, 200));

        // block enter button, it just causes problems and we don't use it in filters
        this.$root.on('keydown', (evt) => {
            const code = (evt.keyCode ? evt.keyCode : evt.which);
            if (code === 13) {
                evt.preventDefault();
                evt.stopPropagation();
                return false;
            }
        });
    }

    addFilterValue(filterName, filterVal) {
        this.filterValues[filterName] = filterVal;
    }

    applyFilters() {
        if (this.isAnyFiltersApplied) {
            this.loader()
                .then((data) => {
                    this.$resultsContainer.html(data);
                    this.$resultsContainer.addClass('active');
                    this.$defaultResults.addClass('hidden');
                });
        } else {
            this.$resultsContainer.html('');
            this.$resultsContainer.removeClass('active');
            this.$defaultResults.removeClass('hidden');
        }
    }
}

export default AjaxFilters;
