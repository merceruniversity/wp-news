<?php
class bk_block_2 extends bk_section_parent  {
    
    public function render( $page_info ) {
        $block_str = '';
        $cfg_ops = array();
        $cfg_ops = $this->cfg_options(); 
        $module_cfg = bk_get_cfg::configs($cfg_ops['has_sb']['bk_block_2'], $page_info);    //get block config
        
        $the_query = bk_get_query::query($module_cfg);              //get query

        $block_str .= '<div class="bkmodule module-block-2 clearfix">';
        if ( $the_query->have_posts() ) :
            $block_str .= bk_core::bk_get_block_title($page_info);  //render block title
        endif;
        $block_str .= $this->render_modules($the_query);            //render modules
        $block_str .= '</div>';
        
        unset($cfg_ops); unset($module_cfg); unset($the_query);     //free
        wp_reset_postdata();
        return $block_str;
	}
    public function render_modules ($the_query){
        $render_modules = '';
        $bk_contentout3 = new bk_contentout3;
        $post_args = array (
                'thumbnail_size'    => 'bk150_100',
                'meta_ar'           => '',
                'title_length'      => 15,
                'post_icon'         => ''
            );
        if ( $the_query->have_posts() ) :            
            $render_modules .= '<ul class="list-small-post row">';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $post_args['postID'] = get_the_ID();
                $render_modules .= '<li class="small-post content_out col-md-6 col-sm-6 clearfix">';
                $render_modules .= $bk_contentout3->render($post_args);
                $render_modules .= '</li><!-- End post -->';        
            endwhile;
            $render_modules .= '</ul> <!-- End list-post -->';
            
        endif;
        return $render_modules;
    }
    
}