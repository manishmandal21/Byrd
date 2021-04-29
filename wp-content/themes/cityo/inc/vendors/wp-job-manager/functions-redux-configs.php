<?php

function cityo_wp_job_manager_redux_config_general($sections, $sidebars, $columns) {
    $general_fields = array(
        array(
            'id' => 'listing_general_region_settings',
            'icon' => true,
            'type' => 'info',
            'raw' => '<h3> '.esc_html__('Region Settings', 'cityo').'</h3>',
        ),
        array(
            'id' => 'submit_listing_region_nb_fields',
            'type' => 'select',
            'title' => esc_html__('Number Fields', 'cityo'),
            'options' => array(
                '1' => esc_html__('1 Field', 'cityo'),
                '2' => esc_html__('2 Fields', 'cityo'),
                '3' => esc_html__('3 Fields', 'cityo'),
                '4' => esc_html__('4 Fields', 'cityo'),
            ),
            'description' => esc_html__('You can set 4 fields for regions like: Country, State, City, District', 'cityo'),
            'default' => 1
        ),
        array(
            'id' => 'submit_listing_region_1_field_label',
            'type' => 'text',
            'title' => esc_html__('First Field Label', 'cityo'),
            'default' => '',
            'description' => esc_html__('First region field label', 'cityo'),
            'required' => array('submit_listing_region_nb_fields', '=', array('1', '2', '3', '4')),
        ),
        array(
            'id' => 'submit_listing_region_2_field_label',
            'type' => 'text',
            'title' => esc_html__('Second Field Label', 'cityo'),
            'default' => '',
            'description' => esc_html__('Second region field label', 'cityo'),
            'required' => array('submit_listing_region_nb_fields', '=', array('2', '3', '4')),
        ),
        array(
            'id' => 'submit_listing_region_3_field_label',
            'type' => 'text',
            'title' => esc_html__('Third Field Label', 'cityo'),
            'default' => '',
            'description' => esc_html__('Third region field label', 'cityo'),
            'required' => array('submit_listing_region_nb_fields', '=', array('3', '4')),
        ),
        array(
            'id' => 'submit_listing_region_4_field_label',
            'type' => 'text',
            'title' => esc_html__('Fourth Field Label', 'cityo'),
            'default' => '',
            'description' => esc_html__('Fourth region field label', 'cityo'),
            'required' => array('submit_listing_region_nb_fields', '=', array('4')),
        ),
        array(
            'id' => 'listing_general_measurement_settings',
            'icon' => true,
            'type' => 'info',
            'raw' => '<h3> '.esc_html__('Measurement Settings', 'cityo').'</h3>',
        ),
        array(
            'id' => 'listing_distance_unit',
            'type' => 'text',
            'title' => esc_html__('Distance Unit', 'cityo'),
            'default' => 'ft',
        ),
    );
    $general_fields = apply_filters('cityo_wp_job_manager_redux_config_general', $general_fields, $sections, $sidebars, $columns);
    $sections[] = array(
        'title' => esc_html__('Listing General', 'cityo'),
        'fields' => $general_fields
    );

    return $sections;
}
add_filter( 'cityo_redux_framwork_configs', 'cityo_wp_job_manager_redux_config_general', 2, 3 );

function cityo_wp_job_manager_redux_config_archive($sections, $sidebars, $columns) {
    
    // Archive Listings settings
    $sections[] = array(
        'title' => esc_html__('Listing Archives', 'cityo'),
        'fields' => array(
            array(
                'id' => 'listing_archive_layout_version',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Layout Style', 'cityo'),
                'options' => array(
                    'half-map-v1' => array(
                        'title' => esc_html__('Half Map - Layout 1', 'cityo'),
                        'img' => get_template_directory_uri() . '/images/archive-layouts/half-map-v1.png'
                    ),
                    'half-map-v2' => array(
                        'title' => esc_html__('Half Map - Layout 2', 'cityo'),
                        'img' => get_template_directory_uri() . '/images/archive-layouts/half-map-v2.png'
                    ),
                    'default' => array(
                        'title' => esc_html__('Box', 'cityo'),
                        'img' => get_template_directory_uri() . '/images/archive-layouts/default.png'
                    ),
                    'default-full' => array(
                        'title' => esc_html__('Fullwidth', 'cityo'),
                        'img' => get_template_directory_uri() . '/images/archive-layouts/default-full.png'
                    ),
                ),
                'default' => 'half-map-v1',
            ),
            array(
                'id' => 'listing_archive_display_mode',
                'type' => 'select',
                'title' => esc_html__('Default Display Mode', 'cityo'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'cityo'),
                    'list' => esc_html__('List', 'cityo'),
                ),
                'default' => 'grid',
            ),
            array(
                'id' => 'listing_columns',
                'type' => 'select',
                'title' => esc_html__('Grid Listing Columns', 'cityo'),
                'options' => $columns,
                'default' => 2,
                'required' => array('listing_archive_display_mode', '=', 'grid'),
            ),
            array(
                'id' => 'listing_filter_sortby_default',
                'type' => 'select',
                'title' => esc_html__('Default Sortby', 'cityo'),
                'options' => array(
                    'default' => esc_html__( 'Default Order', 'cityo' ),
                    'date-desc' => esc_html__( 'Newest First', 'cityo' ),
                    'date-asc' => esc_html__( 'Oldest First', 'cityo' ),
                    'rating-desc' => esc_html__( 'Highest Rating', 'cityo' ),
                    'rating-asc' => esc_html__( 'Lowest Rating', 'cityo' ),
                    'random' => esc_html__( 'Random', 'cityo' ),
                ),
                'default' => 'default'
            ),
            array(
                'id' => 'listing_show_loadmore',
                'type' => 'switch',
                'title' => esc_html__('Show Load More Button ?', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_show_cat_title',
                'type' => 'switch',
                'title' => esc_html__('Show Category Title ?', 'cityo'),
                'default' => 0,
            ),
            array(
                'id' => 'listing_show_cat_description',
                'type' => 'switch',
                'title' => esc_html__('Show Category Description ?', 'cityo'),
                'default' => 0,
            ),
            array(
                'id' => 'sidebar_position',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Sidebar Position', 'cityo').'</h3>',
                'required' => array('listing_archive_layout_version', '=', array('default')),
            ),
            array(
                'id' => 'listing_archive_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Sidebar Layout', 'cityo'),
                'subtitle' => esc_html__('Select a sidebar layout', 'cityo'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Content', 'cityo'),
                        'alt' => esc_html__('Main Content', 'cityo'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'cityo'),
                        'alt' => esc_html__('Left - Main Sidebar', 'cityo'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'cityo'),
                        'alt' => esc_html__('Main - Right Sidebar', 'cityo'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'left-main',
                'required' => array('listing_archive_layout_version', '=', array('default', 'default-full')),
            ),
            array(
                'id' => 'listing_archive_sidebar',
                'type' => 'select',
                'title' => esc_html__('Listings Sidebar', 'cityo'),
                'subtitle' => esc_html__('Choose a sidebar for listings sidebar.', 'cityo'),
                'options' => $sidebars,
                'default' => 'listing-archive-sidebar',
                'required' => array('listing_archive_layout_version', '=', array('default', 'default-full')),
            ),
            array(
                'id' => 'archive_breadcrumbs_settings',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Breadcrumbs Settings', 'cityo').'</h3>',
            ),
            array(
                'id' => 'show_listing_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'cityo'),
                'default' => 1,
                'description' => esc_html__('Breadcrumb is only apply for Listing Archives version (List, Grid)', 'cityo'),
            ),
            array(
                'title' => esc_html__('Breadcrumbs Background Color', 'cityo'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'cityo').'</em>',
                'id' => 'listing_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'listing_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'cityo'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'cityo'),
            ),
            
        )
    );
    return $sections;
}
add_filter( 'cityo_redux_framwork_configs', 'cityo_wp_job_manager_redux_config_archive', 3, 3 );

function cityo_wp_job_manager_redux_config($sections, $sidebars, $columns) {
    
    // review
    $sections[] = array(
        'title' => esc_html__('Listing Review Settings', 'cityo'),
        'fields' => array(
            array(
                'id' => 'listing_review_enable',
                'type' => 'switch',
                'title' => esc_html__('Enable Review', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_review_enable_upload_image',
                'type' => 'switch',
                'title' => esc_html__('Enable Upload Image', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_review_enable_rating',
                'type' => 'switch',
                'title' => esc_html__('Enable Rating', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_review_mode',
                'type' => 'select',
                'title' => esc_html__('Review Mode', 'cityo'),
                'options' => array(
                    '5' => esc_html__('5 Stars', 'cityo'),
                    '10' => esc_html__('10 Stars', 'cityo')
                ),
                'default' => 10,
            ),
            array(
                'id'         => 'listing_review_categories',
                'type'       => 'repeater',
                'title'      => esc_html__( 'Review Categories', 'cityo' ),
                'fields'     => array(
                    array(
                        'id' => 'listing_review_category_title',
                        'type' => 'text',
                        'title' => esc_html__('Title', 'cityo'),
                    ),
                    array(
                        'id' => 'listing_review_category_key',
                        'type' => 'text',
                        'title' => esc_html__('Key', 'cityo'),
                    )
                ),
            ),
            array(
                'id' => 'listing_review_enable_like_review',
                'type' => 'switch',
                'title' => esc_html__('Enable Like Review', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_review_enable_dislike_review',
                'type' => 'switch',
                'title' => esc_html__('Enable DisLike Review', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_review_enable_love_review',
                'type' => 'switch',
                'title' => esc_html__('Enable Love Review', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_review_enable_reply_review',
                'type' => 'switch',
                'title' => esc_html__('Enable Reply Review', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'listing_review_edit_review_title',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Edit Review Settings', 'cityo').'</h3>',
            ),
            array(
                'id' => 'listing_review_enable_user_edit_his_review',
                'type' => 'switch',
                'title' => esc_html__('Allow Registered Users to Edit Comments Indefinitely', 'cityo'),
                'default' => 1,
            )
        )
    );
    // Price Settings
    $sections[] = array(
        'title' => esc_html__('Listing Price Settings', 'cityo'),
        'fields' => array(
            array(
                'id' => 'listing_currency_symbol',
                'type' => 'text',
                'title' => esc_html__('Currency Symbol', 'cityo'),
                'default' => ''
            ),
            array(
                'id' => 'listing_currency_code',
                'type' => 'text',
                'title' => esc_html__('Currency Code', 'cityo'),
                'default' => ''
            ),
            array(
                'id' => 'listing_currency_symbol_after_amount',
                'type' => 'switch',
                'title' => esc_html__('Show Symbol After Amount', 'cityo'),
                'default' => 0,
            ),
            array(
                'id' => 'listing_currency_decimal_places',
                'type' => 'text',
                'title' => esc_html__('Decimal places', 'cityo'),
                'default' => '',
            ),

            array(
                'id' => 'listing_currency_decimal_separator',
                'type' => 'text',
                'title' => esc_html__('Decimal Separator', 'cityo'),
                'default' => ''
            ),
            array(
                'id' => 'listing_currency_thousands_separator',
                'type' => 'text',
                'title' => esc_html__('Thousands Separator', 'cityo'),
                'default' => '',
                'subtitle' => esc_html__('If you need space, enter &nbsp;', 'cityo')
            ),
        )
    );

    

    // sections after listings
    $lsections = apply_filters( 'cityo_redux_config_sections_after_listing', array() );
    if ( !empty($lsections) ) {
        foreach ($lsections as $section) {
            $sections[] = $section;
        }
    }

    // Listing Map Settings
    $sections[] = array(
        'title' => esc_html__('Listing Map Settings', 'cityo'),
        'fields' => array(
            // google map style
            array(
                'id' => 'listing_map_style_type',
                'type' => 'select',
                'title' => esc_html__('Maps Service', 'cityo'),
                'options' => array(
                    'default' => esc_html__('Google Maps', 'cityo'),
                    'mapbox' => esc_html__('MapBox', 'cityo')
                ),
                'default' => 'default'
            ),
            array(
                'id' => 'listing_map_custom_style',
                'type' => 'textarea',
                'title' => esc_html__('Custom Style', 'cityo'),
                'description' => wp_kses(__('<a href="//snazzymaps.com/">Get custom style</a> and paste it below. If there is nothing added, we will fallback to the Google Maps service.', 'cityo'), array('a' => array('href' => array()))),
                'required' => array('listing_map_style_type', '=', 'default'),
            ),
            array(
                'id' => 'listing_mapbox_token',
                'type' => 'text',
                'title' => esc_html__('Mapbox Token', 'cityo'),
                'description' => wp_kses(__('<a href="//www.mapbox.com/help/create-api-access-token/">Get a FREE token</a> and paste it below. If there is nothing added, we will fallback to the Google Maps service.', 'cityo'), array('a' => array('href' => array()))),
                'required' => array('listing_map_style_type', '=', 'mapbox'),
            ),
            array(
                'id' => 'listing_mapbox_style',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('MapBox Style', 'cityo'),
                'description' => esc_html__('Custom map styles works only if you have set a valid Mapbox API token in the field above.', 'cityo'),
                'options' => array(
                    'streets-v11' => array(
                        'alt' => esc_html__('streets', 'cityo'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/streets.png'
                    ),
                    'light-v10' => array(
                        'alt' => esc_html__('light', 'cityo'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/light.png'
                    ),
                    'dark-v10' => array(
                        'alt' => esc_html__('dark', 'cityo'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/dark.png'
                    ),
                    'outdoors-v11' => array(
                        'alt' => esc_html__('outdoors', 'cityo'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/outdoors.png'
                    ),
                    'satellite-v9' => array(
                        'alt' => esc_html__('satellite', 'cityo'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/satellite.png'
                    ),
                ),
                'required' => array('listing_map_style_type', '=', 'mapbox'),
            ),
            array(
                'id' => 'listing_map_latitude',
                'type' => 'text',
                'title' => esc_html__('Default Latitude', 'cityo'),
                'default' => '54.800685'
            ),
            array(
                'id' => 'listing_map_longitude',
                'type' => 'text',
                'title' => esc_html__('Default Longitude', 'cityo'),
                'default' => '-4.130859'
            ),
            array(
                'id' => 'listing_map_geocoder_country',
                'type' => 'select',
                'title' => esc_html__('Geocoder Country', 'cityo'),
                'options' => cityo_all_countries(),
                'default' => ''
            ),
        )
    );

    $sections[] = array(
        'title' => esc_html__('User Profile', 'cityo'),
        'fields' => array(
            array(
                'id' => 'profile_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('General Settings', 'cityo').'</h3>',
            ),
            array(
                'id' => 'profile_background_image',
                'type' => 'media',
                'title' => esc_html__('Profile Background', 'cityo'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'cityo'),
            ),
            array(
                'id' => 'user_profile_show_contact_form',
                'type' => 'switch',
                'title' => esc_html__('Show Contact Form', 'cityo'),
                'default' => 1,
            ),
            array(
                'id' => 'user_profile_listing_number',
                'type' => 'text',
                'title' => esc_html__('Number of Listings Per Page', 'cityo'),
                'default' => 25,
                'min' => '1',
                'step' => '1',
                'max' => '100',
                'type' => 'slider'
            ),
            array(
                'id' => 'user_profile_bookmark_number',
                'type' => 'text',
                'title' => esc_html__('Number of Bookmarks Per Page', 'cityo'),
                'default' => 25,
                'min' => '1',
                'step' => '1',
                'max' => '100',
                'type' => 'slider'
            ),
            array(
                'id' => 'user_profile_reviews_number',
                'type' => 'text',
                'title' => esc_html__('Number of Reviews Per Page', 'cityo'),
                'default' => 25,
                'min' => '1',
                'step' => '1',
                'max' => '100',
                'type' => 'slider'
            ),
            array(
                'id' => 'user_profile_follow_number',
                'type' => 'text',
                'title' => esc_html__('Number of Following/Follower Per Page', 'cityo'),
                'default' => 25,
                'min' => '1',
                'step' => '1',
                'max' => '100',
                'type' => 'slider'
            ),
        )
    );

    // Email Template
    $email_template_fields = apply_filters( 'cityo_email_template_fields', array());
    if ( !empty($email_template_fields) ) {
        $sections[] = array(
            'title' => esc_html__('Email Templates', 'cityo'),
            'fields' => $email_template_fields
        );
    }
    
    $sections[] = array(
        'title' => esc_html__('Image Sizes', 'cityo'),
        'fields' => array(
            array(
                'id' => 'card_grid_image_title',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Card grid image', 'cityo').'</h3>',
            ),
            array(
                'id' => 'image_size_card_grid_width',
                'type' => 'text',
                'title' => esc_html__('Card grid image width', 'cityo'),
                'default' => '350',
            ),
            array(
                'id' => 'image_size_card_grid_height',
                'type' => 'text',
                'title' => esc_html__('Card grid image height', 'cityo'),
                'default' => '200',
            ),
            array(
                'id' => 'card_list_image_title',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Card list image', 'cityo').'</h3>',
            ),
            array(
                'id' => 'image_size_card_list_width',
                'type' => 'text',
                'title' => esc_html__('Card list image width', 'cityo'),
                'default' => '340',
            ),
            array(
                'id' => 'image_size_card_list_height',
                'type' => 'text',
                'title' => esc_html__('Card list image height', 'cityo'),
                'default' => '260',
            ),
            array(
                'id' => 'thumb_small_image_title',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Thumb small image', 'cityo').'</h3>',
            ),
            array(
                'id' => 'image_size_thumb_small_width',
                'type' => 'text',
                'title' => esc_html__('Thumb small image width', 'cityo'),
                'default' => '100',
            ),
            array(
                'id' => 'image_size_thumb_small_height',
                'type' => 'text',
                'title' => esc_html__('Thumb small image height', 'cityo'),
                'default' => '100',
            ),
            array(
                'id' => 'gallery_image_title',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Listing Gallery image', 'cityo').'</h3>',
            ),
            array(
                'id' => 'image_size_gallery_width',
                'type' => 'text',
                'title' => esc_html__('Listing gallery image width', 'cityo'),
                'default' => '480',
            ),
            array(
                'id' => 'image_size_gallery_height',
                'type' => 'text',
                'title' => esc_html__('Listing gallery image height', 'cityo'),
                'default' => '550',
            ),

            array(
                'id' => 'full_image_title',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Listing Full image', 'cityo').'</h3>',
            ),
            array(
                'id' => 'image_size_full_width',
                'type' => 'text',
                'title' => esc_html__('Listing full image width', 'cityo'),
                'default' => '1920',
            ),
            array(
                'id' => 'image_size_full_height',
                'type' => 'text',
                'title' => esc_html__('Listing full image height', 'cityo'),
                'default' => '550',
            ),
        )
    );

    return $sections;
}
add_filter( 'cityo_redux_framwork_configs', 'cityo_wp_job_manager_redux_config', 10, 3 );