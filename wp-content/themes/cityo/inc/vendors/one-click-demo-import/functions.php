<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function cityo_ocdi_import_files() {
    return apply_filters( 'cityo_ocdi_files_args', array(
        array(
            'import_file_name'             => 'Cityo Place',
            'categories'                   => array( 'Place' ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/place/dummy-data.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/place/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/place/redux-options.json',
                    'option_name' => 'cityo_theme_options',
                ),
            ),
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'screenshot.png',
            'import_notice'                => esc_html__( 'Import process may take 5-10 minutes. If you facing any issues please contact our support.', 'cityo' ),
            'preview_url'                  => 'http://demoapus-wp.com/cityo/place',
        ),
        array(
            'import_file_name'             => 'Cityo Car',
            'categories'                   => array( 'Car' ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/car/dummy-data.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/car/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/car/redux-options.json',
                    'option_name' => 'cityo_theme_options',
                ),
            ),
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/vendors/one-click-demo-import/car/cityo-car.png',
            'import_notice'                => esc_html__( 'Import process may take 5-10 minutes. If you facing any issues please contact our support.', 'cityo' ),
            'preview_url'                  => 'http://demoapus-wp.com/cityo/car',
        ),
        array(
            'import_file_name'             => 'Cityo Estate',
            'categories'                   => array( 'Estate' ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/estate/dummy-data.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/estate/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/estate/redux-options.json',
                    'option_name' => 'cityo_theme_options',
                ),
            ),
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/vendors/one-click-demo-import/estate/cityo-estate.png',
            'import_notice'                => esc_html__( 'Import process may take 5-10 minutes. If you facing any issues please contact our support.', 'cityo' ),
            'preview_url'                  => 'http://demoapus-wp.com/cityo/estate',
        ),
        array(
            'import_file_name'             => 'Cityo Event',
            'categories'                   => array( 'Event' ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/event/dummy-data.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/event/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/event/redux-options.json',
                    'option_name' => 'cityo_theme_options',
                ),
            ),
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/vendors/one-click-demo-import/event/cityo-event.png',
            'import_notice'                => esc_html__( 'Import process may take 5-10 minutes. If you facing any issues please contact our support.', 'cityo' ),
            'preview_url'                  => 'http://demoapus-wp.com/cityo/event',
        ),
    ) );
}
add_filter( 'pt-ocdi/import_files', 'cityo_ocdi_import_files' );

function cityo_ocdi_after_import_setup( $selected_import ) {
    // Assign menus to their locations.
    $main_menu       = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $my_account_owner      = get_term_by( 'name', 'My Account Owner', 'nav_menu' );
    $my_account   = get_term_by( 'name', 'My Account', 'nav_menu' );
    $listing_categories        = get_term_by( 'name', 'Listing Categories', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary'      => $main_menu->term_id,
            'myaccount-owner-menu'     => $my_account_owner->term_id,
            'myaccount-menu'  => $my_account->term_id,
            'suggestions_search'       => $listing_categories->term_id,
        )
    );

    // Assign front page and posts page (blog page) and other WooCommerce pages
    
    $blog_page_id       = get_page_by_title( 'Blog' );
    $shop_page_id       = get_page_by_title( 'Shop' );
    $cart_page_id       = get_page_by_title( 'Cart' );
    $checkout_page_id   = get_page_by_title( 'Checkout' );
    $myaccount_page_id  = get_page_by_title( 'My Account' );

    $submit_listing_page_id  = get_page_by_title( 'Submit Listings' );
    $my_listing_page_id  = get_page_by_title( 'My Listings' );
    $favorite_page_id  = get_page_by_title( 'Favorite' );

    update_option( 'show_on_front', 'page' );
    
    update_option( 'page_for_posts', $blog_page_id->ID );
    update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
    update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
    update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
    update_option( 'job_manager_submit_job_form_page_id', $submit_listing_page_id->ID );
    update_option( 'job_manager_job_dashboard_page_id', $my_listing_page_id->ID );
    update_option( 'job_manager_bookmark_page_id', $favorite_page_id->ID );


    update_option( 'job_manager_per_page', 9 );
    update_option( 'job_manager_enable_categories', 1 );
    
    update_option( 'job_manager_user_requires_account', 1 );
    update_option( 'job_manager_enable_registration', 1 );
    update_option( 'job_manager_generate_username_from_email', 1 );

    // elementor
    update_option( 'elementor_container_width', 1160 );
    update_option( 'elementor_global_image_lightbox', 0 );

    // Enable Registration on "My Account" page
    update_option( 'woocommerce_enable_myaccount_registration', 'yes' );

    switch ($selected_import['import_file_name']) {
        case 'Cityo Place':
            $front_page_id = get_page_by_title( 'Home 1' );
            update_option( 'page_on_front', $front_page_id->ID );

            update_option( 'job_manager_enable_types', 0 );

            $file = trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/place/settings.json';
            if ( file_exists($file) ) {
                cityo_ocdi_import_settings($file);
            }
            break;
        case 'Cityo Car':
            $front_page_id = get_page_by_title( 'Home Car' );
            update_option( 'page_on_front', $front_page_id->ID );

            update_option( 'job_manager_enable_types', 1 );

            $file = trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/car/settings.json';
            if ( file_exists($file) ) {
                cityo_ocdi_import_settings($file);
            }
            break;
        case 'Cityo Estate':
            $front_page_id = get_page_by_title( 'Home Real Estate' );
            update_option( 'page_on_front', $front_page_id->ID );

            update_option( 'job_manager_enable_types', 1 );

            $file = trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/estate/settings.json';
            if ( file_exists($file) ) {
                cityo_ocdi_import_settings($file);
            }
            break;
        case 'Cityo Event':
            $front_page_id = get_page_by_title( 'Home Event' );
            update_option( 'page_on_front', $front_page_id->ID );

            update_option( 'job_manager_enable_types', 0 );

            $file = trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/event/settings.json';
            if ( file_exists($file) ) {
                cityo_ocdi_import_settings($file);
            }
            break;
    }
}
add_action( 'pt-ocdi/after_import', 'cityo_ocdi_after_import_setup' );

function cityo_ocdi_import_settings($file) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
    require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
    $file_obj = new WP_Filesystem_Direct( array() );
    $datas = $file_obj->get_contents($file);
    $datas = json_decode( $datas, true );

    if ( count( array_filter( $datas ) ) < 1 ) {
        return;
    }

    if ( !empty($datas['page_options']) ) {
        cityo_ocdi_import_page_options($datas['page_options']);
    }
    if ( !empty($datas['metadata']) ) {
        cityo_ocdi_import_some_metadatas($datas['metadata']);
    }
}

function cityo_ocdi_import_page_options($datas) {
    if ( $datas ) {
        foreach ($datas as $option_name => $page_id) {
            update_option( $option_name, $page_id);
        }
    }
}

function cityo_ocdi_import_some_metadatas($datas) {
    if ( $datas ) {
        foreach ($datas as $slug => $post_types) {
            if ( $post_types ) {
                foreach ($post_types as $post_type => $metas) {
                    if ( $metas ) {
                        $args = array(
                            'name'        => $slug,
                            'post_type'   => $post_type,
                            'post_status' => 'publish',
                            'numberposts' => 1
                        );
                        $posts = get_posts($args);
                        if ( $posts && isset($posts[0]) ) {
                            foreach ($metas as $meta) {
                                update_post_meta( $posts[0]->ID, $meta['meta_key'], $meta['meta_value'] );
                                if ( $meta['meta_key'] == '_mc4wp_settings' ) {
                                    update_option( 'mc4wp_default_form_id', $posts[0]->ID );
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

function cityo_ocdi_before_widgets_import() {

    $sidebars_widgets = get_option('sidebars_widgets');
    $all_widgets = array();

    array_walk_recursive( $sidebars_widgets, function ($item, $key) use ( &$all_widgets ) {
        if( ! isset( $all_widgets[$key] ) ) {
            $all_widgets[$key] = $item;
        } else {
            $all_widgets[] = $item;
        }
    } );

    if( isset( $all_widgets['array_version'] ) ) {
        $array_version = $all_widgets['array_version'];
        unset( $all_widgets['array_version'] );
    }

    $new_sidebars_widgets = array_fill_keys( array_keys( $sidebars_widgets ), array() );

    $new_sidebars_widgets['wp_inactive_widgets'] = $all_widgets;
    if( isset( $array_version ) ) {
        $new_sidebars_widgets['array_version'] = $array_version;
    }

    update_option( 'sidebars_widgets', $new_sidebars_widgets );
}
add_action( 'pt-ocdi/before_widgets_import', 'cityo_ocdi_before_widgets_import' );