<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Listings_Packages extends Widget_Base {

	public function get_name() {
        return 'cityo_listings_packages';
    }

	public function get_title() {
        return esc_html__( 'Apus Packages', 'cityo' );
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
            'columns',
            [
                'label' => esc_html__( 'Columns', 'cityo' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'number',
                'default' => 3,
            ]
        );
        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'cityo' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'cityo'),
                    'style2' => esc_html__('Style 2', 'cityo'),
                ),
                'default' => 'style1',
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

        $loop = cityo_get_products( array('product_type' => 'listing_package'));
        $bcol = 12/$columns;
        ?>
        <div class="widget woocommerce widget-subwoo style-slick <?php echo esc_attr($el_class); ?>">
            <?php if ($loop->have_posts()): ?>
                <div class="slick-carousel <?php echo esc_attr($columns < $loop->post_count ? '' : 'hidden-dots'); ?>" data-items="<?php echo esc_attr($columns); ?>" data-smallmedium="2" data-extrasmall="2" data-smallest="1" data-pagination="true" data-nav="false">
                    <?php while ( $loop->have_posts() ) : $loop->the_post(); global $product;
                    ?>
                        <div class="item">
                            <div class="subwoo-inner <?php echo esc_attr($style.($product->is_featured()?'highlight':'')); ?>">
                                <div class="header-sub">
                                    <div class="inner-sub">
                                        <h3 class="title"><?php the_title(); ?></h3>
                                        <div class="price text-theme"><?php echo (!empty($product->get_price())) ? $product->get_price_html() : esc_html__('Free','cityo'); ?></div>
                                    </div>
                                </div>
                                <div class="bottom-sub">
                                    <?php if ( has_excerpt() ) { ?>
                                        <div class="short-des"><?php the_excerpt(); ?></div>
                                    <?php } ?>
                                    <div class="button-action"><?php do_action( 'woocommerce_after_shop_loop_item' ); ?></div>
                                </div>
                            </div>
                        </div>  
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
        <?php

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Listings_Packages );