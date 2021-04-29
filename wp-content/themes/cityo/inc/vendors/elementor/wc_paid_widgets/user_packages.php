<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Listings_User_Packages extends Widget_Base {

	public function get_name() {
        return 'cityo_listings_user_packages';
    }

	public function get_title() {
        return esc_html__( 'Apus User Packages', 'cityo' );
    }
    
	public function get_categories() {
        return [ 'cityo-listings-elements' ];
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
                'default' => '',
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

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        ?>
        <div class="widget widget-user-packages <?php echo esc_attr($el_class); ?>">
            <?php if ($title!=''): ?>
                <h2 class="user-name">
                    <?php echo esc_attr( $title ); ?>
                </h2>
            <?php endif; ?>
            <?php
            if ( ! is_user_logged_in() ) {
                ?>
                    <div class="text-warning"><?php  esc_html_e( 'Please sign in before accessing this page.', 'cityo' ); ?></div>
                <?php
            } else {
                $packages = apus_wjm_wc_paid_listings_get_packages_by_user( get_current_user_id(), false );
                if ( !empty($packages) ) {
                ?>
                    
                        <div class="widget-content">
                            <table>
                                <thead>
                                    <tr>
                                        <td><?php esc_html_e('ID', 'cityo'); ?></td>
                                        <td><?php esc_html_e('Package', 'cityo'); ?></td>
                                        <td><?php esc_html_e('Posted', 'cityo'); ?></td>
                                        <td><?php esc_html_e('Limit Posts', 'cityo'); ?></td>
                                        <td><?php esc_html_e('Listing Duration', 'cityo'); ?></td>
                                        <td><?php esc_html_e('Status', 'cityo'); ?></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($packages as $package) { ?>
                                        <tr>
                                            <td><?php echo trim($package->ID); ?></td>
                                            <td class="title"><?php echo trim($package->post_title); ?></td>
                                            <td>
                                                <?php
                                                    $_package_count = get_post_meta($package->ID, '_package_count', true);
                                                    echo intval($_package_count);
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $_listings_limit = get_post_meta($package->ID, '_listings_limit', true);
                                                    echo intval($_listings_limit);
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $_listings_duration = get_post_meta($package->ID, '_listings_duration', true);
                                                    echo intval($_listings_duration);
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ( $_package_count >= $_listings_limit && $_listings_limit != 0 ) {
                                                    echo '<span class="action finish">'.esc_html__('Finished', 'cityo').'</span>';
                                                } else {
                                                    echo '<span class="action active">'.esc_html__('Active', 'cityo').'</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    
                <?php } else { ?>
                    <div class="text-warning"><?php esc_html_e( 'No packages found.', 'cityo' ); ?></div>
                <?php } ?>
            </div>
            <?php
        }
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Listings_User_Packages );