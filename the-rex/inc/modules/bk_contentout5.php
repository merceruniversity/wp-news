<?php
class bk_contentout5 {
    
    function render($post_args) {
        ob_start();
        ?>
        <div class="bk-mask">
            <?php echo bk_core::bk_get_feature_image($post_args['thumbnail_size'], true, $post_args['post_icon']);?>
        </div>
        <div class="bk-calendar-meta bk-hide-calendar">
            <div class="day"><?php echo get_the_date('j'); ?></div>
            <div class="month"><?php echo get_the_date('M'); ?></div>
        </div>
        <div class="post-c-wrap">
            <?php echo bk_core::bk_get_post_title($post_args['postID'], $post_args['title_length']);?>
            <?php echo bk_core::bk_get_post_meta( $post_args['meta_ar'] );?>
            <?php echo bk_core::bk_get_post_excerpt($post_args['excerpt_length']);?>  
            <?php echo bk_core::bk_readmore_btn($post_args['postID']);?>        
        </div>
        <?php return ob_get_clean();
    }
    
}