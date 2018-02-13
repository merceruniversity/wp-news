<?php
class bk_feature_slider extends bk_section_parent  {
    
    public function render( $page_info ) {
        $block_str = '';
        $cfg_ops = array();
        $cfg_ops = $this->cfg_options(); 
        $sec = '';
        $has_bkwrapper = '';
        if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
            $has_bkwrapper = '';                 
        }else {
            $has_bkwrapper = 'bkwrapper container';   
        }
        $module_cfg = bk_get_cfg::configs($cfg_ops['fullwidth']['bk_feature_slider'], $page_info);
        
        $the_query = bk_get_query::query($module_cfg);

        $block_str .= '<div class="bkmodule '.$has_bkwrapper.' module-feature-slider bk-slider-module">';
        if ( $the_query->have_posts() ) :
            $block_str .= bk_core::bk_get_block_title($page_info);  //render block title
        endif;
        $block_str .= $this->render_modules($the_query);
        $block_str .= '</div>';
        
        unset($cfg_ops); unset($module_cfg); unset($the_query);
        wp_reset_postdata();
        return $block_str;
	}
    static function render_modules ($the_query){
        $render_modules = '';
        $bk_contentin = new bk_contentin1_3;
        $meta_ar = array('cat', 'review', 'date');
        $post_args = array (
            'thumbnail_size'    => 'full',
            'meta_ar'           => $meta_ar,
            'title_length'      => 15,
            'excerpt_length'    => 60
        );
        if ( $the_query->have_posts() ) :            
            $render_modules .= '<div class="row flexslider">';
            $render_modules .= '<ul class="col-md-12 slides">';
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $post_args['postID'] = get_the_ID();
                $render_modules .= '<li class="item content_in">';
                $render_modules .= $bk_contentin->render($post_args);
                $render_modules .= '</li>';
            endwhile;
            
            $render_modules .= '</ul></div> <!-- Close render modules -->';
            
        endif;
        return $render_modules;
    }
    
}