import $ from 'jquery';

$('.height-limiter').each(function() {
    $(this).find('.height-limiter__toggle').on('click', () => {
        $(this).toggleClass('unfurled');
    })
});
