<?php
class bk_square_grid extends bk_section_parent  {
    
    public function render( $page_info ) {
        $block_str = '';
        $uid = uniqid('', true);
        $cfg_ops = array();
        $cfg_ops = $this->cfg_options(); 
        $module_cfg = bk_get_cfg::configs($cfg_ops['fullwidth']['bk_square_grid'], $page_info);    //get block config
        $bk_ajax_button = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ajax_button', true );
        $sec = '';
        $has_bkwrapper = '';
        $columns = "";
        if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
            $has_bkwrapper = 'square-grid-2';
            $sec = "has_sb";   
            parent::$bk_ajax_c[$uid]['sec'] = 'has_sb';            
        }else {
            $has_bkwrapper = 'bkwrapper container square-grid-3';  
            $sec = "fw";   
            parent::$bk_ajax_c[$uid]['sec'] = 'fw';    
        }
// prepare ajax vars 
        $ajax_load_number = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_ajax_load_number', true );
        
        parent::$bk_ajax_c[$uid]['entries'] = $ajax_load_number;
        
        parent::$bk_ajax_c[$uid]['offset'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
        
///////////////////////
// locallize ajax vars 

        wp_localize_script( 'bk-module-load-post', 'ajax_c', parent::$bk_ajax_c );
        
        $the_query = bk_get_query::query($module_cfg, $uid);//get query

        $block_str .= '<div id="'.$uid.'" class="bkmodule '.$has_bkwrapper.' module-square-grid">';
        if ( $the_query->have_posts() ) :
            $block_str .= bk_core::bk_get_block_title($page_info);  //render block title
        endif;
        $block_str .= '<div class="bk-square-grid-wrap">';
        $block_str .= '<div class="row clearfix">';
        $block_str .= '<ul class="bk-square-grid-content clearfix">';
        $block_str .= $this->render_modules($the_query, $sec);
        $block_str .= '</ul></div></div>';
        //Loadmore button 
        if($bk_ajax_button !== 'disable') {
            $block_str .= '<div class="square-grid-ajax loadmore">';
            $block_str .= '<span class="ajaxtext ajax-load-btn">'.esc_html__("Load More","the-rex").'</span>';
            $block_str .= '<span class="loading-animation"></span>';
            $block_str .= '</div><!-- End Loadmore -->';
        }
        $block_str .= '</div>';
        unset($cfg_ops); unset($module_cfg); unset($the_query);
        wp_reset_postdata();
        return $block_str;
	}
    static function render_modules ($the_query, $sec){
        $render_modules = '';
        if($sec == 'has_sb') {
            $col_width = 'col-md-6 col-sm-6';
        }else {
            $col_width = 'col-md-4 col-sm-6';
        }
        $bk_contentin1 = new bk_contentin1;
        $meta_ar = array('cat', 'review', 'date');
        $post_args = array (
            'thumbnail_size'    => 'full',
            'meta_ar'           => $meta_ar,
            'title_length'      => 15,         
        );
        if ( $the_query->have_posts() ) :
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $post_args['postID'] = get_the_ID();
                $render_modules .= '<li class="content_in '.$col_width.'">';
                $render_modules .= '<div class="content_in_wrapper">';
                $render_modules .= $bk_contentin1->render($post_args);
                $render_modules .= '</div></li><!-- end post item -->';
            endwhile;

        endif;
        return $render_modules;
    }
    
}