<?php
//Copy of registration function in wp-login.php which is required in ajax process
/**
 * Handles registering a new user.
 *
 * @param string $user_login User's username for logging in
 * @param string $user_email User's email address to send password and add
 * @return int|WP_Error Either user's ID or error on failure.
 */
function register_new_user( $user_login, $user_email ) {
	$errors = new WP_Error();

	$sanitized_user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );

	// Check the username
	if ( $sanitized_user_login == '' ) {
		$errors->add( 'empty_username', esc_html__( 'Error: Please enter a username.', 'the-rex') );
	} elseif ( ! validate_username( $user_login ) ) {
		$errors->add( 'invalid_username', esc_html__( 'Error: This username is invalid because it uses illegal characters. Please enter a valid username.', 'the-rex') );
		$sanitized_user_login = '';
	} elseif ( username_exists( $sanitized_user_login ) ) {
		$errors->add( 'username_exists', esc_html__( 'Error:: This username is already registered. Please choose another one.', 'the-rex') );
	}

	// Check the e-mail address
	if ( $user_email == '' ) {
		$errors->add( 'empty_email', esc_html__( 'Error: Please type your e-mail address.', 'the-rex') );
	} elseif ( ! is_email( $user_email ) ) {
		$errors->add( 'invalid_email', esc_html__( 'Error: The email address isn&#8217;t correct.', 'the-rex') );
		$user_email = '';
	} elseif ( email_exists( $user_email ) ) {
		$errors->add( 'email_exists', esc_html__( 'Error: This email is already registered, please choose another one.', 'the-rex') );
	}

	do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

	if ( $errors->get_error_code() )
		return $errors;

	$user_pass = wp_generate_password( 12, false);
	$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
	if ( ! $user_id ) {
		$errors->add( 'registerfail', sprintf( esc_html__( 'Error: Please contact the <a href="mailto:%s">webmaster</a>.', 'the-rex'), get_option( 'admin_email' ) ) );
		return $errors;
	}

	update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.

	wp_new_user_notification( $user_id, $user_pass );

	return $user_id;
}