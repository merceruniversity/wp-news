<?php
/**
 * Plugin Name: BK-Ninja: Popular Posts
 * Plugin URI: http://bk-ninja.com/
 * Description: This widget displays the most popular posts with thumbnails in the tabs.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com/
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'bk_register_most_commented_widget' );

function bk_register_most_commented_widget() {
	register_widget( 'bk_most_commented' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_most_commented extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_most_commented', 'description' => esc_html__('[Sidebar widget] Displays posts that has most commented in sidebar.', 'the-rex') );

		/* Create the widget. */
		parent::__construct( 'bk_most_commented', esc_html__('BK-Ninja: Widget Most Commented', 'the-rex'), $widget_ops);
	}
    
	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		
        $title = apply_filters('widget_title', $instance['title'] );
		$entries_display = esc_attr($instance['entries_display']);
        $meta_ar = array('cat', 'date');
        $time = $instance['time'] ;
        $week = '';
        $month = '';
        $year = '';
        if(isset($instance['category'])){
            $cat_id = $instance['category'];
        }else {
            $cat_id = '';
        }
        if ($time == 'thisweek') {
            $week = date('W');
            $year = date('Y');
        }else if ($time == 'lastweek') {
            $week = date('W') - 1;
            $year = date('Y');
        }else if ($time == 'thismonth') {
            $week = 0;
            $month = date ('n');
            $year = date('Y');
        }else if ($time == 'lastmonth') {
            $week = 0;
            $month = date('n')-1;
            $year = date('Y');
            
        }else if ($time == 'thisyear') {
            $week = 0;
            $month = 0;
            $year = date('Y');      
        }
        
        if( (!isset($entries_display)) || ($entries_display == NULL)){ 
            $entries_display = '5'; 
        }
        if (($time == 'thisweek') || ($time == 'lastweek')) {
            $args = array(
                'w'=> $week,
                'year'=> $year,
    			'post_type' => 'post',
    			'ignore_sticky_posts' => 1,
                'cat' => $cat_id,
    			'posts_per_page' => $entries_display,
                'orderby' => 'comment_count',
                'order' => 'DESC'						
            );	
       } else {
            $args = array(
                'w'=> $week,
                'monthnum'=> $month,
                'year'=> $year,
    			'post_type' => 'post',
    			'ignore_sticky_posts' => 1,
                'cat' => $cat_id,
    			'posts_per_page' => $entries_display,
                'orderby' => 'comment_count',
                'order' => 'DESC'
            );		
       }
        
        echo $before_widget;
		if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_html($title) . $after_title;?>
            </div>
        <?php }?>
 
		<?php $latest_posts = new WP_Query( $args ); ?>
		<?php if ( $latest_posts -> have_posts() ) : ?>
			<ul class="list post-list">
				<?php while ( $latest_posts -> have_posts() ) : $latest_posts -> the_post(); ?>	 
                        <li class="small-post content_out clearfix">
                            <div class="post-wrapper">
                                <?php echo bk_core::bk_get_feature_image('bk150_100', true);?>
                                <?php if ( comments_open() ) : ?>
                					<div class="comments">
                						<?php comments_popup_link( esc_html__('0', 'the-rex'), esc_html__('1', 'the-rex'), esc_html__('%', 'the-rex')); ?>
                					</div>		
        				        <?php endif; ?>                   
                                <div class="post-c-wrap">    
                                    <?php echo bk_core::bk_get_post_title(get_the_ID(), 15);?>
                                    <?php echo bk_core::bk_meta_cases('date');?> 
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
        $instance['time'] = $new_instance['time'];
        $instance['category'] = $new_instance['category'];
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$defaults = array('title' => 'Most commented', 'entries_display' => 5, 'sort' => 'comments', 'time' => 'alltime', 'category' => 'all');
		$instance = wp_parse_args((array) $instance, $defaults);
	?>
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php esc_html_e( 'Title:', 'the-rex'); ?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
                
        <p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><strong><?php esc_html_e( 'Number of entries to display: ', 'the-rex'); ?></strong></label>
		<input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo $instance['entries_display']; ?>" style="width:100%;" /></p>
        
        
        <p>     
            <label for="<?php echo $this->get_field_id( 'time' ); ?>"><strong><?php   esc_html_e( 'Time ','the-rex'); ?></strong></label>    		 	
            <select id="<?php echo $this->get_field_id( 'time' ); ?>" name="<?php echo $this->get_field_name( 'time' ); ?>">
                <option value="alltime" <?php if ($instance['time'] == "alltime") echo 'selected="selected"'; ?>><?php esc_html_e( 'All time', 'the-rex');?></option>                          
                <option value="thisweek" <?php if ($instance['time'] == "thisweek") echo 'selected="selected"'; ?>><?php esc_html_e( 'This Week', 'the-rex');?></option>               
                <option value="lastweek" <?php if ($instance['time'] == "lastweek") echo 'selected="selected"'; ?>><?php esc_html_e( 'Last Week', 'the-rex');?></option>                           	
                <option value="thismonth" <?php if ($instance['time'] == "thismonth") echo 'selected="selected"'; ?>><?php esc_html_e( 'This Month', 'the-rex');?></option>               
                <option value="lastmonth" <?php if ($instance['time'] == "lastmonth") echo 'selected="selected"'; ?>><?php esc_html_e( 'Last Month', 'the-rex');?></option>                           	
                <option value="thisyear" <?php if ($instance['time'] == "thisyear") echo 'selected="selected"'; ?>><?php esc_html_e( 'This Year', 'the-rex');?></option>               
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
