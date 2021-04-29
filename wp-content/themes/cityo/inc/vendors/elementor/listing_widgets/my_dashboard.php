<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Listings_My_Dashboard extends Elementor\Widget_Base {

	public function get_name() {
        return 'cityo_listings_my_dashboard';
    }

	public function get_title() {
        return esc_html__( 'Apus My Dashboard', 'cityo' );
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

        <div class="widget widget-my-dashboard <?php echo esc_attr($el_class); ?>">
            <?php 
                $current_user_id = get_current_user_id();
            ?>
            <?php
            if ( ! is_user_logged_in() ) {
                ?>
                <div class="box-list-2">
                    <div class="text-warning"><?php esc_html_e( 'Please sign in before accessing this page.', 'cityo' ); ?></div>
                </div>
                <?php
            } else {
                if ( !cityo_job_manager_user_can_post_job(true) ) {
                    ?>
                    <div class="box-list-2">
                        <div class="text-warning"><?php esc_html_e('Sorry, you can\'t view this page.', 'cityo'); ?></div>
                    </div>
                    <?php
                    return;
                }
                $args = array(
                    'author'        =>  get_current_user_id(), 
                    'orderby'       =>  'post_date',
                    'order'         =>  'ASC',
                    'posts_per_page' => -1,
                    'post_type' => 'job_listing'
                );

                $posts = get_posts( $args );
                $total = 0;
                $total_views = $total_reviews = $total_bookmarks = 0;
                if ( !empty($posts) ) {
                    $total = count($posts);
                    foreach ($posts as $post) {
                        $total_views += intval(get_post_meta($post->ID, '_views_count', true));
                        $comment_count = wp_count_comments( $post->ID );
                        $total_reviews += !empty($comment_count->approved) ? $comment_count->approved : 0;

                        $total_bookmarks += intval(get_post_meta($post->ID, '_bookmark_count', true));
                    }
                }
                $current_user_id = get_current_user_id();
                $data = get_userdata( $current_user_id );
                $url = cityo_get_user_url($current_user_id, $data->user_nicename);
            ?>
                <h3 class="user-name">
                    <span class="prifix-user"><?php echo esc_html__('Hello ','cityo') ?></span>
                    <?php if ( !empty($url) ) { ?>
                        <a href="<?php echo esc_url($url); ?>">
                    <?php } ?>
                        <?php echo esc_html($data->display_name); ?>
                    <?php if ( !empty($url) ) { ?>
                        </a>
                    <?php } ?>
                </h3>

                <div class="content-inner">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <div class="item active-listing">
                                <div class="clearfix">
                                    <div class="left-inner">
                                        <div class="listings-count"><?php echo trim($total); ?></div>
                                        <div class="listings-text"><?php esc_html_e('All Listings', 'cityo'); ?></div>
                                    </div>
                                    <div class="right-inner">
                                        <i class="flaticon-placeholder"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="item view-listing">
                                <div class="clearfix">
                                    <div class="left-inner">
                                        <div class="listings-count"><?php echo trim($total_views); ?></div>
                                        <div class="listings-text"><?php esc_html_e('Total Views', 'cityo'); ?></div>
                                    </div>
                                    <div class="right-inner">
                                        <i class="flaticon-view-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="item review-listing">
                                <div class="clearfix">
                                    <div class="left-inner">
                                        <div class="listings-count"><?php echo trim($total_reviews); ?></div>
                                        <div class="listings-text"><?php esc_html_e('Total Reviews', 'cityo'); ?></div>
                                    </div>
                                    <div class="right-inner">
                                        <i class="flaticon-consulting-message"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="item bookmard-listing">
                                <div class="clearfix">
                                    <div class="left-inner">
                                        <div class="listings-count"><?php echo trim($total_bookmarks); ?></div>
                                        <div class="listings-text"><?php esc_html_e('Total Bookmarks', 'cityo'); ?></div>
                                    </div>
                                    <div class="right-inner">
                                        <i class="flaticon-like"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row small-row">
                        <?php
                            $args = array(
                                'post_type'           => 'job_listing',
                                'post_status'         => array( 'publish', 'expired', 'pending', 'pending_payment' ),
                                'ignore_sticky_posts' => 1,
                                'posts_per_page'      => -1,
                                'orderby'             => 'date',
                                'order'               => 'desc',
                                'author'              => get_current_user_id()
                            );
                            $query = new WP_Query;
                            $jobs = $query->query( $args );

                            $jobs_status = array();
                            if ( !empty($jobs) ) {
                                foreach ($jobs as $job) {
                                    $jobs_status[$job->post_status][] = $job;
                                }
                            }
                        ?>
                        <div class="col-lg-3 col-xs-6 col-sm-6">
                            <div class="item clearfix text-success">
                                <div class="left-inner">
                                    <div class="listings-count"><?php echo trim(!empty($jobs_status['publish']) ? count($jobs_status['publish']) : 0); ?></div>
                                    <div class="listings-text"><?php esc_html_e('Published', 'cityo'); ?></div>
                                </div>
                                <div class="right-inner">
                                    <i class="ti-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6 col-sm-6">
                            <div class="item clearfix text-danger">
                                <div class="left-inner">
                                    <div class="listings-count"><?php echo trim(!empty($jobs_status['pending']) ? count($jobs_status['pending']) : 0); ?></div>
                                    <div class="listings-text"><?php esc_html_e('Pending', 'cityo'); ?></div>
                                </div>
                                <div class="right-inner">
                                    <i class="ti-reload"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6 col-sm-6">
                            <div class="item clearfix text-info">
                                <div class="left-inner">
                                    <div class="listings-count"><?php echo trim(!empty($jobs_status['pending_payment']) ? count($jobs_status['pending_payment']) : 0); ?></div>
                                    <div class="listings-text"><?php esc_html_e('UnPaid', 'cityo'); ?></div>
                                </div>
                                <div class="right-inner">
                                    <i class="ti-money"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6 col-sm-6">
                            <div class="item clearfix text-warning">
                                <div class="left-inner">
                                    <div class="listings-count"><?php echo trim(!empty($jobs_status['expired']) ? count($jobs_status['expired']) : 0); ?></div>
                                    <div class="listings-text"><?php esc_html_e('Expired', 'cityo'); ?></div>
                                </div>
                                <div class="right-inner">
                                    <i class="ti-lock"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
        <?php

    }

}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Listings_My_Dashboard );