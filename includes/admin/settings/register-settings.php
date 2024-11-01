<?php
/**
 * Register settings
 *
 * @package     SimpleAttribution\Admin\Settings\Register
 * @since       2.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Setup the settings menu
 *
 * @since       1.0.0
 * @param       array $menu The default menu settings.
 * @return      array $menu Our defined settings
 */
function simple_attribution_add_menu( $menu ) {
	$menu['type']       = 'submenu';
	$menu['page_title'] = __( 'Simple Attribution Settings', 'simple-attribution' );
	$menu['menu_title'] = __( 'Simple Attribution', 'simple-attribution' );

	return $menu;
}
add_filter( 'simple_attribution_menu', 'simple_attribution_add_menu' );


/**
 * Define our settings tabs
 *
 * @since       1.0.0
 * @param       array $tabs The default tabs.
 * @return      array $tabs Our defined tabs
 */
function simple_attribution_settings_tabs( $tabs ) {
	$tabs['settings'] = __( 'Settings', 'simple-attribution' );
	$tabs['support']  = __( 'Support', 'simple-attribution' );

	return $tabs;
}
add_filter( 'simple_attribution_settings_tabs', 'simple_attribution_settings_tabs' );


/**
 * Define settings sections
 *
 * @since       1.0.0
 * @param       array $sections The default sections.
 * @return      array $sections Our defined sections
 */
function simple_attribution_registered_settings_sections( $sections ) {
	$sections = array(
		'settings' => apply_filters(
			'simple_attribution_settings_sections_settings',
			array(
				'main'       => __( 'General Settings', 'simple-attribution' ),
				'appearance' => __( 'Appearance', 'simple-attribution' ),
			)
		),
		'support'  => apply_filters(
			'simple_attribution_settings_sections_support',
			array()
		),
	);

	return $sections;
}
add_filter( 'simple_attribution_registered_settings_sections', 'simple_attribution_registered_settings_sections' );


/**
 * Disable save button on unsavable tabs
 *
 * @since       1.0.0
 * @return      array $tabs The updated tabs
 */
function simple_attribution_define_unsavable_tabs() {
	$tabs = array( 'support' );

	return $tabs;
}
add_filter( 'simple_attribution_unsavable_tabs', 'simple_attribution_define_unsavable_tabs' );


/**
 * Define our settings
 *
 * @since       1.0.0
 * @param       array $settings The default settings.
 * @return      array $settings Our defined settings
 */
function simple_attribution_registered_settings( $settings ) {
	$new_settings = array(
		// General Settings.
		'settings' => apply_filters(
			'simple_attribution_settings_settings',
			array(
				'main'       => array(
					array(
						'id'   => 'settings_header',
						'name' => __( 'General Settings', 'simple-attribution' ),
						'desc' => '',
						'type' => 'header',
					),
					array(
						'id'       => 'post_types',
						'name'     => __( 'Post Types', 'simple-attribution' ),
						'desc'     => __( 'Select which post types should support attributions.', 'simple-attribution' ),
						'type'     => 'select',
						'multiple' => true,
						'select2'  => true,
						'std'      => array( 'post' ),
						'options'  => simple_attribution_get_post_types(),
					),
					array(
						'id'            => 'disable',
						'name'          => __( 'Disable Auto Attribution', 'simple-attribution' ),
						'desc'          => __( 'Disables automatic output of attribution.', 'simple-attribution' ),
						'tooltip_title' => __( 'Disable Auto Attribution', 'simple-attribution' ),
						'tooltip_desc'  => __( 'Disabling the automatic output of attribution can be useful if you would prefer to add attribution to a specific place in your template.', 'simple-attribution' ),
						'type'          => 'checkbox',
					),
				),
				'appearance' => array(
					array(
						'id'   => 'appearance_header',
						'name' => __( 'Appearance Settings', 'simple-attribution' ),
						'desc' => '',
						'type' => 'header',
					),
					array(
						'id'      => 'caption_type',
						'name'    => __( 'Caption Type', 'simple-attribution' ),
						'desc'    => __( 'Select which type of captions to use for attributions.', 'simple-attribution' ),
						'type'    => 'select',
						'std'     => 'text',
						'options' => array(
							'text'  => __( 'Text', 'simple-attribution' ),
							'icon'  => __( 'Icon', 'simple-attribution' ),
							'image' => __( 'Image', 'simple-attribution' ),
						),
					),
					array(
						'id'   => 'caption',
						'name' => __( 'Caption', 'simple-attribution' ),
						'desc' => __( 'Enter the caption to use for attributions.', 'simple-attribution' ),
						'type' => 'text',
						'std'  => __( 'Attribution:', 'simple-attribution' ),
					),
					array(
						'id'      => 'icon',
						'name'    => __( 'Icon', 'simple-attribution' ),
						'desc'    => __( 'Select an icon to display for attributions.', 'simple-attribution' ),
						'type'    => 'select',
						'options' => simple_attribution_get_fonts(),
					),
					array(
						'id'      => 'image',
						'name'    => __( 'Image', 'simple-attribution' ),
						'desc'    => __( 'Select which image to display for attributions.', 'simple-attribution' ),
						'type'    => 'select',
						'std'     => 'clip',
						'options' => array(
							'clip'      => __( 'Clip', 'simple-attribution' ),
							'clipboard' => __( 'Clipboard', 'simple-attribution' ),
							'globe-1'   => __( 'Globe 1', 'simple-attribution' ),
							'globe-2'   => __( 'Globe 2', 'simple-attribution' ),
							'quote'     => __( 'Quote', 'simple-attribution' ),
							'custom'    => __( 'Custom', 'simple-attribution' ),
						),
					),
					array(
						'id'   => 'url',
						'name' => __( 'URL', 'simple-attribution' ),
						'desc' => __( 'Enter the URL to the icon you want to display.', 'simple-attribution' ),
						'type' => 'text',
					),
					array(
						'id'   => 'height',
						'name' => __( 'Size', 'simple-attribution' ),
						'desc' => __( 'Specify the height in pixels to use for the image.', 'simple-attribution' ),
						'type' => 'number',
						'size' => 'small',
						'std'  => 24,
						'min'  => 0,
						'step' => 1,
					),
				),
			)
		),
		'support'  => apply_filters(
			'simple_attribution_settings_support',
			array(
				array(
					'id'   => 'support_header',
					'name' => __( 'Simple Attribution Support', 'simple-attribution' ),
					'desc' => '',
					'type' => 'header',
				),
				array(
					'id'   => 'system_info',
					'name' => __( 'System Info', 'simple-attribution' ),
					'desc' => '',
					'type' => 'sysinfo',
				),
			)
		),
	);

	return array_merge( $settings, $new_settings );
}
add_filter( 'simple_attribution_registered_settings', 'simple_attribution_registered_settings' );
