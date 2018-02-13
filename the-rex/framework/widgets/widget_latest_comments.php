<?php
/**
 * Plugin Name: BK-Ninja: Latest Comments
 * Plugin URI: http://bk-ninja.com/
 * Description: This widhet displays the most recent comments with author avatar in the tabs.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com/
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'bk_register_latest_comments_widget' );

function bk_register_latest_comments_widget() {
	register_widget( 'bk_latest_comments' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_latest_comments extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_latest_comments', 'description' => esc_html__('[Sidebar widget] Displays latest comments in sidebar.', 'the-rex') );

		/* Create the widget. */
		parent::__construct( 'bk_latest_comments', esc_html__('BK-Ninja: Widget Latest Comments', 'the-rex'), $widget_ops);
	}
    
	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title'] );
		$entries_display = esc_attr($instance['entries_display']);
		
		$args = array(
		   'status' => 'approve',
			'number' => $entries_display
		);
		
		echo $before_widget;
		if ( $title ) {?>
            <div class="widget-title-wrap">
                <?php echo $before_title . esc_html($title) . $after_title;?>
            </div>
        <?php }?>
        
		<div class="widget_comment cm-flex">
			<ul class="list comment-list">
				<?php 
					//get recent comments
						
					$comments = get_comments($args);
					
					foreach($comments as $comment) :							
							$commentcontent = strip_tags($comment->comment_content);			
                            $commentcontent = bk_core::bk_the_excerpt_limit_by_word($commentcontent,10);

                            
							$commentauthor = $comment->comment_author;
							$commentauthor = bk_core::bk_the_excerpt_limit_by_word($commentauthor,10);		

							$commentid = $comment->comment_ID;
							$commenturl = get_comment_link($commentid); 
                            
                            $bk_postid = $comment->comment_post_ID;
                            $title = get_the_title($bk_postid);
                            $short_title = bk_core::bk_the_excerpt_limit_by_word($title,10);
		                   ?>
                            <li class="clearfix">
                                <div class="author-comment-wrap">
                                    <div class="cm-header">                              
                                		<div class="avatar">
                                			<?php echo get_avatar( $comment, '20' ); ?>
                                		</div>                                 
                                
                                        <div class="author-name">
                                            <?php echo esc_attr($commentauthor); ?>
                                        </div>
                                        <span>on</span>
                                        <div class="date">
                                            <?php echo (get_comment_date('', $commentid)); ?>
                                        </div>
                                    </div>   
                                    <div class="comment-text">
                                		<a href="<?php echo esc_url($commenturl); ?>"><?php echo esc_attr($commentcontent); ?></a>
                                	</div>
                                    <h4 class="post-title">
                                        <a href="<?php echo get_permalink($bk_postid) ?>">-  <?php echo esc_attr($short_title); ?></a>
                                    </h4>
                                </div>
                            </li>
				<?php endforeach; ?>
			</ul>
		</div>
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
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$defaults = array('title' => 'Latest Comments', 'entries_display' => 5);
		$instance = wp_parse_args((array) $instance, $defaults);
	?>
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php esc_html_e( 'Title:', 'the-rex'); ?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
        <p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><strong><?php esc_html_e( 'Number of entries to display: ', 'the-rex'); ?></strong></label>
		<input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo esc_attr($instance['entries_display']); ?>" style="width:100%;" /></p>        

<?php
	}
}
?>
