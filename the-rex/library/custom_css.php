<?php
add_action('wp_head','custom_css',20);
if ( ! function_exists( 'custom_css' ) ) {
    function custom_css() {
        global $bk_option;
        if ( isset($bk_option)):
            $primary_color = $bk_option['bk-primary-color'];
            $bg_switch = $bk_option['bk-site-layout'];
            $cat_opt = get_option('bk_cat_opt');  
            $header_top = $bk_option['bk-header-top-switch'];  
            $sb_location = $bk_option['bk-sb-location-sw']; 
            $sb_responsive_sw = $bk_option['bk-sb-responsive-sw'];
            $meta_review = $bk_option['bk-meta-review-sw'];
            $meta_author = $bk_option['bk-meta-author-sw'];
            $meta_date = $bk_option['bk-meta-date-sw'];
            $meta_comments = $bk_option['bk-meta-comments-sw'];        
            $custom_css = $bk_option['bk-css-code'];         
            $bk_menu_effect = $bk_option['bk-menu-effect'];  
?>
    
    <style type='text/css' media="all">
        <?php
            if ( $meta_review == 0 ) echo ('.review-score {display: none !important;}'); 
            if ( $meta_author == 0 ) echo ('.post-author {display: none !important;}'); 
            if ( $meta_date == 0 ) echo ('.post-date {display: none !important;}'); 
            if ( $meta_comments == 0 ) echo ('.meta-comment {display: none !important;}');
            if ( $header_top == 0 ) echo ('.top-bar {display: none !important;}');
            if ( $sb_location == 'left') echo ('.has-sb > div > .content-wrap, .single-page .main, .bk-header-8, .wp-page .bkpage-content {float: right;} .has-sb .sidebar, .single-page .sidebar, .wp-page .sidebar {float: left; padding-left: 15px; padding-right: 30px;}'); 
            if ($bk_menu_effect == 'fade') echo ('#top-menu>ul>li > .sub-menu, .bk-dropdown-menu, .bk-sub-sub-menu, .bk-mega-menu, .bk-mega-column-menu, .sub-menu, .top-nav .bk-account-info, .bk_small_cart #bk_small_cart_widget {
                                                    top: -9999999px;
                                                    transition: opacity 0.3s linear;
                                                }');
                                                
        ?>
        ::selection {color: #FFF; background: <?php echo esc_attr($primary_color); ?>}
        ::-webkit-selection {color: #FFF; background: <?php echo esc_attr($primary_color); ?>}
        <?php if ( ($primary_color) != null) {?> 
             p > a, p > a:hover, .single-page .article-content a:hover, .single-page .article-content a:visited, .content_out.small-post .meta .post-category, .bk-sub-menu li:hover > a,
            #top-menu>ul>li > .sub-menu a:hover, .bk-dropdown-menu li:hover > a, .widget_tag_cloud .tagcloud a:hover, .bk-header-90 #main-menu > ul > li:hover,
            .footer .searchform-wrap .search-icon i, .module-title h2 span,
            .row-type .meta .post-category, #top-menu>ul>li:hover > a, .article-content li a, .article-content p a, .content_out.small-post .post-category,
            .breadcrumbs .location, .recommend-box .close,
            .s-post-nav .nav-title span, .error-number h4, .redirect-home, .module-breaking-carousel .flex-direction-nav .flex-next, .module-breaking-carousel:hover .flex-direction-nav .flex-prev,
            .bk-author-box .author-info .bk-author-page-contact a:hover, .module-feature2 .meta .post-category, 
            .bk-blog-content .meta .post-category, blockquote,
            #pagination .page-numbers, .post-page-links a, input[type="submit"]:hover, .single-page .icon-play:hover,
            .button:hover, .top-nav .bk-lwa .bk-account-info a:hover, a.bk_u_login:hover, a.bk_u_logout:hover, .bk-back-login:hover,
            .top-nav .bk-links-modal:hover, .main-nav.bk-menu-light .bk-sub-menu li > a:hover, .main-nav.bk-menu-light .bk-sub-posts .post-title a:hover,
            .bk-header-90 .header-social .social-icon a:hover
            {color: <?php echo esc_attr($primary_color); ?>}
            
            .flex-direction-nav li a:hover polyline 
            {stroke: <?php echo esc_attr($primary_color); ?>}
            #top-menu>ul>li > .sub-menu, .bk-dropdown-menu, .widget_tag_cloud .tagcloud a:hover, #page-wrap.wide .main-nav.fixed,
            .bk-mega-menu, .bk-mega-column-menu, .search-loadding, #comment-submit:hover,
            #pagination .page-numbers, .post-page-links a, .post-page-links > span, .widget_latest_comments .flex-direction-nav li a:hover,
            .loadmore span.ajaxtext:hover, #mobile-inner-header, .menu-location-title, input[type="submit"]:hover, .button:hover,
            .bk-lwa:hover > .bk-account-info, .bk-back-login:hover ,.menu-location-title, #mobile-inner-header,
            .main-nav.bk-menu-light .main-nav-container, #bk-gallery-slider .flex-control-paging li a.flex-active
            {border-color: <?php echo esc_attr($primary_color); ?>;}

            .module-fw-slider .flex-control-nav li a.flex-active, .module-breaking-carousel .content_out.small-post .meta:after,
            .footer .cm-flex .flex-control-paging li a.flex-active,
            .bk-review-box .bk-overlay span, .bk-score-box, .share-total, #pagination .page-numbers.current, .post-page-links > span, .readmore a:hover,
            .loadmore span.ajaxtext:hover, .module-title h2:before, .page-title h2:before, #bk-gallery-slider .flex-control-paging li a.flex-active,
            .widget_display_stats dd strong, .widget_display_search .search-icon, .searchform-wrap .search-icon, #comment-submit:hover,
            #back-top, .bk_tabs .ui-tabs-nav li.ui-tabs-active, .s-tags a:hover, .post-category a
            {background-color: <?php echo esc_attr($primary_color); ?>;}
            
            .footer .cm-flex .flex-control-paging li a
            {background-color: <?php echo bk_hex2rgba (esc_attr($primary_color), 0.3); ?>;}
            

        <?php }?>
        <?php
        if ( $bg_switch == 'wide') {?>
            #page-wrap { width: auto; }
        <?php }else{?>
            body { background-position: left; background-repeat: repeat; background-attachment: fixed;}
        <?php };  
        if ( $sb_responsive_sw == 0) {?>
            @media (max-width: 991px){
                .sidebar {display: none !important}
            }
        <?php };?>
        <?php if ($custom_css != '') echo ($custom_css);?>
        
    </style>
    <?php endif;?>
    <?php }?>
<?php }?>