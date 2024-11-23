import $ from 'jquery';

function deselectAllTabs() {
    $('.mp-tab').removeClass('active');
    $('.mp-tab__content').removeClass('active');
}

function setParentContainerHeight($container) {
    let height = 0;
    $container.find('.mp-tab__content').each(function() {
        height = Math.max(height, $(this).outerHeight());
    });

    $container.find('.mp-tabs__contents').height(height);
}

function selectTab(tab) {
    // if the tab is already active, do nothing
    if ($(tab).hasClass('active')) {
        return;
    }

    deselectAllTabs();
    $(tab).addClass('active');

    const $targetContents = $($(tab).data('tabTarget'));
    $targetContents.addClass('active');
}

const $tabElements = $('.mp-tabs');
$tabElements.each(function () {
    const $tabs = $(this).find('.mp-tab');
    $tabs.on('click', function () { selectTab(this); });
    setParentContainerHeight($(this));
});
