<?php
class bk_get_query extends bk_section_parent {
    static function query($atts, $moduleID = '') {
        global $bk_option;
        $args = array();
        $atts = shortcode_atts(
            array(
                'category_id'   => '',
                'limit'         => '',
                'feature'       => '',
                'offset'        => 0,
                'order'         => 'date',
            ),$atts);

        $feat_tag = '';
        if (isset($bk_option)):
            if (isset($bk_option['feat-tag']) && ($bk_option['feat-tag'] != '')){
                $feat_tag = $bk_option['feat-tag'];
            }
        endif;
        if ($atts['feature'] == 'yes') {
            if ($feat_tag != '') {
                $args = array(
    				'tag__in' => $feat_tag,
        			'post_status' => 'publish',
        			'ignore_sticky_posts' => 1,
        			'posts_per_page' => $atts['limit'],
                    'offset' => $atts['offset'],
                    'orderby' =>  $atts['order'],
                );   
            } else {
                $args = array(
    				'post__in'  => get_option( 'sticky_posts' ),
    				'post_status' => 'publish',
    				'ignore_sticky_posts' => 1,
    				'posts_per_page' => $atts['limit'],
                    'offset' => $atts['offset'],
                    'orderby' =>  $atts['order'],
                );
            }         
        }else {
    		$args = array(
    			'post_type' => 'post',
    			'ignore_sticky_posts' => 1,
                'post_status' => 'publish',
    			'posts_per_page' => $atts['limit'],
                'offset' => $atts['offset'],
                'orderby' =>  $atts['order'],
    			// 'meta_key' => '_thumbnail_id', //Only posts that have featured image
    		);
        }
        if ( $atts['category_id'] >= 1 ) {
            if (strpos($atts['category_id'], ",") > 0) {
                $bkcategories = explode(',',$atts['category_id'],1000);
            }else {
                $bkcategories = $atts['category_id'];
            }
            $args[ 'category__in' ] = $bkcategories;
		}
        $the_query = new WP_Query( $args );
        if($moduleID != null) {
            parent::$bk_ajax_c[$moduleID]['args'] = $args;
        }         
        unset($args);
         
        return $the_query;
    }
}