<?php 
/**
 * Random Posts Recommend Box. Appears in single.php
**/
global $bk_option;
if(isset($bk_option['recommend-number']) && ($bk_option['recommend-number']) != null) {$entries = $bk_option['recommend-number'];}else {$entries = 3;};
if(isset($bk_option['recommend-categories']) && ($bk_option['recommend-categories'] != null)){ $cat_id = $bk_option['recommend-categories'];} else {$cat_id = 0;};
?>
<?php 
    $render_modules = '';
    $render_modules .= '<div class="widget recommend-box">';

    $render_modules .= '<a class="close" href="#" title="Close"><i class="fa fa-long-arrow-right"></i></a>';
    $render_modules .= '<h3>'.esc_attr($bk_option['recommend-box-title']).'</h3>';
    
    $render_modules .= '<div class="entries">';

       $bk_contentout3 = new bk_contentout3;
       $arg =  array(
            'post_type' => 'post',
            'post__not_in' => array( $post->ID ),
            'category__in' => $cat_id,
            'orderby' => 'rand',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => $entries
        );
        $post_args = array (
            'thumbnail_size'    => 'bk150_100',
            'meta_ar'           => '',
            'title_length'      => 15,
            'post_icon'         => ''
        );
        $bk_random_post = new WP_Query($arg);
        $render_modules .= '<ul class="list-small-post">';
            while ( $bk_random_post->have_posts() ) : $bk_random_post->the_post();
                $post_args['postID'] = get_the_ID();
                $render_modules .= '<li class="small-post content_out clearfix">';
                $render_modules .= $bk_contentout3->render($post_args);
                $render_modules .= '</li><!-- End post -->';        

    endwhile;
    $render_modules .= '</ul> <!-- End list-post -->';
    $render_modules .= '</div>';
    $render_modules .= '</div><!--recommend-box -->';
    echo ($render_modules);
?>