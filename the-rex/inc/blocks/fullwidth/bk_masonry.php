<?php
class bk_masonry extends bk_section_parent  {

    public function render( $page_info ) {
        $block_str = '';
        $uid = uniqid('', true);
        $cfg_ops = array();
        $cfg_ops = $this->cfg_options(); 
        $bk_post_icon = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );
        $bk_ajax_button = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ajax_button', true );
        $sec = '';
        if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
            $sec = 'has_sb';
            $col_width = '';
            parent::$bk_ajax_c[$uid]['sec'] = 'has_sb';                         
        }else {
            $sec = 'fw';
            $col_width = 'container bkwrapper';
            parent::$bk_ajax_c[$uid]['sec'] = 'fw';                         
        }
        
// prepare ajax vars 
        $ajax_load_number = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ajax_load_number', true );
        
        parent::$bk_ajax_c[$uid]['entries'] = $ajax_load_number;
        
        parent::$bk_ajax_c[$uid]['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
        
        parent::$bk_ajax_c[$uid]['post_icon'] = $bk_post_icon;
///////////////////////
                
        $module_cfg = bk_get_cfg::configs($cfg_ops['fullwidth']['bk_masonry'], $page_info);    //get block config
        
        $the_query = bk_get_query::query($module_cfg, $uid);              //get query

// locallize ajax vars 

        wp_localize_script( 'bk-module-load-post', 'ajax_c', parent::$bk_ajax_c );

        $block_str .= '<div id="'.$uid.'" class="bkmodule module-masonry clearfix '.$col_width.'">';
        if ( $the_query->have_posts() ) :
            $block_str .= bk_core::bk_get_block_title($page_info);  //render block title
        endif;
        $block_str .= '<div class="bk-masonry-wrap">';
        $block_str .= '<div class="row clearfix">';
        $block_str .= '<ul class="bk-masonry-content clearfix">';
        $block_str .= $this->render_modules($the_query, $sec, $bk_post_icon);            //render modules
        $block_str .= '</ul></div></div>';
        //Loadmore button 
        if($bk_ajax_button !== 'disable') {
            $block_str .= '<div class="masonry-ajax loadmore">';
            $block_str .= '<span class="ajaxtext ajax-load-btn">'.esc_html__("Load More","the-rex").'</span>';
            $block_str .= '<span class="loading-animation"></span>';
            $block_str .= '</div><!-- End Loadmore -->';
        }
        
        $block_str .= '</div>';
        
        unset($cfg_ops); unset($module_cfg); unset($the_query);     //free
        wp_reset_postdata();
        return $block_str;
	}
    static function render_modules ($the_query, $sec, $bk_post_icon){
        $render_modules = '';
        $bk_contentout = new bk_contentout4;
        $meta_ar = array('cat', 'review', 'author', 'postview', 'postcomment');
        $post_args = array (
            'thumbnail_size'    => 'bk_masonry-size',
            'meta_ar'           => $meta_ar,
            'title_length'      => 15,
            'excerpt_length'    => 20,
            'post_icon'         => $bk_post_icon            
        );      
        if($sec == 'has_sb') {
            $col_width = 'col-md-6 col-sm-6';
        }else {
            $col_width = 'col-md-4 col-sm-6';
        }
        if ( $the_query->have_posts() ) :            
          
            while ( $the_query->have_posts() ): $the_query->the_post();
                $post_args['postID'] = get_the_ID();
                $render_modules .= '<li class="'.$col_width.' item row-type content_out"><div class="post-wrapper-inner">';
                $render_modules .= $bk_contentout->render($post_args);
                $render_modules .= '</div></li><!-- end post item -->';
            endwhile;
            
        endif;
        return $render_modules;
    }
}