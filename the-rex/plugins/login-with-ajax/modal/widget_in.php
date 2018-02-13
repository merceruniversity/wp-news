<?php 
/*
 * This is the page users will see logged in. 
 * You can edit this, but for upgrade safety you should copy and modify this file into your template folder.
 * The location from within your template folder is plugins/login-with-ajax/ (create these directories if they don't exist)
*/
?>
<div class="bk-lwa">
	<?php 
		global $current_user;
		get_currentuserinfo();
	?>
	<table>
		<tr>
			<td class="avatar lwa-avatar bk-avatar">
				<a href="#"><?php echo get_avatar( $current_user->ID, $size = '27' );  ?></a>
			</td>
            <td>
                <div class="bk-ud-logout-mobile">
                    <span>-</span>
                    <a class="wp-logout" href="<?php echo wp_logout_url() ?>"><?php esc_html_e( 'Log Out' ,'login-with-ajax') ?></a>
                </div>
            </td>
		</tr>
	</table>
    <div class="bk-account-info">
        <?php if ( class_exists('bbpress') ) { ?>
                <div class="bk-lwa-profile">
                    <div class="bk-avatar">
                        <?php echo get_avatar( $current_user->ID, $size = '80' );  ?>
                    </div>
            
                    <div class="bk-user-data clearfix">
                        <div class="bk-username">
                            <i class="fa fa-user"></i>
                            <a href="<?php echo get_edit_user_link($current_user->ID); ?>"><?php echo  $current_user->display_name;  ?></a>
                        </div>
                        <div class="bk-ud-topic">
                            <i class="fa fa-comment-o"></i>
                            <a href="<?php bbp_user_topics_created_url($current_user->ID); ?>"><?php _e( 'Topics Started', 'bbpress' ); ?></a>
                        </div>
        
                        <div class="bk-ud-replied">
                            <i class="fa fa-comments-o"></i>
                            <a href="<?php bbp_user_replies_created_url($current_user->ID); ?>"><?php _e( 'Replies Created', 'bbpress' ); ?></a>
                        </div>
        
                        <div class="bk-ud-favorites">
                            <i class="fa fa-heart-o"></i>
                            <a href="<?php bbp_favorites_permalink($current_user->ID); ?>"><?php _e( 'Favorites', 'bbpress' ); ?></a>
                        </div>
        
                        <div class="bk-ud-subscriptions">
                            <i class="fa fa-bookmark-o"></i>
                            <a href="<?php bbp_subscriptions_permalink($current_user->ID); ?>"><?php _e( 'Subscriptions', 'bbpress' ); ?></a>
                        </div>
                        
                        <div class="bk-ud-logout">
                            <i class="fa fa-sign-out"></i>
                            <a class="wp-logout" href="<?php echo wp_logout_url() ?>"><?php esc_html_e( 'Log Out' ,'login-with-ajax') ?></a>
                        </div>
                        
                    </div>  
                </div>
        <?php }else {?>
                <div class="bk-lwa-profile">
                    <div class="bk-avatar">
                        <?php echo get_avatar( $current_user->ID, $size = '80' );  ?>
                    </div>
            
                    <div class="bk-user-data clearfix">
                        <div class="bk-username">
                            <i class="fa fa-user"></i>
                            <a href="<?php echo get_edit_user_link($current_user->ID); ?>"><?php echo  $current_user->display_name;  ?></a>
                        </div>
                        <div class="bk-block">
                            <i class="fa fa-user"></i>
                            <a href="<?php echo get_edit_user_link($current_user->ID); ?>"><?php esc_html_e("Edit Profile", 'login-with-ajax'); ?></a>
                        </div>  
                        
                        <div class="bk-block">
                            <i class="fa fa-sign-out"></i>
                            <a class="wp-logout" href="<?php echo wp_logout_url() ?>"><?php esc_html_e( 'Log Out' ,'login-with-ajax') ?></a>
                        </div>
                        
                    </div>  
                </div>
        <?php }?>
    </div>
</div>