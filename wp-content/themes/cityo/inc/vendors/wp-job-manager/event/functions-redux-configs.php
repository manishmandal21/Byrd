<?php

function cityo_wp_job_manager_place_redux_config_detail($sections, $sidebars, $columns) {
    $layout_options = array();
    $default_options = cityo_get_listing_layout_style();
    foreach ($default_options as $key => $value) {
        $layout_options[$key] = array(
            'title' => $value['title'],
            'alt' => $value['title'],
            'img' => $value['img'],
        );
    }
    $sections[] = array(
        'title' => esc_html__('Listing Detail', 'cityo'),
        'fields' => array(
            array(
                'id' => 'listing_single_layout_version',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Layout Style', 'cityo'),
                'options' => $layout_options,
                'default' => 'v1',
            ),
            array(
                'id'        => 'listing_single_sort_content',
                'type'      => 'sorter',
                'title'     => esc_html__( 'Listing Content', 'cityo' ),
                'subtitle'  => esc_html__( 'Please drag and arrange the block', 'cityo' ),
                'options'   => array(
                    'enabled' => cityo_get_default_blocks_content(),
                    'disabled' => array()
                )
            ),
            array(
                'id'        => 'listing_single_sort_sidebar',
                'type'      => 'sorter',
                'title'     => esc_html__( 'Listing Sidebar', 'cityo' ),
                'subtitle'  => esc_html__( 'Please drag and arrange the block', 'cityo' ),
                'options'   => array(
                    'enabled' => cityo_get_default_blocks_sidebar_content(),
                    'disabled' => array()
                )
            ),
            array(
                'id' => 'show_listing_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'cityo'),
                'default' => 1
            )

        )
    );
    return $sections;
}
add_filter( 'cityo_redux_framwork_configs', 'cityo_wp_job_manager_place_redux_config_detail', 4, 3 );

function cityo_wp_job_manager_place_redux_config($sections, $sidebars, $columns) {

    $sections[] = array(
        'title' => esc_html__('Listing Filter Settings', 'cityo'),
        'fields' => array(
            
            array(
                'id' => 'listing_filter_show_categories',
                'type' => 'switch',
                'title' => esc_html__('Show categories field', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_filter_show_types',
                'type' => 'switch',
                'title' => esc_html__('Show types field', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_filter_show_regions',
                'type' => 'switch',
                'title' => esc_html__('Show regions field', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_filter_show_location',
                'type' => 'switch',
                'title' => esc_html__('Show location field', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_filter_show_distance',
                'type' => 'switch',
                'title' => esc_html__('Show distance field', 'cityo'),
                'default' => 1,
                'required' => array('listing_filter_show_location', '=', 1),
            ),
            array(
                'id' => 'listing_filter_distance_default',
                'type' => 'text',
                'title' => esc_html__('Distance default', 'cityo'),
                'default' => 50,
                'required' => array('listing_filter_show_location', '=', 1),
            ),
            array(
                'id' => 'listing_filter_distance_unit',
                'type' => 'select',
                'title' => esc_html__('Distance Unit', 'cityo'),
                'options' => array(
                    'km' => esc_html__('Kilometre', 'cityo'),
                    'miles' => esc_html__('Miles', 'cityo'),
                ),
                'default' => 'km',
            ),
            array(
                'id' => 'listing_filter_show_date',
                'type' => 'switch',
                'title' => esc_html__('Show date field', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_filter_show_amenities',
                'type' => 'switch',
                'title' => esc_html__('Show amenities field', 'cityo'),
                'default' => 1,
            ),
        )
    );
    return $sections;
}
add_filter( 'cityo_redux_framwork_configs', 'cityo_wp_job_manager_place_redux_config', 5, 3 );