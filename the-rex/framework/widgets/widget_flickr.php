<?php
/**
 * Plugin Name: BK-Ninja: Flickr Widget
 * Plugin URI: http://bk-ninja.com
 * Description: This widget allows to display flickr images.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'bk_register_flickr_widget' );

function bk_register_flickr_widget() {
	register_widget( 'bk_flickr' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */ 
class bk_flickr extends WP_Widget {
	
	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */		
		$widget_ops = array('classname' => 'widget_flickr', 'description' => esc_html__('[Sidebar widget] Displays Flickr images in sidebar.','the-rex') );
		
		/* Create the widget. */
		parent::__construct('bk_flickr', esc_html__('BK-Ninja: Widget Flickr', 'the-rex'), $widget_ops);
	}

	/**
	 * display the widget on the screen.
	 */
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
        $flickr_id = empty($instance['flickr_id']) ? ' ' : apply_filters('widget_user', $instance['flickr_id']);
        $flickr_counter = empty($instance['flickr_counter']) ? ' ' : apply_filters('widget_counter', $instance['flickr_counter']);
        if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_html($title) . $after_title;?>
            </div>
        <?php }?>
        <?php
            $uid = uniqid();
        ?>                        
		<ul class="flickr clearfix" id="flickr-<?php echo $uid;?>"></ul>
            <script type="text/javascript">
				jQuery(document).ready(function($){
					$.getJSON("//api.flickr.com/services/feeds/photos_public.gne?ids=<?php print esc_attr($flickr_id); ?>&lang=en-us&format=json&jsoncallback=?", function(data){
                        $.each(data.items, function(index, item){
                            if(index >= <?php echo esc_attr($flickr_counter);?>){
                                return false;
                            }
                            $("<img/>").attr("src", item.media.m.replace('_m','_s')).appendTo("#flickr-<?php echo $uid;?>")
                              .wrap("<li class='clearfix'><div class='thumb'><a class='flicker-popup-link cursor-zoom' href='" + item.media.m.replace('_m','_b') + "'></a></div></li>");
                              
                                $('.flicker-popup-link').magnificPopup({
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
				    });
				});
			</script>
			
		<?php
		
        echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        $instance['flickr_id'] = strip_tags($new_instance['flickr_id']);
        $instance['flickr_counter'] = strip_tags($new_instance['flickr_counter']);
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */	 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Flickr', 'flickr_id' => '', 'flickr_counter' => 9 ) );
	?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><strong><?php esc_html_e( 'Title:', 'the-rex') ?></strong>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('flickr_id'); ?>"><strong><?php esc_html_e( 'Flickr User ID ', 'the-rex') ?></strong>( <a href="http://www.idgettr.com" target="_blank" >idGettr</a> ): 
            <input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo $instance['flickr_id']; ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('flickr_counter'); ?>"><strong><?php esc_html_e( 'Number of images:', 'the-rex') ?></strong>
            <input class="widefat" id="<?php echo $this->get_field_id('flickr_counter'); ?>" name="<?php echo $this->get_field_name('flickr_counter'); ?>" type="text" value="<?php echo $instance['flickr_counter']; ?>" /></label></p>
<?php
	}
}