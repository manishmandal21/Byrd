<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Listings_My_Reviews extends Widget_Base {

	public function get_name() {
        return 'cityo_listings_my_reviews';
    }

	public function get_title() {
        return esc_html__( 'Apus My Reviews', 'cityo' );
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
        <div class="widget widget-my-reviews <?php echo esc_attr($el_class); ?>">
            <h3 class="user-name"><?php esc_html_e( 'My Reviews', 'cityo' ); ?></h3>
            <?php
            if ( ! is_user_logged_in() ) {
                ?>
                <div class="text-warning"><?php  esc_html_e( 'Please sign in before accessing this page.', 'cityo' ); ?></div>
                <?php
            } else {
                $user = wp_get_current_user();
                $args = array(
                    'user_id' => $user->ID,
                    'post_type' => 'job_listing',
                    'status' => 'approve',
                    'meta_query' => array(
                        array(
                           'key' => '_apus_rating',
                           'value' => 0,
                           'compare' => '>',
                        )
                    )
                );
                $comments = get_comments( $args );
                if ( !empty($comments) ) {
                    echo '<div class="box-list-2">';
                        $number = cityo_get_config('user_profile_reviews_number', 25);
                        $max_page = ceil(count($comments)/$number);
                        $page = !empty($_GET['cpage']) ? $_GET['cpage'] : 1;
                        echo '<ul class="list-reviews">';
                            wp_list_comments(array(
                                'per_page' => $number,
                                'page' => $page,
                                'reverse_top_level' => false,
                                'callback' => 'cityo_my_review'
                            ), $comments);
                        echo '</ul>';
                        $pargs = array(
                            'base' => add_query_arg( 'cpage', '%#%' ),
                            'format' => '',
                            'total' => $max_page,
                            'current' => $page,
                            'echo' => true,
                            'add_fragment' => ''
                        );
                        if ( $max_page <= 1 ) {
                            return;
                        }
                        cityo_paginate_links( $pargs );
                    echo '</div>';
                } else {
                    ?>
                    <div class="text-warning"><?php esc_html_e('No reviews found.', 'cityo'); ?></div>
                    <?php
                }
            } ?>
        </div>
        <?php

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Listings_My_Reviews );