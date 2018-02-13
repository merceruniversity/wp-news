<?php
/**
 * Plugin Name: BK-Ninja: Shortcode Widget
 * Plugin URI: http://bk-ninja.com
 * Description: Displays shortcode in sidebar.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://BK-Ninja.com
 *
 */
/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'bk_register_shortcode_widget');

function bk_register_shortcode_widget(){
	register_widget('bk_shortcode_widget');
}

class bk_shortcode_widget extends WP_Widget {
    
/**
 * Widget setup.
 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget-shortcode', 'description' => esc_html__('Displays shortcode in the sidebar.', 'the-rex') );

		/* Create the widget. */
		parent::__construct( 'bk_shortcode_widget', esc_html__('*BK: Widget shortcode', 'the-rex'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title'] );
        $shortcode = $instance['shortcode']; 
		echo $before_widget;
        if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_html($title) . $after_title;?>
            </div>
        <?php }
		?>
			<div class="shortcode-widget-content bk-shortcode">
                <?php echo do_shortcode($instance['shortcode']);?>
            </div>
		<?php

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, $this->default );
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['shortcode'] = strip_tags( $new_instance['shortcode'] );

		return $instance;
	}

	function form( $instance ) {
        $defaults = array('title' => esc_html__('Shortcode','the-rex'), 'shortcode' => '');
		$instance = wp_parse_args((array) $instance, $defaults);
        $shortcode = strip_tags( $instance['shortcode'] );
?>
		<!-- Ads Image URL -->
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php esc_html_e( 'Title:', 'the-rex'); ?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- shortcode -->
		<p>
			<label for="<?php echo $this->get_field_id('shortcode'); ?>"><?php esc_html_e( 'Put the shortcode here:','the-rex'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('shortcode'); ?>" name="<?php echo $this->get_field_name('shortcode'); ?>" type="text" value="<?php echo esc_attr($shortcode); ?>" />
		</p>
<?php
	}
}
