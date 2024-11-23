import $ from 'jquery';


class LinkScrollTo {
    constructor(interceptHref, buffer = 100) {
        this.interceptHref = interceptHref;
        this.buffer = buffer;
    }

    init() {
        const _this = this;
        $('a').on('click', function (evt) {
            if ($(this).attr('href') === _this.interceptHref) {
                evt.preventDefault();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $($(this).attr('href')).offset().top - _this.buffer
                }, 1000);
            }
        });
    }
}

export default LinkScrollTo;
