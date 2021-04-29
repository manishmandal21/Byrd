<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Listings_Car_Search_Form extends Elementor\Widget_Base {

	public function get_name() {
        return 'cityo_listings_car_search_form';
    }

	public function get_title() {
        return esc_html__( 'Apus Search Form', 'cityo' );
    }
    
	public function get_categories() {
        return [ 'cityo-listings-elements' ];
    }

	protected function _register_controls() {

        $contracts = array();
        
        $contract_field = cityo_get_field_options('job_contract');
        if ( !empty($contract_field['options']) ) {
            $contracts = $contract_field['options'];
        }
        $i = 0;
        foreach ($contracts as $key => $title) {
            if ( empty($key) ) {
                continue;
            }
            $i++;
            $this->start_controls_section(
                'content_'.$i.'_section',
                [
                    'label' => esc_html__( 'Tab: ', 'cityo' ).$title,
                    'tab' => Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'search_'.$i.'_keyword',
                [
                    'label' => esc_html__( 'Show Search Keyword', 'cityo' ),
                    'type' => Elementor\Controls_Manager::SWITCHER,
                    'default' => '',
                    'label_on' => esc_html__( 'Hide', 'cityo' ),
                    'label_off' => esc_html__( 'Show', 'cityo' ),
                ]
            );

            $this->add_control(
                'enable_autocompleate_search',
                [
                    'label' => esc_html__( 'Enable autocompleate search', 'cityo' ),
                    'type' => Elementor\Controls_Manager::SWITCHER,
                    'default' => '1',
                    'label_on' => esc_html__( 'Yes', 'cityo' ),
                    'label_off' => esc_html__( 'No', 'cityo' ),
                ]
            );
                
            if ( cityo_get_config('listing_filter_show_categories') ) {
                $this->add_control(
                    'search_'.$i.'_category',
                    [
                        'label' => esc_html__( 'Show Search Brand', 'cityo' ),
                        'type' => Elementor\Controls_Manager::SWITCHER,
                        'default' => '',
                        'label_on' => esc_html__( 'Hide', 'cityo' ),
                        'label_off' => esc_html__( 'Show', 'cityo' ),
                    ]
                );
            }
            if ( cityo_get_config('listing_filter_show_types') ) {
                $this->add_control(
                    'search_'.$i.'_type',
                    [
                        'label' => esc_html__( 'Show Search Model', 'cityo' ),
                        'type' => Elementor\Controls_Manager::SWITCHER,
                        'default' => '',
                        'label_on' => esc_html__( 'Hide', 'cityo' ),
                        'label_off' => esc_html__( 'Show', 'cityo' ),
                    ]
                );
            }
            if ( cityo_get_config('listing_filter_show_price_slider') ) {
                $this->add_control(
                    'search_'.$i.'_price',
                    [
                        'label' => esc_html__( 'Show Search Price', 'cityo' ),
                        'type' => Elementor\Controls_Manager::SWITCHER,
                        'default' => '',
                        'label_on' => esc_html__( 'Hide', 'cityo' ),
                        'label_off' => esc_html__( 'Show', 'cityo' ),
                    ]
                );
            }
            if ( cityo_get_config('listing_filter_show_regions') ) {
                $this->add_control(
                    'search_'.$i.'_region',
                    [
                        'label' => esc_html__( 'Show Search Region', 'cityo' ),
                        'type' => Elementor\Controls_Manager::SWITCHER,
                        'default' => '',
                        'label_on' => esc_html__( 'Hide', 'cityo' ),
                        'label_off' => esc_html__( 'Show', 'cityo' ),
                    ]
                );
            }
            if ( cityo_get_config('listing_filter_show_location') ) {
                $this->add_control(
                    'search_'.$i.'_location',
                    [
                        'label' => esc_html__( 'Show Search Location', 'cityo' ),
                        'type' => Elementor\Controls_Manager::SWITCHER,
                        'default' => '',
                        'label_on' => esc_html__( 'Hide', 'cityo' ),
                        'label_off' => esc_html__( 'Show', 'cityo' ),
                    ]
                );
            }

            

            $this->end_controls_section();
        }

        $this->start_controls_section(
            'content_additional_class_section',
            [
                'label' => esc_html__( 'Additional Class', 'cityo' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
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
        
        ?>
        <div class="widget-listingsearch listingsearch-horizontal <?php echo esc_attr($el_class); ?>">
            <?php get_job_manager_template( 'job-filters-simple-car.php', array('settings' => $settings) ); ?>
        </div>
        <?php

    }

}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Listings_Car_Search_Form );