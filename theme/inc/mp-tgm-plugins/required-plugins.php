<?php

/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme MeanPug
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once __DIR__ . '/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'mp_register_required_plugins');

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function mp_register_required_plugins()
{
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// Gravity Forms
		array(
			'name'               => 'Gravity Forms',
			'slug'               => 'gravityforms',
			'source'             => 'https://raw.githubusercontent.com/alexmeanpug/plugins/main/gravityforms_2.8.0.zip',
			'required'           => false,
		),

		// Advanced Custom Fields PRO
		array(
			'name'               => 'Advanced Custom Fields PRO',
			'slug'               => 'advanced-custom-fields-pro',
			'source'             => 'https://raw.githubusercontent.com/alexmeanpug/plugins/main/advanced-custom-fields-pro.zip',
			'required'           => true,
		),

		// Easy Table of Contents
		array(
			'name'               => 'Easy Table of Contents',
			'slug'               => 'easy-table-of-contents',
			'required'           => false,
		),

		// Max Mega Menu
		array(
			'name'               => 'Max Mega Menu',
			'slug'               => 'megamenu',
			'required'           => false,
		),

		// Max Mega Menu Pro Addon
		array(
			'name'               => 'Max Mega Menu Pro Addon',
			'slug'               => 'megamenu-pro',
			'source'             => 'https://raw.githubusercontent.com/alexmeanpug/plugins/main/megamenu-pro-2.4.zip',
			'required'           => false,
		),

		// Classic Widgets
		array(
			'name'               => 'Classic Widgets',
			'slug'               => 'classic-widgets',
			'required'           => false,
		),

		// This is an example of the use of 'is_callable' functionality. A user could - for instance -
		// have WPSEO installed *or* WPSEO Premium. The slug would in that last case be different, i.e.
		// 'wordpress-seo-premium'.
		// By setting 'is_callable' to either a function from that plugin or a class method
		// `array( 'class', 'method' )` similar to how you hook in to actions and filters, TGMPA can still
		// recognize the plugin as being installed.
		array(
			'name'        => 'Yoast SEO',
			'slug'        => 'wordpress-seo',
			'is_callable' => 'wpseo_init',
			'required'    => false,
		),

		// Yoast Duplicate Post
		array(
			'name'               => 'Yoast Duplicate Post',
			'slug'               => 'duplicate-post',
			'required'           => false,
		),

		// WP Migrate DB Pro
		array(
			'name'               => 'WP Migrate DB Pro',
			'slug'               => 'wp-migrate-db-pro',
			'source'             => 'https://raw.githubusercontent.com/alexmeanpug/plugins/main/wp-migrate-db-pro-2.3.4.zip',
			'required'           => false,
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'mp',                    // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa($plugins, $config);
}
