<?php
class bk_adsense extends bk_section_parent  {
    public function render( $page_info ) {
        $adsense_code = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_adsense_code', true );
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
        if (strlen($adsense_code) > 0) {
            $block_str .= $adsense_code; 
        }           
        $block_str .= '</div><!-- Close render ads wrap -->';
        $block_str .= '</div><!-- Close ads module -->';
        return $block_str;
	}    
}