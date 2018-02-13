<?php
/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
$prefix = 'bk_';

global $meta_boxes;

$meta_boxes = array();

// Post Layout Options
$meta_boxes[] = array(
    'id' => "{$prefix}post_ops",
    'title' => esc_html__( 'BK Post Option', 'the-rex'),
    'pages' => array( 'post' ),
    'context' => 'normal',
    'priority' => 'low',

    'fields' => array(
        // Enable Review
        array(
			'id' => "{$prefix}post_layout",
            'name' => esc_html__( 'Post Layout Option', 'the-rex'),
			'desc' => esc_html__('Setup Post Layout', 'the-rex'),
            'type' => 'select', 
			'options'  => array(
                            'parallax' => esc_html__( 'Parallax', 'the-rex'),
        					'fullwidth' => esc_html__( 'Fullwidth', 'the-rex'),
                            'standard' => esc_html__( 'Standard', 'the-rex'),
    				    ),
			// Select multiple values, optional. Default is false.
			'multiple'    => false,
			'std'         => 'standard',
		),
        // Sidebar Select
        array(
            'name' => esc_html__( 'Choose a sidebar for this post', 'the-rex'),
            'id' => "{$prefix}post_sb_select",
            'type' => 'sidebar_select',
            'desc' => esc_html__( 'Global Setting option: Theme Options -> Single Settings -> Single Page Sidebar (this options will be overridden by the other options)', 'the-rex'),
            'std'  => '',
        ),
    )
);
// 2nd meta box
$meta_boxes[] = array(
    'id' => "{$prefix}format_options",
    'title' => esc_html__( 'BK Post Format Options', 'the-rex'),
    'pages' => array( 'post' ),
    'context' => 'normal',
    'priority' => 'high',
	'fields' => array(        
        //Video
        array(
            'name' => esc_html__( 'Format Options: Video, Audio', 'the-rex'),
            'desc' => esc_html__('Support Youtube, Vimeo, SoundCloud, DailyMotion Link', 'the-rex'),
            'id' => "{$prefix}media_embed_code_post",
            'type' => 'textarea',
            'placeholder' => esc_html__('Link ...', 'the-rex'),
            'std' => ''
        ),
		// PLUPLOAD IMAGE UPLOAD (WP 3.3+)
		array(
			'name'             => esc_html__( 'Format Options: Image', 'the-rex'),
            'desc'             => esc_html__('Image Upload', 'the-rex'),
			'id'               => "{$prefix}image_upload",
			'type'             => 'plupload_image',
			'max_file_uploads' => 1,
		),
        //Gallery
        array(
            'name' => esc_html__( 'Format Options: Gallery', 'the-rex'),
            'desc' => esc_html__('Gallery Images', 'the-rex'),
            'id' => "{$prefix}gallery_content",
            'type' => 'image_advanced',
            'std' => ''
        ),
    )
);
// Post Review Options
$meta_boxes[] = array(
    'id' => "{$prefix}review",
    'title' => esc_html__( 'BK Review System', 'the-rex'),
    'pages' => array( 'post' ),
    'context' => 'normal',
    'priority' => 'high',

    'fields' => array(
        // Enable Review
        array(
            'name' => esc_html__( 'Include Review Box', 'the-rex'),
            'id' => "{$prefix}review_checkbox",
            'type' => 'checkbox',
            'desc' => esc_html__( 'Enable Review On This Post', 'the-rex'),
            'std'  => 0,
        ),
        // Criteria 1 Text & Score
        array(
            'name'  => esc_html__( 'Criteria 1 Title', 'the-rex'),
            'id'    => "{$prefix}ct1",
            'type'  => 'text',
        ),
        array(
            'name' => esc_html__( 'Criteria 1 Score', 'the-rex'),
            'id' => "{$prefix}cs1",
            'type' => 'slider',
            'js_options' => array(
                'min'   => 0,
                'max'   => 10.05,
                'step'  => .1,
            ),
        ),
        // Criteria 2 Text & Score
        array(
            'name'  => esc_html__( 'Criteria 2 Title', 'the-rex'),
            'id'    => "{$prefix}ct2",
            'type'  => 'text',
        ),
        array(
            'name' => esc_html__( 'Criteria 2 Score', 'the-rex'),
            'id' => "{$prefix}cs2",
            'type' => 'slider',
            'js_options' => array(
                'min'   => 0,
                'max'   => 10.05,
                'step'  => .1,
            ),
        ),    
        // Criteria 3 Text & Score
        array(
            'name'  => esc_html__( 'Criteria 3 Title', 'the-rex'),
            'id'    => "{$prefix}ct3",
            'type'  => 'text',
        ),
        array(
            'name' => esc_html__( 'Criteria 3 Score', 'the-rex'),
            'id' => "{$prefix}cs3",
            'type' => 'slider',
            'js_options' => array(
                'min'   => 0,
                'max'   => 10.05,
                'step'  => .1,
            ),
        ),
        // Criteria 4 Text & Score
        array(
            'name'  => esc_html__( 'Criteria 4 Title', 'the-rex'),
            'id'    => "{$prefix}ct4",
            'type'  => 'text',
        ),
        array(
            'name' => esc_html__( 'Criteria 4 Score', 'the-rex'),
            'id' => "{$prefix}cs4",
            'type' => 'slider',
            'js_options' => array(
                'min'   => 0,
                'max'   => 10.05,
                'step'  => .1,
            ),
        ),
        // Criteria 5 Text & Score
        array(
            'name'  => esc_html__( 'Criteria 5 Title', 'the-rex'),
            'id'    => "{$prefix}ct5",
            'type'  => 'text',
        ),
        array(
            'name' => esc_html__( 'Criteria 5 Score', 'the-rex'),
            'id' => "{$prefix}cs5",
            'type' => 'slider',
            'js_options' => array(
                'min'   => 0,
                'max'   => 10.05,
                'step'  => .1,
            ),
        ),    
        // Criteria 6 Text & Score
        array(
            'name'  => esc_html__( 'Criteria 6 Title', 'the-rex'),
            'id'    => "{$prefix}ct6",
            'type'  => 'text',
        ),
        array(
            'name' => esc_html__( 'Criteria 6 Score', 'the-rex'),
            'id' => "{$prefix}cs6",
            'type' => 'slider',
            'js_options' => array(
                'min'   => 0,
                'max'   => 10.05,
                'step'  => .1,
            ),
        ),
        // Summary
        array(
            'name' => esc_html__( 'Summary', 'the-rex'),
            'id'   => "{$prefix}summary",
            'type' => 'textarea',
            'cols' => 20,
            'rows' => 4,
        ),
        
        // Final average
        array(
            'name'  => esc_html__('Final Average Score','the-rex'),
            'id'    => "{$prefix}final_score",
            'type'  => 'text',
        ),
        array(
            'name' => esc_html__( 'User Rating', 'the-rex'),
            'id' => "{$prefix}user_rating",
            'type' => 'checkbox',
            'desc' => esc_html__( 'Enable User Rating On This Post', 'the-rex'),
            'std'  => 0,
        ),
        array(
			'id' => "{$prefix}review_box_position",
            'name' => esc_html__( 'Review Box Position', 'the-rex'),
			'desc' => esc_html__('Setup review post position [left-content, right-content, above-content, below-content]', 'the-rex'),
            'type' => 'select', 
			'options'  => array(
        					'left' => esc_html__( 'Left', 'the-rex'),
        					'right' => esc_html__( 'Right ', 'the-rex'),
                            'above' => esc_html__( 'Above', 'the-rex'),
                            'below' => esc_html__( 'Below', 'the-rex'),
    				    ),
			// Select multiple values, optional. Default is false.
			'multiple'    => false,
			'std'         => 'left',
		),

    )
);
/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
if ( ! function_exists( 'bk_register_meta_boxes' ) ) {
    function bk_register_meta_boxes() {
    	// Make sure there's no errors when the plugin is deactivated or during upgrade
    	if ( !class_exists( 'RW_Meta_Box' ) )
    		return;
    
    	global $meta_boxes;
    	foreach ( $meta_boxes as $meta_box )
    	{
    		new RW_Meta_Box( $meta_box );
    	}
    }
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'bk_register_meta_boxes' );
