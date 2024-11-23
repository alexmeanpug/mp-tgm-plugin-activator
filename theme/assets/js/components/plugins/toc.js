import $ from 'jquery';


$('.ez-toc-link').on('click', evt => {
    evt.preventDefault();
    let $target = $($(evt.currentTarget).attr('href'));
    $("html, body").animate({ scrollTop: $target.offset().top - 120 });
});
