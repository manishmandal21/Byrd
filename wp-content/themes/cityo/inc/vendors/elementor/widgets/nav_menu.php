<?php

//namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Nav_Menu extends Elementor\Widget_Base {

	public function get_name() {
        return 'cityo_nav_menu';
    }

	public function get_title() {
        return esc_html__( 'Apus Navigation Menu', 'cityo' );
    }
    
	public function get_categories() {
        return [ 'cityo-elements' ];
    }

	protected function _register_controls() {

        $custom_menus = array();
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
        if ( is_array( $menus ) && ! empty( $menus ) ) {
            foreach ( $menus as $menu ) {
                if ( is_object( $menu ) && isset( $menu->name, $menu->slug ) ) {
                    $custom_menus[ $menu->slug ] = $menu->name;
                }
            }
        }

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Navigation Menu', 'cityo' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title here', 'cityo' ),
            ]
        );

        $this->add_control(
            'nav_menu',
            [
                'label' => esc_html__( 'Menu', 'cityo' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $custom_menus,
                'default' => ''
            ]
        );
        
        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'cityo' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'cityo'),
                    'st_icon' => esc_html__('Icon', 'cityo'),
                ),
                'default' => ''
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
                'label' => esc_html__( 'Title', 'cityo' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'cityo' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'cityo' ),
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_menu_style',
            [
                'label' => esc_html__( 'Menu Item', 'cityo' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'menu_color',
            [
                'label' => esc_html__( 'Menu Color', 'cityo' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widget-content a' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'menu_color_hover',
            [
                'label' => esc_html__( 'Menu Color Hover', 'cityo' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .widget-content a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Menu Typography', 'cityo' ),
                'name' => 'menu_typography',
                'selector' => '{{WRAPPER}} .widget-content a',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        $menu_id = 0;
        if ($nav_menu) {
            $term = get_term_by( 'slug', $nav_menu, 'nav_menu' );
            if ( !empty($term) ) {
                $menu_id = $term->term_id;
            }
        }

        ?>
        <div class="widget-nav-menu widget <?php echo esc_attr($el_class.' '.$style); ?>">
            
            <?php if ( !empty($title) ) { ?>
                <h2 class="widget-title"><?php echo wp_kses_post($title); ?></h2>
            <?php } ?>

            <?php if ( !empty($menu_id) ) { ?>
                <div class="widget-content">
                    <?php
                        $nav_menu_args = array(
                            'fallback_cb' => '',
                            'menu'        => $menu_id,
                            'walker' => new Cityo_Nav_Menu()
                        );

                        wp_nav_menu( $nav_menu_args, $menu_id );
                    ?>
                </div>
            <?php } ?>

        </div>
        <?php
    }

}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Nav_Menu );