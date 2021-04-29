<?php

// Shop Archive settings
function cityo_woo_redux_config($sections, $sidebars, $columns) {
    
    // Woocommerce
    $sections[] = array(
        'icon' => 'el el-shopping-cart',
        'title' => esc_html__('Woocommerce', 'cityo'),
        'fields' => array(
            array(
                'id' => 'show_product_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'cityo'),
                'default' => 1
            ),
            array (
                'title' => esc_html__('Breadcrumbs Background Color', 'cityo'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'cityo').'</em>',
                'id' => 'woo_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'woo_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'cityo'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'cityo'),
            ),
        )
    );
    // Archive settings
    $sections[] = array(
        'subsection' => true,
        'title' => esc_html__('Product Archives', 'cityo'),
        'fields' => array(
            array(
                'id' => 'product_archive_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Archive Product Layout', 'cityo'),
                'subtitle' => esc_html__('Select the layout you want to apply on your archive product page.', 'cityo'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Content', 'cityo'),
                        'alt' => esc_html__('Main Content', 'cityo'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left Sidebar - Main Content', 'cityo'),
                        'alt' => esc_html__('Left Sidebar - Main Content', 'cityo'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main Content - Right Sidebar', 'cityo'),
                        'alt' => esc_html__('Main Content - Right Sidebar', 'cityo'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'left-main'
            ),
            array(
                'id' => 'product_archive_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'cityo'),
                'default' => false
            ),
            array(
                'id' => 'product_archive_filter_sidebar',
                'type' => 'select',
                'title' => esc_html__('Filter Sidebar', 'cityo'),
                'subtitle' => esc_html__('Show filter sidebar when shop only show Main Content.', 'cityo'),
                'options' => array(
                    'none' => esc_html__('Do not show', 'cityo'),
                    'right' => esc_html__('Right', 'cityo'),
                    'top' => esc_html__('Categories + Sidebar in Top', 'cityo'),
                ),
                'required' => array('product_archive_layout', '=', 'main'),
                'default' => 'none'
            ),
            array(
                'id' => 'product_archive_left_sidebar',
                'type' => 'select',
                'title' => esc_html__('Archive Left Sidebar', 'cityo'),
                'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'cityo'),
                'options' => $sidebars
            ),
            array(
                'id' => 'product_archive_right_sidebar',
                'type' => 'select',
                'title' => esc_html__('Archive Right Sidebar', 'cityo'),
                'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'cityo'),
                'options' => $sidebars
            ),
            array(
                'id' => 'product_display_mode',
                'type' => 'select',
                'title' => esc_html__('Display Mode', 'cityo'),
                'subtitle' => esc_html__('Choose a default layout archive product.', 'cityo'),
                'options' => array('grid' => esc_html__('Grid', 'cityo'), 'list' => esc_html__('List', 'cityo')),
                'default' => 'grid'
            ),
            array(
                'id' => 'number_products_per_page',
                'type' => 'text',
                'title' => esc_html__('Number of Products Per Page', 'cityo'),
                'default' => 12,
                'min' => '1',
                'step' => '1',
                'max' => '100',
                'type' => 'slider'
            ),
            array(
                'id' => 'product_columns',
                'type' => 'select',
                'title' => esc_html__('Product Columns', 'cityo'),
                'options' => $columns,
                'default' => 4
            ),
            array(
                'id' => 'show_quickview',
                'type' => 'switch',
                'title' => esc_html__('Show Quick View', 'cityo'),
                'default' => 1
            ),
            array(
                'id' => 'show_swap_image',
                'type' => 'switch',
                'title' => esc_html__('Show Second Image (Hover)', 'cityo'),
                'default' => 1
            ),
        )
    );
    // Product Page
    $sections[] = array(
        'subsection' => true,
        'title' => esc_html__('Single Product', 'cityo'),
        'fields' => array(
            array(
                'id' => 'product_single_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Single Product Layout', 'cityo'),
                'subtitle' => esc_html__('Select the layout you want to apply on your Single Product Page.', 'cityo'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Only', 'cityo'),
                        'alt' => esc_html__('Main Only', 'cityo'),
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
                'default' => 'left-main'
            ),
            array(
                'id' => 'product_single_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'cityo'),
                'default' => false
            ),
            array(
                'id' => 'product_single_left_sidebar',
                'type' => 'select',
                'title' => esc_html__('Single Product Left Sidebar', 'cityo'),
                'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'cityo'),
                'options' => $sidebars
            ),
            array(
                'id' => 'product_single_right_sidebar',
                'type' => 'select',
                'title' => esc_html__('Single Product Right Sidebar', 'cityo'),
                'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'cityo'),
                'options' => $sidebars
            ),
            array(
                'id' => 'show_product_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'cityo'),
                'default' => 1
            ),
            array(
                'id' => 'show_product_review_tab',
                'type' => 'switch',
                'title' => esc_html__('Show Product Review Tab', 'cityo'),
                'default' => 1
            ),
            array(
                'id' => 'show_product_releated',
                'type' => 'switch',
                'title' => esc_html__('Show Products Releated', 'cityo'),
                'default' => 1
            ),
            array(
                'id' => 'show_product_upsells',
                'type' => 'switch',
                'title' => esc_html__('Show Products upsells', 'cityo'),
                'default' => 1
            ),
            array(
                'id' => 'number_product_releated',
                'title' => esc_html__('Number of related/upsells products to show', 'cityo'),
                'default' => 4,
                'min' => '1',
                'step' => '1',
                'max' => '20',
                'type' => 'slider'
            ),
            array(
                'id' => 'releated_product_columns',
                'type' => 'select',
                'title' => esc_html__('Releated Products Columns', 'cityo'),
                'options' => $columns,
                'default' => 4
            ),

        )
    );
    
    return $sections;
}
add_filter( 'cityo_redux_framwork_configs', 'cityo_woo_redux_config', 1, 3 );