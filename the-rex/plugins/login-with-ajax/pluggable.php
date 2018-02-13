<?php
//Replace the user registration welcome email
if ( !function_exists('wp_new_user_notification') ) :
/**
 * Notify the blog admin of a new user, normally via email.
 *
 * @since 2.0
 *
 * @param int $user_id User ID
 * @param string $plaintext_pass Optional. The user's plaintext password
 */
function wp_new_user_notification($user_id, $plaintext_pass = '') {
	
	//Copied out of /wp-includes/pluggable.php
	$user = new WP_User($user_id);

	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);
	
	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$message  = sprintf(esc_html__('New user registration on your blog %s:', 'the-rex'), $blogname) . "\r\n\r\n";
	$message .= sprintf(esc_html__('Username: %s', 'the-rex'), $user_login) . "\r\n\r\n";
	$message .= sprintf(esc_html__('E-mail: %s', 'the-rex'), $user_email) . "\r\n";

	@wp_mail(get_option('admin_email'), sprintf(esc_html__('[%s] New User Registration', 'the-rex'), $blogname), $message);

	if ( empty($plaintext_pass) )
		return;
			
	//LWA Customizations
	if ( !empty(LoginWithAjax::$data['notification_override']) ) {
		//We can use our own logic here
		LoginWithAjax::new_user_notification($user_login, $plaintext_pass, $user_email, $blogname);
	}else{
		//Copied out of /wp-includes/pluggable.php
		$message  = sprintf(esc_html__('Username: %s', 'the-rex'), $user_login) . "\r\n";
		$message .= sprintf(esc_html__('Password: %s', 'the-rex'), $plaintext_pass) . "\r\n";
		$message .= wp_login_url() . "\r\n";
	
		wp_mail($user_email, sprintf(esc_html__('[%s] Your username and password', 'the-rex'), $blogname), $message);
	}
}
endif;

?>