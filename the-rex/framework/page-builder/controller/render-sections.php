<?php
/* -----------------------------------------------------------------------------
 * Render Sections
 * -------------------------------------------------------------------------- */
if ( ! function_exists( 'bk_page_builder' ) ) {
	function bk_page_builder( $args=array() ) {
		$page_info['page_id'] = get_queried_object_id();
        global $bk_ajax_btnstr, $bk_option;
        wp_localize_script( 'bk-module-load-post', 'ajax_btn_str', $bk_ajax_btnstr );
		for ( $counter=1; $counter < 50; $counter++ ) { 
			$field_prefix = 'bk_section_'.$counter;
			$section_type = get_post_meta( $page_info['page_id'], $field_prefix, true );
			if ( ! $section_type ) break;

            if ($section_type == 'fullwidth'){?>
                <div class="fullwidth bksection">
                    <div class="sec-content">
                        <?php
                        for ($mcount=1; $mcount <50; $mcount ++) {
                            $page_info['block_prefix'] = 'bk_fullwidth_module_'.$counter.'_'.$mcount;
                            $block_type = get_post_meta( $page_info['page_id'], $page_info['block_prefix'], true );
                            if ( ! $block_type ) break;
                            $class = "bk_".$block_type;
                            $section_render = new $class();
                            echo ($section_render->render($page_info));
                        }?>
                    </div>
                </div>
            <?php
            }else if($section_type == 'has-rsb') {
                $sidebar_prefix = 'bk_sidebar_'.$counter;
                $sidebar = get_post_meta( $page_info['page_id'], $sidebar_prefix, true );?>
                
                <div class="has-sb container bkwrapper bksection">
                    <div class="row">
                        <div class="content-wrap col-md-8">
                        <?php
                            for ($mcount=1; $mcount <50; $mcount ++) {
                                $page_info['block_prefix'] = 'bk_has_rsb_module_'.$counter.'_'.$mcount;
                                $block_type = get_post_meta( $page_info['page_id'], $page_info['block_prefix'], true );
                                if ( ! $block_type ) break;
                                $class = "bk_".$block_type;
                                $section_render = new $class();
                                echo ($section_render->render($page_info));
                            }?>
                        </div>
                    
                        <div class='sidebar col-md-4'>
                            <div class="sidebar-wrap <?php if($bk_option['pagebuilder-sidebar'] == 'enable') echo 'stick';?>" id="<?php echo ($sidebar_prefix);?>">
                                <div class="sidebar-wrap-inner">
                                    <?php dynamic_sidebar( $sidebar );?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
		}
	}
}
