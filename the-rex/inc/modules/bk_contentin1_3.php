<?php
class bk_contentin1_3 {
    
    function render($post_args) {
        ob_start();
        $bkThumbId = get_post_thumbnail_id( $post_args['postID'] );
        $bkThumbUrl = wp_get_attachment_image_src( $bkThumbId, $post_args['thumbnail_size'] );
        echo '<div class="thumb" data-type="background" style="background-image: url('.$bkThumbUrl[0].')"></div>';
        ?>    
        <div class="post-c-wrap">     
            <div class="table">
                <div class="table-cell">      
                    <div class="post-wrapper">
                        <?php echo bk_core::bk_get_post_meta($post_args['meta_ar']);?>
                        <?php echo bk_core::bk_get_post_title($post_args['postID'], $post_args['title_length']);?>
                        <?php echo bk_core::bk_get_post_excerpt($post_args['excerpt_length']);?>
                    </div>
                </div> 
            </div>
        </div>        
        
        <?php return ob_get_clean();
    }
    
}