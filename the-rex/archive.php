<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
?>
<?php
get_header(); 
global $bk_option;
$bk_layout = '';
if (isset($bk_option) && ($bk_option != '')): 
    $bk_layout = $bk_option['bk-archive-layout'];
    $cur_tag_id = $wp_query->get_queried_object_id();
    $cat_opt = get_option('bk_cat_opt');
    if(isset($bk_option['archive_post_icon'])) {
        $bk_post_icon= $bk_option['archive_post_icon'];
    }else {
        $bk_post_icon = 'hide';
    }
    $cat_feat = '';    
    $tag_layout = 0;    
endif;
if (isset($cat_opt[$cur_tag_id]) && is_array($cat_opt[$cur_tag_id]) && array_key_exists('cat_layout',$cat_opt[$cur_tag_id])) { $tag_layout = $cat_opt[$cur_tag_id]['cat_layout'];};
if (isset($cat_opt[$cur_tag_id]) && is_array($cat_opt[$cur_tag_id]) && array_key_exists('cat_feat',$cat_opt[$cur_tag_id])) { $cat_feat = $cat_opt[$cur_tag_id]['cat_feat'];};
if ($cat_feat == '') { $cat_feat = 0;};
if ((strlen($tag_layout) != 0)&&($tag_layout != 'global')) { $bk_layout = $tag_layout;};
if ($bk_layout == '') {
    $bk_layout = 'classic-blog';
}
?>
<div id="body-wrapper" class="wp-page">
    <div class="module-title bkwrapper container">
        <div class="main-title">
    		<h2 class="heading">
                <?php
                	/* Queue the first post, that way we know
                	 * what date we're dealing with (if that is the case).
                	 *
                	 * We reset this later so we can run the loop
                	 * properly with a call to rewind_posts().
                	 */
                	if ( have_posts() )
                        the_post();
                 ?>
                <?php

    				$var = get_query_var('post_format');
    				// POST FORMATS
    				if ($var == 'post-format-image') :
    					esc_html_e('Image ', 'the-rex');
    				elseif ($var == 'post-format-gallery') :
    					esc_html_e('Gallery ', 'the-rex');
    				elseif ($var == 'post-format-video') :
    					esc_html_e('Video ', 'the-rex');
    				elseif ($var == 'post-format-audio') :
    					esc_html_e('Audio ', 'the-rex');
    				endif;
    
    				if ( is_day() ) :
    					printf( esc_html__( 'Daily Archives: %s', 'the-rex'), get_the_date() );
    				elseif ( is_month() ) :
    					printf( esc_html__( 'Monthly Archives: %s', 'the-rex'), get_the_date( _x( 'F Y', 'monthly archives date format', 'the-rex') ) );
    				elseif ( is_year() ) :
    					printf( esc_html__( 'Yearly Archives: %s', 'the-rex'), get_the_date( _x( 'Y', 'yearly archives date format', 'the-rex') ) );
    				elseif ( is_tag() ) :
                        printf( esc_html__( 'Tag: %s', 'the-rex'), single_tag_title('',false) );
                    else :
    					esc_html_e( 'Archives', 'the-rex');
    				endif;
    			?>
            </h2>
        </div>
    </div>
    <div class="bkwrapper container">		
        <div class="row bksection">			
            <div class="bk-archive-content bkpage-content <?php if ((!($bk_layout == 'masonry-nosb')) && (!($bk_layout == 'square-grid-3'))): echo 'col-md-8 has-sb'; else: echo 'col-md-12 fullwidth';  endif;?>">
<?php
	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();
?>
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
                        <div class="sidebar-wrap <?php if($bk_option['archive-stick-sidebar'] == 'enable') echo 'stick';?>" id="bk-archive-sidebar">
                            <div class="sidebar-wrap-inner">
                                <?php get_sidebar(); ?>
                            </div>
                        </div>
                    </div>
                <?php }
            ?>
        </div>
    </div>
</div>   
<?php get_footer(); ?>