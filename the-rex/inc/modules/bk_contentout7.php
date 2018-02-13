<?php
class bk_contentout7 {
    
    function render($title_length = 15) {
        ob_start();
        $meta_ar = array('cat', 'date');
        echo bk_core::bk_get_feature_image('bk620_420', true);
        ?>
        <div class="post-c-wrap">
            <?php echo bk_core::bk_get_post_title(get_the_ID(), $title_length);?>
            <?php echo bk_core::bk_get_post_meta($meta_ar);?> 
        </div>
        <?php return ob_get_clean();
    }
    
}