<?php
/**
 * Plugin Name: BK-Ninja: Twitter Widget
 * Plugin URI: http://bk-ninja.com/
 * Description: This widget displays the twitter widget with the stream in the sidebar.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com/
 *
 */

function bk_register_tw_widget() {
	register_widget('bk_Twitter');
}

add_action('widgets_init', 'bk_register_tw_widget');

class bk_Twitter extends WP_Widget {
	private $connection;

	private $consumer_key;
	private $consumer_secret;
	private $access_token;
	private $access_token_secret;
    
    private $uid;

	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget-twitter', 'description' => esc_html__('[Sidebar widget] Displays latest tweets in sidebar','the-rex') );


		/* Create the widget. */
		parent::__construct( 'bk-twitter', esc_html__('*BK: Widget Twitter', 'the-rex'), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
        global $bk_flex_el;
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$username = esc_attr($instance['username']);
		$show_count = $instance['show_count'];
        
		echo $before_widget;

		if ( $title )
			echo $before_title . esc_html($title) . $after_title;
        ?>
        <ul class="twitter-list">    
    		<?php
            if (function_exists('getTweets')) :
    
                $tweets_data = getTweets((int)$show_count, $username);
                if (!empty($tweets_data) && is_array($tweets_data)) :
                    foreach ($tweets_data as $tweet) :
                        $tweet['text'] = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i', "<a href=\"$1\" class=\"twitter-link\">$1</a>", $tweet['text']);
                        $tweet['text'] = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i', "<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $tweet['text']);
                        $tweet['text'] = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i", "<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $tweet['text']);
                        $tweet['text'] = preg_replace('/([\.|\,|\:|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $tweet['text']);
                        $tweet['text'] = str_replace('RT', ' ', $tweet['text']);
    
                        $time = strtotime($tweet['created_at']);
                        if ((abs(time() - $time)) < 86400)
                            $h_time = sprintf(esc_html__('%s ago', 'the-rex'), human_time_diff($time));
                        else
                            $h_time = date('M j, Y', $time);
                        ?>
    
                        <li class="twitter-item">
                            <div class="bk-twitter-message">
                                <p><?php echo do_shortcode($tweet['text']); ?></p>
                                <em class="twitter-timestamp"><?php echo esc_attr($h_time) ?></em>
                            </div>
                        </li>
    
                    <?php endforeach; ?>
                <?php
                else : echo '<li><span class="bk-issue">' . esc_html__('Configuration error or no data.', 'the-rex') . '</span></li>';
                endif; ?>
            <?php else :  esc_html_e( 'Please install plugin name "oAuth Twitter Feed for Developers', 'the-rex'); ?>
            <?php endif; ?>
        </ul>
        <?php

		echo '<div class="clear"></div>';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = $new_instance['username'];
		$instance['show_count'] = $new_instance['show_count'];
		$instance['hide_timestamp'] = $new_instance['hide_timestamp'];
		$instance['hide_url'] = $new_instance['hide_url'];
		$instance['consumer_key'] = $new_instance['consumer_key'];
		$instance['consumer_secret'] = $new_instance['consumer_secret'];
		$instance['access_token'] = $new_instance['access_token'];
		$instance['access_token_secret'] = $new_instance['access_token_secret'];

		delete_transient( 'bk_' . $new_instance['username'] );


		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Latest Tweets', 'username' => '', 'show_count' => 5, 'hide_timestamp' => false, 'hide_url' => false,
						   'consumer_key' => 'V6kDOs8evsngxd886KrL8QBuB', 'consumer_secret' => '7J6qrANBChZTZWn5pYlaN8fokOcUHhInx9aS4N8QN13vQhflZj', 
                           'access_token' => '2351267310-BLNj5jSVws3vQU0Ws4JsFCG4Obxkd7gsfKC5keL', 'access_token_secret' => '0cBsn2b0rwCWREKsaR0S76Z8zgqfXJYG7W2eHQvzP3bjb' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php esc_html_e( 'Title: ', 'the-rex'); ?></strong></label><br />
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'username' ); ?>"><strong><?php esc_html_e( 'Twitter Username', 'the-rex'); ?></strong></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>"   />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php esc_html_e( 'Show', 'the-rex'); ?></label>
		<input  type="text" id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo $instance['show_count']; ?>" size="3" /><?php esc_html_e( ' tweets', 'the-rex'); ?>
		</p>

		<?php
	}
}
