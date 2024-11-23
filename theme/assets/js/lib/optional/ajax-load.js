import $ from 'jquery';

class AjaxLoad {
    constructor(url = null) {
        this.url = url || theme.ajax_url;
    }

    load(action, args = {}) {
        const data = { action, ...args };

        return $.ajax({
            url: this.url,
            data,
            type: 'POST',
            beforeSend: (xhr) => {
                $('body').addClass('ajax-loading');
            },
            success: (data) => {
                $('body').removeClass('ajax-loading');
            }
        });
    }
}

export default AjaxLoad;
