<?php
class bk_carousel_type2 extends bk_section_parent  {
    
    public function render( $page_info ) {
        $block_str = '';
        $cfg_ops = array();
        $cfg_ops = $this->cfg_options(); 
        $module_cfg = bk_get_cfg::configs($cfg_ops['fullwidth']['bk_carousel_type2'], $page_info);    //get block config
        $bk_post_icon = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );
        $sec = '';
        $has_bkwrapper = '';
        if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
            $has_bkwrapper = '';                 
        }else {
            $has_bkwrapper = 'bkwrapper container';   
        }
        $the_query = bk_get_query::query($module_cfg);//get query

        $block_str .= '<div class="bkmodule module-carousel-2 hide" style="background-color: '.$module_cfg['bg_color'].'">';
        if ( $the_query->have_posts() ) :
            $block_str .= bk_core::bk_get_block_title($page_info);  //render block title
        endif;
        $block_str .= '<div class="'.$has_bkwrapper.' carousel-type-2"><div class="row"><div class="bk-carousel-wrap flexslider" style="background-color: '.$module_cfg['bg_color'].'">';
        $block_str .= $this->render_modules($the_query, $bk_post_icon);
        $block_str .= '</div></div></div></div>';
        
        unset($cfg_ops); unset($module_cfg); unset($the_query);
        wp_reset_postdata();
        return $block_str;
	}
    static function render_modules ($the_query, $bk_post_icon){
        $render_modules = '';
        $bk_contentout2 = new bk_contentout2;
        $meta_ar = array('cat', 'review', 'author', 'postview', 'postcomment');
        $post_args = array (
            'thumbnail_size'    => 'bk360_248',
            'meta_ar'           => $meta_ar,
            'title_length'      => 15,
            'excerpt_length'    => 20,
            'post_icon'         => $bk_post_icon            
        );
        if ( $the_query->have_posts() ) :
            $render_modules .= '<ul class="slides clearfix">';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $post_args['postID'] = get_the_ID();
                $render_modules .= '<li class="row-type content_out col-md-4 col-sm-6"><div class="post-wrapper-inner">';
                $render_modules .= $bk_contentout2->render($post_args);
                $render_modules .= '</div></li><!-- end post item -->';
            endwhile;
            $render_modules .= '</ul> <!-- Close render slider -->';
        endif;
        return $render_modules;
    }
    
}