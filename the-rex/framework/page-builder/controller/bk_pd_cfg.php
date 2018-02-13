<?php
/* 
 * Sections Configuration
 */
 if ( ! function_exists( 'bk_init_sections' ) ) {
	function bk_init_sections() {
		$sections = array(
            'fullwidth'=>esc_html__('FullWidth Section','the-rex'), 'has-rsb' => esc_html__('Content Section', 'the-rex')
		);
		wp_localize_script( 'bk-page-builder-js', 'bk_sections', $sections );
        $modules = array(
            'feature1' => array(
				'title' => esc_html__( 'BK Feature Module - 1', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'limit' => array(
						'title' => esc_html__('Number of Posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts', 'the-rex'),
						'field' => 'number',
						'default' => 8
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => esc_html__('Order', 'the-rex'),
                        'description' => esc_html__( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load More Button (If have) will be disabled', 'the-rex'),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => esc_html__( 'Latest', 'the-rex'),
							'rand' => esc_html__( 'Random', 'the-rex'),
						),
					),
                    'feature' => array(
						'title' => esc_html__('Display featured posts in slider', 'the-rex'),
                        'description' => esc_html__( 'Yes: Display featured posts', 'the-rex'),
						'field' => 'select',
						'default' => 'no',
						'options' => array(
							'yes' => esc_html__( 'Yes', 'the-rex'),
							'no' => esc_html__( 'No', 'the-rex'),
						),
					),            
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Choose a post category to be shown up', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'feature2' => array(
				'title' => esc_html__( 'BK Feature Module - 2', 'the-rex'),
				'options' => array(
                    'feature' => array(
						'title' => esc_html__('Display featured posts', 'the-rex'),
                        'description' => esc_html__( 'Yes: Display featured posts', 'the-rex'),
						'field' => 'select',
						'default' => 'no',
						'options' => array(
							'yes' => esc_html__( 'Yes', 'the-rex'),
							'no' => esc_html__( 'No', 'the-rex'),
						),
					),
                    'bg_color' => array(
						'title' => esc_html__('Background Color', 'the-rex'),
						'description' => esc_html__( 'Choose Background Color', 'the-rex'),
						'field' => 'color',
						'default' => '',
					),
                    'limit' => array(
						'title' => esc_html__('Number of posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts', 'the-rex'),
						'field' => 'number',
						'default' => 1
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => esc_html__('Order', 'the-rex'),
                        'description' => esc_html__( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'the-rex'),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => esc_html__( 'Latest', 'the-rex'),
							'rand' => esc_html__( 'Random', 'the-rex'),
						),
					),
                    'post_icon' => array(
						'title' => esc_html__('Post Format Icon', 'the-rex'),
                        'description' => esc_html__( 'Show/hide Post Format Icon (Just for Video, Audio and Gallery Post Format)', 'the-rex'),
						'field' => 'select',
						'default' => 'show',
						'options' => array(
							'show' => esc_html__( 'Show', 'the-rex'),
							'hide' => esc_html__( 'Hide', 'the-rex'),
						),
					),        
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'feature_slider' => array(
				'title' => esc_html__( 'BK Boxed Slider', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => esc_html__('Order', 'the-rex'),
                        'description' => esc_html__( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'the-rex'),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => esc_html__( 'Latest', 'the-rex'),
							'rand' => esc_html__( 'Random', 'the-rex'),
						),
					),
                    'feature' => array(
						'title' => esc_html__('Display featured posts in slider', 'the-rex'),
                        'description' => esc_html__( 'Yes: Display featured posts', 'the-rex'),
						'field' => 'select',
						'default' => 'no',
						'options' => array(
							'yes' => esc_html__( 'Yes', 'the-rex'),
							'no' => esc_html__( 'No', 'the-rex'),
						),
					),
                    'limit' => array(
						'title' => esc_html__('Number of Posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts', 'the-rex'),
						'field' => 'number',
						'default' => 1
					),
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'carousel_type2' => array(
				'title' => esc_html__( 'BK Carousel', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'limit' => array(
						'title' => esc_html__('Number of posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts ( Recommend at least 4 posts ', 'the-rex'),
						'field' => 'number',
						'default' => 5
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => esc_html__('Order', 'the-rex'),
                        'description' => esc_html__( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'the-rex'),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => esc_html__( 'Latest', 'the-rex'),
							'rand' => esc_html__( 'Random', 'the-rex'),
						),
					),
                    'bg_color' => array(
						'title' => esc_html__('Background Color', 'the-rex'),
						'description' => esc_html__( 'Choose Background Color (do not choose a white color)', 'the-rex'),
						'field' => 'color',
						'default' => '#000',
					),
                    'post_icon' => array(
						'title' => esc_html__('Post Format Icon', 'the-rex'),
                        'description' => esc_html__( 'Show/hide Post Format Icon (Just for Video, Audio and Gallery Post Format)', 'the-rex'),
						'field' => 'select',
						'default' => 'show',
						'options' => array(
							'show' => esc_html__( 'Show', 'the-rex'),
							'hide' => esc_html__( 'Hide', 'the-rex'),
						),
					),     
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'row' => array(
				'title' => esc_html__( 'BK Row', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'limit' => array(
						'title' => esc_html__('Number of Rows', 'the-rex'),
						'description' => esc_html__( 'Enter the number of post rows', 'the-rex'),
						'field' => 'number',
						'default' => 1
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => esc_html__('Order', 'the-rex'),
                        'description' => esc_html__( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'the-rex'),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => esc_html__( 'Latest', 'the-rex'),
							'rand' => esc_html__( 'Random', 'the-rex'),
						),
					),
                    'post_icon' => array(
						'title' => esc_html__('Post Format Icon', 'the-rex'),
                        'description' => esc_html__( 'Show/hide Post Format Icon (Just for Video, Audio and Gallery Post Format)', 'the-rex'),
						'field' => 'select',
						'default' => 'show',
						'options' => array(
							'show' => esc_html__( 'Show', 'the-rex'),
							'hide' => esc_html__( 'Hide', 'the-rex'),
						),
					),
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'hero' => array(
				'title' => esc_html__( 'BK Hero', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => esc_html__('Order', 'the-rex'),
                        'description' => esc_html__( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'the-rex'),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => esc_html__( 'Latest', 'the-rex'),
							'rand' => esc_html__( 'Random', 'the-rex'),
						),
					),
                    'post_icon' => array(
						'title' => esc_html__('Post Format Icon', 'the-rex'),
                        'description' => esc_html__( 'Show/hide Post Format Icon (Just for Video, Audio and Gallery Post Format)', 'the-rex'),
						'field' => 'select',
						'default' => 'show',
						'options' => array(
							'show' => esc_html__( 'Show', 'the-rex'),
							'hide' => esc_html__( 'Hide', 'the-rex'),
						),
					),
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'fw_slider' => array(
				'title' => esc_html__( 'BK Fullwidth Slider', 'the-rex'),
				'options' => array(
                    'limit' => array(
						'title' => esc_html__('Number of Posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts', 'the-rex'),
						'field' => 'number',
						'default' => 5
					),
                    'feature' => array(
						'title' => esc_html__('Display featured posts in slider', 'the-rex'),
                        'description' => esc_html__( 'Yes: Display featured posts', 'the-rex'),
						'field' => 'select',
						'default' => 'no',
						'options' => array(
							'yes' => esc_html__( 'Yes', 'the-rex'),
							'no' => esc_html__( 'No', 'the-rex'),
						),
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => esc_html__('Order', 'the-rex'),
                        'description' => esc_html__( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'the-rex'),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => esc_html__( 'Latest', 'the-rex'),
							'rand' => esc_html__( 'Random', 'the-rex'),
						),
					),
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'masonry' => array(
				'title' => esc_html__( 'BK Masonry', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'limit' => array(
						'title' => esc_html__('Number of Posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts will be displayed', 'the-rex'),
						'field' => 'number',
						'default' => 3
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'ajax_load_number' => array(
						'title' => esc_html__('Ajax post', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts will be displayed when click ajax load button', 'the-rex'),
						'field' => 'number',
						'default' => 4
					),
                    'ajax_button' => array(
						'title' => esc_html__('Ajax Button', 'the-rex'),
                        'description' => esc_html__( 'Enable/Disable Ajax Button', 'the-rex'),
						'field' => 'select',
						'default' => 'enable',
						'options' => array(
							'enable' => esc_html__( 'Enable', 'the-rex'),
							'disable' => esc_html__( 'Disable', 'the-rex'),
						),
					),
                    'post_icon' => array(
						'title' => esc_html__('Post Format Icon', 'the-rex'),
                        'description' => esc_html__( 'Show/hide Post Format Icon (Just for Video, Audio and Gallery Post Format)', 'the-rex'),
						'field' => 'select',
						'default' => 'show',
						'options' => array(
							'show' => esc_html__( 'Show', 'the-rex'),
							'hide' => esc_html__( 'Hide', 'the-rex'),
						),
					),        
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'square_grid' => array(
				'title' => esc_html__( 'BK Square Grid', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'limit' => array(
						'title' => esc_html__('Number of posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts ( Recommend at least 4 posts ', 'the-rex'),
						'field' => 'number',
						'default' => 5
					),
                    'ajax_load_number' => array(
						'title' => esc_html__('Ajax post', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts will be displayed when click ajax load button', 'the-rex'),
						'field' => 'number',
						'default' => 4
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'ajax_button' => array(
						'title' => esc_html__('Ajax Button', 'the-rex'),
                        'description' => esc_html__( 'Enable/Disable Ajax Button', 'the-rex'),
						'field' => 'select',
						'default' => 'enable',
						'options' => array(
							'enable' => esc_html__( 'Enable', 'the-rex'),
							'disable' => esc_html__( 'Disable', 'the-rex'),
						),
					),
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'custom_html' => array(
				'title' => esc_html__( 'BK Custom HTML', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'custom_html' => array(
						'title' => esc_html__('HTML Code', 'the-rex'),
						'description' => esc_html__( 'Put your custom HTML code here', 'the-rex'),
						'field' => 'textarea',
						'default' => '',
					),
				),
			),  
            'shortcode' => array(
				'title' => esc_html__( 'BK Short Code', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'shortcode' => array(
						'title' => esc_html__('Shortcode', 'the-rex'),
						'description' => esc_html__( 'Put Shortcode here', 'the-rex'),
						'field' => 'textarea',
						'default' => '',
					),
				),
			),  
            'ads' => array(
				'title' => esc_html__( 'BK Single Ads', 'the-rex'),
				'options' => array(
                    'image_url' => array(
						'title' => esc_html__('Image Url','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'url' => array(
						'title' => esc_html__('Url','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					)
				),
            ),
            'two_col_ads' => array(
				'title' => esc_html__( 'BK Two Cols Ads', 'the-rex'),
				'options' => array(
                    'image_url1' => array(
						'title' => esc_html__('Image Url - (First Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'url1' => array(
						'title' => esc_html__('Url - (First Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'image_url2' => array(
						'title' => esc_html__('Image Url - (Last Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'url2' => array(
						'title' => esc_html__('Url - (Last Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					)
				),
            ),
            'three_col_ads' => array(
				'title' => esc_html__( 'BK Three Cols Ads', 'the-rex'),
				'options' => array(
                    'image_url1' => array(
						'title' => esc_html__('Image Url - (First Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'url1' => array(
						'title' => esc_html__('Url - (First Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'image_url2' => array(
						'title' => esc_html__('Image Url - (Middle Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'url2' => array(
						'title' => esc_html__('Url - (Middle Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'image_url3' => array(
						'title' => esc_html__('Image Url - (Last Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'url3' => array(
						'title' => esc_html__('Url - (Last Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					)
				),
            ),
            'adsense' => array(
				'title' => esc_html__( 'BK Adsense', 'the-rex'),
				'options' => array(
                    'adsense_code' => array(
						'title' => esc_html__('Adsense Code','the-rex'),
						'description' => esc_html__( 'Put your adsense code here', 'the-rex'),
						'field' => 'textarea',
						'default' => '',
					),
				),
            ),
        );
		wp_localize_script( 'bk-page-builder-js', 'bk_fullwidth_modules', $modules );
        $modules = array(
            'feature_slider' => array(
				'title' => esc_html__( 'BK Feature Slider', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'feature' => array(
						'title' => esc_html__('Display featured posts in slider', 'the-rex'),
                        'description' => esc_html__( 'Yes: Display featured posts', 'the-rex'),
						'field' => 'select',
						'default' => 'no',
						'options' => array(
							'yes' => esc_html__( 'Yes', 'the-rex'),
							'no' => esc_html__( 'No', 'the-rex'),
						),
					),
                    'limit' => array(
						'title' => esc_html__('Number of Posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts', 'the-rex'),
						'field' => 'number',
						'default' => 1
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => esc_html__('Order', 'the-rex'),
                        'description' => esc_html__( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'the-rex'),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => esc_html__( 'Latest', 'the-rex'),
							'rand' => esc_html__( 'Random', 'the-rex'),
						),
					),
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'square_grid' => array(
				'title' => esc_html__( 'BK Square Grid', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'limit' => array(
						'title' => esc_html__('Number of posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts ( Recommend at least 4 posts ', 'the-rex'),
						'field' => 'number',
						'default' => 5
					),
                    'ajax_load_number' => array(
						'title' => esc_html__('Ajax post', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts will be displayed when click ajax load button', 'the-rex'),
						'field' => 'number',
						'default' => 4
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'ajax_button' => array(
						'title' => esc_html__('Ajax Button', 'the-rex'),
                        'description' => esc_html__( 'Enable/Disable Ajax Button', 'the-rex'),
						'field' => 'select',
						'default' => 'enable',
						'options' => array(
							'enable' => esc_html__( 'Enable', 'the-rex'),
							'disable' => esc_html__( 'Disable', 'the-rex'),
						),
					),
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'block_1' => array(
				'title' => esc_html__( 'BK Post Block 1', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => esc_html__('Order', 'the-rex'),
                        'description' => esc_html__( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'the-rex'),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => esc_html__( 'Latest', 'the-rex'),
							'rand' => esc_html__( 'Random', 'the-rex'),
						),
					),
                    'post_icon' => array(
						'title' => esc_html__('Post Format Icon', 'the-rex'),
                        'description' => esc_html__( 'Show/hide Post Format Icon (Just for Video, Audio and Gallery Post Format)', 'the-rex'),
						'field' => 'select',
						'default' => 'show',
						'options' => array(
							'show' => esc_html__( 'Show', 'the-rex'),
							'hide' => esc_html__( 'Hide', 'the-rex'),
						),
					),
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'block_2' => array(
				'title' => esc_html__( 'BK Post Block 2', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'limit' => array(
						'title' => esc_html__('Number of Posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts will be displayed', 'the-rex'),
						'field' => 'number',
						'default' => 4
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'order' => array(
						'title' => esc_html__('Order', 'the-rex'),
                        'description' => esc_html__( 'Display random posts or latest posts from categories - (IMPORTANT) IF ORDER = Random, Ajax Load (If have) will be disabled', 'the-rex'),
						'field' => 'select',
						'default' => 'date',
						'options' => array(
							'date' => esc_html__( 'Latest', 'the-rex'),
							'rand' => esc_html__( 'Random', 'the-rex'),
						),
					),
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
			'masonry' => array(
				'title' => esc_html__( 'BK Masonry', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'limit' => array(
						'title' => esc_html__('Number of Posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts will be displayed', 'the-rex'),
						'field' => 'number',
						'default' => 4
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'ajax_load_number' => array(
						'title' => esc_html__('Ajax post', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts will be displayed when click ajax load button', 'the-rex'),
						'field' => 'number',
						'default' => 4
					),
                    'ajax_button' => array(
						'title' => esc_html__('Ajax Button', 'the-rex'),
                        'description' => esc_html__( 'Enable/Disable Ajax Button', 'the-rex'),
						'field' => 'select',
						'default' => 'enable',
						'options' => array(
							'enable' => esc_html__( 'Enable', 'the-rex'),
							'disable' => esc_html__( 'Disable', 'the-rex'),
						),
					),
                    'post_icon' => array(
						'title' => esc_html__('Post Format Icon', 'the-rex'),
                        'description' => esc_html__( 'Show/hide Post Format Icon (Just for Video, Audio and Gallery Post Format)', 'the-rex'),
						'field' => 'select',
						'default' => 'show',
						'options' => array(
							'show' => esc_html__( 'Show', 'the-rex'),
							'hide' => esc_html__( 'Hide', 'the-rex'),
						),
					),                                        
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
			),
            'classic_blog' => array(
				'title' => esc_html__( 'BK Classic Blog', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'limit' => array(
						'title' => esc_html__('Number of Posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts will be displayed', 'the-rex'),
						'field' => 'number',
						'default' => 4
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'ajax_load_number' => array(
						'title' => esc_html__('Ajax post', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts will be displayed when click ajax load button', 'the-rex'),
						'field' => 'number',
						'default' => 4
					),
                    'ajax_button' => array(
						'title' => esc_html__('Ajax Button', 'the-rex'),
                        'description' => esc_html__( 'Enable/Disable Ajax Button', 'the-rex'),
						'field' => 'select',
						'default' => 'enable',
						'options' => array(
							'enable' => esc_html__( 'Enable', 'the-rex'),
							'disable' => esc_html__( 'Disable', 'the-rex'),
						),
					),
                    'post_icon' => array(
						'title' => esc_html__('Post Format Icon', 'the-rex'),
                        'description' => esc_html__( 'Show/hide Post Format Icon (Just for Video, Audio and Gallery Post Format)', 'the-rex'),
						'field' => 'select',
						'default' => 'show',
						'options' => array(
							'show' => esc_html__( 'Show', 'the-rex'),
							'hide' => esc_html__( 'Hide', 'the-rex'),
						),
					),
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
            ),
            'large_blog' => array(
				'title' => esc_html__( 'BK Large Blog', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The Module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'limit' => array(
						'title' => esc_html__('Number of Posts', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts will be displayed', 'the-rex'),
						'field' => 'number',
						'default' => 4
					),
                    'offset' => array(
						'title' => esc_html__('Offset', 'the-rex'),
						'description' => esc_html__( 'Enter the offset number', 'the-rex'),
						'field' => 'number',
						'default' => 0
					),
                    'ajax_load_number' => array(
						'title' => esc_html__('Ajax post', 'the-rex'),
						'description' => esc_html__( 'Enter the number of posts will be displayed when click ajax load button', 'the-rex'),
						'field' => 'number',
						'default' => 4
					),
                    'ajax_button' => array(
						'title' => esc_html__('Ajax Button', 'the-rex'),
                        'description' => esc_html__( 'Enable/Disable Ajax Button', 'the-rex'),
						'field' => 'select',
						'default' => 'enable',
						'options' => array(
							'enable' => esc_html__( 'Enable', 'the-rex'),
							'disable' => esc_html__( 'Disable', 'the-rex'),
						),
					),
                    'post_icon' => array(
						'title' => esc_html__('Post Format Icon', 'the-rex'),
                        'description' => esc_html__( 'Show/hide Post Format Icon (Just for Video, Audio and Gallery Post Format)', 'the-rex'),
						'field' => 'select',
						'default' => 'show',
						'options' => array(
							'show' => esc_html__( 'Show', 'the-rex'),
							'hide' => esc_html__( 'Hide', 'the-rex'),
						),
					),
					'category' => array(
						'title' => esc_html__('Category', 'the-rex'),
						'description' => esc_html__( 'Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple categories.', 'the-rex'),
						'field' => 'category',
						'default' => 'All',
					),
				),
            ), 
            'custom_html' => array(
				'title' => esc_html__( 'BK Custom HTML', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'custom_html' => array(
						'title' => esc_html__('HTML Code', 'the-rex'),
						'description' => esc_html__( 'Put your custom HTML code here', 'the-rex'),
						'field' => 'textarea',
						'default' => '',
					),
				),
			),  
            'shortcode' => array(
				'title' => esc_html__( 'BK Short Code', 'the-rex'),
				'options' => array(
                    'title' => array(
						'title' => esc_html__('Title', 'the-rex'),
						'description' => esc_html__( 'The module title', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'sub_title' => array(
						'title' => esc_html__('Sub Title', 'the-rex'),
						'description' => esc_html__( 'The module subtitle', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'shortcode' => array(
						'title' => esc_html__('Shortcode', 'the-rex'),
						'description' => esc_html__( 'Put Shortcode here', 'the-rex'),
						'field' => 'textarea',
						'default' => '',
					),
				),
			),  
            'ads' => array(
				'title' => esc_html__( 'BK Single Ads', 'the-rex'),
				'options' => array(
                    'image_url' => array(
						'title' => esc_html__('Image Url','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'url' => array(
						'title' => esc_html__('Url','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					)
				),
            ),
            'two_col_ads' => array(
				'title' => esc_html__( 'BK Two Cols Ads', 'the-rex'),
				'options' => array(
                    'image_url1' => array(
						'title' => esc_html__('Image Url - (First Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'url1' => array(
						'title' => esc_html__('Url - (First Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'image_url2' => array(
						'title' => esc_html__('Image Url - (Last Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					),
                    'url2' => array(
						'title' => esc_html__('Url - (Last Column)','the-rex'),
						'description' => esc_html__( '', 'the-rex'),
						'field' => 'text',
						'default' => '',
					)
				),
            ),
            'adsense' => array(
				'title' => esc_html__( 'BK Adsense', 'the-rex'),
				'options' => array(
                    'adsense_code' => array(
						'title' => esc_html__('Adsense Code','the-rex'),
						'description' => esc_html__( 'Put your adsense code here', 'the-rex'),
						'field' => 'textarea',
						'default' => '',
					),
				),
            ),
        );
		wp_localize_script( 'bk-page-builder-js', 'bk_has_rsb_modules', $modules );
        $modules = array(
        
        );
		wp_localize_script( 'bk-page-builder-js', 'bk_has_innersb_left_modules', $modules );
        $modules = array(

        );
		wp_localize_script( 'bk-page-builder-js', 'bk_has_innersb_right_modules', $modules );
	}
} 