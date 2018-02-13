<?php
class bk_contentin2 {
    
    function render($excerpt_length = 10) {
        ob_start();
        $meta_ar = array('cat');
        
        echo bk_core::bk_get_feature_image('bk620_420');?>
        <div class="post-c-wrap">
            <div class="meta-title-wrap">        
                <?php echo bk_core::bk_get_post_meta($meta_ar);?>
                <?php echo bk_core::bk_get_post_title(get_the_ID(), 15);?>
            </div>
        </div>
        
        <?php return ob_get_clean();
    }
    
}