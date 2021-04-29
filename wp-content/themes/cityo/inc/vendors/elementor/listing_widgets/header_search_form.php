<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Listings_Header_Search_Form extends Elementor\Widget_Base {

	public function get_name() {
        return 'cityo_listings_header_search_form';
    }

	public function get_title() {
        return esc_html__( 'Apus Header Search Form', 'cityo' );
    }
    
	public function get_categories() {
        return [ 'cityo-header-elements' ];
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
            'show_search_suggestions',
            [
                'label' => esc_html__( 'Show Search Suggestions', 'cityo' ),
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
        $classes = '';
        if ( isset($enable_autocompleate_search) && $enable_autocompleate_search ) {
            wp_enqueue_script( 'handlebars', get_template_directory_uri() . '/js/handlebars.min.js', array(), null, true);
            wp_enqueue_script( 'typeahead-jquery', get_template_directory_uri() . '/js/typeahead.jquery.js', array('jquery', 'handlebars'), null, true);
            $classes = 'apus-autocompleate-input';
        }
        ?>
        <div class="widget-header-listingsearch <?php echo esc_attr($el_class); ?>">
            <form class="job_search_form js-search-form" action="<?php echo cityo_get_listings_page_url(); ?>" method="get" role="search">
                <?php
                    $has_search_menu = false;
                    if ( has_nav_menu( 'suggestions_search' ) && !empty($show_search_suggestions) && $show_search_suggestions )  {
                        $has_search_menu = true;
                    }
                ?>
                <div class="search-field-wrapper  search-filter-wrapper <?php echo esc_attr($has_search_menu ? 'has-suggestion' : ''); ?>">
                    <input class="search-field form-control radius-0 <?php echo esc_attr($classes); ?>" autocomplete="off" type="text" name="search_keywords" placeholder="<?php esc_attr_e( 'What are you looking for?', 'cityo' ); ?>" value="<?php the_search_query(); ?>"/>
                    <?php
                    if ( $has_search_menu ) {
                        $args = array(
                            'theme_location' => 'suggestions_search',
                            'container_class' => 'navbar-collapse navbar-collapse-suggestions',
                            'menu_class' => 'nav search-suggestions-menu',
                            'fallback_cb' => '',
                            'walker' => new Cityo_Nav_Menu()
                        );
                        wp_nav_menu($args);
                    }
                    ?>
                </div>

                <button class="btn btn-search-header radius-0" name="submit">
                    <i class="ti-search"></i>
                </button>
            </form>
        </div>
        <?php

    }

}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Listings_Header_Search_Form );