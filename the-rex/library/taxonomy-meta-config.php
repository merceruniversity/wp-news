<?php
/**
 * Registering meta sections for taxonomies
 *
 * All the definitions of meta sections are listed below with comments, please read them carefully.
 * Note that each validation method of the Validation Class MUST return value.
 *
 * You also should read the changelog to know what has been changed
 *
 */

// Hook to 'admin_init' to make sure the class is loaded before
// (in case using the class in another plugin)
add_action( 'admin_init', 'tn_register_taxonomy_meta_boxes' );

/**
 * Register meta boxes
 *
 * @return void
 */
function tn_register_taxonomy_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Taxonomy_Meta' ) )
		return;
    global $tn_option;
        if ( isset($tn_option) && isset($tn_option['tn-primary-color'])) {
            $primary_color = $tn_option['tn-primary-color'];
        }else {
            $primary_color = '';
        }
	$meta_sections = array();

	// First meta section
	$meta_sections[] = array(
		'title'      => esc_html__('BK Category / Tag Options','the-rex'),             // section title
		'taxonomies' => array('category', 'post_tag'), // list of taxonomies. Default is array('category', 'post_tag'). Optional
		'id'         => 'bk_cat_opt',                 // ID of each section, will be the option name

		'fields' => array(                             // List of meta fields
			// SELECT
			array(
				'name'    => esc_html__('Category / Tag layouts','the-rex'),
				'id'      => 'cat_layout',
				'type'    => 'select',
				'options' => array(
                                'global' => esc_html__('Global Setting', 'the-rex'),
                                'classic-blog'=>esc_html__('Classic Blog', 'the-rex'), 
                                'large-blog'=>esc_html__('Large Blog with Sidebar', 'the-rex'),
                                'masonry'=>esc_html__('Masonry with Sidebar', 'the-rex'),
                                'masonry-nosb'=>esc_html__('Masonry no Sidebar', 'the-rex'),
                                'square-grid-3'=>esc_html__('Square Grid no Sidebar', 'the-rex'),
                                'square-grid-2'=>esc_html__('Square Grid with Sidebar', 'the-rex'),
                            ),
                'std' => 'global',
                'desc' => esc_html__('Global setting option is set in Theme Option panel','the-rex')
			),
            // CHECKBOX
			array(
				'name' => esc_html__('Display featured slider','the-rex'),
                'desc' => esc_html__('This option will be not effected on Tag (Archive) Page','the-rex'),
				'id'   => 'cat_feat',
				'type' => 'checkbox',
			),
            // SELECT SIDEBAR
    		array(
    			'name'      => esc_html__('Select a sidebar for this category page','the-rex'),
    			'id'        => 'sb_category',
    			'type'      => 'sidebarselect',
                'std'       => 'global',
                'desc'      => esc_html__('Global setting option is set in Theme Option panel','the-rex')
    		),
		),
	);

	foreach ( $meta_sections as $meta_section )
	{
		new RW_Taxonomy_Meta( $meta_section );
	}
}
