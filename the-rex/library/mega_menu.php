<?php

/**
* CUSTOM WALKER
*---------------------------------------------------
*/ 


/*--- Frontend Walker ---*/
class BK_Walker extends Walker_Nav_Menu {
    
    function start_el( &$output, $object, $depth = 0, $args = array(), $id = 0) {
        parent::start_el( $output, $object, $depth, $args );
        
        global $bk_megamenu_carousel_el;
        
        $bk_cat_menu = $object->bkmegamenu;

        if ( $bk_cat_menu == NULL ) {
             $bk_cat_menu = '0'; 
        }    
        global $bk_option;
        $bk_output = $bk_posts = $bk_menu_featured = $bk_has_children = $bk_carousel_item_num = NULL;
        $bk_current_type = $object->object;
        $bk_current_classes = $object->classes;
        if ( in_array('menu-item-has-children', $bk_current_classes) ) { $bk_has_children = ' bk-with-sub'; }
        
        if (($object->menu_item_parent == '0')&($object->bkmegamenu == '1')) {
            $bk_carousel_id = "bk-carousel-".$object->ID;
            if ($bk_has_children == ' bk-with-sub') { 
                $bk_carousel_item_num = 3;
            } else { 
                $bk_carousel_item_num = 4;
            }
            $bk_megamenu_carousel_el[$bk_carousel_id] = $bk_carousel_item_num;
            if(isset($bk_option['bk-rtl-sw']) && ($bk_option['bk-rtl-sw'])) {
                $bk_megamenu_carousel_el[$bk_carousel_id]['rtl'] == 'true';
            }else {
                $bk_megamenu_carousel_el[$bk_carousel_id]['rtl'] == 'false';
            }
            wp_localize_script( 'bk-customjs', 'megamenu_carousel_el', $bk_megamenu_carousel_el );
        }

        if ( ( $bk_cat_menu == 1 )  && ( $object->menu_item_parent == '0')) { 
            if ($object->object == "category") {   
                $output .= '<div class="bk-mega-menu ">'; 
                $bk_cat_id = $object->object_id;
                $bk_qry_amount = 9;    
                $bk_args = array( 'cat' => $bk_cat_id,  'post_type' => 'post',  'post_status' => 'publish', 'ignore_sticky_posts' => 1,  'posts_per_page' => $bk_qry_amount);
                $bk_qry_latest = $bk_img = $bk_cat_link = NULL;
                $bk_qry_latest = new WP_Query($bk_args);
                $i = 1;
                
                foreach ( $bk_qry_latest->posts as $bk_post ) {
                    setup_postdata( $bk_post ); 
                        
                    $bk_post_id = $bk_post->ID;

                    if(has_post_thumbnail( $bk_post_id )) {
                        $bk_img = get_the_post_thumbnail($bk_post_id, 'bk360_248');
                    }else {
                        $bk_img =  '<img width="350" height="320" src="'.get_template_directory_uri().'/images/bkdefault400_300.jpg">';
                    }

                    $bk_permalink = get_permalink($bk_post_id);
                    $bk_post_title = bk_core::bk_the_excerpt_limit_by_word($bk_post->post_title,12);
                    $bk_review_score =  bk_review_score($bk_post_id);
                    $date = get_the_date( '', $bk_post_id );
                    $thepost= get_post($bk_post_id);
                    $comment_count = $thepost->comment_count;
            		$comment_html = '<div class="meta-comment">
                            			<span><i class="fa fa-comments-o"></i></span>
                            			<a href="'.$bk_permalink.'#comments">'.$comment_count.'</a>
                            		</div>';

                    if ($bk_img == '<div class="icon-thumb"></div>') {$bk_review_score = '';};
                     
                    $bk_posts .= ' <li class="bk-sub-post">
                                    <div class="thumb">
                                        <a href="'.$bk_permalink.'" class="thumb-link">'. $bk_img.'</a>
                                    </div>
                                            
                                    <h3 class="post-title"><a href="'.$bk_permalink.'">'.$bk_post_title.'</a></h3>  
                                    <div class="meta clearfix">
                                        <div class="post-date"><span><i class="fa fa-clock-o"></i></span>'.$date.'</div>
                                        '.$comment_html.'
                                    </div>          
                                   </li>'; 
                        
                    $i++;
                }
                wp_reset_postdata();  
            }else if ($object->object == "custom") {  
                $output .= '<div class="bk-mega-column-menu">'; 
            }
        }       
        
        if ( ( $bk_cat_menu == 0 )  && ( $object->menu_item_parent == '0')&& ( in_array('menu-item-has-children', $bk_current_classes) ) ) { 
            $output .= '<div class="bk-dropdown-menu">';
        }

        
        if ( $bk_posts != NULL ) {
                 $output .= '<div id="'.$bk_carousel_id.'" class="bk-sub-posts'.$bk_has_children.' flexslider clear-fix">
                                <ul class="slides">'. $bk_posts .'</ul>
                             </div>'; 
        } 
        if ( ($bk_has_children == NULL) && ($object->bkmegamenu == '1') ) {
                $bk_closer = '</div>';
            } else {
                $bk_closer = NULL;
            }
        $output .= $bk_closer;

    
    }
    
    //start of the sub menu wrap
    function start_lvl( &$output, $depth=0, $args = array() ) {

        if ( $depth > 3 ) { return; }
        if ( $depth == 3 )  { $output .= '<ul class="bk-sub-sub-menu">'; }
        if ( $depth == 2 )  { $output .= '<ul class="bk-sub-sub-menu">'; }
        if ( $depth == 1 )  { $output .= '<ul class="bk-sub-sub-menu">'; }
        if ( $depth == 0 )  { $output .= '<div class="bk-sub-menu-wrap"><ul class="bk-sub-menu clearfix">'; }
    }
 
    //end of the sub menu wrap
    function end_lvl( &$output, $depth=0, $args = array() ) {

        if ( $depth > 3 ) { return; }
        if ( $depth == 0 ) { $output .= '</ul></div></div>'; }
        if ( $depth == 1 ) { $output .= '</ul>'; }
        if ( $depth == 2 ) { $output .= '</ul>'; }
        if ( $depth == 3 ) { $output .= '</ul>'; }
        
    }    
}

/*--- Backend Walker ---*/
class bk_walker_backend extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = array() ) {}
    function end_lvl( &$output, $depth = 0, $args = array() ) {}
    
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $_wp_nav_menu_max_depth;
        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        ob_start();
        $item_id = esc_attr( $item->ID );
        if (empty($item->bkmegamenu[0])) {
            $bk_item_megamenu = NULL;
        } else {
            $bk_item_megamenu = esc_attr ($item->bkmegamenu[0]);
        }
        $removed_args = array( 'action','customlink-tab', 'edit-menu-item', 'menu-item', 'page-tab',  '_wpnonce', );

        $original_title = '';
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            $original_title = $original_object->post_title;
        }

        $classes = array(
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );

        $title = $item->title;

        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf( esc_html__( '%s (Invalid)' , 'the-rex'), $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf( esc_html__('%s (Pending)' , 'the-rex'), $item->title);
        }

        $title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

        $submenu_text = '';
        if ( 0 == $depth )
            $submenu_text = 'style="display: none;"';

        ?>
        <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
                    <span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo $submenu_text; ?>><?php esc_html_e( 'sub item' , 'the-rex'); ?></span></span>
                    <span class="item-controls">
                        <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                        <span class="item-order hide-if-js">
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-up-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        esc_url(remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) ))
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'the-rex'); ?>">&#8593;</abbr></a>
                            |
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-down-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        esc_url(remove_query_arg($removed_args, admin_url( 'nav-menus.php' )) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'the-rex'); ?>">&#8595;</abbr></a>
                        </span>
                        <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item', 'the-rex'); ?>" href="<?php
                            echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : esc_url(add_query_arg( 'edit-menu-item', $item_id, esc_url(remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) )) ));
                        ?>"><?php esc_html_e( 'Edit Menu Item' , 'the-rex'); ?></a>
                    </span>
                </dt>
            </dl>

            <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
                <?php if( 'custom' == $item->type ) : ?>
                    <p class="field-url description description-wide">
                        <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                            <?php esc_html_e( 'URL' , 'the-rex'); ?><br />
                            <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                        </label>
                    </p>
                <?php endif; ?>
                <p class="description description-thin">
                    <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Navigation Label' , 'the-rex'); ?><br />
                        <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Title Attribute' , 'the-rex'); ?><br />
                        <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                    </label>
                </p>
                <p class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                        <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                        <?php esc_html_e( 'Open link in a new window/tab' , 'the-rex'); ?>
                    </label>
                </p>
                <p class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'CSS Classes (optional)' , 'the-rex'); ?><br />
                        <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                    </label>
                </p>
                <p class="field-xfn description description-thin">
                    <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Link Relationship (XFN)' , 'the-rex'); ?><br />
                        <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                    </label>
                </p>
                <p class="field-bkmegamenu description">
                    <?php if ($depth == 0 && (($item->object == 'category') || ($item->object == 'custom'))) { ?>
                    <label for="edit-menu-item-bkmegamenu-<?php echo $item_id; ?>">Megamenu</label>
                    <input type="checkbox" id="edit-menu-item-bkmegamenu-<?php echo $item_id; ?>" name="menu-item-bkmegamenu[<?php echo $item_id; ?>]" value="1" <?php checked( $bk_item_megamenu,1 ); ?> />
                    <?php } ?>
                </p>
                <p class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Description' , 'the-rex'); ?><br />
                        <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]">
                            <?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                        <span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.' , 'the-rex'); ?></span>
                    </label>
                </p>  
                <p class="field-move hide-if-no-js description description-wide">
                    <label>
                        <span><?php esc_html_e( 'Move' , 'the-rex'); ?></span>
                        <a href="#" class="menus-move-up"><?php esc_html_e( 'Up one' , 'the-rex'); ?></a>
                        <a href="#" class="menus-move-down"><?php esc_html_e( 'Down one' , 'the-rex'); ?></a>
                        <a href="#" class="menus-move-left"></a>
                        <a href="#" class="menus-move-right"></a>
                        <a href="#" class="menus-move-top"><?php esc_html_e( 'To the top' , 'the-rex'); ?></a>
                    </label>
                </p>

                <div class="menu-item-actions description-wide submitbox">
                    <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                        <p class="link-to-original">
                            <?php printf( esc_html__('Original: %s' , 'the-rex'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                        </p>
                    <?php endif; ?>
                    <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                    echo wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'delete-menu-item',
                                'menu-item' => $item_id,
                            ),
                            admin_url( 'nav-menus.php' )
                        ),
                        'delete-menu_item_' . $item_id
                    ); ?>"><?php esc_html_e( 'Remove' , 'the-rex'); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
                        ?>#menu-item-settings-<?php echo $item_id; ?>"><?php esc_html_e('Cancel' , 'the-rex'); ?></a>
                </div>

                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
            </div><!-- .menu-item-settings-->
            <ul class="menu-item-transport"></ul>
        <?php
        $output .= ob_get_clean();
    }
}

if ( ! function_exists( 'bk_megamenu_walker' ) ) { 
    function bk_megamenu_walker($walker) {
            if ( $walker === 'Walker_Nav_Menu_Edit' ) {
                        $walker = 'bk_walker_backend';
                  }
           return $walker;
        }
}
add_filter( 'wp_edit_nav_menu_walker', 'bk_megamenu_walker');  

if ( ! function_exists( 'bk_megamenu_walker_save' ) ) { 
    function bk_megamenu_walker_save($menu_id, $menu_item_db_id) {

        if  (isset($_POST['menu-item-bkmegamenu'][$menu_item_db_id])) {
                update_post_meta( $menu_item_db_id, '_menu_item_bkmegamenu', $_POST['menu-item-bkmegamenu'][$menu_item_db_id]);
        } else {
            update_post_meta( $menu_item_db_id, '_menu_item_bkmegamenu', '0');
        }
    }
}
add_action( 'wp_update_nav_menu_item', 'bk_megamenu_walker_save', 10, 2 );

if ( ! function_exists( 'bk_megamenu_walker_loader' ) ) { 
    function bk_megamenu_walker_loader($menu_item) {
            $menu_item->bkmegamenu = get_post_meta($menu_item->ID, '_menu_item_bkmegamenu', true);
            return $menu_item;
     }
}
add_filter( 'wp_setup_nav_menu_item', 'bk_megamenu_walker_loader' );