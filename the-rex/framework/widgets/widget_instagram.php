<?php
/**
 * Plugin Name: BK-Ninja: Instagram Widget
 * Plugin URI: http://bk-ninja.com
 * Description: This widget allows to display instagram images.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://BK-Ninja.com
 *
 */
/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'bk_register_instagram_widget');
function bk_register_instagram_widget(){
	register_widget('bk_instagram');
}
class bk_instagram extends WP_Widget {
    
/**
 * Widget setup.
 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget-instagram', 'description' => esc_html__('Displays Instagram Gallery.', 'the-rex') );

		/* Create the widget. */
		parent::__construct( 'bk_instagram', esc_html__('*BK: Widget Instagram', 'the-rex'), $widget_ops);
	}
    function widget( $args, $instance ) {
		extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $userid = apply_filters('userid', $instance['userid']);
        $accessToken = apply_filters('accessToken', $instance['accessToken']);
    	$amount = apply_filters('instagram_image_amount', $instance['image_amount']);		
        echo $before_widget; 
        if ( $title )
        echo $before_title . $title . $after_title; 
		// Pulls and parses data.
		$result = bk_fetchData('https://api.instagram.com/v1/users/'.$userid.'/media/recent/?access_token='.$accessToken.'&count='.$amount);
		$result = json_decode($result);?>
					
                <ul class="instagram-gallery clearfix">
                
                	<?php if(!empty($result->data)){
                	foreach ($result->data as $post){ ?>
                		<li>
                    		<a data-source="<?php if(!empty($post->user->username)){ echo $post->user->username; } ?>" class="instagram-popup-link cursor-zoom" href="<?php echo $post->images->standard_resolution->url ?>"><img src="<?php echo $post->images->thumbnail->url ?>"></a>
                		</li>
                	<?php }
                	}else{
                	echo "<strong>Configuration error or no pictures...</strong>";			
                		} ?>
                </ul>
                <script type="text/javascript">
				jQuery(document).ready(function($){
                    $('.instagram-popup-link').magnificPopup({
                    	type: 'image',
                    	closeOnContentClick: true,
                    	closeBtnInside: false,
                    	fixedContentPos: true,
                    	mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
                    	image: {
                    		verticalFit: true
                    	},
                    	gallery: {
                    		enabled: true
                    	},
                        zoom: {
                    		enabled: true,
                    		duration: 600, // duration of the effect, in milliseconds
                            easing: 'ease', // CSS transition easing function
                    		opener: function(element) {
                    			return element.find('img');
                    		}
                    	}
                    });
				});
			</script>
        								
        <?php echo $after_widget; ?>
        			 
        <?php }	

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {	
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
      /* Set up some default widget settings. */
      $defaults = array( 'title' => '', 'userid' => '', 'accessToken' => '', 'image_amount' => '');
      $instance = wp_parse_args( (array) $instance, $defaults );	

      $title = esc_attr($instance['title']);
			$userid = esc_attr($instance['userid']);
			$accessToken = esc_attr($instance['accessToken']);
			$amount = esc_attr($instance['image_amount']);	
    ?>
    <p>Generate your Instagram user ID and Instagram access token on: <a target="_blank" href="http://www.pinceladasdaweb.com.br/instagram/access-token/">Instagram access token generator</a> website</p>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'the-rex'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

    <p><label for="<?php echo $this->get_field_id('userid'); ?>"><?php esc_html_e( 'Instagram user ID:', 'the-rex'); ?> <input class="widefat" id="<?php echo $this->get_field_id('userid'); ?>" name="<?php echo $this->get_field_name('userid'); ?>" type="text" value="<?php echo $userid; ?>" /></label></p>
	<p><label for="<?php echo $this->get_field_id('accessToken'); ?>"><?php esc_html_e( 'Instagram access token:', 'the-rex'); ?> <input class="widefat" id="<?php echo $this->get_field_id('accessToken'); ?>" name="<?php echo $this->get_field_name('accessToken'); ?>" type="text" value="<?php echo $accessToken; ?>" /></label></p>	
    <p><label for="<?php echo $this->get_field_id('image_amount'); ?>"><?php esc_html_e( 'Images count:', 'the-rex'); ?> <input class="widefat" id="<?php echo $this->get_field_id('image_amount'); ?>" name="<?php echo $this->get_field_name('image_amount'); ?>" type="text" value="<?php echo $amount; ?>" /></label></p>	
			
<?php }

}
?>