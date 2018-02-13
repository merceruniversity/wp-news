<?php
/**
 * The template for displaying Author archive pages
 *
 */
 ?> 
<?php get_header();?>
<?php
global $bk_option;
if (isset($bk_option) && ($bk_option != '')): 
    $bk_layout = $bk_option['bk-category-layout'];
    $cur_cat_id = $wp_query->get_queried_object_id();
    $cat_opt = get_option('bk_cat_opt');
    if(isset($bk_option['category_post_icon'])) {
        $bk_post_icon= $bk_option['category_post_icon'];
    }else {
        $bk_post_icon = 'hide';
    }
    $cat_feat = '';    
    $cat_layout = 0;
endif;
$meta = array();
$meta = get_option('bk_cat_opt');
if (isset($cat_opt[$cur_cat_id]) && is_array($cat_opt[$cur_cat_id]) && array_key_exists('cat_layout',$cat_opt[$cur_cat_id])) { $cat_layout = $cat_opt[$cur_cat_id]['cat_layout'];};
if (isset($cat_opt[$cur_cat_id]) && is_array($cat_opt[$cur_cat_id]) && array_key_exists('cat_feat',$cat_opt[$cur_cat_id])) { $cat_feat = $cat_opt[$cur_cat_id]['cat_feat'];};
if ($cat_feat == '') { $cat_feat = 0;};
if ((strlen($cat_layout) != 0)&&($cat_layout != 'global')) { $bk_layout = $cat_layout;};
?>
<div id="body-wrapper" class="wp-page">
    <div class="module-title bkwrapper container">
        <div class="main-title">
            <h2 class="heading"><?php single_cat_title();?></h2>
        </div>
        <?php if ( category_description() ) : // Show an optional category description ?>
			<div class="sub-title"><?php echo category_description(); ?></div>
		<?php endif;?>
    </div>
    <?php
    if ($cat_feat) {
        $feat_tag = '';
        if ($bk_option['feat-tag'] != ''){
            $feat_tag = $bk_option['feat-tag'];
        }                                
        if ($feat_tag != '') {
            $args = array(
				'tag__in' => $feat_tag,
                'cat' => $cur_cat_id,
    			'post_status' => 'publish',
    			'ignore_sticky_posts' => 1,
    			'posts_per_page' => 5,
            );   
        } else {
            $args = array(
				'post__in'  => get_option( 'sticky_posts' ),
                'cat' => $cur_cat_id,
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => 5,
            );
        }
        $the_query = new WP_Query( $args );;
        if ($the_query->post_count >=1) {
        ?>	
        <div class="bkmodule bkwrapper container module-fw-slider bk-slider-module">
            <?php
                echo bk_fw_slider::render_modules($the_query);
            ?>
        </div>	
        <?php }?>
    <?php }?>
    <div class="bkwrapper container">	
        <div class="row bksection">
            <div class="bk-category-content bkpage-content <?php if ((!($bk_layout == 'masonry-nosb')) && (!($bk_layout == 'square-grid-3'))): echo 'col-md-8 has-sb'; else: echo 'col-md-12 fullwidth';  endif;?>">
                <div class="row">
                    <div id="main-content" class="clear-fix" role="main">
                		
                    <?php
                        if (have_posts()) {                                       
/**
 *  Masonry with Sidebar
 * 
 */            
                            if ($bk_layout == 'masonry') { 
                                $meta_ar = array('cat', 'review', 'author', 'postview', 'postcomment');
                                $post_args = array (
                                    'thumbnail_size'    => 'bk_masonry-size',
                                    'meta_ar'           => $meta_ar,
                                    'title_length'      => 15,
                                    'excerpt_length'    => 20,
                                    'post_icon'         => $bk_post_icon            
                                );   
                                ?>
                                <?php $bk_contentout = new bk_contentout4;?>
                                <div class="content-wrap bk-masonry">
                                    <ul class="bk-masonry-content clearfix">
                                        <?php while (have_posts()): the_post(); ?>  
                                            <?php $post_args['postID'] = get_the_ID();?>
                                            <li class="col-md-6 col-sm-6 item">
                                                <div class="row-type content_out">
                                                    <div class="post-wrapper-inner">
                                                        <?php echo ($bk_contentout->render($post_args));?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                                <?php if (function_exists("bk_paginate")) {?>
                                        <div class="col-md-12">
                                            <?php bk_paginate();?>
                                        </div>
                                <?php }?>  
                            <?php } 
/**
 * Masonry No sidebar
 */   
                            else if ($bk_layout == 'masonry-nosb') {
                                $meta_ar = array('cat', 'review', 'author', 'postview', 'postcomment');
                                $post_args = array (
                                    'thumbnail_size'    => 'bk_masonry-size',
                                    'meta_ar'           => $meta_ar,
                                    'title_length'      => 15,
                                    'excerpt_length'    => 20,
                                    'post_icon'         => $bk_post_icon            
                                );   
                                ?>
                                <?php $bk_contentout = new bk_contentout4;?>
                                <div class="content-wrap bk-masonry">
                                    <ul class="bk-masonry-content clearfix">
                                        <?php while (have_posts()): the_post(); ?>  
                                            <?php $post_args['postID'] = get_the_ID();?>
                                            <li class="col-md-4 col-sm-6 item">
                                                <div class="row-type content_out">
                                                    <div class="post-wrapper-inner">
                                                        <?php echo ($bk_contentout->render($post_args));?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                                <?php if (function_exists("bk_paginate")) {?>
                                        <div class="col-md-12">
                                            <?php bk_paginate();?>
                                        </div>
                                <?php }?>  
                            <?php } 
/**
 * Classic Blog
 * 
 */                         
                             else if ($bk_layout == 'classic-blog') { ?>
                                <?php 
                                $bk_contentout = new bk_contentout5;
                                $meta_ar = array('cat', 'review', 'author', 'postview', 'postcomment');
                                $post_args = array (
                                    'thumbnail_size'    => 'bk620_420',
                                    'meta_ar'           => $meta_ar,
                                    'title_length'      => 15,
                                    'post_icon'         => $bk_post_icon, 
                                    'excerpt_length'    => 20            
                                ); 
                                ?>
                                <div class="content-wrap module-classic-blog module-blog">
                                    <ul class="bk-blog-content clearfix">
                                        <?php while (have_posts()): the_post(); ?>  	
                                        <?php $post_args['postID'] = get_the_ID();?>
                                        <li class="item col-md-12">
                                            <div class="content_out clearfix">
                                                <div class="post-wrapper-inner">
                                                    <?php echo ($bk_contentout->render($post_args));?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                                <?php if (function_exists("bk_paginate")) {?>
                                        <div class="col-md-12">
                                            <?php bk_paginate();?>
                                        </div>
                                <?php }?>  
                             <?php }
/**
 * Large Blog
 */
                             else if ($bk_layout == 'large-blog') { ?>
                                <?php $bk_contentout = new bk_contentout6;
                                $meta_ar = array('cat', 'review', 'author', 'postview', 'postcomment');
                                $post_args = array (
                                    'thumbnail_size'    => 'bk600_315',
                                    'meta_ar'           => $meta_ar,
                                    'title_length'      => 15,
                                    'excerpt_length'    => 60,
                                    'post_icon'         => $bk_post_icon            
                                );
                                ?>
                                <div class="content-wrap module-large-blog module-blog">
                                    <ul class="bk-blog-content clearfix">
                                        <?php while (have_posts()): the_post(); ?>  
                                            <?php $post_args['postID'] = get_the_ID();?>	
                                            <li class="item col-md-12">
                                                <div class="content_out clearfix">
                                                    <div class="post-wrapper-inner">
                                                        <?php echo ($bk_contentout->render($post_args));?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endwhile; ?>
                                    </ul>
                                </div>
                                <?php if (function_exists("bk_paginate")) {?>
                                        <div class="col-md-12">
                                            <?php bk_paginate();?>
                                        </div>
                                <?php }?>
                             <?php }
/**
* square-grid-3
*/
                         else if ($bk_layout == 'square-grid-3') {
                            $meta_ar = array('cat', 'review', 'date');
                            $post_args = array (
                                'thumbnail_size'    => 'full',
                                'meta_ar'           => $meta_ar,
                                'title_length'      => 15,         
                            );
                            ?>
                                <?php $bk_contentin1 = new bk_contentin1;?>
                                <div class="content-wrap square-grid-3 module-square-grid">
                                    <ul class="clearfix">
                                        <?php while (have_posts()): the_post(); ?>  	
                                            <?php $post_args['postID'] = get_the_ID();?>	
                                            <li class="content_in col-md-4 col-sm-6">
                                                <div class="content_in_wrapper">
                                                    <?php echo ($bk_contentin1->render($post_args));?>
                                                </div>
                                            </li>
                                            <?php endwhile; ?>
                                    </ul>
                                </div>
                                <?php if (function_exists("bk_paginate")) {?>
                                        <div class="col-md-12">
                                            <?php bk_paginate();?>
                                        </div>
                                <?php }?>
                             <?php }
/**
* square-grid-2
*/
                             else if ($bk_layout == 'square-grid-2') {
                                $meta_ar = array('cat', 'review', 'date');
                                $post_args = array (
                                    'thumbnail_size'    => 'full',
                                    'meta_ar'           => $meta_ar,
                                    'title_length'      => 15,         
                                );
                                ?>
                                <?php $bk_contentin1 = new bk_contentin1;?>
                                <div class="content-wrap square-grid-2 module-square-grid">
                                    <ul class="clearfix">
                                        <?php while (have_posts()): the_post(); ?>
                                            <?php $post_args['postID'] = get_the_ID();?>	  	
                                            <li class="content_in col-md-6 col-sm-6">
                                                <div class="content_in_wrapper">
                                                    <?php echo ($bk_contentin1->render($post_args));?>
                                                </div>
                                            </li>
                                            <?php endwhile; ?>
                                    </ul>
                                </div>
                                <?php if (function_exists("bk_paginate")) {?>
                                        <div class="col-md-12">
                                            <?php bk_paginate();?>
                                        </div>
                                <?php }?>
                             <?php }
                        } else { esc_html_e('No post to display','the-rex');} ?>
            
    	            </div> <!-- end #main -->
                </div>
            </div> <!-- end #bk-content -->
            <?php
                if ((!($bk_layout == 'masonry-nosb')) && (!($bk_layout == 'square-grid-3'))) {?>
                    <div class="sidebar col-md-4">
                        <div class="sidebar-wrap <?php if($bk_option['category-stick-sidebar'] == 'enable') echo 'stick';?>" id="bk-category-sidebar">
                            <div class="sidebar-wrap-inner">
                            <?php
                                if (isset($cat_opt[$cur_cat_id]) && is_array($cat_opt[$cur_cat_id]) && array_key_exists('sb_category',$cat_opt[$cur_cat_id])) { 
                                    $bkcatSidebar = $cat_opt[$cur_cat_id]['sb_category'];
                                    if ((strlen($bkcatSidebar) != 0)&&($bkcatSidebar != 'global')) { 
                                        dynamic_sidebar($bkcatSidebar);
                                    }else {
                                        get_sidebar();
                                    }
                                }else {
                                    get_sidebar();
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                <?php }
            ?>
        </div>
    </div>
</div>   
<?php get_footer(); ?>