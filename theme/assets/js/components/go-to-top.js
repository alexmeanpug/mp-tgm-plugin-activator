import $ from 'jquery';

$('.inf-go-to-top').on('click', evt => {
    $('html,body').animate({
        scrollTop: 0
    }, 1000);
});
