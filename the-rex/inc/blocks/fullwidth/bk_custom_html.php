<?php
class bk_custom_html extends bk_section_parent  {
    
    public function render( $page_info ) {
        $block_str = '';
        $custom_html = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_custom_html', true );
        if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
            $bkwrapper_container = '';                         
        }else {
            $bkwrapper_container = 'bkwrapper container';            
        }
        $block_str .= '<div class="bkmodule module-custom-html '.$bkwrapper_container.' clearfix">';
        $block_str .= bk_core::bk_get_block_title($page_info);  //render block title
        $block_str .= $custom_html;
        $block_str .= '</div>';
        wp_reset_postdata();
        return $block_str;
	}
    
}