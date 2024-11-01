<?php
/**
 * Meta box
 *
 * @package     SimpleAttribution\Posts\Meta_Box
 * @since       2.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register our custom meta box
 *
 * @since       2.0.0
 * @return      void
 */
function simple_attribution_add_meta_boxes() {
	$post_types = simple_attribution()->settings->get_option( 'post_types', array( 'post' ) );

	foreach ( $post_types as $post_type ) {
		add_meta_box( 'simple_attribution1', __( 'Simple Attribution', 'simple-attribution' ), 'simple_attribution_render_meta_box', $post_type, 'side', 'default' );
	}
}
add_action( 'add_meta_boxes', 'simple_attribution_add_meta_boxes' );


/**
 * Render meta box
 *
 * @since       2.0.0
 * @global      object $post The post we are editing
 * @return      void
 */
function simple_attribution_render_meta_box() {
	global $post;

	$post_id = $post->ID;
	$title   = get_post_meta( $post_id, 'simple_attribution_title', true );
	$url     = get_post_meta( $post_id, 'simple_attribution_url', true );
	?>
	<p>
		<label for="simple_attribution_title"><?php esc_attr_e( 'Attribution Title:', 'simple-attribution' ); ?></label>
		<input type="text" id="simple_attribution_title" name="simple_attribution_title" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
	</p>
	<p>
		<label for="simple_attribution_url"><?php esc_attr_e( 'Attribution URL:', 'simple-attribution' ); ?></label>
		<input type="text" id="simple_attribution_url" name="simple_attribution_url" value="<?php echo esc_attr( $url ); ?>" class="widefat" />
	</p>
	<?php
	// Allow extension of the meta box.
	do_action( 'simple_attribution_meta_box_fields', $post_id );

	wp_nonce_field( basename( __FILE__ ), 'simple_attribution_meta_box_nonce' );
}


/**
 * Save post meta when the save_post action is called
 *
 * @since       2.0.0
 * @param       int $post_id The ID of the post we are saving.
 * @global      object $post The post we are saving
 * @return      void
 */
function simple_attribution_meta_box_save( $post_id ) {
	global $post;

	// Don't process if nonce can't be validated.
	if ( ! isset( $_POST['simple_attribution_meta_box_nonce'] ) || ! wp_verify_nonce( wp_strip_all_tags( wp_unslash( $_POST['simple_attribution_meta_box_nonce'] ) ), basename( __FILE__ ) ) ) {
		return;
	}

	// Don't process if this is an auto-save.
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) {
		return;
	}

	// Don't process if this is a revision.
	if ( isset( $post->post_type ) && 'revision' === $post->post_type ) {
		return;
	}

	// The default fields that get saved.
	$fields = apply_filters(
		'simple_attribution_meta_box_fields_save',
		array(
			'simple_attribution_title',
			'simple_attribution_url',
		)
	);

	foreach ( $fields as $field ) {
		if ( array_key_exists( $field, $_POST, true ) && isset( $_POST[ $field ] ) ) {
			$field      = wp_unslash( $field );
			$post_field = sanitize_text_field( wp_unslash( $_POST[ $field ] ) );

			if ( is_string( $post_field ) ) {
				$new = esc_attr( $post_field );
			} else {
				$new = $post_field;
			}

			$new = apply_filters( 'simple_attribution_meta_box_save_' . $field, $new );

			update_post_meta( $post_id, $field, $new );
		} else {
			delete_post_meta( $post_id, $field );
		}
	}
}
add_action( 'save_post', 'simple_attribution_meta_box_save' );
