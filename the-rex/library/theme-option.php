<?php

/**
	ReduxFramework Config File
	For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
**/

if ( !class_exists( "ReduxFramework" ) ) {
	return;
} 

if ( !class_exists( "Redux_Framework_config" ) ) {
	class Redux_Framework_config {

		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct( ) {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();
			
			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();
			
			if ( !isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}
			
			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
			

			// If Redux is running as a plugin, this will remove the demo notice and links
			//add_action( 'redux/plugin/hooks', array( $this, 'remove_demo' ) );
			
			// Function to test the compiler hook and demo CSS output.
			//add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2); 
			// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.

			// Change the arguments after they've been declared, but before the panel is created
			//add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
			
			// Change the default value of a field after it's been set, but before it's been used
			//add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

			// Dynamically add a section. Can be also used to modify sections/fields
			add_filter('redux/options/'.$this->args['opt_name'].'/sections', array( $this, 'dynamic_section' ) );

		}


		/**

			This is a test function that will let you see when the compiler hook occurs. 
			It only runs if a field	set with compiler=>true is changed.

		**/

		function compiler_action($options, $css) {

		}



		/**
		 
		 	Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		 	Simply include this function in the child themes functions.php file.
		 
		 	NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		 	so you must use get_template_directory_uri() if you want to use any of the built in icons
		 
		 **/

		function dynamic_section($sections){
		    /*//$sections = array();
		    $sections[] = array(
		        'title' => esc_html__('Section via hook', 'redux-framework-demo'),
		        'desc' => esc_html__('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
				'icon' => 'el-icon-paper-clip',
				    // Leave this as a blank section, no options just some intro text set above.
		        'fields' => array()
		    );*/

		    return $sections;
		}
		
		
		/**

			Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

		**/
		
		function change_arguments($args){
		    //$args['dev_mode'] = true;
		    
		    return $args;
		}
			
		
		/**

			Filter hook for filtering the default value of any given field. Very useful in development mode.

		**/

		function change_defaults($defaults){
		    $defaults['str_replace'] = "Testing filter hook!";
		    
		    return $defaults;
		}


		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo() {
			
			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists('ReduxFrameworkPlugin') ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2 );
			}

			// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
			remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );	

		}


		public function setSections() {

			/**
			 	Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
			 **/


			// Background Patterns Reader
			$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
			$sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
			$sample_patterns      = array();

			if ( is_dir( $sample_patterns_path ) ) :
				
			  if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
			  	$sample_patterns = array();

			    while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

			      if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
			      	$name = explode(".", $sample_patterns_file);
			      	$name = str_replace('.'.end($name), '', $sample_patterns_file);
			      	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
			      }
			    }
			  endif;
			endif;

			ob_start();

			$ct = wp_get_theme();
			$this->theme = $ct;
			$item_name = $this->theme->get('Name'); 
			$tags = $this->theme->Tags;
			$screenshot = $this->theme->get_screenshot();
			$class = $screenshot ? 'has-screenshot' : '';

			$customize_title = sprintf( esc_html__( 'Customize &#8220;%s&#8221;','the-rex'), $this->theme->display('Name') );

			?>
			<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
				<?php if ( $screenshot ) : ?>
					<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
					<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
						<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview', 'the-rex'); ?>" />
					</a>
					<?php endif; ?>
					<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview', 'the-rex'); ?>" />
				<?php endif; ?>

				<h4>
					<?php echo esc_attr($this->theme->display('Name')); ?>
				</h4>

				<div>
					<ul class="theme-info">
						<li><?php printf( esc_html__('By %s','the-rex'), $this->theme->display('Author') ); ?></li>
						<li><?php printf( esc_html__('Version %s','the-rex'), $this->theme->display('Version') ); ?></li>
						<li><?php echo '<strong>'.esc_html__('Tags', 'the-rex').':</strong> '; ?><?php printf( $this->theme->display('Tags') ); ?></li>
					</ul>
					<p class="theme-description"><?php echo esc_attr($this->theme->display('Description')); ?></p>
					<?php if ( $this->theme->parent() ) {
						printf( ' <p class="howto">' . esc_html__( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'the-rex') . '</p>',
							esc_html__( 'http://codex.wordpress.org/Child_Themes','the-rex'),
							$this->theme->parent()->display( 'Name' ) );
					} ?>
					
				</div>

			</div>

			<?php
			$item_info = ob_get_contents();
			    
			ob_end_clean();

			$sampleHTML = '';

			// ACTUAL DECLARATION OF SECTIONS
            
                $this->sections[] = array(
    				'icon' => 'el-icon-wrench',
    				'title' => esc_html__('General Settings', 'the-rex'),
    				'fields' => array(
                        array(
    						'id'=>'bk-favicon',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Site favicon', 'the-rex'),
    						'subtitle' => esc_html__('Upload site Favicon (16x16 px)', 'the-rex'),
                            'placeholder' => esc_html__('No media selected','the-rex')
						),
    					array(
    						'id'=>'bk-primary-color',
    						'type' => 'color',
    						'title' => esc_html__('Primary color', 'the-rex'), 
    						'subtitle' => esc_html__('Pick a primary color for the theme.', 'the-rex'),
    						'default' => '#d13030',
    						'validate' => 'color',
						),
                        array(
    						'id'=>'bk-smooth-scroll',
    						'type' => 'switch', 
    						'title' => esc_html__('Smooth Scroll Enable', 'the-rex'),
    						'subtitle' => esc_html__('Choose to enable/disable Smooth Scroll Script', 'the-rex'),
                            'default' => 0,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						), 
                        array(
    						'id'=>'bk-retina-display',
    						'type' => 'switch', 
    						'title' => esc_html__('Retina Display', 'the-rex'),
    						'subtitle' => esc_html__('Choose to enable/disable Retina Display for your page', 'the-rex'),
                            'default' => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),                                                                        
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-tasks',
    				'title' => esc_html__('Site Layout', 'the-rex'),
    				'fields' => array(
                        array(
    						'id'=>'bk-site-layout',
    						'type' => 'button_set',
    						'title' => esc_html__('Site layout', 'the-rex'),
    						'subtitle'=> esc_html__('Choose between wide and boxed layout', 'the-rex'),
    						'options' => array('wide' => esc_html__('Wide', 'the-rex'),'boxed' => esc_html__('Boxed', 'the-rex')),
    						'default' => 'wide'
						),
                        array(
    						'id'=>'bk-body-bg',
    						'type' => 'background',
                            'required' => array('bk-site-layout','=','boxed'),
    						'output' => array('body'),
    						'title' => esc_html__('Site background', 'the-rex'), 
    						'subtitle' => esc_html__('Choose background image or background color for boxed layout', 'the-rex'),
						),
                        array(
    						'id'=>'bk-sb-location-sw',
    						'type' => 'select', 
    						'title' => esc_html__('Sidebar Location', 'the-rex'),
    						'subtitle' => esc_html__('Choose to display sidebar in the left or right the content section', 'the-rex'),
                            'options' => array('left' => esc_html__('Left', 'the-rex'),'right'=>esc_html__('Right', 'the-rex')),
    						"default" => 'right',
						),
                        array(
    						'id'=>'bk-sb-responsive-sw',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable sidebar in responsive layout (For small device width < 991px)', 'the-rex'),
    						'subtitle' => esc_html__('Choose to display or hide sidebar in responsive layout', 'the-rex'),
    						"default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-credit-card',
    				'title' => esc_html__('Header Settings', 'the-rex'),
    				'fields' => array(
                        array(
    						'id'=>'bk-logo',
    						'type' => 'media', 
    						'url'=> true,
    						'title' => esc_html__('Site logo', 'the-rex'),
    						'subtitle' => esc_html__('Upload logo of your site that is displayed in header', 'the-rex'),
                            'placeholder' => esc_html__('No media selected','the-rex')
						),
                        array(
    						'id'=>'bk-header-bg',
    						'type' => 'background',
    						'output' => array('.main-nav'),
    						'title' => esc_html__('Main Nav background', 'the-rex'), 
    						'subtitle' => esc_html__('Choose background image or background color for site header', 'the-rex'),
						),
                        array(
    						'id'=>'bk-header-top-switch',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable header top bar', 'the-rex'),
    						'subtitle' => esc_html__('', 'the-rex'),
						    'default' => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),
                        array(
    						'id'=>'bk-ajaxlogin-switch',
    						'type' => 'switch', 
                            'required' => array('bk-header-top-switch','=','1'),
    						'title' => esc_html__('Enable header Ajax login', 'the-rex'),
    						'subtitle' => esc_html__('You must install <a target="_blank" href="https://wordpress.org/plugins/login-with-ajax/">Login With Ajax</a> plugin to have this function', 'the-rex'),
    						'default' => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),
                        array(
    						'id'=>'bk-social-header-switch',
    						'type' => 'switch', 
                            'required' => array('bk-header-top-switch','=','1'),
    						'title' => esc_html__('Enable social header ', 'the-rex'),
    						'subtitle' => esc_html__('Enable social header by display icons', 'the-rex'),
    						'default' => 0,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),	
                        array(
    						'id'=>'bk-social-header',
    						'type' => 'text',
                            'required' => array('bk-social-header-switch','=','1'),
    						'title' => esc_html__('Social media', 'the-rex'),
    						'subtitle' => esc_html__('Set up social links for site', 'the-rex'),
    						'options' => array('fb'=>'Facebook Url', 'twitter'=>'Twitter Url', 'gplus'=>'GPlus Url', 'linkedin'=>'Linkedin Url',
                                               'pinterest'=>'Pinterest Url', 'instagram'=>'Instagram Url', 'dribbble'=>'Dribbble Url', 
                                               'youtube'=>'Youtube Url', 'vimeo'=>'Vimeo Url', 'vk'=>'VK Url', 'vine'=>'Vine URL',
                                               'snapchat'=>'SnapChat Url', 'rss'=>'RSS Url'),
    						'default' => array('fb'=>'', 'twitter'=>'', 'gplus'=>'', 'linkedin'=>'', 'pinterest'=>'', 'instagram'=>'', 'dribbble'=>'', 
                                                'youtube'=>'', 'vimeo'=>'', 'vk'=>'', 'vine'=>'', 'snapchat'=>'', 'rss'=>'')
						),
                        array(
    						'id'=>'bk-fixed-nav-switch',
    						'type' => 'button_set', 
    						'title' => esc_html__('Enable fixed header menu', 'the-rex'),
    						'subtitle'=> esc_html__('Choose between fixed and static header navigation', 'the-rex'),
                            'options' => array('1' => esc_html__('Static', 'the-rex'),'2' => esc_html__('Fixed', 'the-rex')),
    						'default' => '1',
						),
                        
                        array(
    						'id'=>'bk-menu-effect',
    						'type' => 'select', 
    						'title' => esc_html__('Menu Hover Effect', 'the-rex'),
    						'subtitle'=> esc_html__('Choose between Jump Up effect and Fade Effect Menu', 'the-rex'),
                            'options' => array('jump_up' => esc_html__('Jump Up', 'the-rex'),'fade' => esc_html__('Fade', 'the-rex')),
    						'default' => 'jump_up',
						), 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-credit-card',
    				'title' => esc_html__('Footer Settings', 'the-rex'),
    				'fields' => array(            
                        array(
    						'id'=>'bk-footer-instagram',
    						'type' => 'switch',
    						'title' => esc_html__('Footer Instagram', 'the-rex'),
    						'default' 		=> 0,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),
                        array(
                            'id' => 'section-instagram-header-start',
                            'title' => esc_html__('Footer Instagram Setting', 'the-rex'),
                            'subtitle' => '',
                            'required' => array('bk-footer-instagram','=','1'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-footer-instagram-title',
    						'title' => esc_html__('Instagram Section Title', 'the-rex'),
                            'type' => 'text',                            
						),
                        array(
    						'id'=>'bk-footer-instagram-username',
    						'title' => esc_html__('Instagram Username', 'the-rex'),
                            'type' => 'text',                            
						),
                        array(
                            'id' => 'section-instagram-header-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        array(
    						'id'=>'bk-backtop-switch',
    						'type' => 'switch', 
    						'title' => esc_html__('Scroll top button', 'the-rex'),
    						'subtitle'=> esc_html__('Show scroll to top button in right lower corner of window', 'the-rex'),
    						'default' 		=> 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),
                        array(
    						'id'=>'cr-text',
    						'type' => 'textarea',
    						'title' => esc_html__('Copyright text - HTML Validated', 'the-rex'), 
    						'subtitle' => esc_html__('HTML Allowed (wp_kses)', 'the-rex'),
    						'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
    						'default' => esc_html__('&#169; Copyright <a href="htttp://your-site-url">Your Site Name</a>. All rights reserved.', 'the-rex')
						),
    				)
    			);
                $this->sections[] = array(
            		'icon'    => ' el-icon-font',
            		'title'   => esc_html__('Typography', 'the-rex'),
            		'fields'  => array(
                        array(
            				'id'=>'bk-top-menu-font',
            				'type' => 'typography', 
                            'output' => array('#top-menu>ul>li, #top-menu>ul>li .sub-menu li, .bk_u_login, .bk_u_logout, .bk-links-modal,.bk-lwa-profile .bk-user-data > div'),
            				'title' => esc_html__('Top-menu font', 'the-rex'),
            				//'compiler'=>true, // Use if you want to hook in your own CSS compiler
            				'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            				//'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
            				//'subsets'=>false, // Only appears if google is true and subsets not set to false
            				'font-size'=>false,
            				'line-height'=>false,
            				//'word-spacing'=>true, // Defaults to false
            				//'letter-spacing'=>true, // Defaults to false
            				'color'=>false,
            				//'preview'=>false, // Disable the previewer
            				'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
            				'units'=>'px', // Defaults to px
                            'text-align' => false,
            				'subtitle'=> esc_html__('Font options for top menu', 'the-rex'),
            				'default'=> array( 
            					'font-weight'=>'400', 
            					'font-family'=>'Open Sans', 
            					'google' => true,
            				    ),
                        ),
                        array(
            				'id'=>'bk-main-menu-font',
            				'type' => 'typography', 
                            'output' => array('.main-nav #main-menu .menu > li, .main-nav #main-menu .menu > li > a, .mega-title h3, .header .logo.logo-text h1, .bk-sub-posts .post-title,
                            .comment-box .comment-author-name, .today-date, #main-mobile-menu li a'),
            				'title' => esc_html__('Main-menu font', 'the-rex'),
            				//'compiler'=>true, // Use if you want to hook in your own CSS compiler
            				'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            				//'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
            				//'subsets'=>false, // Only appears if google is true and subsets not set to false
            				'font-size'=>false,
            				'line-height'=>false,
            				//'word-spacing'=>true, // Defaults to false
            				//'letter-spacing'=>true, // Defaults to false
            				'color'=>false,
            				//'preview'=>false, // Disable the previewer
            				'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
            				'units'=>'px', // Defaults to px
                            'text-align' => false,
            				'subtitle'=> esc_html__('Font options for main menu', 'the-rex'),
            				'default'=> array( 
            					'font-weight'=>'400', 
            					'font-family'=>'Roboto', 
            					'google' => true,
            				    ),
                        ),
                        array(
            				'id'=>'bk-review-font',
            				'type' => 'typography', 
                            'output' => array('.review-score, .bk-criteria-wrap > span'
                            ),
            				'title' => esc_html__('Review score font', 'the-rex'),
            				//'compiler'=>true, // Use if you want to hook in your own CSS compiler
            				'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            				//'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
            				//'subsets'=>false, // Only appears if google is true and subsets not set to false
            				'font-size'=>false,
            				'line-height'=>false,
            				//'word-spacing'=>true, // Defaults to false
            				//'letter-spacing'=>true, // Defaults to false
            				'color'=>false,
            				//'preview'=>false, // Disable the previewer
            				'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
            				'units'=>'px', // Defaults to px
                            'text-align' => false,
            				'subtitle'=> esc_html__('Font options for review score', 'the-rex'),
            				'default'=> array( 
            					'font-weight'=>'400', 
            					'font-family'=>'Archivo Narrow', 
            					'google' => true,
            				    ),
                        ),
                        array(
            				'id'=>'bk-meta-font',
            				'type' => 'typography', 
                            'output' => array('.meta, .post-category, .post-date, .widget_comment .cm-header div, .module-feature2 .post-author, .comment-box .comment-time,
                            .loadmore span.ajaxtext, #comment-submit, .breadcrumbs, .button, .bk-search-content .nothing-respond'
                            ),
            				'title' => esc_html__('Meta font', 'the-rex'),
            				//'compiler'=>true, // Use if you want to hook in your own CSS compiler
            				'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            				//'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
            				//'subsets'=>false, // Only appears if google is true and subsets not set to false
            				'font-size'=>false,
            				'line-height'=>false,
            				//'word-spacing'=>true, // Defaults to false
            				//'letter-spacing'=>true, // Defaults to false
            				'color'=>false,
            				//'preview'=>false, // Disable the previewer
            				'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
            				'units'=>'px', // Defaults to px
                            'text-align' => false,
            				'subtitle'=> esc_html__('Font options for meta', 'the-rex'),
            				'default'=> array( 
            					'font-weight'=>'400', 
            					'font-family'=>'Archivo Narrow', 
            					'google' => true,
            				    ),
                        ),
                        array(
            				'id'=>'bk-module-title-font',
            				'type' => 'typography', 
                            'output' => array('.module-title h2, .page-title h2, .widget-title h3'),
            				'title' => esc_html__('Module title / Page Title font', 'the-rex'),
            				//'compiler'=>true, // Use if you want to hook in your own CSS compiler
            				'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            				//'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
            				//'subsets'=>false, // Only appears if google is true and subsets not set to false
            				'font-size'=>false,
            				'line-height'=>false,
            				//'word-spacing'=>true, // Defaults to false
            				//'letter-spacing'=>true, // Defaults to false
            				'color'=>false,
            				//'preview'=>false, // Disable the previewer
            				'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
            				'units'=>'px', // Defaults to px
                            'text-align' => false,
            				'subtitle'=> esc_html__('Font options for Module title / Page Title', 'the-rex'),
            				'default'=> array( 
            					'font-weight'=>'700', 
            					'font-family'=>'Vollkorn', 
            					'google' => true,
            				    ),
                        ),
                        array(
            				'id'=>'bk-title-font',
            				'type' => 'typography', 
                            'output' => array('h1, h2, h3, h4, h5, #mobile-top-menu > ul > li, #mobile-menu > ul > li, #footer-menu a, .bk-copyright, 
                            .widget-social-counter ul li .data .subscribe, 
                            .bk_tabs  .ui-tabs-nav li, .bkteamsc .team-member .member-name, .buttonsc '),
            				'title' => esc_html__('Title font', 'the-rex'),
            				//'compiler'=>true, // Use if you want to hook in your own CSS compiler
            				'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            				//'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
            				//'subsets'=>false, // Only appears if google is true and subsets not set to false
            				'font-size'=>false,
            				'line-height'=>false,
            				//'word-spacing'=>true, // Defaults to false
            				//'letter-spacing'=>true, // Defaults to false
            				'color'=>false,
            				//'preview'=>false, // Disable the previewer
            				'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
            				'units'=>'px', // Defaults to px
                            'text-align' => false,
            				'subtitle'=> esc_html__('Font options for title', 'the-rex'),
            				'default'=> array( 
            					'font-weight'=>'600', 
            					'font-family'=>'Open Sans', 
            					'google' => true,
            				    ),
                        ),
                        array(
            				'id'=>'bk-body-font',
            				'type' => 'typography',
                            'output' => array('body, textarea, input, p, 
                            .entry-excerpt, .comment-text, .comment-author, .article-content,
                            .comments-area, .tag-list, .bk-mega-menu .bk-sub-posts .feature-post .menu-post-item .post-date, .comments-area small'), 
            				'title' => esc_html__('Text font', 'the-rex'),
            				//'compiler'=>true, // Use if you want to hook in your own CSS compiler
            				'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
            				//'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
            				//'subsets'=>false, // Only appears if google is true and subsets not set to false
            				'font-size'=>false,
            				'line-height'=>false,
            				//'word-spacing'=>true, // Defaults to false
            				//'letter-spacing'=>true, // Defaults to false
            				'color'=>false,
            				//'preview'=>false, // Disable the previewer
            				'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
            				'units'=>'px', // Defaults to px
                            'text-align' => false,
            				'subtitle'=> esc_html__('Font options for text body', 'the-rex'),
            				'default'=> array(
            					'font-weight'=>'400', 
            					'font-family'=>'Lato', 
            					'google' => true,
                            ),
            			),
                    ),
                );
                $this->sections[] = array(
    				'icon' => 'el-icon-file-edit',
    				'title' => esc_html__('Post Settings', 'the-rex'),
    				'fields' => array(
                        array(
                            'id'       => 'feat-tag',
                            'type' => 'select',
                            'data' => 'tags',
                            'multi' => true,
                            'title'    => esc_html__('Featured tag name', 'the-rex'),
                            'subtitle' => esc_html__('Tag name to feature your post, if no posts match the tag, sticky post will be displayed instead.', 'the-rex'),
                            'default'  => ''
                        ),
                        array(
                            'id' => 'section-postmeta-start',
                            'title' => esc_html__('Post meta', 'the-rex'),
                            'subtitle' => esc_html__('Options for displaying post meta in modules and widgets','the-rex'),
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'=>'bk-meta-review-sw',
                            'type' => 'switch',
                            'title' => esc_html__('Enable post meta review score', 'the-rex'),
                            "default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
                        ),
                        array(
                            'id'=>'bk-meta-author-sw',
                            'type' => 'switch',
                            'title' => esc_html__('Enable post meta author', 'the-rex'),
                            "default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
                        ),
                        array(
                            'id'=>'bk-meta-date-sw',
                            'type' => 'switch',
                            'title' => esc_html__('Enable post meta date', 'the-rex'),
                            "default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
                        ),
                        array(
                            'id'=>'bk-meta-comments-sw',
                            'type' => 'switch',
                            'title' => esc_html__('Enable post meta comments', 'the-rex'),
                            "default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
                        ),
                        array(
                            'id' => 'section-postmeta-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),
                        
    				)
    			);
                $this->sections[] = array(
            		'icon'    => 'el-icon-book',
            		'title'   => esc_html__('Pages Setting', 'the-rex'),
            		'heading' => esc_html__('Pages Setting','the-rex'),
            		'desc'    => esc_html__('<p class="description">Setting layout for pages</p>', 'the-rex'),
            		'fields'  => array(
                    /*** Pagebuilder ***/
                    array(
                            'id' => 'section-front-layout-start',
                            'title' => esc_html__('Pagebuilder Setting', 'the-rex'),
                            'subtitle' => '',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),   
                        array(
                            'id' => 'pagebuilder-sidebar',  
                            'type' => 'select',
                            'multi' => false,
                            'title' => esc_html__('Stick Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                            'options' => array('enable'=>esc_html__('Enable', 'the-rex'), 
                                                'disable'=>esc_html__('Disable', 'the-rex')
                                                ),
                            'default' => 'disable',
                        ),
                        array(
                            'id' => 'section-blog-layout-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                    /*** Blog Layout ***/
                        array(
                            'id' => 'section-blog-layout-start',
                            'title' => esc_html__('Blog Page Setting', 'the-rex'),
                            'subtitle' => '',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),   
                        array(
            				'id'=>'bk-blog-layout',
            				'type' => 'select',
                            'title' => esc_html__('Blog page layout', 'the-rex'), 
    						'options' => array('classic-blog'=>esc_html__('Classic Blog', 'the-rex'), 
                                                'large-blog'=>esc_html__('Large Blog with Sidebar', 'the-rex'), 
                                                'masonry'=>esc_html__('Masonry with Sidebar', 'the-rex'),
                                                'masonry-nosb'=>esc_html__('Masonry no Sidebar', 'the-rex'),
                                                'square-grid-3'=>esc_html__('Square Grid no Sidebar', 'the-rex'),
                                                'square-grid-2'=>esc_html__('Square Grid with Sidebar', 'the-rex'),
                                                ),
    						'default' => 'blog-small',
            			),
                        array(
                            'id' => 'blog_post_icon',  
                            'type' => 'select',
                            'multi' => false,
                            'title' => esc_html__('Enable Post Icon on Blog page', 'the-rex'),
                            'subtitle' => esc_html__('Support for "Classic Blog layout", "Large Blog layout" and "Masonry Layout"', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                            'options' => array('show'=>esc_html__('Show', 'the-rex'), 
                                                'hide'=>esc_html__('Hide', 'the-rex')
                                                ),
                            'default' => 'disable',
                        ),
                        array(
                            'id' => 'blog-page-sidebar',  
                            'type' => 'select',
                            'data' => 'sidebars',
                            'multi' => false,
                            'title' => esc_html__('Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Choose sidebar for blog page', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                        ),
                        array(
                            'id' => 'blog-stick-sidebar',  
                            'type' => 'select',
                            'multi' => false,
                            'title' => esc_html__('Stick Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                            'options' => array('enable'=>esc_html__('Enable', 'the-rex'), 
                                                'disable'=>esc_html__('Disable', 'the-rex')
                                                ),
                            'default' => 'disable',
                        ),
                        array(
                            'id' => 'section-blog-layout-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                    /*** Author Layout ***/
                        array(
                        'id' => 'section-author-layout-start',
                            'title' => esc_html__('Author Page Setting', 'the-rex'),
                            'subtitle' => '',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),   
                        array(
            				'id'=>'bk-author-layout',
            				'type' => 'select',
                            'title' => esc_html__('Author page layout', 'the-rex'), 
    						'options' => array('classic-blog'=>esc_html__('Classic Blog', 'the-rex'), 
                                                'large-blog'=>esc_html__('Large Blog with Sidebar', 'the-rex'), 
                                                'masonry'=>esc_html__('Masonry with Sidebar', 'the-rex'),
                                                'masonry-nosb'=>esc_html__('Masonry no Sidebar', 'the-rex'),
                                                'square-grid-3'=>esc_html__('Square Grid no Sidebar', 'the-rex'),
                                                'square-grid-2'=>esc_html__('Square Grid with Sidebar', 'the-rex'),
                                                ),
    						'default' => 'blog-small',
            			),
                        array(
                            'id' => 'author_post_icon',  
                            'type' => 'select',
                            'multi' => false,
                            'title' => esc_html__('Enable Post Icon on Author page', 'the-rex'),
                            'subtitle' => esc_html__('Support for "Classic Blog layout", "Large Blog layout" and "Masonry Layout"', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                            'options' => array('show'=>esc_html__('Show', 'the-rex'), 
                                                'hide'=>esc_html__('Hide', 'the-rex')
                                                ),
                            'default' => 'disable',
                        ),
                        array(
                            'id' => 'author-page-sidebar',  
                            'type' => 'select',
                            'data' => 'sidebars',
                            'multi' => false,
                            'title' => esc_html__('Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Choose sidebar for Author page', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                        ),
                        array(
                            'id' => 'author-stick-sidebar',  
                            'type' => 'select',
                            'multi' => false,
                            'title' => esc_html__('Stick Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                            'options' => array('enable'=>esc_html__('Enable', 'the-rex'), 
                                                'disable'=>esc_html__('Disable', 'the-rex')
                                                ),
                            'default' => 'disable',
                        ),
                        array(
                            'id' => 'section-author-layout-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                    /*** Category Layout ***/
                        array(
                        'id' => 'section-category-layout-start',
                            'title' => esc_html__('Category Page Setting', 'the-rex'),
                            'subtitle' => '',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
            				'id'=>'bk-category-layout',
            				'type' => 'select',
                            'title' => esc_html__('Category page layout', 'the-rex'),
                            'subtitle' => esc_html__('Global setting for layout of category archive page, will be overridden by layout option in category edit page.', 'the-rex'), 
    						'options' => array('classic-blog'=>esc_html__('Classic Blog', 'the-rex'), 
                                                'large-blog'=>esc_html__('Large Blog with Sidebar', 'the-rex'), 
                                                'masonry'=>esc_html__('Masonry with Sidebar', 'the-rex'),
                                                'masonry-nosb'=>esc_html__('Masonry no Sidebar', 'the-rex'),
                                                'square-grid-3'=>esc_html__('Square Grid no Sidebar', 'the-rex'),
                                                'square-grid-2'=>esc_html__('Square Grid with Sidebar', 'the-rex'),
                                                ),
    						'default' => 'masonry',
            			),
                        array(
                            'id' => 'category_post_icon',  
                            'type' => 'select',
                            'multi' => false,
                            'title' => esc_html__('Enable Post Icon on category page', 'the-rex'),
                            'subtitle' => esc_html__('Support for "Classic Blog layout", "Large Blog layout" and "Masonry Layout"', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                            'options' => array('show'=>esc_html__('Show', 'the-rex'), 
                                                'hide'=>esc_html__('Hide', 'the-rex')
                                                ),
                            'default' => 'disable',
                        ),
                        array(
                            'id' => 'category-page-sidebar',  
                            'type' => 'select',
                            'data' => 'sidebars',
                            'multi' => false,
                            'title' => esc_html__('Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Choose sidebar for Category page', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                        ),
                        array(
                            'id' => 'category-stick-sidebar',  
                            'type' => 'select',
                            'multi' => false,
                            'title' => esc_html__('Stick Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                            'options' => array('enable'=>esc_html__('Enable', 'the-rex'), 
                                                'disable'=>esc_html__('Disable', 'the-rex')
                                                ),
                            'default' => 'disable',
                        ),
                        array(
                            'id' => 'section-category-layout-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                    /*** Archive Layout ***/
                        array(
                            'id' => 'section-archive-layout-start',
                            'title' => esc_html__('Archive Page Setting', 'the-rex'),
                            'subtitle' => '',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
            				'id'=>'bk-archive-layout',
            				'type' => 'select',
                            'title' => esc_html__('Archive page layout', 'the-rex'), 
                            'subtitle' => esc_html__('Layout for Archive page and Tag archive.', 'the-rex'),
    						'options' => array('classic-blog'=>esc_html__('Classic Blog', 'the-rex'), 
                                                'large-blog'=>esc_html__('Large Blog with Sidebar', 'the-rex'), 
                                                'masonry'=>esc_html__('Masonry with Sidebar', 'the-rex'),
                                                'masonry-nosb'=>esc_html__('Masonry no Sidebar', 'the-rex'),
                                                'square-grid-3'=>esc_html__('Square Grid no Sidebar', 'the-rex'),
                                                'square-grid-2'=>esc_html__('Square Grid with Sidebar', 'the-rex'),
                                                ),
    						'default' => 'classic-blog',
            			),
                        array(
                            'id' => 'archive_post_icon',  
                            'type' => 'select',
                            'multi' => false,
                            'title' => esc_html__('Enable Post Icon on Archive page', 'the-rex'),
                            'subtitle' => esc_html__('Support for "Classic Blog layout", "Large Blog layout" and "Masonry Layout"', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                            'options' => array('show'=>esc_html__('Show', 'the-rex'), 
                                                'hide'=>esc_html__('Hide', 'the-rex')
                                                ),
                            'default' => 'disable',
                        ),
                        array(
                            'id' => 'archive-page-sidebar',  
                            'type' => 'select',
                            'data' => 'sidebars',
                            'multi' => false,
                            'title' => esc_html__('Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Choose sidebar for Archive page', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                        ),
                        array(
                            'id' => 'archive-stick-sidebar',  
                            'type' => 'select',
                            'multi' => false,
                            'title' => esc_html__('Stick Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                            'options' => array('enable'=>esc_html__('Enable', 'the-rex'), 
                                                'disable'=>esc_html__('Disable', 'the-rex')
                                                ),
                            'default' => 'disable',
                        ),
                        array(
                            'id' => 'section-archive-layout-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                    /*** Search Layout ***/
                        array(
                            'id' => 'section-search-layout-start',
                            'title' => esc_html__('Search Page Setting', 'the-rex'),
                            'subtitle' => '',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
            				'id'=>'bk-search-layout',
            				'type' => 'select',
                            'title' => esc_html__('Search page layout', 'the-rex'), 
    						'options' => array('classic-blog'=>esc_html__('Classic Blog', 'the-rex'), 
                                                'large-blog'=>esc_html__('Large Blog with Sidebar', 'the-rex'), 
                                                'masonry'=>esc_html__('Masonry with Sidebar', 'the-rex'),
                                                'masonry-nosb'=>esc_html__('Masonry no Sidebar', 'the-rex'),
                                                'square-grid-3'=>esc_html__('Square Grid no Sidebar', 'the-rex'),
                                                'square-grid-2'=>esc_html__('Square Grid with Sidebar', 'the-rex'),
                                                ),
    						'default' => 'classic-blog',
            			),
                        array(
                            'id' => 'search_post_icon',  
                            'type' => 'select',
                            'multi' => false,
                            'title' => esc_html__('Enable Post Icon on Search page', 'the-rex'),
                            'subtitle' => esc_html__('Support for "Classic Blog layout", "Large Blog layout" and "Masonry Layout"', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                            'options' => array('show'=>esc_html__('Show', 'the-rex'), 
                                                'hide'=>esc_html__('Hide', 'the-rex')
                                                ),
                            'default' => 'disable',
                        ),
                        array(
                            'id' => 'search-page-sidebar',  
                            'type' => 'select',
                            'data' => 'sidebars',
                            'multi' => false,
                            'title' => esc_html__('Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Choose sidebar for Search page', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                        ),
                        array(
                            'id' => 'search-stick-sidebar',  
                            'type' => 'select',
                            'multi' => false,
                            'title' => esc_html__('Stick Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                            'options' => array('enable'=>esc_html__('Enable', 'the-rex'), 
                                                'disable'=>esc_html__('Disable', 'the-rex')
                                                ),
                            'default' => 'disable',
                        ),
                        array(
                            'id' => 'section-search-layout-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ),                        
                    ),
                );
                $this->sections[] = array(
    				'icon' => 'el-icon-list-alt',
    				'title' => esc_html__('Single Settings', 'the-rex'),
    				'fields' => array(
                        array(
    						'id'=>'bk-single-featimg',
    						'type' => 'switch', 
    						'title' => esc_html__('Featured image', 'the-rex'),
    						'subtitle' => esc_html__('Enable/Disable featured image in single post (Just effect to Standard Post Layout)', 'the-rex'),
    						"default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),
                        array(
                            'id' => 'single-page-sidebar',  
                            'type' => 'select',
                            'data' => 'sidebars', 
                            'multi' => false,
                            'title' => esc_html__('Single Page Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Choose sidebar for single page', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                        ),
                        array(
                            'id' => 'single-stick-sidebar',  
                            'type' => 'select',
                            'multi' => false,
                            'title' => esc_html__('Stick Sidebar', 'the-rex'),
                            'subtitle' => esc_html__('Enable Stick Sidebar / Disable Stick Sidebar', 'the-rex'),
                            'desc' => esc_html__('', 'the-rex'),
                            'options' => array('enable'=>esc_html__('Enable', 'the-rex'), 
                                                'disable'=>esc_html__('Disable', 'the-rex')
                                                ),
                            'default' => 'disable',
                        ),
                        array(
    						'id'=>'bk-sharebox-sw',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable share box', 'the-rex'),
    						'subtitle' => esc_html__('Enable share links below single post', 'the-rex'),
    						"default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
                            'indent' => true
						),
                        array(
                            'id'=>'section-sharebox-start',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),
                        array(
                            'id'=>'bk-fb-sw',
                            'type' => 'switch',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'title' => esc_html__('Enable Facebook share link', 'the-rex'),
                            "default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
                        ),
                        array(
                            'id'=>'bk-tw-sw',
                            'type' => 'switch',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'title' => esc_html__('Enable Twitter share link', 'the-rex'),
                            "default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
                        ),
                        array(
                            'id'=>'bk-gp-sw',
                            'type' => 'switch',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'title' => esc_html__('Enable Google+ share link', 'the-rex'),
                            "default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
                        ),
                        array(
                            'id'=>'bk-pi-sw',
                            'type' => 'switch',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'title' => esc_html__('Enable Pinterest share link', 'the-rex'),
                            "default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
                        ),
                        array(
                            'id'=>'bk-stu-sw',
                            'type' => 'switch',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'title' => esc_html__('Enable Stumbleupon share link', 'the-rex'),
                            "default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
                        ),
                        array(
                            'id'=>'bk-li-sw',
                            'type' => 'switch',
                            'required' => array('bk-sharebox-sw','=','1'),
                            'title' => esc_html__('Enable Linkedin share link', 'the-rex'),
                            "default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
                        ),
                        array(
                            'id'=>'section-sharebox-end',
                            'type' => 'section', 
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ), 
                        array(
    						'id'=>'bk-authorbox-sw',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable author box', 'the-rex'),
    						'subtitle' => esc_html__('Enable author information below single post', 'the-rex'),
    						"default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),
                        array(
    						'id'=>'bk-postnav-sw',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable post navigation', 'the-rex'),
    						'subtitle' => esc_html__('Enable post navigation below single post', 'the-rex'),
    						"default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),
                        array(
    						'id'=>'bk-related-sw',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable related posts', 'the-rex'),
    						'subtitle' => esc_html__('Enable related posts below single post', 'the-rex'),
    						"default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),
                        array(
    						'id'=>'bk-comment-sw',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable comment section', 'the-rex'),
    						'subtitle' => esc_html__('Enable comment section below single post', 'the-rex'),
    						"default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),
                        array(
                            'id' => 'section-recommend-start',
                            'title' => esc_html__('Recommend Box Setting', 'the-rex'),
                            'subtitle' => '',
                            'type' => 'section',                             
                            'indent' => true // Indent all options below until the next 'section' option is set.
                        ),     
                        array(
    						'id'=>'bk-recommend-box',
    						'type' => 'switch', 
    						'title' => esc_html__('Enable Recommend Box', 'the-rex'),
    						'subtitle' => esc_html__('A random post appear on single page', 'the-rex'),
    						"default" => 1,
    						'on' => esc_html__('Enabled', 'the-rex'),
    						'off' => esc_html__('Disabled', 'the-rex'),
						),     
                        array(
                            'id'       => 'recommend-box-title',
                            'type'     => 'text',
                            'title'    => esc_html__('Recommend Box title', 'the-rex'),
                            'default'  => ''
                        ),
                        array(
                            'id' => 'recommend-categories',
                            'type' => 'select',
                            'data' => 'categories',
                            'multi' => true,
                            'title' => esc_html__('Categories', 'the-rex')
                        ),
                        array(
                            'id'       => 'recommend-number',
                            'type'     => 'text',
                            'title'    => esc_html__('Number of posts', 'the-rex'),
                            'subtitle' => esc_html__('Type number of posts will be displayed', 'the-rex'),
                            'default'  => ''
                        ),
                        array(
                            'id' => 'section-recommend-end',
                            'type' => 'section',                             
                            'indent' => false // Indent all options below until the next 'section' option is set.
                        ) 
    				)
    			);
                $this->sections[] = array(
    				'icon' => 'el-icon-css',
    				'title' => esc_html__('Custom CSS', 'the-rex'),
    				'fields' => array(
                        array(
    						'id'=>'bk-css-code',
    						'type' => 'ace_editor',
    						'title' => esc_html__('CSS Code', 'the-rex'), 
    						'subtitle' => esc_html__('Paste your CSS code here.', 'the-rex'),
    						'mode' => 'css',
    			            'theme' => 'chrome',
    						'desc' => esc_html__('Possible modes can be found at <a href="http://ace.c9.io" target="_blank">', 'the-rex').'http://ace.c9.io/</a>.',
    			            'default' => "",
    					),                                              	
    				)
    			);				
					

			$theme_info = '<div class="redux-framework-section-desc">';
			$theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.esc_html__('<strong>Theme URL:</strong> ', 'the-rex').'<a href="'.$this->theme->get('ThemeURI').'" target="_blank">'.$this->theme->get('ThemeURI').'</a></p>';
			$theme_info .= '<p class="redux-framework-theme-data description theme-author">'.esc_html__('<strong>Author:</strong> ', 'the-rex').$this->theme->get('Author').'</p>';
			$theme_info .= '<p class="redux-framework-theme-data description theme-version">'.esc_html__('<strong>Version:</strong> ', 'the-rex').$this->theme->get('Version').'</p>';
			$theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$this->theme->get('Description').'</p>';
			$tabs = $this->theme->get('Tags');
			if ( !empty( $tabs ) ) {
				$theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.esc_html__('<strong>Tags:</strong> ', 'the-rex').implode(', ', $tabs ).'</p>';	
			}
			$theme_info .= '</div>';

			$this->sections[] = array(
				'type' => 'divide',
			);
		}	

		public function setHelpTabs() {

		}


		/**
			
			All the possible arguments for Redux.
			For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

		 **/
		public function setArguments() {
			
			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
	            
	            // TYPICAL -> Change these values as you need/desire
				'opt_name'          	=> 'bk_option', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'			=> $theme->get('Name'), // Name that appears at the top of your panel
				'display_version'		=> $theme->get('Version'), // Version that appears at the top of your panel
				'menu_type'          	=> 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'     	=> true, // Show the sections below the admin menu item or not
				'menu_title'			=> esc_html__( 'Theme Options', 'the-rex'),
	            'page'		 	 		=> esc_html__( 'Theme Options', 'the-rex'),
	            'google_api_key'   	 	=> 'AIzaSyBdxbxgVuwQcnN5xCZhFDSpouweO-yJtxw', // Must be defined to add google fonts to the typography module
	            'global_variable'    	=> '', // Set a different name for your global variable other than the opt_name
	            'dev_mode'           	=> false, // Show the time the page took to load, etc
	            'customizer'         	=> true, // Enable basic customizer support

	            // OPTIONAL -> Give you extra features
	            'page_priority'      	=> null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	            'page_parent'        	=> 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	            'page_permissions'   	=> 'manage_options', // Permissions needed to access the options panel.
	            'menu_icon'          	=> '', // Specify a custom URL to an icon
	            'last_tab'           	=> '', // Force your panel to always open to a specific tab (by id)
	            'page_icon'          	=> 'icon-themes', // Icon displayed in the admin panel next to your menu_title
	            'page_slug'          	=> '_options', // Page slug used to denote the panel
	            'save_defaults'      	=> true, // On load save the defaults to DB before user clicks save or not
	            'default_show'       	=> false, // If true, shows the default value next to each field that is not the default value.
	            'default_mark'       	=> '', // What to print by the field's title if the value shown is default. Suggested: *


	            // CAREFUL -> These options are for advanced use only
	            'transient_time' 	 	=> 60 * MINUTE_IN_SECONDS,
	            'output'            	=> true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	            'output_tag'            	=> true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	            //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
	            //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
	            

	            // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	            'database'           	=> '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	            
	        
	            'show_import_export' 	=> true, // REMOVE
	            'system_info'        	=> false, // REMOVE
	            
	            'help_tabs'          	=> array(),
	            'help_sidebar'       	=> '', // esc_html__( '', $this->args['domain'] );            
				);


			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.		
			$this->args['share_icons'][] = array(
			    'url' => 'https://github.com/ReduxFramework/ReduxFramework',
			    'title' => 'Visit us on GitHub', 
			    'icon' => 'el-icon-github'
			    // 'img' => '', // You can use icon OR img. IMG needs to be a full URL.
			);		
			$this->args['share_icons'][] = array(
			    'url' => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
			    'title' => 'Like us on Facebook', 
			    'icon' => 'el-icon-facebook'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://twitter.com/reduxframework',
			    'title' => 'Follow us on Twitter', 
			    'icon' => 'el-icon-twitter'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://www.linkedin.com/company/redux-framework',
			    'title' => 'Find us on LinkedIn', 
			    'icon' => 'el-icon-linkedin'
			);

			
	 
			// Panel Intro text -> before the form
			if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false ) {
				if (!empty($this->args['global_variable'])) {
					$v = $this->args['global_variable'];
				} else {
					$v = str_replace("-", "_", $this->args['opt_name']);
				}
				$this->args['intro_text'] = '';
			} else {
				$this->args['intro_text'] = '';
			}

			// Add content after the form.
			$this->args['footer_text'] = '' ;

		}
	}
	new Redux_Framework_config();

}


/** 

	Custom function for the callback referenced above

 */
if ( !function_exists( 'redux_my_custom_field' ) ):
	function redux_my_custom_field($field, $value) {
	    print_r($field);
	    print_r($value);
	}
endif;

/**
 
	Custom function for the callback validation referenced above

**/
if ( !function_exists( 'redux_validate_callback_function' ) ):
	function redux_validate_callback_function($field, $value, $existing_value) {
	    $error = false;
	    $value =  'just testing';
	    /*
	    do your validation
	    
	    if(something) {
	        $value = $value;
	    } elseif(something else) {
	        $error = true;
	        $value = $existing_value;
	        $field['msg'] = 'your custom error message';
	    }
	    */
	    
	    $return['value'] = $value;
	    if($error == true) {
	        $return['error'] = $field;
	    }
	    return $return;
	}
endif;
