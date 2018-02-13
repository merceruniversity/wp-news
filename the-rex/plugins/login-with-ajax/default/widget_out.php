<?php 
/*
 * This is the page users will see logged out. 
 * You can edit this, but for upgrade safety you should copy and modify this file into your template folder.
 * The location from within your template folder is plugins/login-with-ajax/ (create these directories if they don't exist)
*/
?>
	<div class="lwa lwa-default"><?php //class must be here, and if this is a template, class name should be that of template directory ?>
        <div class="lwa-form bk-login-form-wrapper bk-form-wrapper">
            <form class="bk-login-modal-form bk-lwa-form" action="<?php echo esc_attr(LoginWithAjax::$url_login); ?>" method="post">
            	<div class="bk-login-status">
                    <span class="lwa-status"></span>
                </div>
                <div class="bk-ajaxform-wrap">
                    <div class="lwa-username bk-login-input">
                        <div class="username_input bkusername_input">
                            <input type="text" name="log" id="lwa_user_login" class="input" placeholder="<?php esc_html_e('your username','the-rex');?>" required />
                        </div>
                    </div>
                    <div class="lwa-password bk-login-input">
                        <div class="password_input bkpassword_input">
                            <input type="password" name="pwd" id="lwa_user_pass" class="input" value="" placeholder="<?php esc_html_e('your password','the-rex');?>" required />
                        </div>
                    </div>
                    <?php do_action('login_form'); ?>
                    <div class="lwa-submit bk-formsubmit clearfix">
                        <div class="lwa-links bk-links">
                            <div class="bk-rememberme">
    				        	<?php if( !empty($lwa_data['remember']) ): ?>
    							<a class="lwa-links-remember bk-links-remember" href="<?php echo esc_attr(LoginWithAjax::$url_remember); ?>" title="<?php esc_attr_e('Password Lost and Found','login-with-ajax') ?>"><?php esc_attr_e('Lost your password?','login-with-ajax') ?></a>
    							<?php endif; ?>
    						</div>
                            <div class="bk-registration">
                                <?php if ( get_option('users_can_register') && !empty($lwa_data['registration']) ) : ?>  
    							<a href="<?php echo esc_attr(LoginWithAjax::$url_register); ?>" class="lwa-links-register lwa-links-modal"><?php esc_html_e('Register','login-with-ajax') ?></a>
    							<?php endif; ?>
                            </div>
                                                    
                        </div>
                        <div class="lwa-submit-button bk-submit-button">
                            <input type="submit" name="wp-submit" class="lwa-wp-submit" value="<?php esc_attr_e('Log In','login-with-ajax'); ?>" tabindex="100" />
                            <input type="hidden" name="lwa_profile_link" value="<?php echo !empty($lwa_data['profile_link']) ? 1:0 ?>" />
                        	<input type="hidden" name="login-with-ajax" value="login" />
    						<?php if( !empty($lwa_data['redirect']) ): ?>
    						<input type="hidden" name="redirect_to" value="<?php echo esc_url($lwa_data['redirect']); ?>" />
    						<?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php if( !empty($lwa_data['remember']) ): ?>
        <div class="lwa-remember bk-remember-form-wrapper bk-form-wrapper" style="display:none;">
            <form action="<?php echo esc_attr(LoginWithAjax::$url_remember) ?>" method="post">
            	<span class="lwa-status"></span>
                <div class="bk-forgotpass clearfix">
	                <div class="lwa-remember-email bk-login-input">	                    
                        <input type="text" name="user_login" id="lwa_user_remember" placeholder="<?php esc_html_e('Enter username or email','the-rex');?>"/>
	                </div>
                    <?php do_action('lostpassword_form'); ?>
	                <div class="bk-recover-submit">
                        <a href="#" class="bk-back-login"><i class="fa fa-long-arrow-left"></i><?php esc_html_e("Back to login",'login-with-ajax'); ?></a>
                        <input type="submit" value="<?php esc_attr_e("Get New Password", 'login-with-ajax'); ?>" />
                        <input type="hidden" name="login-with-ajax" value="remember" />	                
	                </div>
	            </div>
            </form>
        </div>
        <?php endif; ?>
		<?php if( get_option('users_can_register') && !empty($lwa_data['registration']) ): ?>
		<div class="lwa-register lwa-register-default lwa-modal" style="display:none;">
			<h1 class="bk-login-title"><?php esc_html_e('Register', 'the-rex');?></h1>
            <form name="lwa-register"  action="<?php echo esc_attr(LoginWithAjax::$url_register); ?>" method="post">
        		<span class="lwa-status"></span>
                <div class="lwa-username bk-login-input">
                    <input type="text" name="user_login" id="user_login" placeholder="<?php esc_html_e('Username','the-rex');?>"/>
                </div>
                <div class="lwa-email bk-login-input">
                    <input type="text" name="user_email" id="user_email" placeholder="<?php esc_html_e('E-mail','the-rex');?>"/>
                </div>
                <?php do_action('register_form'); ?>
                <?php do_action('lwa_register_form'); ?>
                <div class="bk-register-submit">
                    <input type="submit" value="<?php esc_attr_e('Register','login-with-ajax'); ?>" tabindex="100" />
					<input type="hidden" name="login-with-ajax" value="register" />
                </div>
			</form>
		</div>
		<?php endif; ?>
	</div>