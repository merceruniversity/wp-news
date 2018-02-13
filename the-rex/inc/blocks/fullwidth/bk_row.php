<?php
class bk_row extends bk_section_parent  {
    
    public function render( $page_info ) {
        $block_str = '';
        $cfg_ops = array();
        $cfg_ops = $this->cfg_options(); 
        $bk_post_icon = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );
        $module_cfg = bk_get_cfg::configs($cfg_ops['fullwidth']['bk_row'], $page_info);    //get block config
        $module_cfg['limit'] = $module_cfg['limit']*3;
        
        $the_query = bk_get_query::query($module_cfg);              //get query

        $block_str .= '<div class="bkmodule container bkwrapper module-row clearfix">';
        if ( $the_query->have_posts() ) :
            $block_str .= bk_core::bk_get_block_title($page_info);  //render block title
        endif;
        $block_str .= $this->render_modules($the_query, $bk_post_icon);            //render modules
        $block_str .= '</div>';
        
        unset($cfg_ops); unset($module_cfg); unset($the_query);     //free
        wp_reset_postdata();
        return $block_str;
	}
    public function render_modules ($the_query, $bk_post_icon){
        $render_modules = '';
        $bk_contentout2 = new bk_contentout2;
        $meta_ar = array('cat', 'review', 'author');
        $post_args = array (
            'thumbnail_size'    => 'bk360_248',
            'meta_ar'           => $meta_ar,
            'title_length'      => 15,
            'excerpt_length'    => 30,
            'post_icon'         => $bk_post_icon            
        );
        if ( $the_query->have_posts() ) :            
            $render_modules .= '<ul class="row clearfix">';
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $post_args['postID'] = get_the_ID();
                $render_modules .= '<li class="row-type content_out col-md-4 col-sm-6"><div class="post-wrapper-inner">';
                $render_modules .= $bk_contentout2->render($post_args);
                $render_modules .= '</div></li><!-- end post item -->';
            endwhile;
            
            $render_modules .= '</ul><!-- Close render modules -->';
            
        endif;
        return $render_modules;
    }
    
}