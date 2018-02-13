<?php
class bk_contentout1 {
    
    function render($post_args) {
        ob_start();
        ?>
        <div class="feat-img">
            <?php echo bk_core::bk_get_feature_image($post_args['thumbnail_size'], true, $post_args['post_icon']);?>
        </div>
        <div class="post-c-wrap table">
            <div class="table-cell">
                <div class="cell-inner">
                    <?php echo bk_core::bk_get_post_meta($post_args['meta_ar']);?>                                            
                    <?php echo bk_core::bk_get_post_title($post_args['postID'], $post_args['title_length']);?>
                    <div class="post-author">
                        By <?php the_author_posts_link();?>           
                    </div>
                    <?php echo bk_core::bk_get_post_excerpt($post_args['excerpt_length']);?>
                </div>
            </div>            
        </div>
        
        <?php return ob_get_clean();
    }
    
}