<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Testimonials extends Widget_Base {

	public function get_name() {
        return 'cityo_testimonials';
    }

	public function get_title() {
        return esc_html__( 'Apus Testimonials', 'cityo' );
    }

	public function get_icon() {
        return 'eicon-testimonial';
    }

	public function get_categories() {
        return [ 'cityo-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'cityo' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'content', [
                'label' => esc_html__( 'Content', 'cityo' ),
                'type' => Controls_Manager::TEXTAREA
            ]
        );

        $repeater->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Choose Image', 'cityo' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Brand Image', 'cityo' ),
            ]
        );
        $repeater->add_control(
            'img_rating_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Choose Image Rating', 'cityo' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Rating Image', 'cityo' ),
            ]
        );
        $repeater->add_control(
            'name',
            [
                'label' => esc_html__( 'Name', 'cityo' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'John Doe',
            ]
        );

        $repeater->add_control(
            'job',
            [
                'label' => esc_html__( 'Job', 'cityo' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Designer',
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link To', 'cityo' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'Enter your social link here', 'cityo' ),
                'placeholder' => esc_html__( 'https://your-link.com', 'cityo' ),
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__( 'Testimonials', 'cityo' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );
        
        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'cityo' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'cityo'),
                ),
                'default' => ''
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'cityo' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'cityo' ),
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Tyles', 'cityo' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'cityo' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'cityo' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->add_control(
            'test_title_color',
            [
                'label' => esc_html__( 'Testimonial Title Color', 'cityo' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .name-client a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Testimonial Title Typography', 'cityo' ),
                'name' => 'test_title_typography',
                'selector' => '{{WRAPPER}} .name-client a',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Content Color', 'cityo' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Content Typography', 'cityo' ),
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->add_control(
            'job_color',
            [
                'label' => esc_html__( 'Job Color', 'cityo' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Job Typography', 'cityo' ),
                'name' => 'job_typography',
                'selector' => '{{WRAPPER}} .job',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        if ( !empty($testimonials) ) {
            ?>
            <div class="widget widget-testimonials <?php echo esc_attr($el_class.' '.$style); ?>">
                <div class="slick-carousel" data-items="1" data-smalldesktop="1" data-medium="1" data-smallmedium="1" data-loop="true" data-extrasmall="1" data-pagination="true" data-nav="false">
                    <?php foreach ($testimonials as $item) { ?>
                    <?php $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : ''; ?>
                    <div class="item">
                        <div class="testimonials-item">

                            <?php if ( !empty($item['content']) ) { ?>
                                <div class="description"><?php echo wp_kses_post($item['content']); ?></div>
                            <?php } ?>

                            <?php if ( $img_src ) { ?>
                                <div class="avarta">
                                    <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                </div>
                            <?php } ?>
                            <?php
                            $img_rating_src = ( isset( $item['img_rating_src']['id'] ) && $item['img_rating_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_rating_src']['id'] ) : '';
                            ?>
                             <?php if ( !empty($item['name']) ) {

                                $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                if ( ! empty( $item['link']['url'] ) ) {
                                    $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                }
                                echo wp_kses_post($title);
                            ?>
                            <?php } ?>

                            <?php if ( !empty($item['job']) ) { ?>
                                <span class="job text-theme"><?php echo wp_kses_post($item['job']); ?></span>
                            <?php } ?>
                            <?php if ( $img_rating_src ) {
                            ?>
                                <div class="rating">
                                    <img src="<?php echo esc_url($img_rating_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Testimonials );