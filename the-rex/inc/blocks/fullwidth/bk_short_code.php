<?php
class bk_shortcode extends bk_section_parent  {
    
    public function render( $page_info ) {
        $block_str = '';
        $i=0;
        $shortcode_str = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_shortcode', true );
        $shortcodes = explode("[bkend]",$shortcode_str);
        if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
            $bkwrapper_container = '';                         
        }else {
            $bkwrapper_container = 'bkwrapper container';            
        }
        $block_str .= '<div class="bkmodule module-shortcode '.$bkwrapper_container.' clearfix">';
        $block_str .= bk_core::bk_get_block_title($page_info);  //render block title
        $block_str .= '<div class="bkshortcode-wrapper">';
        for ($i=0; $i< count($shortcodes); $i++) {
            $block_str .= do_shortcode($shortcodes[$i]);
        }
        $block_str .= '</div><!-- End bkshortcode-wrapper --></div><!-- End module-shortcode -->';
        wp_reset_postdata();
        return $block_str;
	}
    
}