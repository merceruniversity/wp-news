<?php
/**
 * Plugin Name: BK-Ninja: Slider Widget
 * Plugin URI: http://bk-ninja.com
 * Description: Slider widget in sidebar
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'bk_register_slider_widget');

function bk_register_slider_widget(){
	register_widget('bk_slider');
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */ 
class bk_slider extends WP_Widget {
	
	/**
	 * Widget setup.
	 */
	function __construct(){
		/* Widget settings. */	
		$widget_ops = array('classname' => 'widget_slider', 'description' => esc_html__('[Sidebar widget] Displays a slider in sidebar.', 'the-rex'));
		
		/* Create the widget. */
		parent::__construct('bk_slider', esc_html__('BK-Ninja: Widget Slider','the-rex'), $widget_ops);
	}
	
	/**
	 * display the widget on the screen.
	 */
	function widget($args, $instance){	
		extract($args);
        $title = apply_filters('widget_title', $instance['title'] );
		$entries_display = esc_attr($instance['entries_display']);
        $posts_order = $instance['posts_order'];
        
        if(isset($instance['offset_post'])){
            $offset_post = $instance['offset_post'];
        }else {
            $offset_post = 0;
        }
		$cat_id = $instance['category'];
        echo $before_widget;
        if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_html($title) . $after_title;?>
            </div>
        <?php }
              
		$args = array(
				'cat' => $cat_id,
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => $entries_display, 
                'offset' => $offset_post
                );
        if ( $posts_order == 'random' ) {
			$args[ 'orderby' ] = 'rand';
		}
        $meta_ar = array('cat', 'date');
        ?>
		<div class="flexslider">
			<ul class="slides">
				<?php $query = new WP_Query( $args ); ?>
				<?php while($query->have_posts()): $query->the_post(); ?>
                        <?php $postid = get_the_ID();?>		
                        <li class="content_in">
                            <div class='thumb hide-thumb'>
                                <a href="<?php the_permalink();?>">
                                    <?php 
                                        if(has_post_thumbnail( get_the_ID() )) {
                                            echo get_the_post_thumbnail(get_the_ID(), 'bk360_248');
                                        }else {
                                            echo '<img width="485" height="300" src="'.get_template_directory_uri().'/images/bkdefault485_300.jpg">';
                                        }
                                    ?>
                                </a>
                            </div>
                            <div class="post-c-wrap">
                                <?php echo bk_core::bk_get_post_meta($meta_ar);?>
                                <?php echo bk_core::bk_get_post_title(get_the_ID(), 15);?>
                            </div>        
                            <a class="bk-cover-link" href="<?php the_permalink();?>"></a>	
						</li>	
                    																				
				<?php endwhile; ?>
			</ul>
		</div>			
		<?php
		echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']); 
		$instance['category'] = $new_instance['category'];
		$instance['entries_display'] = $new_instance['entries_display'];
        $instance['posts_order'] = strip_tags( $new_instance['posts_order'] );
        $instance['offset_post'] = $new_instance['offset_post'];
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */	
	function form($instance){
		$defaults = array('title' => '', 'category' => 'all', 'entries_display' => 5, 'posts_order' => 'latest', 'offset_post' => 0);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
        
		<!-- Title: Text Input -->     
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php esc_html_e( 'Title: ','the-rex');?></strong></label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
        
        <p><label for="<?php echo $this->get_field_id( 'offset_post' ); ?>"><strong><?php esc_html_e( 'Offet Posts number: ', 'the-rex'); ?></strong></label>
    	<input type="text" id="<?php echo $this->get_field_id('offset_post'); ?>" name="<?php echo $this->get_field_name('offset_post'); ?>" value="<?php echo $instance['offset_post']; ?>" style="width:100%;" /></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><strong><?php esc_html_e( 'Filter by Category: ','the-rex');?></strong></label> 
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['category']) echo 'selected="selected"'; ?>><?php esc_html_e(  'All Categories', 'the-rex'); ?></option>
				<?php $categories = get_categories('hide_empty=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['category']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'posts_order' ); ?>">Posts order : </label>
			<select id="<?php echo $this->get_field_id( 'posts_order' ); ?>" name="<?php echo $this->get_field_name( 'posts_order' ); ?>" >
				<option value="latest" <?php if( !empty($instance['posts_order']) && $instance['posts_order'] == 'latest' ) echo "selected=\"selected\""; else echo ""; ?>>Most recent</option>
				<option value="random" <?php if( !empty($instance['posts_order']) && $instance['posts_order'] == 'random' ) echo "selected=\"selected\""; else echo ""; ?>>Random</option>
			</select>
		</p>
        
		<p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><strong><?php esc_html_e( 'Number of entries to display: ', 'the-rex'); ?></strong></label>
		<input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo $instance['entries_display']; ?>" style="width:100%;" /></p>

	<?php }
}
?>