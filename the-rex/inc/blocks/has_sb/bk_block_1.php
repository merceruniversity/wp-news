<?php
class bk_block_1 extends bk_section_parent  {
    
    public function render( $page_info ) {
        $block_str = '';
        $cfg_ops = array();
        $cfg_ops = $this->cfg_options(); 
        $bk_post_icon = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_post_icon', true );
        
        $module_cfg = bk_get_cfg::configs($cfg_ops['has_sb']['bk_block_1'], $page_info);    //get block config
        $module_cfg['limit'] = 5;
        
        $the_query = bk_get_query::query($module_cfg);              //get query

        $block_str .= '<div class="bkmodule module-block-1 clearfix">';
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
        $bk_contentout3 = new bk_contentout3;
        $meta_ar = array('cat', 'review', 'postview', 'postcomment');
        $post_args = array (
            'thumbnail_size'    => 'bk620_420',
            'meta_ar'           => $meta_ar,
            'title_length'      => 15,
            'post_icon'         => $bk_post_icon, 
            'excerpt_length'    => 22           
        );        
        if ( $the_query->have_posts() ) :            
            $render_modules .= '<div class="row clearfix">';
            
            if ( $the_query->have_posts() ) :
                foreach( range( 1, 1) as $i ):
                    $the_query->the_post();
                    $post_args['postID'] = get_the_ID();
                    $render_modules .= '<div class="large-post row-type content_out col-md-6 col-sm-6 "><div class="post-wrapper-inner">';
                    $render_modules .= $bk_contentout2->render($post_args);               
                    $render_modules .=  '</div></div>';
                endforeach;        

            endif;
            $post_args = array (
                'thumbnail_size'    => 'bk150_100',
                'meta_ar'           => '',
                'title_length'      => 15,
                'post_icon'         => ''
            );
            if ( $the_query->have_posts() ) :
                $render_modules .= '<div class="col-md-6 col-sm-6 clearfix">';
                $render_modules .= '<ul class="list-small-post">';
                foreach( range( 1, $the_query->post_count - 1) as $i ):
                    $the_query->the_post();
                    $post_args['postID'] = get_the_ID();                    
                    $render_modules .= '<li class="small-post content_out clearfix">';
                    $render_modules .= $bk_contentout3->render($post_args);
                    $render_modules .= '</li><!-- End post -->';        
                endforeach;
                $render_modules .= '</ul> <!-- End list-post -->';
                $render_modules .= '</div><!-- End Column -->';
            endif;
            
            $render_modules .= '</div><!-- Close render modules -->';
            
        endif;
        return $render_modules;
    }
    
}