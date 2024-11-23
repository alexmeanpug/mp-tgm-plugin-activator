<?php

function inf_register_menus() {
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'nav' => esc_html__( 'Nav', 'inf' ),
      'mobile-nav' => esc_html__( 'Mobile Nav', 'inf' ),
			'footer' => esc_html__( 'Footer', 'inf' )
		) );
}
add_action( 'after_setup_theme', 'inf_register_menus' );
