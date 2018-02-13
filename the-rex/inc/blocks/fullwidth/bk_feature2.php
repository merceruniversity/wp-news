<?php
class bk_feature2 extends bk_section_parent  {
    
    public function render( $page_info ) {
        $block_str = '';
        $cfg_ops = array();
        $cfg_ops = $this->cfg_options(); 
        $bk_post_icon = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );
        
        $module_cfg = bk_get_cfg::configs($cfg_ops['fullwidth']['bk_feature2'], $page_info);    //get block config
        
        $the_query = bk_get_query::query($module_cfg);              //get query

        $block_str .= '<div class="bkmodule module-feature2" style="background-color: '.$module_cfg['bg_color'].'">';
        if ( $the_query->have_posts() ) :
            //$block_str .= bk_core::bk_get_block_title($page_info);  //render block title
        endif;
        $block_str .= $this->render_modules($the_query, $module_cfg, $bk_post_icon);            //render modules
        $block_str .= '</div>';
        
        unset($cfg_ops); unset($module_cfg); unset($the_query);     //free
        wp_reset_postdata();
        return $block_str;
	}
    public function render_modules ($the_query, $module_cfg, $bk_post_icon){
        $render_modules = '';
        $bk_contentout1 = new bk_contentout1;
        $meta_ar = array('cat', 'review', 'date');
        $post_args = array (
            'thumbnail_size'    => 'bk800_520',
            'meta_ar'           => $meta_ar,
            'title_length'      => 15,
            'excerpt_length'    => 50,
            'post_icon'         => $bk_post_icon
        );
        if ( $the_query->have_posts() ) :            
            $render_modules .= '<div class="row">';
            $render_modules .= '<div class="flexslider" style="background-color: '.$module_cfg['bg_color'].'">';
            $render_modules .= '<ul class="slides">';
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $post_args['postID'] = get_the_ID();
                $render_modules .= '<li class="content_out">';
                $render_modules .= '<div class="container bkwrapper"><div class="article-wrapper row">';
                $render_modules .= $bk_contentout1->render($post_args);
                $render_modules .= '</div></div></li>';
            endwhile;
            
            $render_modules .= '</ul></div></div> <!-- Close render modules -->';
            
        endif;
        return $render_modules;
    }
    
}