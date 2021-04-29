<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Countdown extends Widget_Base {

	public function get_name() {
        return 'cityo_countdown';
    }

	public function get_title() {
        return esc_html__( 'Apus Countdown', 'cityo' );
    }
    
	public function get_categories() {
        return [ 'cityo-elements' ];
    }
    
	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Countdown', 'cityo' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'cityo' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title here', 'cityo' ),
            ]
        );

        $this->add_control(
            'price',
            [
                'label' => esc_html__( 'Price', 'cityo' ),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter your Price here', 'cityo' ),
            ]
        );
        $this->add_control(
            'des',
            [
                'label' => esc_html__( 'Content', 'cityo' ),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter your content here', 'cityo' ),
            ]
        );
        $this->add_control(
            'end_date', [
                'label' => esc_html__( 'End Date', 'cityo' ),
                'type' => Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'enableTime' => false
                ]
            ]
        );
        
        $this->add_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'cityo' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'cityo' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'cityo' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'cityo' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'cityo' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .widget-countdown' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'URL', 'cityo' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__( 'Enter your Button Link here', 'cityo' ),
            ]
        );
        $this->add_control(
            'btn_text',
            [
                'label' => esc_html__( 'Button Text', 'cityo' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your button text here', 'cityo' ),
            ]
        );

        $this->add_control(
            'btn_style',
            [
                'label' => esc_html__( 'Button Style', 'cityo' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'btn-theme' => esc_html__('Theme Color', 'cityo'),
                    'btn-theme btn-outline' => esc_html__('Theme Outline Color', 'cityo'),
                    'btn-default' => esc_html__('Default ', 'cityo'),
                    'btn-primary' => esc_html__('Primary ', 'cityo'),
                    'btn-success' => esc_html__('Success ', 'cityo'),
                    'btn-info' => esc_html__('Info ', 'cityo'),
                    'btn-warning' => esc_html__('Warning ', 'cityo'),
                    'btn-danger' => esc_html__('Danger ', 'cityo'),
                    'btn-pink' => esc_html__('Pink ', 'cityo'),
                    'btn-white' => esc_html__('White ', 'cityo'),
                ),
                'default' => 'btn-default'
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'cityo' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'cityo'),
                    'style2' => esc_html__('Style 2(showdow)', 'cityo'),
                    'style3' => esc_html__('Style 3(circle)', 'cityo'),
                ),
                'default' => 'style1'
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
                'label' => esc_html__( 'Style', 'cityo' ),
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
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'cityo' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Description Color', 'cityo' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .des' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Description Typography', 'cityo' ),
                'name' => 'desc_typography',
                'selector' => '{{WRAPPER}} .des',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        $end_date = !empty($end_date) ? strtotime($end_date) : '';
        if ( $end_date ) {
            ?>
            <div class="widget-countdown <?php echo esc_attr($el_class.' '.$style); ?>">
                <?php if ( !empty($title) ) { ?>
                    <h2 class="title"><?php echo wp_kses_post($title); ?></h2>
                <?php } ?>
                <?php if ( !empty($price) ) { ?>
                    <div class="price"><?php echo wp_kses_post($price); ?></div>
                <?php } ?>
                <?php if ( !empty($des) ) { ?>
                    <div class="des"><?php echo wp_kses_post($des); ?></div>
                <?php } ?>
                <div class="time-wrapper">
                    <div class="apus-countdown clearfix" data-time="timmer"
                        data-date="<?php echo date('m', $end_date).'-'.date('d', $end_date).'-'.date('Y', $end_date).'-'. date('H', $end_date) . '-' . date('i', $end_date) . '-' .  date('s', $end_date) ; ?>">
                    </div>
                </div>
                <?php if ( !empty($btn_text) && !empty($link) ) { ?>
                    <div class="url-bottom">
                        <a type="button" href="<?php echo esc_url($link); ?>" class="btn <?php echo esc_attr(!empty($btn_style) ? $btn_style : ''); ?>"><?php echo wp_kses_post($btn_text); ?></a>
                    </div>
                <?php } ?>
            </div>
            <?php
        }
    }

}
Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Countdown );