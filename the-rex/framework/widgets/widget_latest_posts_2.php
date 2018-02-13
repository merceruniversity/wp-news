<?php
/**
 * Plugin Name: BK-Ninja: Latest Posts 2
 * Plugin URI: http://bk-ninja.com/
 * Description: This widget displays the most recent posts with thumbnails in the tabs.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com/
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'bk_register_latest_posts_2_widget' );

function bk_register_latest_posts_2_widget() {
	register_widget( 'bk_latest_posts_2' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_latest_posts_2 extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_latest_posts_2', 'description' => __('[Sidebar widget] Displays latest posts in sidebar.', 'the-rex') );

		/* Create the widget. */
		parent::__construct( 'bk_latest_posts_2', __('BK-Ninja: (2) Widget Latest Posts Type 2', 'the-rex'), $widget_ops);
	}
    
	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
        
        $title = apply_filters('widget_title', $instance['title'] );
		$entries_display = esc_attr($instance['entries_display']) ;
        
        if(isset($instance['offset_post'])){
            $offset_post = $instance['offset_post'];
        }else {
            $offset_post = 0;
        }

        if(isset($instance['category'])){
            $cat_id = $instance['category'];
        }else {
            $cat_id = '';
        }
        
		if( (!isset($entries_display)) || ($entries_display == NULL)){ 
            $entries_display = '4'; 
        }
        $meta_ar = array('cat', 'date');
		$args_latest = array(
            'cat' => $cat_id,
			'post_type' => 'post',
			'ignore_sticky_posts' => 1,
            'post_status' => 'publish',
            'offset' => $offset_post,
			'posts_per_page' => $entries_display		
		);	
		echo $before_widget;
		if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_html($title) . $after_title;?>
            </div>
        <?php }?>
         	
		<?php $latest_posts = new WP_Query( $args_latest ); ?>
		<?php if ( $latest_posts -> have_posts() ) : ?>
			<ul class="list post-list clearfix">
				<?php while ( $latest_posts -> have_posts() ) : $latest_posts -> the_post(); ?>	
                        <li class="small-post content_out clearfix">
                            <div class="post-wrapper">
                                <?php echo bk_core::bk_get_feature_image('bk150_100', true);?>
                                <div class="post-c-wrap">  
                                    <?php echo bk_core::bk_get_post_title(get_the_ID(), 15);?>
                                </div>
                            </div>
                        </li> 			
				<?php endwhile; ?>
			</ul>
		<?php endif;?>

    <?php
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
        $instance['title'] = $new_instance['title'];
		$instance['entries_display'] = strip_tags($new_instance['entries_display']);
        $instance['offset_post'] = $new_instance['offset_post'];
        $instance['category'] = $new_instance['category'];
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$defaults = array('title' => 'Latest Posts','entries_display' => 4, 'offset_post' => 0, 'category' => 'all');
		$instance = wp_parse_args((array) $instance, $defaults);
	?>
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e('Title:', 'the-rex'); ?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>               
        <p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><strong><?php _e('Number of entries to display: ', 'the-rex'); ?></strong></label>
		<input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo $instance['entries_display']; ?>" style="width:100%;" /></p>
        <p><label for="<?php echo $this->get_field_id( 'offset_post' ); ?>"><strong><?php _e('Offet Posts number: ', 'the-rex'); ?></strong></label>
		<input type="text" id="<?php echo $this->get_field_id('offset_post'); ?>" name="<?php echo $this->get_field_name('offset_post'); ?>" value="<?php echo $instance['offset_post']; ?>" style="width:100%;" /></p>
        <p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><strong><?php _e('Filter by Category: ','the-rex');?></strong></label> 
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['category']) echo 'selected="selected"'; ?>><?php _e( 'All Categories', 'the-rex'); ?></option>
				<?php $categories = get_categories('hide_empty=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['category']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>        
<?php
	}
}
?>
