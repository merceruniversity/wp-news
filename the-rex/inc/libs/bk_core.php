<?php
if (!class_exists('bk_core')) {
    class bk_core {
        static function bk_get_article_info($bkPostId, $bk_author_id){  
            $article_info = '';
            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $bkPostId ), 'full' );
            $article_info .= '<meta itemprop="author" content="'.get_the_author_meta('display_name', $bk_author_id).'">';
            $article_info .= '<meta itemprop="headline " content="'.get_the_title($bkPostId).'">';
            $article_info .= '<meta itemprop="datePublished" content="'.date(DATE_W3C, get_the_time('U', $bkPostId)).'">';
            $article_info .= '<meta itemprop="image" content="'.esc_attr( $thumbnail_src[0] ).'">';
            $article_info .= '<meta itemprop="interactionCount" content="UserComments:' . get_comments_number($bkPostId) . '"/>';
            return $article_info;
        }
        /**
         * ************* Post Views *********************
         *---------------------------------------------------
         */ 
        static function bk_getPostViews($postID){
            $count_key = 'post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            if($count==''){
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
                return "0";
           }
           return $count;
        }
        static function bk_setPostViews($postID){
            $count_key = 'post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            if($count==''){
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            }else{
                $count++;
                update_post_meta($postID, $count_key, $count);
            }
            return false;   
        }
        static function bk_get_block_title($page_info){  
            $block_title = '';
            $title = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );
            $sub_title = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_sub_title', true ); 
            if(strlen($title)!=0) {
                $block_title .= '<div class="module-title">';
                $block_title .= '<div class="main-title"><h2>'.$title.'</h2></div>';
                $block_title .= '<div class="sub-title"><p>'.$sub_title.'</p></div>';
    			$block_title .= '</div>';
            }
            return $block_title;
        }
    
        static function bk_get_feature_image($thumbSize, $clickable = '', $post_icon = ''){
            $feat_img = '';
            $feat_img .= '<div class="thumb hide-thumb">';
            if($clickable == true) {
                $feat_img .= '<a href="'.get_permalink(get_the_ID()).'">';
            }
            if(has_post_thumbnail( get_the_ID() )) {
                $feat_img .= get_the_post_thumbnail(get_the_ID(), $thumbSize);
            }else {
                $feat_img .= '<img width="684" height="452" src="'.get_template_directory_uri().'/images/bkdefault684_452.jpg">';
            }
            if ($post_icon === 'show') {
                $feat_img .=  bk_core::bk_get_post_icon(get_the_ID());
            }
            if($clickable == true) {
                $feat_img .= '</a> <!-- close a tag -->';
            }
            $feat_img .= '</div> <!-- close thumb -->';
            return $feat_img;
        }
     
        static function bk_get_post_icon ($bkPostID) {
            $str_ret = '';
            $postformat = get_post_format( $bkPostID );
            switch($postformat) {
                case "video":
                    $str_ret = '<span><i class="fa fa-play post-icon video-icon"></i></span>';
                    break;
                case "audio":
                    $str_ret = '<span><i class="fa fa-volume-up post-icon audio-icon"></i></span>';
                    break;
                case "gallery":
                    $str_ret = '<span><i class="fa fa-picture-o post-icon gallery-icon"></i></span>';
                    break;
                default:
                    $str_ret = '';
                    break;
            }
            return $str_ret;
        }
        static function bk_meta_cases( $meta_type ) {
            $bk_meta = $meta_type;
            $bk_meta_str = '';
            switch ($bk_meta) {
                case "review":
                    $bk_final_score = get_post_meta(get_the_ID(), 'bk_final_score', true );
                    if (isset($bk_final_score) && ($bk_final_score != null)){
                        $bk_meta_str .= '<div class="review-score"><span>';
                        $bk_meta_str .= $bk_final_score;
                        $bk_meta_str .= '</span></div>';
                    }
                    break;
                case "cat":
                    $bk_meta_str .= '<div class="post-category">';
                    $bk_meta_str .= bk_get_category_link(get_the_ID());
                    $bk_meta_str .= '</div>';
                    break;
                case "date":
                    $bk_meta_str .= '<div class="post-date" itemprop="datePublished"><i class="fa fa-clock-o"></i>';
                    $bk_meta_str .=  get_the_date('', get_the_ID());
                    $bk_meta_str .= '</div>';
                    break;
                case "author":
                    $bk_meta_str .=  '<div class="post-author" itemprop="author">';
                    $bk_meta_str .=  esc_html__('By ', 'the-rex').'<a href="'. get_author_posts_url(get_the_author_meta( 'ID' )).'">'. get_the_author() .'</a>';          
                    $bk_meta_str .=  '</div>';
                    break;
                case "bg":
                    $thumb130 = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'bk130_130');
                    $bk_meta_str .=  '<div class="meta-bg" style="background-image:url('.$thumb130['0'].');background-size:cover;background-position:50% 50%;background-repeat:no-repeat;"></div>';
                    break;
                case "postview":
                    $bk_meta_str .=  '<div class="views"><i class="fa fa-eye"></i>'.self::bk_getPostViews(get_the_ID()).'</div>';
                    break;
                case "postcomment":
                    $bk_meta_str .=  '<div class="comments"><i class="fa fa-comment-o"></i>'.get_comments_number(get_the_ID()).'</div>';
                    break;
                default:
                    echo "No Case Matched!";
            }
            return $bk_meta_str;
        }
    
        static function bk_get_post_meta( $meta_arg ) {
            $bk_meta = '';
            $bk_meta .= '<div class="meta">';
            if ((isset($meta_arg[0])) && ($meta_arg[0] != null)) {
                $bk_meta .= self::bk_meta_cases($meta_arg[0]);
            }
            if ((isset($meta_arg[1])) && ($meta_arg[1] != null)) {
                $bk_meta .= self::bk_meta_cases($meta_arg[1]);
            }
            if ((isset($meta_arg[2])) && ($meta_arg[2] != null)) {
                $bk_meta .= self::bk_meta_cases($meta_arg[2]);
            }
            if ((isset($meta_arg[3])) && ($meta_arg[3] != null)) {
                $bk_meta .= self::bk_meta_cases($meta_arg[3]);
            }
            if ((isset($meta_arg[4])) && ($meta_arg[4] != null)) {
                $bk_meta .= self::bk_meta_cases($meta_arg[4]);
            }
            if ((isset($meta_arg[5])) && ($meta_arg[5] != null)) {
                $bk_meta .= self::bk_meta_cases($meta_arg[5]);
            }
            $bk_meta .= '</div>';
            return $bk_meta;
        }
        
        static function bk_the_excerpt_limit_by_word($string, $word_limit){
            $words = explode(' ', $string, ($word_limit + 1));
            if(count($words) > $word_limit)
            array_pop($words);
            $strout = implode(' ', $words);
            if (strlen($strout) < strlen($string))
                $strout .=" ...";
            return $strout;
        }
        
        static function bk_get_post_title ($bkPostId, $length){
            $bk_title = '';
            $bk_title .= '<h4 class="title">';
            $bk_title .= self::bk_get_title_link($bkPostId, $length);
            $bk_title .= '</h4>';
            return $bk_title;
        }
        
        static function bk_get_title_link( $bkPostId, $length ) {
            $titleLink = '';
            $titleLink .= '<a href="'.get_permalink($bkPostId).'">';
            if($length != null) {
                $titleLink .= self::bk_the_excerpt_limit_by_word(get_the_title($bkPostId),$length);
            }else {
                $titleLink .= get_the_title($bkPostId);
            }
            $titleLink .= '</a>';
            return $titleLink;
        }
        
        static function bk_get_post_excerpt($length) {
            $bk_excerpt = '';
            $the_excerpt = get_the_excerpt();
            $bk_excerpt .= '<div class="excerpt">';
            $bk_excerpt .= self::bk_the_excerpt_limit_by_word($the_excerpt, $length); 
            $bk_excerpt .= '</div>';
            return $bk_excerpt;
        }
        static function bk_readmore_btn($bkPostId, $icon = '') {
            $readmore = '';
            $readmore .= '<div class="readmore">';
            if($icon != null) {
                $readmore .= $icon;
            }
            $readmore .= '<a href="'.get_permalink($bkPostId).'">'.esc_html__("Read More", "the-rex").'</a>';
            $readmore .= '</div>';
            return $readmore;
        }
        
        static function bk_get_review_score($bk_final_score) {
            $bk_review = '';
            if (isset($bk_final_score) && ($bk_final_score != null)){
                $bk_review .= '<div class="review-score">';
                $bk_review .= $bk_final_score;
                $bk_review .= '</div>';
            }
            return $bk_review;
        }
    //Single Function
    /**
     * Video Post Format
     */
        static function bk_get_video_postFormat($postFormat) { 
            $videoFormat = '';
            if ($postFormat['url'] != null) {
                $videoFormat .= '<div class="bk-embed-video">';
                $videoFormat .= '<div class="bk-frame-wrap">';
                $videoFormat .= $postFormat['iframe'];
                $videoFormat .= '</div></div> <!-- End embed-video -->';
            }else {
                $videoFormat .= '';
            }
            return $videoFormat;
        }
    /**
     * Audio Post Format
     */
        static function bk_get_audio_postFormat($bkPostId, $postFormat, $audioType) { 
            $audioFormat = '';
            if ($postFormat['url'] != null) {
                preg_match('/src="([^"]+)"/', wp_oembed_get( $postFormat['url'] ), $match);
                if(isset($match[1])) {
                    $bkNewURL = $match[1];
                }else {
                    return null;
                }
                $audioFormat .= '<div class="bk-embed-audio"><div class="bk-frame-wrap">';
                $audioFormat .= wp_oembed_get( $postFormat['url'] );
                $audioFormat .= '</div></div>';
            }else {
                $audioFormat .= '';
            }
            return $audioFormat;
        }
     /**
     * Gallery Post Format
     */
        static function bk_get_gallery_postFormat($galleryImages) { 
            $galleryFormat = '';
            $galleryFormat .= '<div class="gallery-wrap">';
            $galleryFormat .= '<div id="bk-gallery-slider" class="flexslider">';
            $galleryFormat .= '<ul class="slides">';
            foreach ( $galleryImages as $image ){
                $attachment_url = wp_get_attachment_image_src($image['ID'], 'full', true);
                $attachment = get_post($image['ID']);
                $caption = apply_filters('the_title', $attachment->post_excerpt);
                $galleryFormat .= '<li class="bk-gallery-item">';
                    $galleryFormat .= '<a class="zoomer" title="'.$caption.'" data-source="'.$attachment_url[0].'" href="'.$attachment_url[0].'">'.wp_get_attachment_image($attachment->ID, 'bk620_420').'</a>';
                    if (strlen($caption) > 0) {
                        $galleryFormat .= '<div class="caption">'.$caption.'</div>';
                    }
                $galleryFormat .= '</li>';
            }
            $galleryFormat .= '</ul></div></div><!-- Close gallery-wrap -->';
            return $galleryFormat; 
        }
     /**
     * Image Post Format
     */
        static function bk_get_image_postFormat($bkPostId) { 
            $attachmentID = get_post_meta($bkPostId, 'bk_image_upload', true );
            $thumb_url = wp_get_attachment_image_src($attachmentID, true);
            $imageFormat = '';
            $imageFormat .= '<div class="image-post-format"><img src="'.$thumb_url[0].'"></div>'; 
            return $imageFormat;
        }
    /**
     * Standard Post Format
     */
        static function bk_get_standard_postFormat($bkPostId) { 
            $imageFormat = '';
            $imageFormat .= '<div class="s-feat-img">'.get_the_post_thumbnail($bkPostId, 'bk750_375').'</div>';
            return $imageFormat;        
        }
    /**
     * Post Format Detect
     */
        static function bk_post_format_detect($bkPostId) { 
            $bk_format = array();
    /** Video Post Format **/
            if(function_exists('has_post_format') && ( get_post_format( $bkPostId ) == 'video')){
                $bkURL = get_post_meta($bkPostId, 'bk_media_embed_code_post', true);
                $bkUrlParse = parse_url($bkURL);
                $bk_format['format'] = 'video';
                if (isset($bkUrlParse['host']) && (($bkUrlParse['host'] == 'www.youtube.com')||($bkUrlParse['host'] == 'youtube.com'))) { 
                    $video_id = self::bk_parse_youtube($bkURL);
                    $bk_format['iframe'] = '<iframe width="1050" height="591" src="//www.youtube.com/embed/'.$video_id.'" allowFullScreen ></iframe>';
                    $bk_format['url'] = $bkURL;
                }else if (isset($bkUrlParse['host']) && (($bkUrlParse['host'] == 'www.vimeo.com')||($bkUrlParse['host'] == 'vimeo.com'))) {
                    $video_id = self::bk_parse_vimeo($bkURL);
                    $bk_format['iframe'] = '<iframe src="//player.vimeo.com/video/'.$video_id.'?api=1&amp;title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff"></iframe>';
                    $bk_format['url'] = $bkURL;
                }else {
                    $bk_format['iframe'] = null;
                    $bk_format['url'] = null;
                    $bk_format['notice'] = esc_html__('please put youtube or vimeo video link to the video post format section', 'the-rex');
                }
            }
    /** Audio Post Format **/        
            else if(function_exists('has_post_format') && (has_post_format('audio'))) {
                $bkURL = get_post_meta($bkPostId, 'bk_media_embed_code_post', true);
                $bkUrlParse = parse_url($bkURL);
                $bk_format['format'] = 'audio';
                if (isset($bkUrlParse['host']) && (($bkUrlParse['host'] == 'www.soundcloud.com')||($bkUrlParse['host'] == 'soundcloud.com'))) { 
                    $bk_format['url'] = $bkURL;
                }else {
                    $bk_format['url'] = null;
                }
            }
    /** Gallery post format **/
            else if( function_exists('has_post_format') && has_post_format( 'gallery') ) {
                $bk_format['format'] = 'gallery';
            }
    /** Image Post Format **/
            else if( function_exists('has_post_format') && has_post_format( 'image') ) {
                $bk_format['format'] = 'image';
            }
    /** Standard Post **/
            else {
                $bk_format['format'] = 'standard';
            }
            return $bk_format;
            
        }
    
    /**
     * ************* Display Post format *****************
     *---------------------------------------------------
     */ 
    
        static function bk_post_format_display($bkPostId, $bk_post_layout) { 
            global $bk_option;
            $single_img = $bk_option['bk-single-featimg'];
            $postFormat = array();
            $postFormat = self::bk_post_format_detect($bkPostId);
            $postFormatOut = '';
    /** Video **/
            if($postFormat['format'] == 'video') {
                $postFormatOut .= self::bk_get_video_postFormat($postFormat);
            }
    /** Audio **/
            else if($postFormat['format'] == 'audio') {
                $postFormatOut .= self::bk_get_audio_postFormat($bkPostId, $postFormat, null);
            }
    /** Gallery **/
            else if($postFormat['format'] == 'gallery') {
                $galleryImages = rwmb_meta( 'bk_gallery_content', $args = array('type' => 'image'), $bkPostId );
                $galleryLength = count($galleryImages); 
                if ($galleryLength == 0) {
                    return null;
                }else {
                    $postFormatOut .= self::bk_get_gallery_postFormat($galleryImages);
                }
            }
    /** Image **/
            else if($postFormat['format'] == 'image') {
                $attachmentID = get_post_meta($bkPostId, 'bk_image_upload', true );
                $thumb_url = wp_get_attachment_image_src($attachmentID, true);
                if(isset($thumb_url[0])) {
                    $postFormatOut .= self::bk_get_image_postFormat($bkPostId);
                }
            }
    /** Standard **/
            else if(($single_img) && ($postFormat['format'] == 'standard') && ($bk_post_layout == 'bk-normal-feat')) {
                $postFormatOut .= self::bk_get_standard_postFormat($bkPostId);
            }else {
                $postFormatOut .= '';
            }
            return $postFormatOut;
            
        }
    /**
     * Single Tags
     */
        static function bk_single_tags($tags) {
            $single_tags = '';
            $single_tags .= '<div class="s-tags">';
            $single_tags .= '<span>'.esc_html__('Tags', 'the-rex').'</span>';
        		foreach ($tags as $tag):
        			$single_tags .= '<a href="'. get_tag_link($tag->term_id) .'" title="'. esc_attr(sprintf(esc_html__("View all posts tagged %s","the-rex"), $tag->name)) .'">'. $tag->name.'</a>';
        		endforeach;
            $single_tags .= '</div>';
            return $single_tags;
        }
    /**
     * Post Navigation
     */
    static function bk_single_post_nav($next_post, $prev_post){
        $post_nav = '';
        $post_nav .= '<div class="s-post-nav clearfix">';  
        if (!empty($prev_post)):
            $post_nav .= '<div class="nav-btn nav-prev">';
    		$post_nav .= '<div class="nav-title clearfix">';
            $post_nav .= '<span class="icon"><i class="fa fa-long-arrow-left"></i></span>';
            $post_nav .= '<span>'.esc_html__("Previous Article","the-rex").'</span>';
            $post_nav .= '<h3>';
            $post_nav .= '<a href="'.get_permalink( $prev_post->ID ).'">'.self::bk_the_excerpt_limit_by_word(get_the_title($prev_post->ID),7).'</a>';
            $post_nav .= '</h3>';
            $post_nav .= '</div></div>';
		endif;
        if (!empty($next_post)):
            $post_nav .= '<div class="nav-btn nav-next">';
            $post_nav .= '<div class="nav-title clearfix">';
            $post_nav .= '<span class="icon"><i class="fa fa-long-arrow-right"></i></span>';
            $post_nav .= '<span>'.esc_html__("Next Article","the-rex").'</span>';
            $post_nav .= '<h3>';
            $post_nav .= '<a href="'.get_permalink( $next_post->ID ).'">'.self::bk_the_excerpt_limit_by_word(get_the_title($next_post->ID),7).'</a>';
            $post_nav .= '</h3>';
            $post_nav .= '</div></div>';
        endif;                
        $post_nav .= '</div>';
        return $post_nav;
    }     
    /**
    * ************* Author box *****************
    *---------------------------------------------------
    */  
        static function bk_author_details($bk_author_id, $bk_desc = true) {
            
            $bk_author_email = get_the_author_meta('publicemail', $bk_author_id);
            $bk_author_name = get_the_author_meta('display_name', $bk_author_id);
            $bk_author_tw = get_the_author_meta('twitter', $bk_author_id);
            $bk_author_go = get_the_author_meta('googleplus', $bk_author_id);
            $bk_author_fb = get_the_author_meta('facebook', $bk_author_id);
            $bk_author_yo = get_the_author_meta('youtube', $bk_author_id);
            $bk_author_www = get_the_author_meta('url', $bk_author_id);
            $bk_author_instagram = get_the_author_meta('instagram', $bk_author_id);
            $bk_author_desc = get_the_author_meta('description', $bk_author_id);
            $bk_author_posts = count_user_posts( $bk_author_id ); 
        
            $bk_author = NULL;
            $bk_author .= '<div class="bk-author-box clearfix"><div class="bk-author-avatar"><a href="'.get_author_posts_url($bk_author_id).'">'. get_avatar($bk_author_id, '75').'</a></div><div class="author-info" itemprop="author"><h3><a href="'.get_author_posts_url($bk_author_id).'">'.$bk_author_name.'</a></h3>';
                                
            if (($bk_author_desc != NULL) && ($bk_desc == true)) { $bk_author .= '<p class="bk-author-bio">'. $bk_author_desc .'</p>'; }                    
            if (($bk_author_email != NULL) || ($bk_author_www != NULL) || ($bk_author_tw != NULL) || ($bk_author_go != NULL) || ($bk_author_fb != NULL) ||($bk_author_yo != NULL)) {$bk_author .= '<div class="bk-author-page-contact">';}
            if ($bk_author_email != NULL) { $bk_author .= '<a class="bk-tipper-bottom" data-title="Email" href="mailto:'. $bk_author_email.'"><i class="fa fa-envelope " title="'.esc_html__('Email', 'the-rex').'"></i></a>'; } 
            if ($bk_author_www != NULL) { $bk_author .= ' <a class="bk-tipper-bottom" data-title="Website" href="'. $bk_author_www .'" target="_blank"><i class="fa fa-globe " title="'.esc_html__('Website', 'the-rex').'"></i></a> '; } 
            if ($bk_author_tw != NULL) { $bk_author .= ' <a class="bk-tipper-bottom" data-title="Twitter" href="//www.twitter.com/'. $bk_author_tw.'" target="_blank" ><i class="fa fa-twitter " title="Twitter"></i></a>'; } 
            if ($bk_author_go != NULL) { $bk_author .= ' <a class="bk-tipper-bottom" data-title="Google Plus" href="'. $bk_author_go .'" rel="publisher" target="_blank"><i title="Google+" class="fa fa-google-plus " ></i></a>'; }
            if ($bk_author_fb != NULL) { $bk_author .= ' <a class="bk-tipper-bottom" data-title="Facebook" href="'.$bk_author_fb. '" target="_blank" ><i class="fa fa-facebook " title="Facebook"></i></a>'; }
            if ($bk_author_yo != NULL) { $bk_author .= ' <a class="bk-tipper-bottom" data-title="Youtube" href="http://www.youtube.com/user/'.$bk_author_yo. '" target="_blank" ><i class="fa fa-youtube " title="Youtube"></i></a>'; }
            if ($bk_author_instagram != NULL) { $bk_author .= ' <a class="bk-tipper-bottom" data-title="Instagram" href="'. $bk_author_instagram .'" rel="publisher" target="_blank"><i title="Instagram" class="fa fa-instagram " ></i></a>'; }
            if (($bk_author_email != NULL) || ($bk_author_www != NULL) || ($bk_author_go != NULL) || ($bk_author_tw != NULL) || ($bk_author_fb != NULL) ||($bk_author_yo != NULL)) {$bk_author .= '</div>';}                          
            
            $bk_author .= '</div></div><!-- close author-infor-->';
                 
            return $bk_author;
        }
    /**
     * ************* Related Post *****************
     *---------------------------------------------------
     */            
        static function bk_related_posts($bk_number_related) {
            global $post;
            $bkPostId = $post->ID;
            if (is_attachment() && ($post->post_parent)) { $bkPostId = $post->post_parent; };
            $i = 1;
            $bk_related_posts = array();
            $bk_relate_tags = array();
            $bk_relate_categories = array();
            $excludeid = array();
            $bk_number_related_remain = 0;
            array_push($excludeid, $bkPostId);
    
            $bk_tags = wp_get_post_tags($bkPostId);
            $tag_length = sizeof($bk_tags);                               
            $bk_tag_check = $bk_all_cats = NULL;
            $bk_related_output = '';
     
     // Get tag post
            if ($tag_length > 0){
                foreach ( $bk_tags as $bk_tag ) { $bk_tag_check .= $bk_tag->slug . ','; }             
                    $bk_related_args = array(   'numberposts' => $bk_number_related, 
                                                'tag' => $bk_tag_check, 
                                                'post__not_in' => $excludeid,
                                                'post_status' => 'publish',
                                                'orderby' => 'rand'  );
                $bk_relate_tags_posts = get_posts( $bk_related_args );
                $bk_number_related_remain = $bk_number_related - sizeof($bk_relate_tags_posts);
                if(sizeof($bk_relate_tags_posts) > 0){
                    foreach ( $bk_relate_tags_posts as $bk_relate_tags_post ) {
                        array_push($excludeid, $bk_relate_tags_post->ID);
                        array_push($bk_related_posts, $bk_relate_tags_post);
                    }
                }
            }
     // Get categories post
            $bk_categories = get_the_category($bkPostId);  
            $category_length = sizeof($bk_categories);       
            if ($category_length > 0){       
                foreach ( $bk_categories as $bk_category ) { $bk_all_cats .= $bk_category->term_id  . ','; }
                    $bk_related_args = array(  'numberposts' => $bk_number_related_remain, 
                                            'category' => $bk_all_cats, 
                                            'post__not_in' => $excludeid, 
                                            'post_status' => 'publish', 
                                            'orderby' => 'rand'  );
                $bk_relate_categories = get_posts( $bk_related_args );
    
                if(sizeof($bk_relate_categories) > 0){
                    foreach ( $bk_relate_categories as $bk_relate_category ) {
                        array_push($bk_related_posts, $bk_relate_category);
                    }
                }
            }
            if ( $bk_related_posts != NULL ) {
                $meta_ar = array('cat', 'date');
                
                $bk_related_output .= '<div class="bk-related-posts">';
                $bk_related_output .= '<ul class="related-posts row clearfix">';                                            
                    foreach ( $bk_related_posts as $key => $post ) { //setup global post
                        if($key > ($bk_number_related - 1))
                            break;                                   
                        setup_postdata($post);
                        $bk_related_output .= '<li class="item small-post content_out col-md-6 col-sm-6">';
                        $bk_related_output .= self::bk_get_thumbnail($post->ID, 'bk150_100');
                        $bk_related_output .= '<div class="post-c-wrap">';
                        $bk_related_output .= self::bk_meta_cases('cat');
                        $bk_related_output .= '<h4><a href='.get_the_permalink().'>'.get_the_title().'</a></h4>';
                        $bk_related_output .= self::bk_meta_cases('date');
                        $bk_related_output .= '</div>';
                        $bk_related_output .= '</li>';
                    }
                $bk_related_output .= '</ul>';
                $bk_related_output .= '</div>';
                wp_reset_postdata();    
                return $bk_related_output;
            }    
        }
        static function bk_get_thumbnail($bkPostId, $thumb_type) {
            $bk_thumb_output = '';
            $bk_thumb_output .= '<div class="thumb hide-thumb">';
            $bk_thumb_output .= '<a href="'.get_the_permalink().'">';
            if(has_post_thumbnail( $bkPostId )) {
                $bk_thumb_output .=  get_the_post_thumbnail($bkPostId, $thumb_type);
            }else {
                $bk_thumb_output .=  '<img width="684" height="452" src="'.get_template_directory_uri().'/images/bkdefault150_100.jpg">';
            }
            $bk_thumb_output .= '</a>';
            $bk_thumb_output .= '</div>';
            return $bk_thumb_output;
        }     
     /**
     *  BK Get Feature Image
     */
        static function bk_single_fw_image($bkPostId, $bk_post_layout) {
            global $bk_option;
            $postFormat = bk_core::bk_post_format_detect($bkPostId);
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
            $bkReviewSW = get_post_meta($bkPostId, 'bk_review_checkbox',true);
            if ( $bkReviewSW == '1' ) { $itemprop =  'itemprop="itemReviewed"'; } else { $itemprop = 'itemprop="headline"'; }
            $bk_feat_img = '';
            $meta_ar = array('cat', 'author', 'date', 'postview', 'postcomment');
            $bk_post_header = '';
            $bk_post_header .= '<div class="s_header_wraper"><div class="s-post-header bkwrapper container"><div class="bk-header-row"><div class="bk-header-8 col-md-8"><h1 '.$itemprop.'>'.get_the_title().'</h1>';
            $bk_post_header .= self::bk_get_post_meta($meta_ar);
            $bk_post_header .= self::bk_share_box($bkPostId, $social_share);
            $bk_post_header .= '</div></div></div></div><!-- end single header -->';
            if ($bk_post_layout === 'bk-parallax-feat') {
                $bk_feat_img .= '<header id="bk-parallax-feat" class="clearfix">'; 
            }else if ($bk_post_layout === 'bk-fw-feat') {
                $bk_feat_img .= '<header id="bk-fw-feat" class="clearfix">'; 
            }
            if ( has_post_thumbnail($bkPostId) ) {
                $bkThumbId = get_post_thumbnail_id( $bkPostId );
                $bkThumbUrl = wp_get_attachment_image_src( $bkThumbId, 'full' );
                if ($postFormat['format'] != 'image') {
                    $bk_feat_img .= '<div class="s-feat-img" data-type="background" style="background-image: url('.$bkThumbUrl[0].')"></div>';
                }else {
                    $attachmentID = get_post_meta($bkPostId, 'bk_image_upload', true );
                    $bkThumbUrl = wp_get_attachment_image_src($attachmentID, true);
                    $bk_feat_img .= '<div class="s-feat-img" data-type="background" style="background-image: url('.$bkThumbUrl[0].')"></div>';
                }
            }
            $bk_feat_img .= $bk_post_header;
            $bk_feat_img .= '</header>';
            
            return $bk_feat_img;
        }
           
    /**
     * BK WP Native Gallery
     */
         static function bk_native_gallery($bkPostId, $attachment_ids){
            global $bk_justified_ids;
            $uid = rand();
            $bk_justified_ids[]=$uid;
            wp_localize_script( 'bk-customjs', 'justified_ids', $bk_justified_ids );
            $ret = '';
            
            $ret .= '<div class="zoom-gallery justifiedgall_'.$uid.' justified-gallery" style="margin: 0px 0px 1.5em;">';
    						if ($attachment_ids) :					
    						foreach ($attachment_ids as $id) :
    							$attachment_url = wp_get_attachment_image_src( $id, 'full' );
                                $attachment = get_post($id);
    							$caption = apply_filters('the_title', $attachment->post_excerpt);
    					
                                $ret .= '<a class="zoomer" title="'.$caption.'" data-source="'.$attachment_url[0].'" href="'.$attachment_url[0].'">'.wp_get_attachment_image($attachment->ID, 'full').'</a>';
    
    						endforeach;
    						endif;
    			$ret .= '</div>';
                return $ret;
         }
    /**
     *  Single Content
     */    
        static function bk_single_content($bkPostId){
            $the_content = '';
            $the_content = apply_filters( 'the_content', get_the_content($bkPostId) );
            $the_content = str_replace( ']]>', ']]&gt;', $the_content );
    
            $post_content_str = get_the_content($bkPostId);
            $gallery_flag = 0;
            $i = 0;
            $ids = null;
            for ($i=0; $i < 10; $i++) {
                preg_match('/<style(.+(\n))+.*?<\/div>/', $the_content, $match);
                    
                preg_match('/\[gallery.*ids=.(.*).\]/', $post_content_str, $ids);             
                
                if ($ids != null) {
                    $the_content = str_replace($match[0], $ids[0] ,$the_content);          
                       
                    $attachment_ids = explode(",", $ids[1]);
                    $post_content_str = str_replace($ids[0], self::bk_native_gallery ($bkPostId, $attachment_ids),$post_content_str);
                    $the_content = str_replace($ids[0], self::bk_native_gallery ($bkPostId, $attachment_ids),$the_content);
                    $gallery_flag = 1;
                }
            }
            if($gallery_flag == 1) {
                return $the_content;
            }else {
                return the_content($bkPostId);
            }
        }
    /**
     * Review Box
     */
    /**
     * Canvas box 
     */
        static function bk_user_review($bk_post_id){
            global $bk_option;
            $bk_user_rating = get_post_meta($bk_post_id, 'bk_user_rating', true );
            if($bk_user_rating) {
                $bk_user_review = '';
                $bk_number_rates = get_post_meta($bk_post_id, "bk_rates", true);
                $bk_user_score = get_post_meta($bk_post_id, "bk_user_score_output", true); 
                if ($bk_number_rates == NULL) {$bk_number_rates = 0;}
                if ($bk_user_score == NULL) {$bk_user_score = 0;}
                $bk_average_score = '<span class="bk-criteria-score bk-average-score">'.  floatval($bk_user_score) .'</span>'; 
                if(isset($_COOKIE["bk_user_rating"])) { $bk_current_rates = $_COOKIE["bk_user_rating"]; } else { $bk_current_rates = NULL; }
                if(isset($_COOKIE["bk_score_rating"])) { $bk_current_score = $_COOKIE["bk_score_rating"]; } else { $bk_current_score = NULL; }
    
                if ( preg_match('/\b' .$bk_post_id . '\b/', $bk_current_rates) ) {
                     $bk_class = " bk-rated"; 
                     $bk_tip_class = ' bk-tipper-bottom'; 
                     $bk_tip_title = ' data-title="'. esc_html__('You have rated '.$bk_current_score.' points for this post', 'the-rex') .'"'; 
                } else {
                     $bk_class = $bk_tip_title = $bk_tip_class = NULL; 
                }
    
                if ( $bk_number_rates == '1' ) {
                    $bk_rate_str = esc_html__("Rate", "the-rex");
                }  else {
                    $bk_rate_str = esc_html__("Rates", "the-rex");
                }             
                $bk_user_review .= '<div class="bk-bar bk-user-rating clearfix"><div id="bk-rate" class="bg bk-criteria-wrap clearfix '. $bk_class .'"><span class="bk-criteria">'. esc_html__("Reader Rating", "the-rex"). ': (<span>'. $bk_number_rates .'</span> '. $bk_rate_str .')</span>';
                
                $bk_user_review .= $bk_average_score. '<div class="bk-overlay'. $bk_tip_class .'"'. $bk_tip_title .'><span style="width:'. $bk_user_score*10 .'%"></span></div></div></div>';
    
                 if ( function_exists('wp_nonce_field') ) { $bk_user_review .= wp_nonce_field('rating_nonce', 'rating_nonce', true, false); } 
                 
                 return $bk_user_review;
            }
        }
    /**
     * Canvas box 
     */
         static function bk_canvas_box($bk_final_score){
            global $bk_option;
            $bk_best_rating = '10';
            $bk_review_final_score = floatval($bk_final_score);  
            $arc_percent = $bk_final_score*10;
            $bk_canvas_ret = '';                                       
            $score_circle = '<canvas class="rating-canvas" data-rating="'.$arc_percent.'"></canvas>';           
            $bk_canvas_ret .= '<div class="bk-score-box" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">'.$score_circle.'<meta itemprop="worstRating" content="1"><meta itemprop="bestRating" content="'. $bk_best_rating .'"><span class="score" itemprop="ratingValue">'.$bk_review_final_score.'</span></div><!--close canvas-->';
            return $bk_canvas_ret;
        }
    /**
    * ************* Display post review box ********
    *---------------------------------------------------
    */
        static function bk_post_review_boxes($bk_post_id, $reviewPos){
            global $bk_option;
            if (isset($bk_option)){
                $primary_color = $bk_option['bk-primary-color'];
            }
            $bk_custom_fields = get_post_custom();
            $bk_review_checkbox = get_post_meta($bk_post_id, 'bk_review_checkbox', true );
    
            if ( $bk_review_checkbox == '1' ) {
                 $bk_review_checkbox = 'on'; 
            } else {
                 $bk_review_checkbox = 'off';
            }
            if ($bk_review_checkbox == 'on') {
                $bk_summary = get_post_meta($bk_post_id, 'bk_summary', true );                
                $bk_final_score = get_post_meta($bk_post_id, 'bk_final_score', true );        
                
                if ( isset ( $bk_custom_fields['bk_ct1'][0] ) ) { $bk_rating_1_title = $bk_custom_fields['bk_ct1'][0]; }
                if ( isset ( $bk_custom_fields['bk_cs1'][0] ) ) { $bk_rating_1_score = $bk_custom_fields['bk_cs1'][0]; }
                if ( isset ( $bk_custom_fields['bk_ct2'][0] ) ) { $bk_rating_2_title = $bk_custom_fields['bk_ct2'][0]; }
                if ( isset ( $bk_custom_fields['bk_cs2'][0] ) ) { $bk_rating_2_score = $bk_custom_fields['bk_cs2'][0]; }
                if ( isset ( $bk_custom_fields['bk_ct3'][0] ) ) { $bk_rating_3_title = $bk_custom_fields['bk_ct3'][0]; }
                if ( isset ( $bk_custom_fields['bk_cs3'][0] ) ) { $bk_rating_3_score = $bk_custom_fields['bk_cs3'][0]; }
                if ( isset ( $bk_custom_fields['bk_ct4'][0] ) ) { $bk_rating_4_title = $bk_custom_fields['bk_ct4'][0]; }
                if ( isset ( $bk_custom_fields['bk_cs4'][0] ) ) { $bk_rating_4_score = $bk_custom_fields['bk_cs4'][0]; }
                if ( isset ( $bk_custom_fields['bk_ct5'][0] ) ) { $bk_rating_5_title = $bk_custom_fields['bk_ct5'][0]; }
                if ( isset ( $bk_custom_fields['bk_cs5'][0] ) ) { $bk_rating_5_score = $bk_custom_fields['bk_cs5'][0]; }
                if ( isset ( $bk_custom_fields['bk_ct6'][0] ) ) { $bk_rating_6_title = $bk_custom_fields['bk_ct6'][0]; }
                if ( isset ( $bk_custom_fields['bk_cs6'][0] ) ) { $bk_rating_6_score = $bk_custom_fields['bk_cs6'][0]; }
                
                $bk_ratings = array();  
            
                for( $i = 1; $i < 7; $i++ ) {
                     if ( isset(${"bk_rating_".$i."_score"}) ) { $bk_ratings[] =  ${"bk_rating_".$i."_score"};}
                }
                $bk_review_ret = '<div class="bk-review-box '.$reviewPos.' clearfix"><div class="bk-detail-rating clearfix">'; 
                for( $j = 1; $j < 7; $j++ ) {
                    
                     $k = ($j - 1);
                
                     if ((isset(${"bk_rating_".$j."_title"})) && (isset(${"bk_rating_".$j."_score"})) ) {                       
                            $bk_review_ret .= '<div class="bk-criteria-wrap"><span class="bk-criteria">'. ${"bk_rating_".$j."_title"}.'</span><span class="bk-criteria-score">'. $bk_ratings[$k].'</span>';                                     
                            $bk_review_ret .= '<div class="bk-bar clearfix"><span class="bk-overlay"><span class="bk-zero-trigger" style="width:'. ( ${"bk_rating_".$j."_score"}*10).'%"></span></span></div></div>';
                     }
                }
                $bk_review_ret .= '</div>';
                $bk_review_ret .= '<div class="summary-wrap clearfix">';
                if ( $bk_summary != NULL ) { $bk_review_ret .= '<div class="bk-summary"><div id="bk-conclusion" itemprop="description">'.$bk_summary.'</div></div>'; }                                    
                $bk_review_ret .= self::bk_canvas_box($bk_final_score);
                $bk_review_ret .= '</div><!-- /bk-author-review-box -->';
                $bk_review_ret .= self::bk_user_review($bk_post_id);
                $bk_review_ret .= '</div> <!--bk-review-box close-->';
                return $bk_review_ret;
            }
        }
    /**
    * ************* Get youtube ID  *****************
    *---------------------------------------------------
    */ 
      
        static function bk_parse_youtube($link){
         
            $regexstr = '~
                # Match Youtube link and embed code
                (?:                             # Group to match embed codes
                    (?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
                    |(?:                        # Group to match if older embed
                        (?:<object .*>)?      # Match opening Object tag
                        (?:<param .*</param>)*  # Match all param tags
                        (?:<embed [^>]*src=")?  # Match embed tag to the first quote of src
                    )?                          # End older embed code group
                )?                              # End embed code groups
                (?:                             # Group youtube url
                    https?:\/\/                 # Either http or https
                    (?:[\w]+\.)*                # Optional subdomains
                    (?:                         # Group host alternatives.
                    youtu\.be/                  # Either youtu.be,
                    | youtube\.com              # or youtube.com
                    | youtube-nocookie\.com     # or youtube-nocookie.com
                    )                           # End Host Group
                    (?:\S*[^\w\-\s])?           # Extra stuff up to VIDEO_ID
                    ([\w\-]{11})                # $1: VIDEO_ID is numeric
                    [^\s]*                      # Not a space
                )                               # End group
                "?                              # Match end quote if part of src
                (?:[^>]*>)?                       # Match any extra stuff up to close brace
                (?:                             # Group to match last embed code
                    </iframe>                 # Match the end of the iframe
                    |</embed></object>          # or Match the end of the older embed
                )?                              # End Group of last bit of embed code
                ~ix';
        
            preg_match($regexstr, $link, $matches);
        
            return $matches[1];
        
        }
        
    /**
     * ************* Get vimeo ID *****************
     *---------------------------------------------------
     */  
        
        static function bk_parse_vimeo($link){
         
            $regexstr = '~
                # Match Vimeo link and embed code
                (?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
                (?:                         # Group vimeo url
                    https?:\/\/             # Either http or https
                    (?:[\w]+\.)*            # Optional subdomains
                    vimeo\.com              # Match vimeo.com
                    (?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
                    \/                      # Slash before Id
                    ([0-9]+)                # $1: VIDEO_ID is numeric
                    [^\s]*                  # Not a space
                )                           # End group
                "?                          # Match end quote if part of src
                (?:[^>]*></iframe>)?        # Match the end of the iframe
                (?:<p>.*</p>)?              # Match any title information stuff
                ~ix';
        
            preg_match($regexstr, $link, $matches);
        
            return $matches[1];
        }
    /**
     * ************* Get Dailymotion ID *****************
     *---------------------------------------------------
     */  
        static function bk_parse_dailymotion($link){
            preg_match('#<object[^>]+>.+?http://www.dailymotion.com/swf/video/([A-Za-z0-9]+).+?</object>#s', $link, $matches);
        
                // Dailymotion url
                if(!isset($matches[1])) {
                    preg_match('#http://www.dailymotion.com/video/([A-Za-z0-9]+)#s', $link, $matches);
                }
        
                // Dailymotion iframe
                if(!isset($matches[1])) {
                    preg_match('#http://www.dailymotion.com/embed/video/([A-Za-z0-9]+)#s', $link, $matches);
                }
            return $matches[1];
        }
    
/**
 * ************* Social Share Box *****************
 *---------------------------------------------------
 */
              
        static function bk_share_box($bkPostId, $social_share) {
            $titleget = get_the_title($bkPostId);
            $fb_oc = "window.open('http://www.facebook.com/sharer.php?u=".urlencode(get_permalink())."','Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;";
            $tw_oc = "window.open('http://twitter.com/share?url=".urlencode(get_permalink())."&amp;text=".str_replace(" ", "%20", $titleget)."','Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;";
            $gp_oc = "window.open('https://plus.google.com/share?url=".urlencode(get_permalink())."','Google plus','width=585,height=666,left='+(screen.availWidth/2-292)+',top='+(screen.availHeight/2-333)+''); return false;";
            $stu_oc = "window.open('http://www.stumbleupon.com/submit?url=".urlencode(get_permalink())."','Stumbleupon','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;";
            $li_oc = "window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=".urlencode(get_permalink())."','Linkedin','width=863,height=500,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;";
            $str_ret = '';
            $str_ret .= '<div class="bk-share-box">';
            $str_ret .= '<span>'.esc_html__("Share:", "the-rex").'</span>';
            $str_ret .= '<div class="share-box-wrap">';
            $str_ret .= '<div class="share-box">';
            $str_ret .= '<ul class="social-share">';
            if ($social_share['fb']): 
                $str_ret .= '<li class="bk_facebook_share"><a onClick="'.$fb_oc.'" href="http://www.facebook.com/sharer.php?u='.urlencode(get_permalink()).'"><div class="share-item-icon"><i class="fa fa-facebook " title="Facebook"></i></div></a></li>';
            endif; 
            if ($social_share['tw']):
                $str_ret .= '<li class="bk_twitter_share"><a onClick="'.$tw_oc.'" href="http://twitter.com/share?url='.urlencode(get_permalink()).'&amp;text='.str_replace(" ", "%20", $titleget).'"><div class="share-item-icon"><i class="fa fa-twitter " title="Twitter"></i></div></a></li>';
            endif;
            if ($social_share['gp']):
                $str_ret .= '<li class="bk_gplus_share"><a onClick="'.$gp_oc.'" href="https://plus.google.com/share?url='.urlencode(get_permalink()).'"><div class="share-item-icon"><i class="fa fa-google-plus " title="Google Plus"></i></div></a></li>';
            endif;
            if ($social_share['pi']):
                $str_ret .= '<li class="bk_pinterest_share"><a href="javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());"><div class="share-item-icon"><i class="fa fa-pinterest " title="Pinterest"></i></div></a></li>';
            endif;
            if ($social_share['stu']):
                $str_ret .= '<li class="bk_stumbleupon_share"><a onClick="'.$stu_oc.'" href="http://www.stumbleupon.com/submit?url='.urlencode(get_permalink()).'"><div class="share-item-icon"><i class="fa fa-stumbleupon " title="Stumbleupon"></div></i></a></li>';
            endif;
            if ($social_share['li']):
                $str_ret .= '<li class="bk_linkedin_share"><a onClick="'.$li_oc.'" href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.urlencode(get_permalink()).'"><div class="share-item-icon"><i class="fa fa-linkedin " title="Linkedin"></i></div></a></li>';
            endif;      
            $str_ret .= '</ul>';
            $str_ret .= '</div>';
            $str_ret .= '</div>';
            $str_ret .= '</div>';
            return $str_ret;  
        }    
/**
 * ************* Get Images Instagram *****************
 *---------------------------------------------------
 */
        
        static function bk_get_instagram( $username, $cache_hours, $nr_images, $attachment ) {
        	if ( isset( $username ) && !empty( $username ) ) {
        		$search = 'user';
        		$search_string = $username;
        	} else {
        		return __( 'Nothing to search for', 'jrinstaslider');
        	}
        	
        	
        	$opt_name  = 'jr_insta_' . md5( $search . '_' . $search_string );
        	$instaData = get_transient( $opt_name );
        	$user_opt  = (array) get_option( $opt_name );
        
        	if ( false === $instaData || $user_opt['search_string'] != $search_string || $user_opt['search'] != $search || $user_opt['cache_hours'] != $cache_hours || $user_opt['nr_images'] != $nr_images || $user_opt['attachment'] != $attachment ) {
        		
        		$instaData = array();
        		$user_opt['search']        = $search;
        		$user_opt['search_string'] = $search_string;
        		$user_opt['cache_hours']   = $cache_hours;
        		$user_opt['nr_images']     = $nr_images;
        		$user_opt['attachment']    = $attachment;
        
        		if ( 'user' == $search ) {
        			$response = wp_remote_get( 'https://www.instagram.com/' . trim( $search_string ), array( 'sslverify' => false, 'timeout' => 60 ) );
        		} 
        		if ( is_wp_error( $response ) ) {
        
        			return $response->get_error_message();
        		}
        		if ( $response['response']['code'] == 200 ) {
        			
        			$json = str_replace( 'window._sharedData = ', '', strstr( $response['body'], 'window._sharedData = ' ) );
        			
        			// Compatibility for version of php where strstr() doesnt accept third parameter
        			if ( version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
        				$json = strstr( $json, '</script>', true );
        			} else {
        				$json = substr( $json, 0, strpos( $json, '</script>' ) );
        			}
        			
        			$json = rtrim( $json, ';' );
        			// Function json_last_error() is not available before PHP * 5.3.0 version
        			if ( function_exists( 'json_last_error' ) ) {
        				
        				( $results = json_decode( $json, true ) ) && json_last_error() == JSON_ERROR_NONE;
        				
        			} else {
        				
        				$results = json_decode( $json, true );
        			}
        			
        			if ( $results && is_array( $results ) ) {
        
        				if ( 'user' == $search ) {
        					$entry_data = isset( $results['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ? $results['entry_data']['ProfilePage'][0]['user']['media']['nodes'] : array();
        				} else {
        					$entry_data = isset( $results['entry_data']['TagPage'][0]['tag']['media']['nodes'] ) ? $results['entry_data']['TagPage'][0]['tag']['media']['nodes'] : array();
        				}
        				
        				if ( empty( $entry_data ) ) {
        					return __( 'No images found', 'jrinstaslider');
        				}
        
        				foreach ( $entry_data as $current => $result ) {
        
        					if ( $result['is_video'] == true ) {
        						$nr_images++;
        						continue;
        					}
        
        					if ( $current >= $nr_images ) {
        						break;
        					}
        
        					$image_data['code']       = $result['code'];
        					$image_data['username']   = 'user' == $search ? $search_string : false;
        					$image_data['user_id']    = $result['owner']['id'];
        					$image_data['caption']    = '';
        					$image_data['id']         = $result['id'];
        					$image_data['link']       = 'https://www.instagram.com/p/'. $result['code'] . '/';
        					$image_data['popularity'] = (int) ( $result['comments']['count'] ) + ( $result['likes']['count'] );
        					$image_data['timestamp']  = (float) $result['date'];
        					$image_data['url']        = $result['display_src'];
        					$image_data['url_thumbnail'] = $result['thumbnail_src'];
        
        						
        					$instaData[] = $image_data;
        
        					
        				} // end -> foreach
        				
        			} // end -> ( $results ) && is_array( $results ) )
        			
        		} else { 
        
        			return $response['response']['message'];
        
        		} // end -> $response['response']['code'] === 200 )
                //print_R($instaData);
        		update_option( $opt_name, $user_opt );
        		
        		if ( is_array( $instaData ) && !empty( $instaData )  ) {
        
        			//set_transient( $opt_name, $instaData, $cache_hours * 60 * 60 );
        		}
        		
        	} // end -> false === $instaData
        
        	return $instaData;
        }
    } // Close bk_core class
}