<?php
if ( ! function_exists( 'bk_review_score' ) ) {
    function bk_review_score ($post_id) {
        $ret = '';
        if (strlen(get_post_meta($post_id, 'bk_final_score', true)) > 0) {
            $ret .= '<div class="review-score">';
            $ret .= '<span><i class="fa fa-star-o"></i></span>';
            $ret .= get_post_meta($post_id, 'bk_final_score', true);
            $ret .= '</div>';
        }
        return $ret;
    }
}
/**
 * ********* Get Post Category ************
 *---------------------------------------------------
 */ 
if ( ! function_exists('bk_get_category_link')){
    function bk_get_category_link($postid){ 
        $html = '';
        $category = get_the_category($postid); 
        if(isset($category[0]) && $category[0]){
            foreach ($category as $key => $value) {
                if($key != 0) {
                    $html.=', ';
                }
                $html.= '<a href="'.get_category_link($value->term_id ).'">'.$value->cat_name.'</a>';  
            }
        						
        }
        return $html;
    }
}
// Square Grid
add_action( 'wp_ajax_square_grid_load', 'bk_ajax_square_grid_load' );
add_action('wp_ajax_nopriv_square_grid_load', 'bk_ajax_square_grid_load');
if ( ! function_exists( 'bk_ajax_square_grid_load' ) ) {
    function bk_ajax_square_grid_load() {
        $post_offset = isset( $_POST['post_offset'] ) ? $_POST['post_offset'] : 0;
        $entries = isset( $_POST['entries'] ) ? $_POST['entries'] : 0;
        $sec = isset( $_POST['sec'] ) ? $_POST['sec'] : 0;
        $args = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $args[ 'posts_per_page' ] = $entries;
        $args[ 'offset' ] = $post_offset;
                
        $the_query = new WP_Query( $args );
        echo bk_square_grid::render_modules($the_query, $sec);
        die();
    }
}
// Small Blog
add_action( 'wp_ajax_blog_load', 'bk_ajax_blog_load' );
add_action('wp_ajax_nopriv_blog_load', 'bk_ajax_blog_load');
if ( ! function_exists( 'bk_ajax_blog_load' ) ) {
    function bk_ajax_blog_load() {
        $post_offset = isset( $_POST['post_offset'] ) ? $_POST['post_offset'] : 0;
        $entries = isset( $_POST['entries'] ) ? $_POST['entries'] : 0;
        $args = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $post_icon = isset( $_POST['post_icon'] ) ? $_POST['post_icon'] : 0; 
        $args[ 'posts_per_page' ] = $entries;
        $args[ 'offset' ] = $post_offset;
                
        $the_query = new WP_Query( $args );
        echo bk_classic_blog::render_modules($the_query, $post_icon);
        die();
    }
}
// Latge Blog
add_action( 'wp_ajax_large_blog', 'bk_ajax_large_blog' );
add_action('wp_ajax_nopriv_large_blog', 'bk_ajax_large_blog');
if ( ! function_exists( 'bk_ajax_large_blog' ) ) {
    function bk_ajax_large_blog() {
        $post_offset = isset( $_POST['post_offset'] ) ? $_POST['post_offset'] : 0;
        $entries = isset( $_POST['entries'] ) ? $_POST['entries'] : 0;
        $args = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $post_icon = isset( $_POST['post_icon'] ) ? $_POST['post_icon'] : 0;        
        $args[ 'posts_per_page' ] = $entries;
        $args[ 'offset' ] = $post_offset;
                
        $the_query = new WP_Query( $args );
        echo bk_large_blog::render_modules($the_query, $post_icon);
        die();
    }
}
// Masonry
add_action( 'wp_ajax_masonry_load', 'bk_ajax_masonry_load' );
add_action('wp_ajax_nopriv_masonry_load', 'bk_ajax_masonry_load');
if ( ! function_exists( 'bk_ajax_masonry_load' ) ) {
    function bk_ajax_masonry_load() {
        $post_offset = isset( $_POST['post_offset'] ) ? $_POST['post_offset'] : 0;
        $entries = isset( $_POST['entries'] ) ? $_POST['entries'] : 0;
        $sec = isset( $_POST['sec'] ) ? $_POST['sec'] : 0;
        $post_icon = isset( $_POST['post_icon'] ) ? $_POST['post_icon'] : 0;
        $args = isset( $_POST['args'] ) ? $_POST['args'] : null;    
        $args[ 'posts_per_page' ] = $entries;
        $args[ 'offset' ] = $post_offset;
                
        $the_query = new WP_Query( $args );
        echo bk_masonry::render_modules($the_query, $sec, $post_icon);
        die();
    }
}
//render search form
if (!function_exists('bk_ajax_form_search')) {
    function bk_ajax_form_search()
    {
        $str = '';
        $str .= '<div class="ajax-search-wrap">';
        $str .= '<div id="ajax-form-search" class="ajax-search-icon"><i class="fa fa-search"></i></div>';
        $str .= '<form class="ajax-form" method="get" action="' . esc_url(home_url('/')) . '">';
        $str .= '<fieldset>';
        $str .= '<input id="search-form-text" type="text" class="field" name="s" autocomplete="off" value="" placeholder="' . esc_html__('Search and hit enter..', 'the-rex') . '">';
        $str .= '</fieldset>';
        $str .= '</form>';
        $str .= ' <div id="ajax-search-result"></div></div>';
        return $str;
    }
}

/**
 * ************* update image feature for image post  *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_set_image_post_as_featured_image') ) {
    
    function bk_set_image_post_as_featured_image($bkPostId) {
        $format = get_post_format( $bkPostId );
        if(($format == 'image') && (!has_post_thumbnail($bkPostId))){
            $attachment_id = get_post_meta($bkPostId, 'bk_image_upload', true );
            set_post_thumbnail( $bkPostId, $attachment_id );
        }
    }
}    
add_action('save_post', 'bk_set_image_post_as_featured_image', 100);
/**
 * BK Comments
 */
if ( ! function_exists( 'bk_comments') ) {
    function bk_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; 
        $args['reply_text'] = esc_html__('Reply', 'the-rex');
        ?>
		<li <?php comment_class(); ?>>
			<article id="comment-<?php comment_ID(); ?>" class="comment-article  media">
                <header class="comment-author clear-fix">
                    <div class="comment-avatar">
                        <?php echo get_avatar( get_comment_author_email(), 60 ); ?>  
                    </div>
                        <?php printf('<span class="comment-author-name">%s</span>', get_comment_author_link()) ?>
    					          <span class="comment-time" datetime="<?php comment_time('c'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>" class="comment-timestamp"><?php comment_time(esc_html__('j F, Y \a\t H:i', 'the-rex')); ?> </a></span>
                        <span class="comment-links">
                            <?php
                                edit_comment_link(esc_html__('Edit', 'the-rex'),'  ','');
                                comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));
                            ?>
                        </span>
                    </header><!-- .comment-meta -->
                
                <div class="comment-text">
                    				
    				<?php if ($comment->comment_approved == '0') : ?>
    				<div class="alert info">
    					<p><?php esc_html_e('Your comment is awaiting moderation.', 'the-rex') ?></p>
    				</div>
    				<?php endif; ?>
    				<section class="comment-content">
    					<?php comment_text() ?>
    				</section>
                </div>
			</article>
		<!-- </li> is added by WordPress automatically -->
		<?php
    }
}
add_action('wp_footer', 'bk_user_rating');

// User Rating System
if ( ! function_exists( 'bk_user_rating' ) ) {
    function bk_user_rating() {
        if (is_single()) {
            global $wp_query;
            global $bk_option;
            $post = $wp_query->post;
            $bk_review_checkbox = get_post_meta( $post->ID, 'bk_review_checkbox', true );
            if ($bk_review_checkbox == 1) {
                if(isset($bk_option['bk-rtl-sw'])) {
                    $rtl = $bk_option['bk-rtl-sw'];
                }
                $user_rating_script = "";            
                $user_rating_script.= " <script type='text/javascript'>
                var bkExistingOverlay=0, bkWidthDivider = 1, old_val=0, new_val=1;
                old_val = jQuery('#bk-rate').find('.bk-overlay').width();
                jQuery(window).resize(function(){
                    x = jQuery('#bk-rate').find('.bk-overlay').find('span').width();
                    y = jQuery('#bk-rate').find('.bk-overlay').width();
                    new_val = y;
                    //console.log(x);
                    //console.log(y);
                    //console.log(new_val);
                    //console.log(old_val);
                    if (new_val != old_val) {
                        bkExistingOverlay = ((x/old_val)*y).toFixed(0)+'px';
                        old_val = new_val;
                    }
                    bkWidthDivider = jQuery('#bk-rate').width() / 100;
                    //console.log(bkExistingOverlay);
                    jQuery('#bk-rate').find('.bk-overlay').find('span').css( {'width': bkExistingOverlay} );
                });
                (function ($) {'use strict';
                    var bkRate = $('#bk-rate'), 
                        bkCriteriaAverage = $('.bk-criteria-score.bk-average-score'),
                        bkRateCriteria = bkRate.find('.bk-criteria'),
                        bkRateOverlay = bkRate.find('.bk-overlay');
                            
                        var bkExistingOverlaySpan = bkRateOverlay.find('span'),
                            bkNotRated = bkRate.not('.bk-rated').find('.bk-overlay');
                            
                        bkExistingOverlay = bkExistingOverlaySpan.css('width');
                        bkExistingOverlaySpan.addClass('bk-zero-trigger');
                        
                    var bkExistingScore =  $(bkCriteriaAverage).text(),
                        bkExistingRateLine = $(bkRateCriteria).html(),
                        bkRateAmount  = $(bkRate).find('.bk-criteria span').text();
                        bkWidthDivider = ($(bkRate).width() / 100);
                        
                    if ( typeof bkExistingRateLine !== 'undefined' ) {
                        var bkExistingRatedLine = bkExistingRateLine.substr(0, bkExistingRateLine.length-1) + ')'; 
                    }
                    var bk_newRateAmount = parseInt(bkRateAmount) + 1;
                    if ( (bkRateAmount) === '0' ) {
                        var bkRatedLineChanged = '". esc_html__('Reader Rating', 'the-rex') .": (' + (bk_newRateAmount) + ' ". esc_html__('Rate', 'the-rex') .")';
                    } else {
                        var bkRatedLineChanged = '". esc_html__('Reader Rating', 'the-rex') .": (' + (bk_newRateAmount) + ' ". esc_html__('Rates', 'the-rex') .")';      
                    }
    
                    if (bkRate.hasClass('bk-rated')) {
                        bkRate.find('.bk-criteria').html(bkExistingRatedLine); 
                    }
    
                    bkNotRated.on('mousemove click mouseleave mouseenter', function(e) {
                        var bkParentOffset = $(this).parent().offset();  
                        ";
                        if(isset($bk_option['bk-rtl-sw']) && ($bk_option['bk-rtl-sw'])) {
                            $user_rating_script.= "
                            var bkBaseX =  100 - (Math.ceil((e.pageX - bkParentOffset.left) / bkWidthDivider));";
                        }else {
                            $user_rating_script.= "
                            var bkBaseX = Math.ceil((e.pageX - bkParentOffset.left) / bkWidthDivider);";
                        }
                        $user_rating_script.= "
                        var bkFinalX = (bkBaseX / 10).toFixed(1);
                        bkCriteriaAverage.text(bkFinalX);
                        
                        bkExistingOverlaySpan.css( 'width', (bkBaseX +'%') );
     
                        if ( e.type == 'mouseleave' ) {
                            bkExistingOverlaySpan.animate( {'width': bkExistingOverlay}, 300); 
                            bkCriteriaAverage.text(bkExistingScore); 
                        }
                        
                        if ( e.type == 'click' ) {
                                var bkFinalX = bkFinalX;
                                console.log(bkRatedLineChanged);
                                bkRateCriteria.fadeOut(550, function () {  $(this).fadeIn(550).html(bkRatedLineChanged);  });
                                var bkParentOffset = $(this).parent().offset(),
                                    nonce = $('input#rating_nonce').val(),
                                    bk_data_rates = { 
                                            action  : 'bk_rate_counter', 
                                            nonce   : nonce, 
                                            postid  : '". $post->ID ."' 
                                    },
                                    bk_data_score = { 
                                            action: 'bk_add_user_score', 
                                            nonce: nonce, 
                                            bkCurrentRates: bkRateAmount, 
                                            bkNewScore: bkFinalX, 
                                            postid: '". $post->ID ."' 
                                    };
                                
                                bkRateOverlay.off('mousemove click mouseleave mouseenter'); 
                                        
                                $.post('". admin_url('admin-ajax.php'). "', bk_data_rates, function(bk_rates) {
                                    if ( bk_rates !== '-1' ) {
                                        
                                        var bk_checker = cookie.get('bk_user_rating'); 
                                       
                                        if (!bk_checker) {
                                            var bk_rating_c = '" . $post->ID . "';
                                        } else {
                                            var bk_rating_c = bk_checker + '," . $post->ID . "';
                                        }
                                       cookie.set('bk_user_rating', bk_rating_c, { expires: 1, }); 
                                    } 
                                });
                                        
                                $.post('". admin_url('admin-ajax.php') ."', bk_data_score, function(bk_score) {
                                        var res = bk_score.split(' ');
                                        if ( ( res[0] !== '-1' ) && ( res[0] !=='null' ) ) {
                                            
                                                var bkScoreOverlay = (res[0]*10);
                                                var latestScore = res[1];
                                                var bkScore_display = (parseFloat(res[0])).toFixed(1);
                                                var overlay_w = jQuery('#bk-rate').find('.bk-overlay').width();
                                                
                                                var bkScoreOverlay_px = (bkScoreOverlay*overlay_w)/100;
                                                
                                                old_val = overlay_w;
                                                
                                                bkCriteriaAverage.html( bkScore_display ); 
                                               
                                                bkExistingOverlaySpan.css( 'width', bkScoreOverlay_px +'px' );
                                                bkRate.addClass('bk-rated');
                                                bkRateOverlay.addClass('bk-tipper-bottom').attr('data-title', '". esc_html__('You have rated ', 'the-rex') . "' + latestScore + ' points for this post');
                                                bkRate.off('click');
                                        } 
                                });
                                cookie.set('bk_score_rating', bkFinalX, { expires: 1, }); 
                                
                                return false;
                       }
                    });
                })(jQuery);
                </script>";
                echo ($user_rating_script);
            }
        }
    }
}
if ( ! function_exists( 'bk_rate_counter' ) ) {
    function bk_rate_counter() {
        if ( ! wp_verify_nonce($_POST['nonce'], 'rating_nonce') ) { return; }
    
        $bk_post_id = $_POST['postid'];   
        $bk_current_rates = get_post_meta($bk_post_id, "bk_rates", true); 
        
        if ($bk_current_rates == NULL) {
             $bk_current_rates = 0; 
        }
        
        $bk_current_rates = intval($bk_current_rates);       
        $bk_new_rates = $bk_current_rates + 1;
        
        update_post_meta($bk_post_id, 'bk_rates', $bk_new_rates);
            
        die(0);
    }
}
add_action('wp_ajax_bk_rate_counter', 'bk_rate_counter');
add_action('wp_ajax_nopriv_bk_rate_counter', 'bk_rate_counter');
add_action('wp_ajax_bk_rate_counter', 'bk_rate_counter');
add_action('wp_ajax_nopriv_bk_rate_counter', 'bk_rate_counter');

if ( ! function_exists( 'bk_add_user_score' ) ) {
    function bk_add_user_score() {
        
        if ( ! wp_verify_nonce($_POST['nonce'], 'rating_nonce')) { return; }

        $bk_post_id = $_POST['postid'];
        $bk_latest_score = floatval($_POST['bkNewScore']);
        $bk_current_rates = floatval($_POST['bkCurrentRates']);   
        
        $current_score = get_post_meta($bk_post_id, "bk_user_score_output", true);    

        if ($bk_current_rates == NULL) {
            $bk_current_rates = 0; 
        }

        if ($bk_current_rates == 0) {
            $bk_new_score =  $bk_latest_score ;
        }
        
        if ($bk_current_rates == 1) {
            $bk_new_score = round(floatval(( $current_score + $bk_latest_score  ) / 2),1);
        }
        if ($bk_current_rates > 1) {
            $current_score_total = ($current_score * $bk_current_rates );
            $bk_new_score = round(floatval(($current_score_total + $bk_latest_score) / ($bk_current_rates + 1)),1) ;
        }

        update_post_meta($bk_post_id, 'bk_user_score_output', $bk_new_score);
        $score_return = array();
        $score_return['bk_new_score'] = $bk_new_score;
        $score_return['bk_latest_score'] = $bk_latest_score;                 
        echo implode(" ",$score_return);
        die();
    }
}
add_action('wp_ajax_bk_add_user_score', 'bk_add_user_score');
add_action('wp_ajax_nopriv_bk_add_user_score', 'bk_add_user_score');
/**
* ************* Author Page.*****************
*---------------------------------------------------
*/ 
if ( ! function_exists( 'bk_contact_data' ) ) {  
    function bk_contact_data($contactmethods) {
    
        unset($contactmethods['aim']);
        unset($contactmethods['yim']);
        unset($contactmethods['jabber']);
        $contactmethods['publicemail'] = 'Public Email';
        $contactmethods['twitter'] = 'Twitter Username';
        $contactmethods['facebook'] = 'Facebook URL';
        $contactmethods['youtube'] = 'Youtube Username';
        $contactmethods['googleplus'] = 'Google+ (Entire URL)';
        $contactmethods['instagram'] = 'Instagram URL';
         
        return $contactmethods;
    }
}
add_filter('user_contactmethods', 'bk_contact_data');

/**
 * wp_get_attachment
 * -------------------------------------------------
 */
if ( ! function_exists( 'wp_get_attachment' ) ) {
    function wp_get_attachment( $attachment_id ) {
    
        $attachment = get_post( $attachment_id );
        return array(
        	'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        	'caption' => $attachment->post_excerpt,
        	'description' => $attachment->post_content,
        	'href' => get_permalink( $attachment->ID ),
        	'src' => $attachment->guid,
        	'title' => $attachment->post_title
        );
    }
}

/**
 * ************* Pagination *****************
 *---------------------------------------------------
 */ 
if ( ! function_exists( 'bk_paginate') ) {
    function bk_paginate(){  
        global $wp_query, $wp_rewrite, $bk_option; 
        if ( $wp_query->max_num_pages > 1 ) : ?>
        <div id="pagination" class="clear-fix">
        	<?php
        		$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
                if(isset($bk_option['bk-rtl-sw']) && ($bk_option['bk-rtl-sw'])) {
                    $pagination = array(
            			'base' => esc_url(add_query_arg( 'paged','%#%' )),
            			'format' => '',
            			'total' => $wp_query->max_num_pages,
            			'current' => $current,
            			'prev_text' => '<i class="fa fa-long-arrow-right"></i>',
            			'next_text' => '<i class="fa fa-long-arrow-left"></i>',
            			'type' => 'plain'
            		); 
                }else {
            		$pagination = array(
            			'base' => esc_url(add_query_arg( 'paged','%#%' )),
            			'format' => '',
            			'total' => $wp_query->max_num_pages,
            			'current' => $current,
            			'prev_text' => '<i class="fa fa-long-arrow-left"></i>',
            			'next_text' => '<i class="fa fa-long-arrow-right"></i>',
            			'type' => 'plain'
            		);
                }
        		
        		if( $wp_rewrite->using_permalinks() )
        			$pagination['base'] = user_trailingslashit( trailingslashit( esc_url(remove_query_arg( 's', get_pagenum_link( 1 ) )) ) . 'page/%#%/', 'paged' );
        
        		if( !empty( $wp_query->query_vars['s'] ) )
        			$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
        
        		echo paginate_links( $pagination );

        	?>
        </div>
<?php
    endif;
    }
}
/* Convert hexdec color string to rgb(a) string */

function bk_hex2rgba($color, $opacity = false) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
          return $default; 

	//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}
//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
		return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
	}
add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info

function insert_fb_in_head() {
	global $post;
	if ( !is_singular()) //if it is not a post or a page
		return;
        echo '<meta property="og:title" content="' . get_the_title() . '"/>';
        echo '<meta property="og:type" content="article"/>';
        echo '<meta property="og:url" content="' . get_permalink() . '"/>';
	if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
		echo '<meta property="og:image" content=""/>';
	}
	else{
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'bk600_315' );
		echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
	}
	echo "
";
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );

// Gets instagram data
function bk_fetchData($url){
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_TIMEOUT, 20);
     $result = curl_exec($ch);
     curl_close($ch); 
     return $result;
}
