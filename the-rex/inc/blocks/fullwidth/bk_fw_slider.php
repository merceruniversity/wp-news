<?php
class bk_fw_slider extends bk_section_parent  {
    
    public function render( $page_info ) {
        $block_str = '';
        $cfg_ops = array();
        $cfg_ops = $this->cfg_options(); 
        $module_cfg = bk_get_cfg::configs($cfg_ops['fullwidth']['bk_fw_slider'], $page_info);    //get block config
        
        $the_query = bk_get_query::query($module_cfg);              //get query

        $block_str .= '<div class="bkmodule module-fw-slider bk-slider-module">';
        $block_str .= $this->render_modules($the_query);            //render modules
        $block_str .= '</div>';
        
        unset($cfg_ops); unset($module_cfg); unset($the_query);     //free
        wp_reset_postdata();
        return $block_str;
	}
    static function render_modules ($the_query){
        $render_modules = '';
        $bk_contentin1_2 = new bk_contentin1_2;
        $meta_ar = array('cat', 'review', 'date');
        $post_args = array (
            'thumbnail_size'    => 'full',
            'meta_ar'           => $meta_ar,
            'title_length'      => 15,
            'excerpt_length'    => 25
        );
        if ( $the_query->have_posts() ) :            
            $render_modules .= '<div class="row flexslider">';
            $render_modules .= '<ul class="col-md-12 slides">';
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $post_args['postID'] = get_the_ID();
                $render_modules .= '<li class="item content_in">';
                $render_modules .= $bk_contentin1_2->render($post_args);
                $render_modules .= '</li>';
            endwhile;
            
            $render_modules .= '</ul></div> <!-- Close render modules -->';
            
        endif;
        return $render_modules;
    }
    
}