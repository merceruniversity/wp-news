<?php
    global $bk_option;
    $favicon = array(); $logo = array();
    if (isset($bk_option)){
                        
        if ((isset($bk_option['bk-favicon'])) && (($bk_option['bk-favicon']) != NULL)){ 
            $favicon = $bk_option['bk-favicon'];
        }; 
          
        if ((isset($bk_option['bk-logo'])) && (($bk_option['bk-logo']) != NULL)){ 
            $logo = $bk_option['bk-logo'];
        };
        
        if(isset($bk_option['bk-backtop-switch'])){$backtop = $bk_option['bk-backtop-switch'];}else {$backtop = 1;};
    
        if(isset($bk_option['bk-site-layout'])){$bkSiteLayout = $bk_option['bk-site-layout'];}else {$bkSiteLayout = 'wide';};
    }
    $schema_org = '';
    if (is_single()) {
    	$schema_org .= '';
    } else {
    	$schema_org .= ' itemscope itemtype="http://schema.org/WebPage"';
    }
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    	
    	<?php if (is_search()) { ?>
    	   <meta name="robots" content="noindex, nofollow" /> 
    	<?php } ?>
    
    	<?php if (!function_exists('_wp_render_title_tag')) : ?>
            <title><?php wp_title('|', true, 'right'); ?></title>
        <?php endif; ?>
    	<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {?>
        	<?php if (($favicon != null) && (array_key_exists('url',$favicon))) {
                if ($favicon['url'] != '') {
                echo '<link rel="shortcut icon" href="'.  $favicon['url']  .'"/>';
                }
             }?>
         <?php }?>
    	
    	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    	
    	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        
    	<?php if ( is_singular() ) wp_enqueue_script('comment-reply'); ?>
    
    	<?php wp_head(); ?>
    </head>
    
    <body <?php body_class(); echo $schema_org; ?>>
        <div id="page-wrap" class= '<?php if($bkSiteLayout !== 'boxed') {echo "wide";}else {echo "boxed";}?>'>
        <div id="main-mobile-menu">
            <div class="block">
                <div id="mobile-inner-header">
                    <h3 class="menu-title">
                        <?php echo bloginfo( 'name' );?>
                    </h3>
                    <a class="mobile-menu-close" href="#" title="Close"><i class="fa fa-long-arrow-left"></i></a>
                </div>
                <?php if ( isset($bk_option ['bk-header-top-switch']) && ($bk_option ['bk-header-top-switch'] == 1) ){ ?>
                     <div class="top-menu">
                        <h3 class="menu-location-title">
                            <?php esc_html_e('Top Menu', 'the-rex');?>
                        </h3>
                    <?php
                    wp_nav_menu( array( 
                        'theme_location' => 'menu-top',
                        'depth' => '3',
                        'container_id' => 'mobile-top-menu' ) );
                    ?>
                    </div>
                <?php }?>
                <div class="main-menu">
                    <h3 class="menu-location-title">
                        <?php esc_html_e('Main Menu', 'the-rex');?>
                    </h3>
                    <?php
                    wp_nav_menu( array( 
                        'theme_location' => 'main-menu',
                        'depth' => '3',
                        'container_id' => 'mobile-menu' ) );
                    ?>
                </div>
            </div>
        </div>
        <div id="page-inner-wrap">
            <div class="page-cover mobile-menu-close"></div>
            <div class="bk-page-header">
                <div class="header-wrap header bk-header-90">
                    <div class="top-bar" style="display: ;">
                        <div class="bkwrapper container">
                            <?php if ( isset($bk_option ['bk-header-top-switch']) && ($bk_option ['bk-header-top-switch'] == 1) ){ ?>
                                <div class="top-nav clearfix">
                                    <?php if ( isset($bk_option ['bk-ajaxlogin-switch']) && ($bk_option ['bk-ajaxlogin-switch'] == 1) ){ ?>
                                        <?php 
                                            if ( function_exists('login_with_ajax') ) {  
                                                $bk_home_url = get_home_url();
                                                $ajaxArgs = array(
                                                    'profile_link' => true,
                                                    'template' => 'modal',
                                                    'registration' => true,
                                                    'remember' => true,
                                                    'redirect'  => $bk_home_url
                                                );
                                                login_with_ajax($ajaxArgs);  
                                        }?>
                                    <?php }?>
                                    <?php if ( has_nav_menu('menu-top') ) {?> 
                                        <?php wp_nav_menu(array('theme_location' => 'menu-top','container_id' => 'top-menu'));?> 
                                    <?php }?>
                                
                                    <?php if ( isset($bk_option ['bk-social-header-switch']) && ($bk_option ['bk-social-header-switch'] == 1) ){ ?>
                    				<div class="header-social">
                    					<ul class="clearfix">
                    						<?php if ($bk_option['bk-social-header']['fb']){ ?>
                    							<li class="social-icon fb"><a href="<?php echo esc_url($bk_option['bk-social-header']['fb']); ?>" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
                    						<?php } ?>
                    						
                    						<?php if ($bk_option['bk-social-header']['twitter']){ ?>
                    							<li class="social-icon twitter"><a href="<?php echo esc_url($bk_option['bk-social-header']['twitter']); ?>" target="_blank"><i class="fa fa-twitter-square"></i></a></li>
                    						<?php } ?>
                    						
                    						<?php if ($bk_option['bk-social-header']['gplus']){ ?>
                    							<li class="social-icon gplus"><a href="<?php echo esc_url($bk_option['bk-social-header']['gplus']); ?>" target="_blank"><i class="fa fa-google-plus-square"></i></a></li>
                    						<?php } ?>
                    						
                    						<?php if ($bk_option['bk-social-header']['linkedin']){ ?>
                    							<li class="social-icon linkedin"><a href="<?php echo esc_url($bk_option['bk-social-header']['linkedin']); ?>" target="_blank"><i class="fa fa-linkedin-square"></i></a></li>
                    						<?php } ?>
                    						
                    						<?php if ($bk_option['bk-social-header']['pinterest']){ ?>
                    							<li class="social-icon pinterest"><a href="<?php echo esc_url($bk_option['bk-social-header']['pinterest']); ?>" target="_blank"><i class="fa fa-pinterest-square"></i></a></li>
                    						<?php } ?>
                    						
                    						<?php if ($bk_option['bk-social-header']['instagram']){ ?>
                    							<li class="social-icon instagram"><a href="<?php echo esc_url($bk_option['bk-social-header']['instagram']); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                    						<?php } ?>
                    						
                    						<?php if ($bk_option['bk-social-header']['dribbble']){ ?>
                    							<li class="social-icon dribbble"><a href="<?php echo esc_url($bk_option['bk-social-header']['dribbble']); ?>" target="_blank"><i class="fa fa-dribbble"></i></a></li>
                    						<?php } ?>
                    						
                    						<?php if ($bk_option['bk-social-header']['youtube']){ ?>
                    							<li class="social-icon youtube"><a href="<?php echo esc_url($bk_option['bk-social-header']['youtube']); ?>" target="_blank"><i class="fa fa-youtube-square"></i></a></li>
                    						<?php } ?>      							
                    						                                    
                                            <?php if ($bk_option['bk-social-header']['vimeo']){ ?>
                    							<li class="social-icon vimeo"><a href="<?php echo esc_url($bk_option['bk-social-header']['vimeo']); ?>" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>
                    						<?php } ?>
                                            
                                            <?php if ($bk_option['bk-social-header']['vk']){ ?>
                    							<li class="social-icon vk"><a href="<?php echo esc_url($bk_option['bk-social-header']['vk']); ?>" target="_blank"><i class="fa fa-vk"></i></a></li>
                    						<?php } ?>
                                            
                                            <?php if ($bk_option['bk-social-header']['rss']){ ?>
                    							<li class="social-icon rss"><a href="<?php echo esc_url($bk_option['bk-social-header']['rss']); ?>" target="_blank"><i class="fa fa-rss-square"></i></a></li>
                    						<?php } ?>                    						
                    					</ul>
                    				</div>
                    
                                    <?php }?>  
                                </div><!--top-nav-->
                            <?php }?>
                        </div>
                    </div><!--top-bar-->
                    <!-- nav open -->
            		<nav class="main-nav">
                        <div class="main-nav-inner bkwrapper container">
                            <div class="main-nav-container clearfix">
                                <div class="main-nav-wrap">
                                    <div class="mobile-menu-wrap">
                                        <a class="mobile-nav-btn" id="nav-open-btn"><i class="fa fa-bars"></i></a>  
                                    </div>
                                    <!-- logo open -->
                                    <?php if (($logo != null) && (array_key_exists('url',$logo))) {
                                            if ($logo['url'] != '') {
                                        ?>
                        			<div class="logo">
                                        <a href="<?php echo get_home_url();?>">
                                            <img src="<?php echo esc_url($logo['url']);?>" alt="logo"/>
                                        </a>
                        			</div>
                        			<!-- logo close -->
                                    <?php } else {?> 
                                    <div class="logo logo-text">
                                        <a href="<?php echo get_home_url();?>">
                                            <?php echo bloginfo( 'name' );?>
                                        </a>
                        			</div>
                                    <?php }
                                    } else {?> 
                                    <div class="logo logo-text">
                                        <a href="<?php echo get_home_url();?>">
                                            <?php echo bloginfo( 'name' );?>
                                        </a>
                        			</div>
                                    <?php } ?>
                                    
                                    <?php if ( has_nav_menu( 'main-menu' ) ) { 
                                        wp_nav_menu( array( 
                                            'theme_location' => 'main-menu',
                                            'container_id' => 'main-menu',
                                            'walker' => new BK_Walker,
                                            'depth' => '5' ) );}?>
                                    <?php 
                                        echo bk_ajax_form_search();
                                    ?> 
                                </div>
                            </div>    
                        </div><!-- main-nav-inner -->       
            		</nav>
                    <!-- nav close --> 
        		</div>                
            </div>                
            
            <!-- backtop open -->
    		<?php if ($backtop) { ?>
                <div id="back-top"><i class="fa fa-long-arrow-up"></i></div>
            <?php } ?>
    		<!-- backtop close -->