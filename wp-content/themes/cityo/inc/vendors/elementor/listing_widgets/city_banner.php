<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Listings_City_Banner extends Elementor\Widget_Base {

	public function get_name() {
        return 'cityo_listings_city_banner';
    }

	public function get_title() {
        return esc_html__( 'Apus Listings City Banner', 'cityo' );
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
                'label' => esc_html__( 'City Slug', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your City Slug here', 'cityo' ),
            ]
        );

        $this->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'City Image', 'cityo' ),
                'type' => Elementor\Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Image Here', 'cityo' ),
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
            'style',
            [
                'label' => esc_html__( 'Style', 'cityo' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'box-banner1' => esc_html__('Style 1', 'cityo'),
                    'box-banner2' => esc_html__('Style 2', 'cityo'),
                    'box-banner5' => esc_html__('Style 3', 'cityo')
                ),
                'default' => 'box-banner1'
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

    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        if ( empty($slug) ) {
            return;
        }
        ?>
        <div class="widget-listing-city-banner <?php echo esc_attr($el_class); ?>">
    
            <?php
            $term = get_term_by( 'slug', $slug, 'job_listing_region' );
            if ($term) {
            ?>
                <a class="<?php echo esc_attr($style); ?>" href="<?php echo esc_url(get_term_link( $term, 'job_listing_region' )); ?>">
                    <div class="city-banner-inner">
                        <?php
                        if ( !empty($img_src['id']) ) {
                        ?>
                            <div class="city-image">
                                <?php echo cityo_get_attachment_thumbnail($img_src['id'], 'full'); ?>
                            </div>
                        <?php } ?>
                        <div class="content-inner">
                            <div class="clearfix">
                                <?php if ( !empty($icon) ) { ?>
                                    <div class="city-icon">
                                        <i class="<?php echo esc_attr($icon); ?>"></i>
                                    </div>
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
                                                        'taxonomy'      => 'job_listing_region',
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

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Listings_City_Banner );