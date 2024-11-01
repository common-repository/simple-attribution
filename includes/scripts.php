<?php
/**
 * Scripts
 *
 * @package     SimpleAttribution\Scripts
 * @since       2.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Load admin scripts
 *
 * @since       2.0.0
 * @return      void
 */
function simple_attribution_scripts() {
	$css_dir = SIMPLE_ATTRIBUTION_URL . 'assets/css/';

	// Use minified libraries if SCRIPT_DEBUG is turned off.
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_register_style( 'simple-attribution', $css_dir . 'simple-attribution' . $suffix . '.css', array(), SIMPLE_ATTRIBUTION_VER );
	wp_enqueue_style( 'simple-attribution' );

	if ( simple_attribution()->settings->get_option( 'caption_type', 'text' ) === 'icon' ) {
		wp_enqueue_script( 'simple-attribution-fa', 'https://use.fontawesome.com/bb26903156.js', array(), '4.7.0', true );
	}
}
add_action( 'wp_enqueue_scripts', 'simple_attribution_scripts' );


/**
 * Load admin scripts
 *
 * @since       2.0.0
 * @return      void
 */
function simple_attribution_admin_scripts() {
	$screen = get_current_screen();

		// Only load scripts on our settings page.
	if ( 'settings_page_simple_attribution-settings' !== $screen->id ) {
		return;
	}

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_register_style( 'simple-attribution', SIMPLE_ATTRIBUTION_URL . 'assets/css/admin' . $suffix . '.css', array(), SIMPLE_ATTRIBUTION_VER );
	wp_enqueue_style( 'simple-attribution' );

	wp_enqueue_script( 'simple-attribution-fa', 'https://use.fontawesome.com/bb26903156.js', array(), '4.7.0', true );

	wp_register_script( 'simple-attribution', SIMPLE_ATTRIBUTION_URL . 'assets/js/admin' . $suffix . '.js', array( 'jquery' ), SIMPLE_ATTRIBUTION_VER, true );
	wp_enqueue_script( 'simple-attribution' );

	wp_localize_script(
		'simple-attribution',
		'simple_attribution_vars',
		array(
			'imageBaseUrl' => SIMPLE_ATTRIBUTION_URL . 'assets/images/',
		)
	);
}
add_action( 'admin_enqueue_scripts', 'simple_attribution_admin_scripts' );
