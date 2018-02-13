<?php
class bk_two_col_ads extends bk_section_parent  {
    public function render( $page_info ) {
        $image_url1 = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_image_url1', true );
        $url1 = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_url1', true );
        $image_url2 = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_image_url2', true );
        $url2 = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_url2', true );
        $sec = '';
        $has_bkwrapper = '';
        if (substr( $page_info['block_prefix'], 0, 10 ) == 'bk_has_rsb') {
            $has_bkwrapper = '';                 
        }else {
            $has_bkwrapper = 'bkwrapper container';   
        }
        $block_str = '';
        $block_str .= '<div class="bkmodule '.$has_bkwrapper.' module-ads ad-cols">';
        $block_str .= '<ul class="bk-ads row">';
        if (strlen($image_url1) > 0) {
            $block_str .= '<li class="col-md-6">';
           	$block_str .= '<a class="ads-banner-link" target="_blank" href="'.esc_url($url1).'">';
 			$block_str .= '<img class="ads-banner" src="'.esc_url($image_url1).'" alt=""/>';
  		    $block_str .= '</a>';
            $block_str .= '</li>';
        }
        if (strlen($image_url2) > 0) {
            $block_str .= '<li class="col-md-6">';
           	$block_str .= '<a class="ads-banner-link" target="_blank" href="'.esc_url($url2).'">'; 
 			$block_str .= '<img class="ads-banner" src="'.esc_url($image_url2).'" alt=""/>';
  		    $block_str .= '</a>';
            $block_str .= '</li>';
        }
        $block_str .= '</ul><!-- Close render ads wrap -->';
        $block_str .= '</div><!-- Close ads module -->';
        return $block_str;
	}    
}