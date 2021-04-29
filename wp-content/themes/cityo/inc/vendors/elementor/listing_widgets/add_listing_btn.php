<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Listings_Add_Listing_Button extends Elementor\Widget_Base {

	public function get_name() {
        return 'cityo_listings_add_listing_btn';
    }

	public function get_title() {
        return esc_html__( 'Apus Add Listing Button', 'cityo' );
    }
    
	public function get_categories() {
        return [ 'cityo-header-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Settings', 'cityo' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'default' => 'Add Listing',
            ]
        );

        $this->add_control(
            'show_add_listing',
            [
                'label' => esc_html__( 'Show Add Listing Button', 'cityo' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('No', 'cityo'),
                    'always' => esc_html__('Always', 'cityo'),
                    'show_logedin' => esc_html__('Loged in', 'cityo'),
                ],
                'default' => 'always',
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
        
        if ( $show_add_listing == 'always' || ($show_add_listing == 'show_logedin' && is_user_logged_in()) ) {
            if ( is_user_logged_in() ) {
                $can_post = false;
                $user_id = get_current_user_id();
                $user = get_userdata( $user_id );
                if ( ! empty( $user->roles ) && is_array( $user->roles ) && Cityo_Apus_Userinfo::check_role_employee($user->roles) ) {
                    $can_post = true;
                }

                if ( !$can_post ) {
                    return;
                }
            }
        ?>
            <div class="add-listing <?php echo esc_attr($el_class); ?>">
                <a class="btn btn-white" href="<?php echo esc_url( get_permalink(get_option( 'job_manager_submit_job_form_page_id' )) );?>"><i class="ti-plus"></i><?php echo wp_kses_post($title); ?></a>   
            </div>
        <?php }

    }

}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Listings_Add_Listing_Button );