<?php
class bk_ads extends bk_section_parent  {
    public function render( $page_info ) {
        $image_url = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_image_url', true );
        $url = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_url', true );
        $sec = '';
        $has_bkwrapper = '';
        if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
            $has_bkwrapper = '';                 
        }else {
            $has_bkwrapper = 'bkwrapper container';   
        }
        $block_str = '';
        $block_str .= '<div class="bkmodule '.$has_bkwrapper.' module-ads">';
        $block_str .= '<div class="bk-ads">';
        if (strlen($image_url) > 0) {
           	$block_str .= '<a class="ads-banner-link" target="_blank" href="'.esc_url($url).'">';
     		$block_str .= '<img class="ads-banner" src="'.esc_url($image_url).'" alt=""/>';
     		$block_str .= '</a>';
        }                   
        $block_str .= '</div><!-- Close render ads wrap -->';
        $block_str .= '</div><!-- Close ads module -->';
        return $block_str;
	}    
}