<?php
/* -----------------------------------------------------------------------------
 * Delete Page builder Section
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_delete_section' ) ) {
	function bk_delete_section( $post_id, $target_field ) {
		$custom_fields = get_post_custom_keys( $post_id );
		foreach ( $custom_fields as $custom_field ) {
			if ( strpos( $custom_field, $target_field ) === 0 ) {
				delete_post_meta( $post_id, $custom_field );
			}
		}
	}
}
