<?php
class bk_feature1 extends bk_section_parent  {
    
    public function render( $page_info ) {
        $block_str = '';
        $cfg_ops = array();
        $cfg_ops = $this->cfg_options(); 
        $columns = '';
        if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
            $container = '';                   
        }else {
            $container = 'bkwrapper container';                  
        }
        $module_cfg = bk_get_cfg::configs($cfg_ops['fullwidth']['bk_feature1'], $page_info);    //get block config

        $the_query = bk_get_query::query($module_cfg);              //get query

        $block_str .= '<div class="bkmodule module-grid clearfix '.$container.'">';
        if($the_query->post_count < 5) {
            $block_str .= 'Found '.$the_query->post_count.' posts that corresponds to your conditions. This module (bk grid) need at least 5 posts to work properly. Please try to create more posts';
        }else {
            if ( $the_query->have_posts() ) :
                $block_str .= bk_core::bk_get_block_title($page_info);  //render block title
            endif;
            $block_str .= $this->render_modules($the_query);            //render modules
        }
        $block_str .= '</div>';
        
        unset($cfg_ops); unset($module_cfg); unset($the_query);     //free
        wp_reset_postdata();
        return $block_str;
	}
    public function render_modules ($the_query){
        $render_modules = '';
        $bk_contentin1 = new bk_contentin1;
        if ( $the_query->have_posts() ) :   
            $meta_ar = array('cat', 'review', 'date');
            $post_args = array (
                'thumbnail_size'    => 'full',
                'meta_ar'           => $meta_ar,
                'title_length'      => 15
            );
            $render_modules .= '<div class="flexslider">';
            if ( $the_query->have_posts() ) :
                $render_modules .= '<ul class="slides">';
                foreach( range( 1, $the_query->post_count - 4) as $i ):
                    $the_query->the_post();
                    $post_args['postID'] = get_the_ID();
                    $render_modules .= '<li class="large-item content_in">';
                    $render_modules .= $bk_contentin1->render($post_args);
                    $render_modules .=  '</li>';
                endforeach;
                $render_modules .= '</ul>';

            endif;
            $render_modules .= '</div><!-- Close slider -->';
            if ( $the_query->have_posts() ) :
                $post_args = array (
                    'thumbnail_size'    => 'full',
                    'meta_ar'           => $meta_ar,
                    'title_length'      => 15
                );
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $post_args['postID'] = get_the_ID();
                    $render_modules .= '<div class="small-item content_in"><div class="post-inner">';
                    $render_modules .= $bk_contentin1->render($post_args);
                    $render_modules .= '</div></div><!-- End post -->';        
                endwhile;
            endif;
            
        endif;
        return $render_modules;
    }
    
}