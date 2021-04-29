<?php

if ( !function_exists( 'cityo_page_metaboxes' ) ) {
	function cityo_page_metaboxes(array $metaboxes) {
		global $wp_registered_sidebars;
        $sidebars = array( '' => esc_html__('Choose a sidebar to display', 'cityo') );

        if ( !empty($wp_registered_sidebars) ) {
            foreach ($wp_registered_sidebars as $sidebar) {
                $sidebars[$sidebar['id']] = $sidebar['name'];
            }
        }
        $headers = array_merge( array('global' => esc_html__( 'Global Setting', 'cityo' )), cityo_get_header_layouts() );
        $footers = array_merge( array('global' => esc_html__( 'Global Setting', 'cityo' )), cityo_get_footer_layouts() );

        $columns = array(
            '' => esc_html__( 'Global Setting', 'cityo' ),
            '1' => esc_html__('1 Column', 'cityo'),
            '2' => esc_html__('2 Columns', 'cityo'),
            '3' => esc_html__('3 Columns', 'cityo'),
            '4' => esc_html__('4 Columns', 'cityo'),
            '6' => esc_html__('6 Columns', 'cityo')
        );

		$prefix = 'apus_page_';

        // Listing Page
        $fields = array(
            array(
                'name' => esc_html__( 'Layout Style', 'cityo' ),
                'id'   => $prefix.'layout_version',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'cityo' ),
                    'half-map-v1' => esc_html__('Half Map - Layout 1', 'cityo'),
                    'half-map-v2' => esc_html__('Half Map - Layout 2', 'cityo'),
                    'default' => esc_html__('Box', 'cityo'),
                    'default-full' => esc_html__('Fullwidth', 'cityo')
                )
            ),
            array(
                'id' => $prefix.'display_mode',
                'type' => 'select',
                'name' => esc_html__('Default Display Mode', 'cityo'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'cityo' ),
                    'grid' => esc_html__('Grid', 'cityo'),
                    'list' => esc_html__('List', 'cityo'),
                )
            ),
            array(
                'id' => $prefix.'listing_columns',
                'type' => 'select',
                'name' => esc_html__('Grid Listing Columns', 'cityo'),
                'options' => $columns,
            ),
            array(
                'id' => $prefix.'sortby_default',
                'type' => 'select',
                'name' => esc_html__('Default Sortby', 'cityo'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'cityo' ),
                    'default' => esc_html__( 'Default Order', 'cityo' ),
                    'date-desc' => esc_html__( 'Newest First', 'cityo' ),
                    'date-asc' => esc_html__( 'Oldest First', 'cityo' ),
                    'rating-desc' => esc_html__( 'Highest Rating', 'cityo' ),
                    'rating-asc' => esc_html__( 'Lowest Rating', 'cityo' ),
                    'random' => esc_html__( 'Random', 'cityo' ),
                ),
            ),
        );
        
        $metaboxes[$prefix . 'listing_setting'] = array(
            'id'                        => $prefix . 'listing_setting',
            'title'                     => esc_html__( 'Listings Settings', 'cityo' ),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );

	    $fields = array(
			array(
				'name' => esc_html__( 'Select Layout', 'cityo' ),
				'id'   => $prefix.'layout',
				'type' => 'select',
				'options' => array(
					'main' => esc_html__('Main Content Only', 'cityo'),
					'left-main' => esc_html__('Left Sidebar - Main Content', 'cityo'),
					'main-right' => esc_html__('Main Content - Right Sidebar', 'cityo'),
				)
			),
			array(
                'id' => $prefix.'fullwidth',
                'type' => 'select',
                'name' => esc_html__('Is Full Width?', 'cityo'),
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__('No', 'cityo'),
                    'yes' => esc_html__('Yes', 'cityo')
                )
            ),
            array(
                'id' => $prefix.'sidebar',
                'type' => 'select',
                'name' => esc_html__('Sidebar', 'cityo'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'show_breadcrumb',
                'type' => 'select',
                'name' => esc_html__('Show Breadcrumb?', 'cityo'),
                'options' => array(
                    'no' => esc_html__('No', 'cityo'),
                    'yes' => esc_html__('Yes', 'cityo')
                ),
                'default' => 'yes',
            ),
            array(
                'id' => $prefix.'description',
                'type' => 'text',
                'name' => esc_html__('Description for Breadcrumb', 'cityo'),
            ),
            array(
                'id' => $prefix.'breadcrumb_color',
                'type' => 'colorpicker',
                'name' => esc_html__('Breadcrumb Background Color', 'cityo')
            ),
            array(
                'id' => $prefix.'breadcrumb_image',
                'type' => 'file',
                'name' => esc_html__('Breadcrumb Background Image', 'cityo')
            ),
            array(
                'id' => $prefix.'header_type',
                'type' => 'select',
                'name' => esc_html__('Header Layout Type', 'cityo'),
                'description' => esc_html__('Choose a header for your website.', 'cityo'),
                'options' => $headers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'header_transparent',
                'type' => 'select',
                'name' => esc_html__('Header Transparent?', 'cityo'),
                'options' => array(
                    'no' => esc_html__('No', 'cityo'),
                    'yes' => esc_html__('Yes', 'cityo')
                ),
                'default' => 'no',
            ),
            array(
                'id' => $prefix.'footer_type',
                'type' => 'select',
                'name' => esc_html__('Footer Layout Type', 'cityo'),
                'description' => esc_html__('Choose a footer for your website.', 'cityo'),
                'options' => $footers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'extra_class',
                'type' => 'text',
                'name' => esc_html__('Extra Class', 'cityo'),
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'cityo')
            )
    	);
		
	    $metaboxes[$prefix . 'display_setting'] = array(
			'id'                        => $prefix . 'display_setting',
			'title'                     => esc_html__( 'Display Settings', 'cityo' ),
			'object_types'              => array( 'page' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => $fields
		);

        
        
	    return $metaboxes;
	}
}
add_filter( 'cmb2_meta_boxes', 'cityo_page_metaboxes' );

if ( !function_exists( 'cityo_cmb2_style' ) ) {
	function cityo_cmb2_style() {
		wp_enqueue_style( 'cityo-cmb2-style', get_template_directory_uri() . '/inc/vendors/cmb2/assets/style.css', array(), '1.0' );
	}
}
add_action( 'admin_enqueue_scripts', 'cityo_cmb2_style' );