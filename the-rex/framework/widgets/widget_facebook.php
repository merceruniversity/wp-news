<?php
/**
 * Plugin Name: BK-Ninja: Facebook Widget
 * Plugin URI: http://bk-ninja.com/
 * Description: This widget displays the Facebook likebox in sidebar.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com/
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'bk_register_facebook_widget');

function bk_register_facebook_widget()
{
	register_widget('bk_facebook');
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_facebook extends WP_Widget {
	
	/**
	 * Widget setup.
	 */
	function __construct()
	{
		/* Widget settings. */
		$widget_ops = array('classname' => 'widget-facebook', 'description' => esc_html__('[Sidebar widget] Displays the Facebook likebox in sidebar.','the-rex'));
		
		/* Create the widget. */
		parent::__construct('bk_facebook', esc_html__('BK-Ninja: Widget Facebook','the-rex'), $widget_ops);
	}
	
	/**
	 * display the widget on the screen.
	 */
	function widget($args, $instance)
	{
		
		extract($args);
		$page_url = esc_url($instance['page_url']);
		$title = apply_filters('widget_title', $instance['title'] );
        $show_post = $instance['show_post'];
		if($page_url): 
		echo $before_widget;
        if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_html($title) . $after_title;?>
            </div>
        <?php }?>
		
		<div class="fb-container">
			<div id="fb-root"></div>
                <script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=1385724821660962";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-page" data-href="<?php echo esc_url($page_url);?>" data-hide-cover="false" data-show-facepile="true" data-show-posts="<?php if($show_post == 'true') {echo 'true';} else {echo 'false';}?>"></div>            
		</div>
		<?php 
			echo $after_widget;
		endif;
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['page_url'] = $new_instance['page_url'];
		$instance['show_post'] = $new_instance['show_post'];
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance)
	{
		$defaults = array( 'title' => esc_html__('Find us on Facebook','the-rex'), 'page_url' => '', 'show_post' => 'true');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php esc_html_e( 'Title:', 'the-rex'); ?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		
		
		<p>
			<label for="<?php echo $this->get_field_id('page_url'); ?>"><strong><?php esc_html_e( 'Facebook Page URL:', 'the-rex') ?></strong></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('page_url'); ?>" name="<?php echo $this->get_field_name('page_url'); ?>" value="<?php echo $instance['page_url']; ?>" style="width:100%;"/>
		</p>

        <p>
            <label for="<?php echo $this->get_field_id('show_post'); ?>"><strong><?php esc_html_e( 'Show Facebook Posts:', 'the-rex') ?></strong></label>    
            <select id="<?php echo $this->get_field_id('show_post'); ?>" name="<?php echo $this->get_field_name('show_post'); ?>" style="width:100%;">
        		<option value='true' <?php if ('true' == $instance['show_post']) echo 'selected="selected"'; ?>><?php esc_html_e( 'True', 'the-rex');?></option>
        		<option value='false' <?php if ('false' == $instance['show_post']) echo 'selected="selected"'; ?>><?php esc_html_e( 'False', 'the-rex');?></option>
        	</select>
        </p>
        
		
	<?php
	}
}
?>