import $ from 'jquery';
import { tracking } from '@meanpug-llc/wp-core';
const { FormTracking } = tracking;

// set up form tracking for every form on the page
$('form').each(function() {
    // don't apply tracking on GET forms, it blows up the query params
    if ($(this).attr('method') === 'get') {
        return;
    }

    const formTracking = new FormTracking($(this));
    formTracking.init();
});
