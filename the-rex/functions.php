<?php
require_once (get_template_directory().'/framework/page-builder/controller/bk_pd_template.php');
require_once (get_template_directory().'/framework/page-builder/controller/bk_pd_cfg.php');
require_once (get_template_directory().'/framework/page-builder/controller/bk_pd_save.php');
require_once (get_template_directory().'/framework/page-builder/controller/bk_pd_del.php');
require_once (get_template_directory().'/framework/page-builder/controller/render-sections.php');
require_once (get_template_directory().'/framework/page-builder/bk_pd_start.php');

require_once (get_template_directory().'/framework/taxonomy-meta/taxonomy-meta.php');
require_once (get_template_directory().'/library/taxonomy-meta-config.php');
/**
 * Load the TGM Plugin Activator class to notify the user
 * to install the Envato WordPress Toolkit Plugin
 */
require_once( get_template_directory() . '/inc/class-tgm-plugin-activation.php' );
function tgmpa_register_toolkit() {
    // Specify the Envato Toolkit plugin
    $plugins = array(
        array(
            'name' => 'Envato WordPress Toolkit',
            'slug' => 'envato-wordpress-toolkit-master',
            'source' => get_template_directory() . '/plugins/envato-wordpress-toolkit-master.zip',
            'required' => true,
            'version' => '1.7.2',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name'      => 'oAuth Twitter Feed for Developers',
            'slug'      => 'oauth-twitter-feed-for-developers',
            'required'  => true,
        ),
        array(
            'name' => 'Login With Ajax',
            'slug' => 'login-with-ajax',
            'source' => get_template_directory() . '/plugins/login-with-ajax.3.1.4.zip',
            'required' => true,
            'version' => '3.1.4',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => 'Sidebar Generator',
            'slug' => 'smk-sidebar-generator',
            'source' => get_template_directory() . '/plugins/smk-sidebar-generator.zip',
            'required' => true,
            'version' => '3.0',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => 'BK Shortcode',
            'slug' => 'short-code',
            'source' => get_template_directory() . '/plugins/short-code.zip',
            'required' => true,
            'version' => '1.0',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
    );
     
    // Configuration of TGM
    $config = array(
        'domain'           => 'the-rex',
        'default_path'     => '',
        'menu'             => 'install-required-plugins',
        'has_notices' => true,                     // Show admin notices or not.
        'dismissable' => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '',                       // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message' => '',  
        'strings'          => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'the-rex'),
            'menu_title'                      => esc_html__( 'Install Plugins', 'the-rex'),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'the-rex'),
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'the-rex'),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'the-rex'),
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'the-rex'),
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'the-rex'),
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'the-rex'),
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'the-rex'),
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'the-rex'),
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'the-rex'),
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'the-rex'),
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'the-rex'),
            'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'the-rex'),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'the-rex'),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'the-rex'),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'the-rex'),
            'nag_type'                        => 'updated'
        )
    );
    tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'tgmpa_register_toolkit' );
/**
 * Load the Envato WordPress Toolkit Library check for updates
 * and direct the user to the Toolkit Plugin if there is one
 */
function envato_toolkit_admin_init() {
 
    // Include the Toolkit Library
    include_once( get_template_directory() . '/inc/envato-wordpress-toolkit-library/class-envato-wordpress-theme-upgrader.php' );

/**
 * Display a notice in the admin to remind the user to enter their credentials
 */
    function envato_toolkit_credentials_admin_notices() {
        $message = sprintf( esc_html__( "To enable theme update notifications, please enter your Envato Marketplace credentials in the %s", "the-rex"),
            "<a href='" . admin_url() . "admin.php?page=envato-wordpress-toolkit'>Envato WordPress Toolkit Plugin</a>" );
        echo "<div id='message' class='updated below-h2'><p>{$message}</p></div>";
    }
    
    // Use credentials used in toolkit plugin so that we don't have to show our own forms anymore
    $credentials = get_option( 'envato-wordpress-toolkit' );
    if ( empty( $credentials['user_name'] ) || empty( $credentials['api_key'] ) ) {
        add_action( 'admin_notices', 'envato_toolkit_credentials_admin_notices' );
        return;
    }

    // Check updates only after a while
    $lastCheck = get_option( 'toolkit-last-toolkit-check' );
    if ( false === $lastCheck ) {
        update_option( 'toolkit-last-toolkit-check', time() );
        return;
    }
    
    // Check for an update every 3 hours
    if ( 10800 < ( time() - $lastCheck ) ) {
        return;
    }
    
    // Update the time we last checked
    update_option( 'toolkit-last-toolkit-check', time() );
    
    // Check for updates
    $upgrader = new Envato_WordPress_Theme_Upgrader( $credentials['user_name'], $credentials['api_key'] );
    $updates = $upgrader->check_for_theme_update();
     
    // If $updates->updated_themes_count == true then we have an update!
    
    // Add update alert, to update the theme
    if ((isset($updates->updated_themes_count)) && ( $updates->updated_themes_count )) {
        add_action( 'admin_notices', 'envato_toolkit_admin_notices' );
    }
    
    /**
     * Display a notice in the admin that an update is available
     */
    function envato_toolkit_admin_notices() {
        $message = sprintf( esc_html__( "An update to the theme is available! Head over to %s to update it now.", "the-rex" ),
            "<a href='" . admin_url() . "admin.php?page=envato-wordpress-toolkit'>Envato WordPress Toolkit Plugin</a>" );
        echo "<div id='message' class='updated below-h2'><p>{$message}</p></div>";
    }
}
add_action( 'admin_init', 'envato_toolkit_admin_init' );
$bk_justified_ids = array();
$bk_ajax_btnstr = array();
/**
 * http://codex.wordpress.org/Content_Width
 */
if ( ! isset($content_width)) {
	$content_width = 1200;
}

/**
 * Get ajaxurl
 *---------------------------------------------------
 */
if ( ! function_exists( 'bk_ajaxurl' ) ) {
    function bk_ajaxurl() {
    ?>
        <script type="text/javascript">
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        </script>
    <?php
    }
}
add_action('wp_head','bk_ajaxurl');

if ( ! function_exists( 'bk_scripts_method' ) ) {
    function bk_scripts_method() {
        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-accordion');

        wp_enqueue_style( 'bk-bootstrap-css', get_template_directory_uri().'/framework/bootstrap/css/bootstrap.css', array(), '' );        
        
        wp_enqueue_style('bk-fa', get_template_directory_uri() . '/css/fonts/awesome-fonts/css/font-awesome.min.css');
        wp_enqueue_style('bk-fa-snapchat', get_template_directory_uri() . '/css/fa-snapchat.css');
        wp_enqueue_style('bk-flexslider', get_template_directory_uri() . '/css/flexslider.css');

        wp_enqueue_style('bkstyle', get_template_directory_uri() . '/css/bkstyle.css');
        wp_enqueue_style('bkresponsive', get_template_directory_uri() . '/css/responsive.css');
        
        if(!(!(isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)))) {
            wp_enqueue_style('bkiestyle', get_template_directory_uri() . '/css/ie.css');
        }
        
        wp_enqueue_style('bk-tipper', get_template_directory_uri() . '/css/jquery.fs.tipper.css');
        wp_enqueue_style('bk-justifiedgallery', get_template_directory_uri() . '/css/justifiedGallery.css');
        wp_enqueue_style('bk-justifiedlightbox', get_template_directory_uri() . '/css/magnific-popup.css');
        
        wp_enqueue_script( 'bk-theme-plugins', get_template_directory_uri().'/js/theme_plugins.js', array( 'jquery' ), '', true );
        
        wp_enqueue_script( 'bk-onviewport', get_template_directory_uri().'/js/onviewport.js', array( 'jquery' ), false, true );
        
        wp_enqueue_script('bk-module-load-post', get_template_directory_uri() . '/js/module-load-post.js', array('jquery'),false,true); 
         
        wp_enqueue_script( 'bk-menu', get_template_directory_uri().'/js/menu.js', array( 'jquery' ), false, true );

        wp_enqueue_script( 'bk-customjs', get_template_directory_uri().'/js/customjs.js', array( 'jquery' ), false, true );
        
     }
}

add_action('wp_enqueue_scripts', 'bk_scripts_method');

if ( ! function_exists( 'bk_post_admin_scripts_and_styles' ) ) {
    function bk_post_admin_scripts_and_styles($hook) {        
    	if( $hook == 'post.php' || $hook == 'post-new.php' ) {
            wp_enqueue_script( 'bk-bootstrap-admin-js', get_template_directory_uri().'/framework/bootstrap-admin/bootstrap.js', array(), '', true );
            wp_enqueue_style( 'bk-bootstrap-admin-css', get_template_directory_uri().'/framework/bootstrap-admin/bootstrap.css', array(), '' );
            wp_enqueue_style( 'bk-jquery-core-css', '//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css', array(), '' );
            wp_enqueue_script( 'bk-ui-core-js', '//code.jquery.com/ui/1.11.2/jquery-ui.js', '', true );
            wp_register_script( 'bk-post-review-admin',  get_template_directory_uri() . '/js/post-review-admin.js', array(), '', true);
            wp_enqueue_script( 'bk-post-review-admin' ); // enqueue it
   		}
        wp_enqueue_script('bk-ckeditor-js', get_template_directory_uri() . '/js/ckeditor/ckeditor.js', array('jquery'));
        
        wp_enqueue_script('bk-bootstrap-colorpicker-js', get_template_directory_uri() . '/js/bootstrap-colorpicker.js', array('jquery')); 
        
        wp_enqueue_style('bk-bootstrap-colorpicker-css', get_template_directory_uri() . '/css/bootstrap-colorpicker.css');
        
        wp_enqueue_style( 'bk-admin-css', get_template_directory_uri().'/css/admin.css', array(), '' );
        
        add_editor_style('css/editorstyle.css');
        
        wp_enqueue_style('bk-fa-admin', get_template_directory_uri() . '/css/fonts/awesome-fonts/css/font-awesome.min.css');
        
        wp_enqueue_script( 'bk-autosize-js', get_template_directory_uri().'/js/jquery.autosize.min.js', array(), '', true );
        
        wp_enqueue_script( 'bk-admin-js', get_template_directory_uri().'/js/admin.js', array('jquery-ui-sortable'), '', true );

        
    }
}
add_action('admin_enqueue_scripts', 'bk_post_admin_scripts_and_styles');
 if ( ! function_exists( 'bk_page_builder_js' ) ) {
    function bk_page_builder_js($hook) {
        if( $hook == 'post.php' || $hook == 'post-new.php' ) {
            wp_enqueue_script( 'bk-page-builder-js', get_template_directory_uri().'/framework/page-builder/controller/js/page-builder.js', array( 'jquery' ), null, true );
            wp_localize_script( 'bk-page-builder-js', 'bkpb_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
  		}
    }
 }
 add_action('admin_enqueue_scripts', 'bk_page_builder_js', 9);
/**
 * Register sidebars and widgetized areas.
 *---------------------------------------------------
 */
 if ( ! function_exists( 'bk_widgets_init' ) ) {
    function bk_widgets_init() {

        register_sidebar( array(
    		'name' => esc_html__('Sidebar', 'the-rex'),
    		'id' => 'home_sidebar',
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget' => '</aside>',
    		'before_title' => '<div class="bk-header"><div class="widget-title"><h3>',
    		'after_title' => '</h3></div></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Sidebar 2', 'the-rex'),
    		'id' => 'home_sidebar_2',
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget' => '</aside>',
    		'before_title' => '<div class="bk-header"><div class="widget-title"><h3>',
    		'after_title' => '</h3></div></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Single Sidebar', 'the-rex'),
    		'id' => 'single_sidebar',
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget' => '</aside>',
    		'before_title' => '<div class="bk-header"><div class="widget-title"><h3>',
    		'after_title' => '</h3></div></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Page Sidebar', 'the-rex'),
    		'id' => 'page_sidebar',
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget' => '</aside>',
    		'before_title' => '<div class="bk-header"><div class="widget-title"><h3>',
    		'after_title' => '</h3></div></div>',
    	) );

        register_sidebar( array(
    		'name' => esc_html__('Footer Sidebar 1', 'the-rex'),
    		'id' => 'footer_sidebar_1',
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget' => '</aside>',
    		'before_title' => '<div class="bk-header"><div class="widget-title"><h3>',
    		'after_title' => '</h3></div></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Footer Sidebar 2', 'the-rex'),
    		'id' => 'footer_sidebar_2',
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget' => '</aside>',
    		'before_title' => '<div class="bk-header"><div class="widget-title"><h3>',
    		'after_title' => '</h3></div></div>',
    	) );
        
        register_sidebar( array(
    		'name' => esc_html__('Footer Sidebar 3', 'the-rex'),
    		'id' => 'footer_sidebar_3',
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget' => '</aside>',
    		'before_title' => '<div class="bk-header"><div class="widget-title"><h3>',
    		'after_title' => '</h3></div></div>',
    	) );
    }
}
add_action( 'widgets_init', 'bk_widgets_init' );

/**
 * Add php library file.
 */
require_once(get_template_directory()."/library/core.php");
require_once(get_template_directory()."/library/mega_menu.php");
require_once(get_template_directory()."/library/custom_css.php");
require_once(get_template_directory()."/library/translation.php");
require_once(get_template_directory()."/inc/controller.php");


/**
 * Add widgets
 */
include(get_template_directory()."/framework/widgets/widget_latest_posts.php");
include(get_template_directory()."/framework/widgets/widget_latest_posts_2.php");
include(get_template_directory()."/framework/widgets/widget_most_commented.php");
include(get_template_directory()."/framework/widgets/widget_latest_review.php");
include(get_template_directory()."/framework/widgets/widget_top_review.php");
include(get_template_directory()."/framework/widgets/widget_social_counter.php");
include(get_template_directory()."/framework/widgets/widget_latest_comments.php");
include(get_template_directory()."/framework/widgets/widget_twitter.php");
include(get_template_directory()."/framework/widgets/widget_flickr.php");
include(get_template_directory()."/framework/widgets/widget_slider.php");
include(get_template_directory()."/framework/widgets/widget_facebook.php");
include(get_template_directory()."/framework/widgets/widget_google_badge.php");
include(get_template_directory()."/framework/widgets/widget_instagram.php");
include(get_template_directory()."/framework/widgets/widget_ads.php");
include(get_template_directory()."/framework/widgets/widget_shortcode.php");

/**
 * Integrate Meta box plugin
 */
// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/framework/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( get_stylesheet_directory() . '/framework/meta-box' ) );
// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';
include(get_template_directory()."/library/meta_box_config.php");

//Add support tag title
add_theme_support('title-tag');

/**
 * Add support for the featured images (also known as post thumbnails).
 */
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
}

add_action( 'after_setup_theme', 'bk_thumbnail_setup' );
if ( ! function_exists( 'bk_thumbnail_setup' ) ){

    function bk_thumbnail_setup() {
        add_image_size( 'bk750_375', 750, 375, true );
        add_image_size( 'bk800_520', 800, 520, true );
        add_image_size( 'bk600_315', 600, 315, true );
        add_image_size( 'bk620_420', 620, 420, true ); 
        add_image_size( 'bk360_248', 360, 248, true );
        add_image_size( 'bk130_130', 130, 130, true );
        add_image_size( 'bk150_100', 150, 100, true );
        add_image_size( 'bk_fw_slider', 1000, 485, true );
        add_image_size( 'bk_masonry-size', 400, 99999, false );
    }
}
/**
 * Post Format 
 */
 add_action('after_setup_theme', 'bk_add_theme_format', 11);
function bk_add_theme_format() {
    add_theme_support( 'post-formats', array( 'gallery', 'video', 'image', 'audio' ) );
}
/**
 * Add support for the featured images (also known as post thumbnails).
 */
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
}
/**
 * Register menu locations
 *---------------------------------------------------
 */
if ( ! function_exists( 'bk_register_menu' ) ) {
    function bk_register_menu() {
        register_nav_menu('main-menu',esc_html__( 'Main Menu', 'the-rex'));
        register_nav_menu('menu-top',esc_html__( 'Top Menu', 'the-rex'));
        register_nav_menu('menu-footer',esc_html__( 'Footer Menu', 'the-rex')); 
    }
}
add_action( 'init', 'bk_register_menu' );

function bk_category_nav_class( $classes, $item ){
    if( 'category' == $item->object ){
        $classes[] = 'menu-category-' . $item->object_id;
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'bk_category_nav_class', 10, 2 );

function custom_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function remove_pages_from_search() {
    global $wp_post_types;
    $wp_post_types['page']->exclude_from_search = true;
    $wp_post_types['attachment']->exclude_from_search = true;
}
add_action('init', 'remove_pages_from_search');
/**
 * ReduxFramework
 */

if ( !class_exists( 'ReduxFramework' ) && file_exists( get_template_directory() . '/framework/ReduxFramework/ReduxCore/framework.php' ) ) {
    require_once( get_template_directory() . '/framework/ReduxFramework/ReduxCore/framework.php' );
}
if ( !isset( $bk_option ) && file_exists( get_template_directory() . '/library/theme-option.php' ) ) {
    require_once( get_template_directory() . '/library/theme-option.php' );
}

global $bk_option;
if (isset($bk_option['bk-retina-display'])) {
    $bk_retina_display = $bk_option['bk-retina-display'];
}else {
    $bk_retina_display = 0;
}

if ($bk_retina_display) {
    /**
     * Enqueueing retina.js
     *
     * This function is attached to the 'wp_enqueue_scripts' action hook.
     */
    add_action( 'wp_enqueue_scripts', 'bk_retina_support_enqueue_scripts' );
    function bk_retina_support_enqueue_scripts() {
        wp_enqueue_script( 'retina_js', get_template_directory_uri() . '/js/retina.min.js', '', '', true );
    }
    
    add_filter( 'wp_generate_attachment_metadata', 'bk_retina_support_attachment_meta', 10, 2 );
    /**
     * Retina images
     *
     * This function is attached to the 'wp_generate_attachment_metadata' filter hook.
     */
    function bk_retina_support_attachment_meta( $metadata, $attachment_id ) {
        foreach ( $metadata as $key => $value ) {
            if ( is_array( $value ) ) {
                foreach ( $value as $image => $attr ) {
                    if ( is_array( $attr ) )
                        bk_retina_support_create_images( get_attached_file( $attachment_id ), $attr['width'], $attr['height'], true );
                }
            }
        }
     
        return $metadata;
    }
    
    /**
     * Create retina-ready images
     *
     * Referenced via retina_support_attachment_meta().
     */
    function bk_retina_support_create_images( $file, $width, $height, $crop = false ) {
        if ( $width || $height ) {
            $resized_file = wp_get_image_editor( $file );
            if ( ! is_wp_error( $resized_file ) ) {
                $filename = $resized_file->generate_filename( $width . 'x' . $height . '@2x' );
     
                $resized_file->resize( $width * 2, $height * 2, $crop );
                $resized_file->save( $filename );
     
                $info = $resized_file->get_size();
     
                return array(
                    'file' => wp_basename( $filename ),
                    'width' => $info['width'],
                    'height' => $info['height'],
                );
            }
        }
        return false;
    }
    
    add_filter( 'delete_attachment', 'bk_delete_retina_support_images' );
    /**
     * Delete retina-ready images
     *
     * This function is attached to the 'delete_attachment' filter hook.
     */
    function bk_delete_retina_support_images( $attachment_id ) {
        $meta = wp_get_attachment_metadata( $attachment_id );
        $upload_dir = wp_upload_dir();
        if(isset($meta['file'])) {
            $path = pathinfo( $meta['file'] );
            foreach ( $meta as $key => $value ) {
                if ( 'sizes' === $key ) {
                    foreach ( $value as $sizes => $size ) {
                        $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
                        $retina_filename = substr_replace( $original_filename, '@2x.', strrpos( $original_filename, '.' ), strlen( '.' ) );
                        if ( file_exists( $retina_filename ) )
                            unlink( $retina_filename );
                    }
                }
            }
        }
    }
}
?>