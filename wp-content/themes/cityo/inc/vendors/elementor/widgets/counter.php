<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor counter widget.
 *
 * Elementor widget that displays stats and numbers in an escalating manner.
 *
 * @since 1.0.0
 */
class Cityo_Elementor_Counter extends Widget_Base {

	
	public function get_name() {
		return 'cityo_counter';
	}

	public function get_title() {
		return esc_html__( 'Apus Counter', 'cityo' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
        return [ 'cityo-elements' ];
    }

	public function get_script_depends() {
		return [ 'jquery-numerator' ];
	}

	
	public function get_keywords() {
		return [ 'counter' ];
	}

	
	protected function _register_controls() {
		$this->start_controls_section(
			'section_counter',
			[
				'label' => esc_html__( 'Counter', 'cityo' ),
			]
		);

		$this->add_control(
			'starting_number',
			[
				'label' => esc_html__( 'Starting Number', 'cityo' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
			]
		);

		$this->add_control(
			'ending_number',
			[
				'label' => esc_html__( 'Ending Number', 'cityo' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 100,
			]
		);

		$this->add_control(
			'prefix',
			[
				'label' => esc_html__( 'Number Prefix', 'cityo' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => 1,
			]
		);

		$this->add_control(
			'suffix',
			[
				'label' => esc_html__( 'Number Suffix', 'cityo' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Plus', 'cityo' ),
			]
		);

		$this->add_control(
			'duration',
			[
				'label' => esc_html__( 'Animation Duration', 'cityo' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 2000,
				'min' => 100,
				'step' => 100,
			]
		);

		$this->add_control(
			'thousand_separator',
			[
				'label' => esc_html__( 'Thousand Separator', 'cityo' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__( 'Show', 'cityo' ),
				'label_off' => esc_html__( 'Hide', 'cityo' ),
			]
		);

		$this->add_control(
			'thousand_separator_char',
			[
				'label' => esc_html__( 'Separator', 'cityo' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'thousand_separator' => 'yes',
				],
				'options' => [
					'' => 'Default',
					'.' => 'Dot',
					' ' => 'Space',
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'cityo' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Cool Number', 'cityo' ),
				'placeholder' => esc_html__( 'Cool Number', 'cityo' ),
			]
		);

		$this->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Image Icon', 'cityo' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Image Icon Here', 'cityo' ),
            ]
        );

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', 'cityo' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_number',
			[
				'label' => esc_html__( 'Number', 'cityo' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'number_color',
			[
				'label' => esc_html__( 'Text Color', 'cityo' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .cityo-counter-number-wrapper' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_number',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .cityo-counter-number-wrapper',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'cityo' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'cityo' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .cityo-counter-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .cityo-counter-title',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render counter widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'counter', [
			'class' => 'cityo-counter-number',
			'data-duration' => $settings['duration'],
			'data-to-value' => $settings['ending_number'],
		] );

		if ( ! empty( $settings['thousand_separator'] ) ) {
			$delimiter = empty( $settings['thousand_separator_char'] ) ? ',' : $settings['thousand_separator_char'];
			$this->add_render_attribute( 'counter', 'data-delimiter', $delimiter );
		}
		?>
		<div class="cityo-counter">
			<div class="flex-middle">
				<div class="image-icon">
					<?php
	                if ( !empty($settings['img_src']['id']) ) {
	                ?>
	                    <?php echo cityo_get_attachment_thumbnail($settings['img_src']['id'], 'full'); ?>
	                <?php } ?>
				</div>
				<div class="counter-wrapper">
					<div class="cityo-counter-number-wrapper">
						<span class="cityo-counter-number-prefix"><?php echo wp_kses_post($settings['prefix']); ?></span>
						<span <?php echo wp_kses_post($this->get_render_attribute_string( 'counter' )); ?>><?php echo wp_kses_post($settings['starting_number']); ?></span>
						<span class="cityo-counter-number-suffix"><?php echo wp_kses_post($settings['suffix']); ?></span>
					</div>
					<?php if ( $settings['title'] ) : ?>
						<div class="cityo-counter-title"><?php echo wp_kses_post($settings['title']); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Counter );