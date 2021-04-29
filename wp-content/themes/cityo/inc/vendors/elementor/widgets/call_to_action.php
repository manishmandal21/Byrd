<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Call_To_Action extends Widget_Base {

	public function get_name() {
        return 'cityo_call_to_action';
    }

	public function get_title() {
        return esc_html__( 'Apus Call To Action', 'cityo' );
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

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'cityo' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'cityo' ),
            ]
        );
        $this->add_control(
            'description',
            [
                'label' => esc_html__( 'Description', 'cityo' ),
                'type' => Controls_Manager::WYSIWYG,
                'placeholder' => esc_html__( 'Enter your description here', 'cityo' ),
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label' => esc_html__( 'Button Text', 'cityo' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your button text here', 'cityo' ),
            ]
        );

        $this->add_control(
            'btn_link',
            [
                'label' => esc_html__( 'Button Link', 'cityo' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__( 'Enter your Button Link here', 'cityo' ),
            ]
        );
        
        $this->add_control(
            'btn_style',
            [
                'label' => esc_html__( 'Button Style', 'cityo' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'btn-default' => esc_html__('Default ', 'cityo'),
                    'btn-primary' => esc_html__('Primary ', 'cityo'),
                    'btn-success' => esc_html__('Success ', 'cityo'),
                    'btn-info' => esc_html__('Info ', 'cityo'),
                    'btn-warning' => esc_html__('Warning ', 'cityo'),
                    'btn-danger' => esc_html__('Danger ', 'cityo'),
                    'btn-pink' => esc_html__('Pink ', 'cityo'),
                    'btn-white' => esc_html__('White ', 'cityo'),
                    'btn-dark' => esc_html__('Dark ', 'cityo'),
                    'btn-darkred' => esc_html__('Dark Red', 'cityo'),
                ),
                'default' => 'btn-default'
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
                    '{{WRAPPER}} .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Description Typography', 'cityo' ),
                'name' => 'desc_typography',
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__( 'Button Color', 'cityo' ),
                'type' => Controls_Manager::COLOR,
                
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_bg_color',
            [
                'label' => esc_html__( 'Button Background', 'cityo' ),
                'type' => Controls_Manager::COLOR,
                
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .btn' => 'background: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Button Typography', 'cityo' ),
                'name' => 'btn_typography',
                'selector' => '{{WRAPPER}} .btn',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        ?>
        <div class="widget-action <?php echo esc_attr($el_class); ?> flex-middle-sm">
            <div class="item-left">
                <?php if( !empty($title) ) { ?>
                    <h2 class="title" >
                       <span><?php echo esc_attr( $title ); ?></span>
                    </h2>
                <?php } ?>
                <?php if ( !empty($description) ) { ?>
                    <div class="description">
                        <?php echo wp_kses_post( $description ); ?>
                    </div>
                <?php } ?>
            </div>
            <?php if( !empty($btn_link) && !empty($btn_text) ) { ?>
                <div class="action">
                    <a class="btn <?php echo esc_attr(!empty($btn_style) ? $btn_style : ''); ?>" href="<?php echo esc_url( $btn_link ); ?>"><?php echo wp_kses_post( $btn_text ); ?><i class="fas fa-long-arrow-alt-right"></i> </a>
                </div>
            <?php } ?>
        </div>
        <?php

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Call_To_Action );