<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Listings_Category_Banner extends Elementor\Widget_Base {

	public function get_name() {
        return 'cityo_listings_category_banner';
    }

	public function get_title() {
        return esc_html__( 'Apus Listings Category Banner', 'cityo' );
    }
    
	public function get_categories() {
        return [ 'cityo-listings-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Listings', 'cityo' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your Title here', 'cityo' ),
            ]
        );

        $this->add_control(
            'slug',
            [
                'label' => esc_html__( 'Category Slug', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your Category Slug here', 'cityo' ),
            ]
        );

        

        $this->add_control(
            'show_nb_listings',
            [
                'label' => esc_html__( 'Show Number Listings', 'cityo' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'cityo' ),
                'label_off' => esc_html__( 'Show', 'cityo' ),
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout Type', 'cityo' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'box-banner1' => esc_html__('Layout 1', 'cityo'),
                    'box-banner2' => esc_html__('Layout 2', 'cityo'),
                    'box-banner3' => esc_html__('Layout 3', 'cityo'),
                    'box-banner4' => esc_html__('Layout 4', 'cityo'),
                    'box-banner5' => esc_html__('Layout 5', 'cityo'),
                ),
                'default' => 'box-banner1'
            ]
        );

        $this->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Category Image', 'cityo' ),
                'type' => Elementor\Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Image Here', 'cityo' ),
                'condition' => [
                    'layout_type' => array('box-banner1', 'box-banner2', 'box-banner4', 'box-banner5'),
                ],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Category Icon', 'cityo' ),
                'type' => Elementor\Controls_Manager::ICON,
                'condition' => [
                    'layout_type' => array('box-banner2', 'box-banner3'),
                ],
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'cityo' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'cityo' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Style', 'cityo' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_hover_color',
            [
                'label' => esc_html__( 'Background Hover Color', 'cityo' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .box-banner2::before' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'layout_type' => 'box-banner2'
                ],
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        if ( empty($slug) ) {
            return;
        }
        ?>
        <div class="widget-listing-category-banner <?php echo esc_attr($el_class); ?>">
    
            <?php
            $term = get_term_by( 'slug', $slug, 'job_listing_category' );
            if ($term) {
            ?>
                <?php 
                    $color_value = get_term_meta( $term->term_id, 'apus_color', true );
                    $style = '';
                    if ( !empty($color_value) ) {
                        $style = ' style="color: '.$color_value.';"';
                    }
                ?>
                <a href="<?php echo esc_url(get_term_link( $term, 'job_listing_category' )); ?>" class="<?php echo esc_attr($layout_type); ?>">
                    <div class="category-banner-inner">
                        <?php
                        if ( !empty($img_src['id']) && $layout_type !== 'box-banner3' ) {
                        ?>
                            <div class="category-image">
                                <?php echo cityo_get_attachment_thumbnail($img_src['id'], 'full'); ?>
                            </div>
                        <?php } ?>
                        <div class="content-inner">
                            <div class="clearfix">
                                <?php if ( !empty($icon) && ($layout_type == 'box-banner2' || $layout_type == 'box-banner3') ) { ?>
                                    <div class="category-icon" <?php echo esc_attr($layout_type == 'box-banner2') ? $style:''; ?>><i class="<?php echo esc_attr($icon); ?>"></i></div>
                                <?php } ?>
                                <div class="inner-content">
                                    <?php if ( !empty($title) ) { ?>
                                        <h4 class="title">
                                            <?php echo trim($title); ?>
                                        </h4>
                                    <?php } ?>

                                    <?php if ( $show_nb_listings ) {
                                            $args = array(
                                                'tax_query' => array(array(
                                                        'taxonomy'      => 'job_listing_category',
                                                        'field'         => 'slug',
                                                        'terms'         => $term->slug,
                                                        'operator'      => 'IN'
                                                )),
                                                'posts_per_page' => -1,
                                                'post_status' => 'publish'
                                            );
                                            $query = new WP_Query( $args );
                                            $count = $query->post_count;
                                    ?>
                                        <span class="number"><?php echo sprintf(_n('%d Listing', '%d Listings', $count, 'cityo'), $count); ?></span>
                                    <?php } ?>
                                </div>  
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
        <?php

    }

}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Listings_Category_Banner );