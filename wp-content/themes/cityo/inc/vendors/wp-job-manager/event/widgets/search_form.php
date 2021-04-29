<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Listings_Event_Search_Form extends Elementor\Widget_Base {

	public function get_name() {
        return 'cityo_listings_event_search_form';
    }

	public function get_title() {
        return esc_html__( 'Apus Search Form', 'cityo' );
    }
    
	public function get_categories() {
        return [ 'cityo-listings-elements' ];
    }

	protected function _register_controls() {


        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Search Form', 'cityo' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'search_keyword',
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
    
        $this->add_control(
            'show_search_suggestions',
            [
                'label' => esc_html__( 'Show Search Suggestions', 'cityo' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'cityo' ),
                'label_off' => esc_html__( 'Show', 'cityo' ),
            ]
        );
        
        if ( cityo_get_config('listing_filter_show_categories') ) {
            $this->add_control(
                'search_category',
                [
                    'label' => esc_html__( 'Show Search Category', 'cityo' ),
                    'type' => Elementor\Controls_Manager::SWITCHER,
                    'default' => '',
                    'label_on' => esc_html__( 'Hide', 'cityo' ),
                    'label_off' => esc_html__( 'Show', 'cityo' ),
                ]
            );
        }
        if ( cityo_get_config('listing_filter_show_regions') ) {
            $this->add_control(
                'search_region',
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
                'search_location',
                [
                    'label' => esc_html__( 'Show Search Location', 'cityo' ),
                    'type' => Elementor\Controls_Manager::SWITCHER,
                    'default' => '',
                    'label_on' => esc_html__( 'Hide', 'cityo' ),
                    'label_off' => esc_html__( 'Show', 'cityo' ),
                ]
            );
        }

        if ( cityo_get_config('listing_filter_show_date') ) {
            $this->add_control(
                'show_search_date',
                [
                    'label' => esc_html__( 'Show Search Date', 'cityo' ),
                    'type' => Elementor\Controls_Manager::SWITCHER,
                    'default' => '',
                    'label_on' => esc_html__( 'Hide', 'cityo' ),
                    'label_off' => esc_html__( 'Show', 'cityo' ),
                ]
            );
        }
        

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
        <div class="widget-listingsearch listingsearch-vertical <?php echo esc_attr($el_class); ?>">
            <div class="widget-content">
                <?php get_job_manager_template( 'job-filters-simple-place.php', $settings ); ?>
            </div>
        </div>
        <?php

    }

}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Listings_Event_Search_Form );