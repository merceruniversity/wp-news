<?php
class bk_contentout3 {
    
    function render($post_args) {
        ob_start();
        echo bk_core::bk_get_feature_image($post_args['thumbnail_size'], true);
        ?>
        <div class="post-c-wrap">
            <?php echo bk_core::bk_get_post_meta(array('cat', 'review'));?>
            <?php echo bk_core::bk_get_post_title($post_args['postID'], $post_args['title_length']);?>
            <?php echo bk_core::bk_meta_cases('date');?>
        </div>
        <?php return ob_get_clean();
    }
    
}