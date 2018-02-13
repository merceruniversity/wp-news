<?php
class bk_contentin3 {
    
    function render($post_args) {
        ob_start();
        
        echo bk_core::bk_get_feature_image($post_args['thumbnail_size'], true, $post_args['post_icon']);?>
        <div class="bk-calendar-meta bk-hide-calendar">
            <div class="day"><?php echo get_the_date('j'); ?></div>
            <div class="month"><?php echo get_the_date('M'); ?></div>
        </div>
        <div class="post-c-wrap">        
            <?php echo bk_core::bk_get_post_meta($post_args['meta_ar']);?>
            <?php echo bk_core::bk_get_post_title($post_args['postID'], $post_args['title_length']);?>
        </div>
        
        <?php return ob_get_clean();
    }
    
}