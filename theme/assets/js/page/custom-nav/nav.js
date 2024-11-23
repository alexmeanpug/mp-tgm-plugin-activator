// import from main
import { interactions } from '@meanpug-llc/wp-core';
import DesktopNav from './desktop-nav';
import $ from 'jquery';

let nav = null;
if ($(window).width() < 1280) {
    $('.inf-menu-trigger').on('click', () => {
        $('.inf-stacked-nav').toggleClass('active');
        $('.inf-menu-trigger').toggleClass('active');
    });

    nav = new interactions.StackNav($('.inf-stacked-nav'), {
        stackContainerSelector: '.menu-nav-container'
    });
} else {
    nav = new DesktopNav($('.inf-menu--nav'));
}

nav.init();

/* SAMPLE MARKUP
<div class="ep-site-header__menu ep-stacked-nav">
    <?php wp_nav_menu( array(
        'menu' => 'Primary',
        'menu_class' => "header-menu", // (string) CSS class to use for the ul element which forms the menu. Default 'menu'.
    ) ); ?>
</div>
 */
