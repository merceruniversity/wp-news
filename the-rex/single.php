<?php 
    //echo (preg_replace('/[^A-Za-z0-9]/', '', $_SERVER["REQUEST_URI"]));
    $bk_uri = explode('/', $_SERVER["REQUEST_URI"]);
    $bkcookied = 0;
    $cookietime = 30*60;
    if($bk_uri[count($bk_uri) - 1] !== '') {
        $cookie_name = preg_replace('/[^A-Za-z0-9]/', '', $bk_uri[count($bk_uri) - 1]);
    }else {
        $cookie_name = preg_replace('/[^A-Za-z0-9]/', '', $bk_uri[count($bk_uri) - 2]);
    }
    if(!isset($_COOKIE[$cookie_name])) {
        setcookie($cookie_name, '1', time() + $cookietime);  /* expire in 1 hour */
        $bkcookied = 1;
    }else {
        $bkcookied = 0;
    }
?>
<?php get_header(); ?>
<?php 
    $social_share = array();
    $share_box = $bk_option['bk-sharebox-sw'];
    if ($share_box){
        $social_share['fb'] = $bk_option['bk-fb-sw'];
        $social_share['tw'] = $bk_option['bk-tw-sw'];
        $social_share['gp'] = $bk_option['bk-gp-sw'];
        $social_share['pi'] = $bk_option['bk-pi-sw'];
        $social_share['stu'] = $bk_option['bk-stu-sw'];
        $social_share['li'] = $bk_option['bk-li-sw'];
    }
    $authorbox_sw = $bk_option['bk-authorbox-sw'];
    $postnav_sw = $bk_option['bk-postnav-sw'];
    $related_sw = $bk_option['bk-related-sw'];
    $comment_sw = $bk_option['bk-comment-sw'];
?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php 
                $bkPostID = get_the_ID();  
                if ($bkcookied == 1) {
                    bk_core::bk_setPostViews($bkPostID);
                }                      
                $bkReviewSW = get_post_meta($bkPostID,'bk_review_checkbox',true);
                $postFormat = bk_core::bk_post_format_detect($bkPostID);
                if($bkReviewSW == '1') {
                    $reviewPos = get_post_meta($bkPostID,'bk_review_box_position',true);
                }
                $bkPostLayout = get_post_meta($bkPostID,'bk_post_layout',true);
                if(isset($bkPostLayout)){
                    if ($bkPostLayout == 'parallax') {
                        $bk_post_layout = 'bk-parallax-feat';
                    }else if($bkPostLayout == 'fullwidth'){
                        $bk_post_layout = 'bk-fw-feat';
                    }else {
                        $bk_post_layout = 'bk-normal-feat';
                    }
                }else {
                    $bk_post_layout = 'bk-normal-feat';
                }
                $sidebar_option = '';
                $sidebar_option = get_post_meta($bkPostID,'bk_post_sb_select',true);
            ?>
        <div class="single-page <?php if ($bk_post_layout != 'bk-normal-feat') echo 'bk-fullwidth';?>" <?php if ( $bkReviewSW != '1' ) { echo 'itemscope itemtype="http://schema.org/Article"'; } else { echo 'itemscope itemtype="http://schema.org/Review"'; } ?>>
            <?php if (($bk_post_layout === 'bk-parallax-feat') || ($bk_post_layout === 'bk-fw-feat')) {?>
                <?php echo bk_core::bk_single_fw_image($bkPostID, $bk_post_layout);?>
            <?php }?>
            <div class="article-wrap bkwrapper container">
                <div class="row bk-in-single-page bksection">
                    <div class="main <?php if ($sidebar_option != 'disable') {echo 'col-md-8';}else {echo 'col-md-12';}?>">
                        <div class="article-content clearfix" <?php if ( $bkReviewSW == '1' ) { echo 'itemprop="reviewBody"'; } else { echo 'itemprop="articleBody"'; } ?>>
                            <?php 
                            if (($bk_post_layout !== 'bk-parallax-feat') && ($bk_post_layout !== 'bk-fw-feat')) {
                                $meta_ar = array('cat', 'author', 'date', 'postview', 'postcomment');
                                if ( $bkReviewSW == '1' ) { $itemprop =  'itemprop="itemReviewed"'; } else { $itemprop = 'itemprop="headline"'; }
                                $bk_post_header = '';
                                $bk_post_header .= '<div class="s_header_wraper bk-standard-layout"><div class="s-post-header container"><h1 '.$itemprop.'>'.get_the_title().'</h1>';
                                $bk_post_header .= bk_core::bk_get_post_meta($meta_ar);
                                $bk_post_header .= bk_core::bk_share_box($bkPostID, $social_share);
                                $bk_post_header .= '</div></div><!-- end single header -->';
                                echo $bk_post_header;
                            }?>
                            <?php echo bk_core::bk_post_format_display($bkPostID, $bk_post_layout);?>
<!-- ARTICAL CONTENT -->
                            <?php if(isset($reviewPos) && ($reviewPos != 'below')) {?>
                            <?php echo bk_core::bk_post_review_boxes($bkPostID, $reviewPos);?>
                            <?php }?>
                            <?php echo bk_core::bk_single_content($bkPostID);?>
                            <?php if(isset($reviewPos) && ($reviewPos == 'below')) {?>
                            <?php echo bk_core::bk_post_review_boxes($bkPostID, $reviewPos);?>
                            <?php }?>
                        </div><!-- end article content --> 
                    <?php wp_link_pages( array(
							'before' => '<div class="post-page-links">',
							'pagelink' => '<span>%</span>',
							'after' => '</div>',
						)
					 ); 
                    ?>
<!-- TAGS -->
                    <?php
            			$tags = get_the_tags();
                        if ($tags): 
                            echo bk_core::bk_single_tags($tags);
                        endif; 
                    ?>
<!-- SHARE BOX -->
                    <?php if ($share_box) {?>        
                        <div class="bk-share-box-bottom">                                                        
                        <?php echo bk_core::bk_share_box($bkPostID, $social_share);?>
                        </div>
                    <?php }?>
<!-- NAV -->
                    <?php
                        if($postnav_sw) {   
                            $next_post = get_next_post();
                            $prev_post = get_previous_post();
                            if (!empty($prev_post) || !empty($next_post)): ?> 
                                <?php echo bk_core::bk_single_post_nav($next_post, $prev_post);?>
                            <?php endif; ?>
                        <?php }?>
<!-- AUTHOR BOX -->
                    <?php if ($authorbox_sw) {?>
                    <?php
                        $bk_author_id = $post->post_author;
                        echo bk_core::bk_author_details($bk_author_id);
                    ?>
                    <?php }?> 
                    <?php
                        echo bk_core::bk_get_article_info(get_the_ID(), $bk_author_id);
                    ?>
<!-- RELATED POST -->
                    <?php if ($related_sw){?>  
                        <div class="related-box">
                            <h3><?php esc_html_e('Related articles', 'the-rex');?></h3>
                            <?php $bk_related_num = 4; echo (bk_core::bk_related_posts($bk_related_num));?>
                        </div>
                    <?php }?>
<!-- COMMENT BOX -->
                    <?php if($comment_sw  && (comments_open())) {?>
                        <div class="comment-box clearfix">
                            <?php comments_template(); ?>
                        </div> <!-- End Comment Box -->
                    <?php }?>
                    </div>
                    <?php if ($bk_option['bk-recommend-box'] == 1) {?>
                        <?php get_template_part( 'library/bk_recommend_box');?>
                    <?php }?>
                    <!-- Sidebar -->
                    <?php if ($sidebar_option != 'disable') {?>
                    <div class="sidebar col-md-4">
                        <div class="sidebar-wrap <?php if($bk_option['single-stick-sidebar'] == 'enable') echo 'stick';?>" id="bk-single-sidebar">
                            <div class="sidebar-wrap-inner">
                                <?php                                
                                    if (($sidebar_option != '')&&($sidebar_option != 'global')) {
                                        $sidebar = $sidebar_option;
                                    }else if((isset($bk_option['single-page-sidebar'])) && ($bk_option['single-page-sidebar'] != '')){
                                        $sidebar = $bk_option['single-page-sidebar'];
                                    }else {
                                        $sidebar = '';
                                    }
                                    if (strlen($sidebar)) {
                                        dynamic_sidebar($sidebar);
                                    }else {
                                        dynamic_sidebar('home_sidebar');
                                    }                                                   
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    
	<?php endwhile; endif;?>
<?php get_footer(); ?>