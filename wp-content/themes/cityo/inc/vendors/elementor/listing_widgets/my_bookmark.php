<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Listings_My_Bookmark extends Elementor\Widget_Base {

	public function get_name() {
        return 'cityo_listings_my_bookmark';
    }

	public function get_title() {
        return esc_html__( 'Apus My Bookmark', 'cityo' );
    }
    
	public function get_categories() {
        return [ 'cityo-listings-elements' ];
    }

	protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'cityo' ),
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

        <div class="widget box-user widget-my-bookmark <?php echo esc_attr($el_class); ?>">
            <h3 class="user-name"><?php esc_html_e( 'My Favorite', 'cityo' ); ?></h3>
            <?php
            if ( !is_user_logged_in() ) { ?>
                <div class="text-warning"><?php esc_html_e('Please login to view your bookmark', 'cityo'); ?></div>
            <?php
            } else {
                $post_ids = Cityo_Bookmark::get_bookmark();
                $loop = Cityo_Bookmark::get_listings($post_ids);
                if ( !empty($loop) && $loop->have_posts() ) {
                    ?>
                    <div class="box-list-2">
                        <div class="job-manager-jobs">  
                            <div class="listings-bookmark tab-content">
                                <?php while ( $loop->have_posts() ): $loop->the_post(); global $post; ?>
                                    <?php get_job_manager_template( 'job_manager/loop/list-bookmark.php', array('job' => $post) ); ?>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php } else { ?>
                    <div class="apus-bookmark-note text-warning">
                        <?php esc_html_e( 'You have not added any listings to your bookmark', 'cityo' ); ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <?php

    }

}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Listings_My_Bookmark );