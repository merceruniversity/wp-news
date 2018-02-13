<?php
/**
 * Plugin Name: BKninja: Social Counter Widget
 * Plugin URI: http://bkninja.com
 * Description: Displays social counters.
 * Version: 1.0
 * Author: BKninja
 * Author URI: http://bkninja.com
 *
 */
 
/**
 * Include required files
 */

 /**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init','bk_register_social_counters_widget');

function bk_register_social_counters_widget() {
	register_widget('bk_social_counter');
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_social_counter extends WP_Widget {
    private $connection;

	private $consumer_key;
	private $consumer_secret;
	private $access_token;
	private $access_token_secret;	
	/**
	 * Widget setup.
	 */
	function __construct() {
		
		/* Widget settings. */
		$widget_ops = array('classname' => 'widget-social-counter','description' => esc_html__('Displays social counters', 'the-rex'));
		
		/* Create the widget. */
		parent::__construct('bk_social_counter',esc_html__('BKninja: Widget Social Counters', 'the-rex'),$widget_ops);

	}
	
	/**
	 * display the widget on the screen.
	 */	
	function widget( $args, $instance ) {
		extract( $args );
		//user settings	
        $title = apply_filters('widget_title', $instance['title'] );
		$bk_youtube_username = esc_attr($instance['bk_youtube_username']);
        $bk_pinterest_id = esc_attr($instance['bk_pinterest_id']);
		$bk_dribbble_username = esc_attr($instance['bk_dribbble_username']);
        $bk_rss_url = esc_url($instance['bk_rss_url']);
		$bk_facebook_username = esc_attr($instance['bk_facebook_username']);
        $bk_facebook_accesstoken = $instance['bk_facebook_accesstoken'];
		$bk_twitter_id = esc_attr($instance['bk_twitter_id']);
        
        $bk_soundcloud_user = esc_attr($instance['bk_soundcloud_user']);
        $bk_soundcloud_api = esc_attr($instance['bk_soundcloud_api']);
        $bk_instagram_api = esc_attr($instance['bk_instagram_api']);

		$this->consumer_key = isset( $instance['bk_consumer_key'] ) ? $instance['bk_consumer_key'] : '';
		$this->consumer_secret = isset( $instance['bk_consumer_secret'] ) ? $instance['bk_consumer_secret'] : '';
		//$this->access_token = isset( $instance['bk_access_token'] ) ? $instance['bk_access_token'] : '';
		//$this->access_token_secret = isset( $instance['bk_access_secret'] ) ? $instance['bk_access_secret'] : '';	
		  

		echo $before_widget;
		if ( $title )
			echo $before_title . esc_html($title) . $after_title;

		//twitter
		if (isset($bk_twitter_id)&&(strlen($bk_twitter_id) != 0)){
			$interval = 600;				
			$follower_count = 0;
			
			$credentials = $this->consumer_key . ':' . $this->consumer_secret;
    		$to_send     = base64_encode( $credentials );
            $token       = get_option( 'bk_twitter_token' );
    		// http post arguments
    		if ( empty( $token ) ) {
    			$args = array(
    				'method'      => 'POST',
    				'httpversion' => '1.1',
    				'blocking'    => true,
    				'headers'     => array(
    					'Authorization' => 'Basic ' . $to_send,
    					'Content-Type'  => 'application/x-www-form-urlencoded',
    				),
    				'body'        => array( 'grant_type' => 'client_credentials' )
    			);
    			add_filter( 'https_ssl_verify', '__return_false' );
    			$response = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args );
    			$keys     = json_decode( wp_remote_retrieve_body( $response ) );
    			if ( $keys ) {
    				$token = $keys->access_token;
    				update_option( 'bk_twitter_token', $token );
    			};
    		}
    
    		$args = array(
    			'httpversion' => '1.1',
    			'blocking'    => true,
    			'headers'     => array(
                    'Accept-Encoding' => '',
    				'Authorization' => "Bearer $token"
    			)
    		);
    		add_filter( 'https_ssl_verify', '__return_false' );
    		$api_url  = "https://api.twitter.com/1.1/users/show.json?screen_name=$bk_twitter_id";
    		$response = wp_remote_get( $api_url, $args );
    		if ( ! is_wp_error( $response ) ) {
    			$followers = json_decode( wp_remote_retrieve_body( $response ) );
    			if ( ! empty( $followers->followers_count ) ) {
    				update_option('bk_twitter_followers', $followers->followers_count);
    			} else {
    				return false;
    			}
    		} else {
    			return false;
    		}
		}
		//Soundcloud
		if ((isset($bk_soundcloud_user)&&(strlen($bk_soundcloud_user) != 0)) && (isset($bk_soundcloud_api)&&(strlen($bk_soundcloud_api) != 0))){
		  	$interval = 600;
			$soundcloud_count = 0;
            $soundcloud_url = '';
            //if(time() > get_option('bk_soundcloud_cache_time')) {
                $url = 'http://api.soundcloud.com/users/'.$bk_soundcloud_user.'.json?consumer_key='.$bk_soundcloud_api;
                $api = wp_remote_get( $url ) ;
                $request = json_decode(wp_remote_retrieve_body ($api), true);
                $soundcloud_count = $request['followers_count']; 
                $soundcloud_url =  $request['permalink_url']; 
                if ($soundcloud_count >= 0 ) {
					update_option('bk_soundcloud_cache_time', time() + $interval);
					update_option('bk_soundcloud_followers', $soundcloud_count);
					update_option('bk_soundcloud_link', $soundcloud_url);
				}
            //}        
        }
        //Instagram
		if (isset($bk_instagram_api)&&(strlen($bk_instagram_api) != 0)){
		  	$interval = 600;
			$instagram_count = 0;
            $instagram_username = '';
            //if(time() > get_option('bk_instagram_cache_time')) {
                $instagram_userid = explode(".", $bk_instagram_api);
                $url = 'https://api.instagram.com/v1/users/'.$instagram_userid[0].'/?access_token='.$bk_instagram_api;
                $api = wp_remote_get( $url ) ;
                $request = json_decode(wp_remote_retrieve_body ($api), true);
                $instagram_count = $request['data']['counts']['followed_by'];   
                $instagram_username =  $request['data']['username'];
                $instagram_url = 'http://instagram.com/'.$instagram_username;
                if ($instagram_count >= 0 ) {
					update_option('bk_instagram_cache_time', time() + $interval);
					update_option('bk_instagram_followers', $instagram_count);
					update_option('bk_instagram_link', $instagram_url);
				}
            //}            
        }
		//facebook
		if (isset($bk_facebook_username)&&(strlen($bk_facebook_username) != 0)){
			$interval = 600;
			$fb_likes = 0;
			
			//if(time() > get_option('bk_facebook_cache_time')) {
                $api = wp_remote_get( 'https://graph.facebook.com/v2.6/' . $bk_facebook_username . '?fields=fan_count&access_token=420136554757149|68q0UtG1q5AmWfR9v2Wh5zTUjGc', array( 'timeout' => 60 ) );                
				
                if ( is_wp_error( $api ) || ( isset( $api['response']['code'] ) && 200 != $api['response']['code'] ) ) {
    				$total = 0;
    			} else {
    				$_data = json_decode( $api['body'], true );
    
    				if ( isset( $_data['fan_count'] ) ) {
    					$fb_likes = intval( $_data['fan_count'] );
    
    					$total = $fb_likes;
    				} else {
    					$total = 0;
    				}                   
    			}			
				update_option('bk_facebook_cache_time', time() + $interval);
				update_option('bk_facebook_followers', $total);
				update_option('bk_facebook_link', 'https://www.facebook.com/'.$bk_facebook_username);
			//}
		}
		
		//dribbble
		if (isset($bk_dribbble_username)&&(strlen($bk_dribbble_username) != 0)){
			$interval = 600;
			$followers_count = 0;
			//if(time() > get_option('bk_dribbble_cache_time')) {
				
				$api = wp_remote_get('http://api.dribbble.com/' . $bk_dribbble_username);
				
				if (!is_wp_error($api)) {
					$json = json_decode($api['body']);
					$followers_count = $json->followers_count;
					
					if ($followers_count > 0 ) {
						update_option('bk_dribbble_cache_time', time() + $interval);
						update_option('bk_dribbble_followers', $followers_count );
					}
				}
			//}
		}
        
        if(isset($bk_youtube_username)&&(strlen($bk_youtube_username) != 0)){
            $interval = 600;
            $url = "https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername=".$bk_youtube_username."&key=AIzaSyB9OPUPAtVh3_XqrByTwBTSDrNzuPZe8fo";
            $json = wp_remote_get($url);
            $json_data = json_decode($json['body'], false);
            //if(time() > get_option('bk_youtube_cache_time')) {               
                if($json_data != null){
                    $subscriberCount = $json_data->items[0]->statistics->subscriberCount;
                }
                if (isset($subscriberCount) && ($subscriberCount > 0) ){
                    update_option('bk_youtube_cache_time', time() + $interval);
                    update_option('bk_youtube_subscribers', $subscriberCount );
                }
            //}
                      
        } 
        if(isset($bk_pinterest_id)&&(strlen($bk_pinterest_id) != 0)){
            $interval = 600;
			$circledByCount = 0;
			
			//if(time() > get_option('bk_google_cache_time')) {
				$pinterest_data = wp_remote_get( 'http://api.pinterest.com/v3/pidgets/users/' . $bk_pinterest_id .'/pins');
                $json_data = json_decode($pinterest_data['body']);   
                if ( $json_data != null ) {
                    $followerCount = (int) $json_data->data->pins[0]->pinner->follower_count ;
    				update_option('bk_pinterest_cache_time', time() + $interval);
					update_option('bk_pinterest_followers', $followerCount);
					update_option('bk_pinterest_link', $json_data->data->pins[0]->pinner->profile_url);
                }
                
			//}
        }        
		?>
		<div class="wrap clearfix">
			<ul class="clearfix">
											
				<?php if (isset($bk_twitter_id)&&(strlen($bk_twitter_id) != 0)){ ?>
					<li class="twitter clear-fix">
                        <a target="_blank" href="http://twitter.com/<?php echo esc_attr($bk_twitter_id); ?>">
    						<div class="social-icon"><i class="fa fa-twitter"></i></div>
    						<div class="data">
    							<div class="counter"><?php echo get_option('bk_twitter_followers'); ?></div>
    							<div class="text"><?php esc_html_e( 'Followers', 'the-rex');?></div>
    						</div>
                        </a>
					</li> <!-- /twitter -->
				<?php } ?>
				
				<?php if (isset($bk_facebook_username) && (strlen($bk_facebook_username) != 0)){ ?>
					<li class="facebook clear-fix">
                        <a target="_blank" href="<?php echo get_option('bk_facebook_link'); ?>">
    						<div class="social-icon"><i class="fa fa-facebook"></i></div>
    						<div class="data">				
    							<div class="counter"><?php echo get_option('bk_facebook_followers'); ?></div>
					   		 <div class="text"><?php esc_html_e( 'Likes', 'the-rex');?></div>				
    						</div>
                        </a>
					</li><!-- /facebook -->
				<?php } ?>
                
				<?php if (isset($bk_dribbble_username)&&(strlen($bk_dribbble_username) != 0)){ ?>
					<li class="dribbble clear-fix">
                        <a target="_blank" href="http://dribbble.com/<?php echo esc_attr($bk_dribbble_username); ?>">
					    	<div class="social-icon"><i class="fa fa-dribbble"></i></div>
    						<div class="data">
    							<div class="counter"><?php echo get_option('bk_dribbble_followers'); ?></div>
    							<div class="text"><?php esc_html_e( 'Followers', 'the-rex'); ?></div>		
    						</div>
                        </a>				
					</li>
				<?php } ?>
				
				<?php if (isset($bk_youtube_username)&&(strlen($bk_youtube_username) != 0)){ ?>
					<li class="youtube clear-fix">
                        <a target="_blank" href="http://www.youtube.com/user/<?php echo esc_attr($bk_youtube_username) ;?>">
					    	<div class="social-icon"><i class="fa fa-youtube"></i></div>
    						<div class="data">
    							<div class="counter"><?php echo get_option('bk_youtube_subscribers'); ?></div>
    							<div class="text"><?php esc_html_e( 'Subscribers', 'the-rex'); ?></div>		
    						</div>
                        </a>				
					</li>
				<?php } ?>
                
                <?php if (isset($bk_pinterest_id)&&(strlen($bk_pinterest_id) != 0)){ ?>
					<li class="pinterest clear-fix">
                        <a target="_blank" href="<?php echo get_option('bk_pinterest_link'); ?>">
					    	<div class="social-icon"><i class="fa fa-pinterest"></i></div>
    						<div class="data">
    							<div class="counter"><?php echo get_option('bk_pinterest_followers'); ?></div>
    							<div class="text"><?php esc_html_e( 'Followers', 'the-rex'); ?></div>		
    						</div>
                        </a>				
					</li>
				<?php } ?>
                
                 <?php if ((isset($bk_soundcloud_user)&&(strlen($bk_soundcloud_user) != 0)) && (isset($bk_soundcloud_api)&&(strlen($bk_soundcloud_api) != 0))){ ?>
					<li class="soundcloud clear-fix">
                        <a target="_blank" href="<?php echo get_option('bk_soundcloud_link'); ?>">
    						<div class="social-icon"><i class="fa fa-soundcloud"></i></div>
    						<div class="data">
    							<div class="counter"><?php echo get_option('bk_soundcloud_followers'); ?></div>
    							<div class="text"><?php esc_html_e( 'Followers', 'the-rex'); ?></div>	
    						</div>	
                        </a>			
					</li>
				<?php } ?>
                <?php if (isset($bk_instagram_api)&&(strlen($bk_instagram_api) != 0)){ ?>
					<li class="instagram clear-fix">
                        <a target="_blank" href="<?php echo get_option('bk_instagram_link'); ?>">
    						<div class="social-icon"><i class="fa fa-instagram"></i></div>
    						<div class="data">
    							<div class="counter"><?php echo get_option('bk_instagram_followers'); ?></div>
    							<div class="text"><?php esc_html_e( 'Followers', 'the-rex'); ?></div>	
    						</div>	
                        </a>			
					</li>
				<?php } ?>
                <?php if (isset($bk_rss_url)&&(strlen($bk_rss_url) != 0)){ ?>
					<li class="rss clear-fix">
                        <a target="_blank" href="<?php echo esc_url($bk_rss_url); ?>">
					    	<div class="social-icon"><i class="fa fa-rss"></i></div>
    						<div class="data">
    							<div class="subscribe"><?php esc_html_e( 'Subscribe', 'the-rex'); ?></div>
    							<div class="text"><?php esc_html_e( 'RSS Feeds', 'the-rex'); ?></div>		
    						</div>	
                        </a>			
					</li>
				<?php } ?>
				
			</ul>
				
		</div><!-- /wrap -->			
		<?php 
		echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']); 
		$instance['bk_youtube_username'] = $new_instance['bk_youtube_username'];
        $instance['bk_pinterest_id'] = $new_instance['bk_pinterest_id'];
		$instance['bk_dribbble_username'] = $new_instance['bk_dribbble_username'];
		$instance['bk_facebook_username'] = $new_instance['bk_facebook_username'];
        $instance['bk_facebook_accesstoken'] = $new_instance['bk_facebook_accesstoken'];
        $instance['bk_rss_url'] = $new_instance['bk_rss_url'];
        $instance['bk_soundcloud_user'] = $new_instance['bk_soundcloud_user'];
        $instance['bk_soundcloud_api'] = $new_instance['bk_soundcloud_api'];
        $instance['bk_instagram_api'] = $new_instance['bk_instagram_api'];
        $instance['bk_twitter_id'] = $new_instance['bk_twitter_id'];
		$instance['bk_consumer_key'] = $new_instance['bk_consumer_key'];	
		$instance['bk_consumer_secret'] = $new_instance['bk_consumer_secret'];	
		$instance['bk_access_token'] = $new_instance['bk_access_token'];	
		$instance['bk_access_secret'] = $new_instance['bk_access_secret'];
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	 
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
        	'title' => '',		
			'bk_youtube_username' => '',
            'bk_pinterest_id' => '',
			'bk_dribbble_username' => '',
			'bk_twitter_id' => '',
			'bk_facebook_username' => '',
            'bk_facebook_accesstoken' => '420136554757149|68q0UtG1q5AmWfR9v2Wh5zTUjGc',
            'bk_rss_url' => '',
            'bk_soundcloud_user' => '',
            'bk_soundcloud_api' => 'fc20fec35eb62030a9051ff68e6e6614',
            'bk_instagram_api' => '',
			'bk_consumer_key' => 'oWr9V8ZNA98RNHXyFmKQFz187',	
			'bk_consumer_secret' => 'uQRWxFTIBd4YdViMfoGKDun5GTTBS2jkhdyNzSuDg7JT704192',	
			'bk_access_token' => '2351267310-DmBomEvRghx1MTUlgHywQOjQplOeg798Asv6tSO',	
			'bk_access_secret' => 'YoYg3Zymk3pUGJHBDuHkvGvOIa5vnf6v8lAicGp4Mun5f'
 		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<!-- Title: Text Input -->     
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php esc_html_e( 'Title:', 'the-rex');?></strong></label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>
                
		<p>
			<label for="<?php echo $this->get_field_id( 'bk_facebook_username' ); ?>"><strong><?php esc_html_e( 'Facebook Username:', 'the-rex');?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id( 'bk_facebook_username' ); ?>" name="<?php echo $this->get_field_name( 'bk_facebook_username' ); ?>" value="<?php echo esc_attr($instance['bk_facebook_username']); ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'bk_facebook_accesstoken' ); ?>"><strong><?php esc_html_e( 'Facebook Access token:', 'the-rex');?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id( 'bk_facebook_accesstoken' ); ?>" name="<?php echo $this->get_field_name( 'bk_facebook_accesstoken' ); ?>" value="<?php echo esc_attr($instance['bk_facebook_accesstoken']); ?>" class="widefat" />
            <i>Instruction to Get Facebook Access Token <a target="_blank" href="https://smashballoon.com/custom-facebook-feed/access-token/">here</a></i>
        </p>

        <p>
			<label for="<?php echo $this->get_field_id( 'bk_dribbble_username' ); ?>"><strong><?php esc_html_e( 'Dribbble Username', 'the-rex');?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id( 'bk_dribbble_username' ); ?>" name="<?php echo $this->get_field_name( 'bk_dribbble_username' ); ?>" value="<?php echo esc_attr($instance['bk_dribbble_username']); ?>" class="widefat" />
        </p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'bk_youtube_username' ); ?>"><strong><?php esc_html_e( 'Youtube username', 'the-rex');?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id( 'bk_youtube_username' ); ?>" name="<?php echo $this->get_field_name( 'bk_youtube_username' ); ?>" value="<?php echo esc_attr($instance['bk_youtube_username']); ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'bk_pinterest_id' ); ?>"><strong><?php esc_html_e( 'Pinterest ID', 'the-rex');?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id( 'bk_pinterest_id' ); ?>" name="<?php echo $this->get_field_name( 'bk_pinterest_id' ); ?>" value="<?php echo esc_attr($instance['bk_pinterest_id']); ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'bk_soundcloud_user' ); ?>"><strong><?php esc_html_e( 'SoundCloud Username','the-rex');?></strong> </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_soundcloud_user' ); ?>" name="<?php echo $this->get_field_name( 'bk_soundcloud_user' ); ?>" value="<?php echo esc_attr($instance['bk_soundcloud_user']); ?>"/>
			
			<label for="<?php echo $this->get_field_id( 'bk_soundcloud_api' ); ?>">Soundcloud API Key : </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_soundcloud_api' ); ?>" name="<?php echo $this->get_field_name( 'bk_soundcloud_api' ); ?>" value="<?php echo esc_attr($instance['bk_soundcloud_api']); ?>" />
		</p>
        
		<p>
			<label for="<?php echo $this->get_field_id( 'bk_instagram_api' ); ?>"><strong>Instagram Access Token Key :</strong> </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_instagram_api' ); ?>" name="<?php echo $this->get_field_name( 'bk_instagram_api' ); ?>" value="<?php echo esc_attr($instance['bk_instagram_api']); ?>" />
            <i>Get Instagram Access Token <a target="_blank" href="http://jelled.com/instagram/access-token">here</a></i>
        </p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'bk_rss_url' ); ?>"><strong><?php esc_html_e( 'RSS URL', 'the-rex');?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id( 'bk_rss_url' ); ?>" name="<?php echo $this->get_field_name( 'bk_rss_url' ); ?>" value="<?php echo esc_url($instance['bk_rss_url']); ?>" class="widefat" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'bk_twitter_id' ); ?>"><strong><?php esc_html_e( 'Twitter Name', 'the-rex');?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id( 'bk_twitter_id' ); ?>" name="<?php echo $this->get_field_name( 'bk_twitter_id' ); ?>" value="<?php echo esc_attr($instance['bk_twitter_id']); ?>" class="widefat" />
        </p>

		<p>
			<label for="<?php echo $this->get_field_id( 'bk_consumer_key' ); ?>"><strong><?php esc_html_e( 'Consumer key', 'the-rex') ?></strong></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_consumer_key' ); ?>" name="<?php echo $this->get_field_name( 'bk_consumer_key' ); ?>" value="<?php echo esc_attr($instance['bk_consumer_key']); ?>" />			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'bk_consumer_secret' ); ?>"><strong><?php esc_html_e( 'Consumer secret', 'the-rex') ?></strong></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_consumer_secret' ); ?>" name="<?php echo $this->get_field_name( 'bk_consumer_secret' ); ?>" value="<?php echo esc_attr($instance['bk_consumer_secret']); ?>" />			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'bk_access_token' ); ?>"><strong><?php esc_html_e( 'Access token', 'the-rex');?></strong></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_access_token' ); ?>" name="<?php echo $this->get_field_name( 'bk_access_token' ); ?>" value="<?php echo esc_attr($instance['bk_access_token']); ?>" />			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'bk_access_secret' ); ?>"><strong><?php esc_html_e( 'Access token secret', 'the-rex');?></strong></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bk_access_secret' ); ?>" name="<?php echo $this->get_field_name( 'bk_access_secret' ); ?>" value="<?php echo esc_attr($instance['bk_access_secret']); ?>" />			
		</p>


	<?php 
	}
    	function pre_validate_keys() {
    	if ( ! $this->consumer_key        ) return false;
    	if ( ! $this->consumer_secret     ) return false;
    	if ( ! $this->access_token        ) return false;
    	if ( ! $this->access_token_secret ) return false;
    
    	return true;
	}
} //end class