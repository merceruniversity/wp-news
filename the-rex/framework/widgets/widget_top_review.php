<?php
/**
 * Plugin Name: BK-Ninja: Top Review Widget
 * Plugin URI: http://bk-ninja.com/
 * Description: This widget displays Top Review posts.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com/
 *
 */


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'bk_register_top_reviews_widget' );

function bk_register_top_reviews_widget() {
	register_widget( 'bk_top_review' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_top_review extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget-top-review', 'description' => esc_html__('[Sidebar widget] Displays top review posts in sidebar.', 'the-rex') );

		/* Create the widget. */
		parent::__construct( 'bk_top_review', esc_html__('BK-Ninja: Widget Top Reviews', 'the-rex'), $widget_ops);
	}

	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title'] );
		$entries_display = esc_attr($instance['entries_display']);
        $bk_top_reviews_time = $instance['top-reviews'];
        $meta_ar = array('cat', 'date');
        $week = ''; $month = ''; $year = '';
        $week = date('W');
        $year = date('Y');
        $month = date('m');
        if(isset($instance['category'])){
            $cat_id = $instance['category'];
        }else {
            $cat_id = '';
        }
		if( (!isset($entries_display)) || ($entries_display == NULL)){ 
            $entries_display = '5'; 
        }
		echo $before_widget;
?>      
    <?php
		if($bk_top_reviews_time == 'week'){
           $args = array(
                'cat' => $cat_id,
    			'post_type' => 'post',
    			'ignore_sticky_posts' => 1,
                'meta_key'  => 'bk_final_score',
                'orderby' => 'meta_value_num',
                'order'=> 'DESC',
                'w'  => $week,                                                        
    			'posts_per_page' => $entries_display		
            );
        }else if($bk_top_reviews_time == 'month'){
            $args = array(
                'cat' => $cat_id,
    			'post_type' => 'post',
    			'ignore_sticky_posts' => 1,
                'meta_key'  => 'bk_final_score',
                'orderby' => 'meta_value_num',
                'order'=> 'DESC',
                'monthnum'  => $month,
    			'posts_per_page' => $entries_display		
            );
        }else if($bk_top_reviews_time == 'year'){
            $args = array(
                'cat' => $cat_id,
    			'post_type' => 'post',
    			'ignore_sticky_posts' => 1,
                'meta_key'  => 'bk_final_score',
                'orderby' => 'meta_value_num',
                'order'=> 'DESC',
                'year'  => $year,
    			'posts_per_page' => $entries_display
            );
        }else{
    		$args = array(
                'cat' => $cat_id,
    			'post_type' => 'post',
    			'ignore_sticky_posts' => 1,
                'meta_key'  => 'bk_final_score',
                'orderby' => 'meta_value_num',
                'order'=> 'DESC',
    			'posts_per_page' => $entries_display		
            );
        }				
		
        $review_posts = new WP_Query( $args );
		if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_html($title) . $after_title;?>
            </div>
        <?php }
        if ( $review_posts -> have_posts() ) : ?>  
        <div class="widget_top_review widget_reviews"> 
       	    <ul class="list post-review-list">
                <?php
            	while ( $review_posts -> have_posts() ) : $review_posts -> the_post();?>
                    <?php 
                        $bk_final_score = get_post_meta(get_the_ID(), 'bk_final_score', true );
                    ?>
                    <li class="small-post content_out clearfix">
                        <div class="post-wrapper">
                            <?php echo bk_core::bk_get_feature_image('bk150_100', true);?>
                            <?php echo bk_core::bk_get_review_score($bk_final_score);?>                      
                            <div class="post-c-wrap">    
                                <?php echo bk_core::bk_get_post_title(get_the_ID(), 15);?>
                                <?php echo bk_core::bk_meta_cases('date');?> 
                            </div>
                        </div>
                    </li>   
                        
                <?php endwhile;?>
       	    </ul>
        </div>
        <?php endif;?>
		<?php echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
        $instance['title'] = $new_instance['title'];
		$instance['entries_display'] = strip_tags($new_instance['entries_display']);
        $instance['top-reviews'] = $new_instance['top-reviews'];
        $instance['category'] = $new_instance['category'];
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$defaults = array('title' => 'Top Reviews', 'entries_display' => 5, 'top-reviews' => 'all-time', 'category' => 'all');
		$instance = wp_parse_args((array) $instance, $defaults);
	?>
    <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php esc_html_e( 'Title:', 'the-rex'); ?></strong></label>
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
	</p>
            
    <p>
        <label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><strong><?php esc_html_e( 'Number of entries to display: ', 'the-rex'); ?></strong></label>
        <input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo $instance['entries_display']; ?>" style="width:100%;" />
    </p>        
    
   	<p>
		<label for="<?php echo $this->get_field_id('top-reviews'); ?>"><strong><?php esc_html_e( 'Filter by time for Top Reviews: ', 'the-rex'); ?></strong></label> 
		<select id="<?php echo $this->get_field_id('top-reviews'); ?>" name="<?php echo $this->get_field_name('top-reviews'); ?>" style="width:100%;">
		  	<option value='all-time' <?php if ('all-time' == $instance['top-reviews']) echo 'selected="selected"'; ?>><?php esc_html_e( 'All time', 'the-rex');?></option>
			<option value='week' <?php if ('week' == $instance['top-reviews']) echo 'selected="selected"'; ?>><?php esc_html_e( 'This week', 'the-rex');?></option>
            <option value='month' <?php if ('month' == $instance['top-reviews']) echo 'selected="selected"'; ?>><?php esc_html_e( 'This month', 'the-rex');?></option>
            <option value='year' <?php if ('year' == $instance['top-reviews']) echo 'selected="selected"'; ?>><?php esc_html_e( 'This year', 'the-rex');?></option>
		</select>
	</p>
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
	<?php
	}
}
?>