<?php
/**
 * Filters
 *
 * @package     SimpleAttribution\Filters
 * @since       2.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter content
 *
 * @access      public
 * @since       2.0.0
 * @param       string $content The current content.
 * @return      string $content The updated content
 */
function simple_attribution_filter_content( $content ) {
	global $post;

	if ( ! simple_attribution()->settings->get_option( 'disable', false ) ) {
		$allowed_post_types = simple_attribution()->settings->get_option( 'post_types', array( 'post' ) );

		if ( ( is_single() || is_page() ) && in_array( $post->post_type, $allowed_post_types, true ) ) {
			$attribution = simple_attribution_build();

			$attribution = apply_filters( 'simple_attribution_' . $post->post_type, $attribution );
			$attribution = apply_filters( 'simple_attribution_' . $post->ID, $attribution );

			$content .= $attribution;
		}
	}

	return $content;
}
add_filter( 'the_content', 'simple_attribution_filter_content' );
