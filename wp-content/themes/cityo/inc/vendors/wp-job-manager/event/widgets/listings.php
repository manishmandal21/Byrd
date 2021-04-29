<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Event_Listings extends Elementor\Widget_Base {

	public function get_name() {
        return 'cityo_place_listings';
    }

	public function get_title() {
        return esc_html__( 'Apus Listings', 'cityo' );
    }
    
	public function get_categories() {
        return [ 'cityo-listings-elements' ];
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
            'title',
            [
                'label' => esc_html__( 'Title', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your Title here', 'cityo' ),
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => esc_html__( 'Number listings to show', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'default' => 4
            ]
        );

        $this->add_control(
            'get_by',
            [
                'label' => esc_html__( 'Get Listings By', 'cityo' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'recent' => esc_html__('Recent Listing', 'cityo'),
                    'popular' => esc_html__('Popular Listing', 'cityo'),
                    'featured' => esc_html__('Featured Listing', 'cityo'),
                    'upcoming' => esc_html__('Upcoming Listing', 'cityo'),
                    'rand' => esc_html__('Random', 'cityo'),
                ),
                'default' => 'recent'
            ]
        );

        $this->add_control(
            'category_slugs',
            [
                'label' => esc_html__( 'Categories Slug', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter id spearate by comma(,)', 'cityo' ),
            ]
        );

        $this->add_control(
            'region_slugs',
            [
                'label' => esc_html__( 'Regions Slug', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter id spearate by comma(,)', 'cityo' ),
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'default' => 3,
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout Type', 'cityo' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid', 'cityo'),
                    'carousel' => esc_html__('Carousel', 'cityo'),
                ),
                'default' => 'grid'
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'label' => esc_html__( 'Show Nav', 'cityo' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'cityo' ),
                'label_off' => esc_html__( 'Show', 'cityo' ),
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );
        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__( 'Show Pagination', 'cityo' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'cityo' ),
                'label_off' => esc_html__( 'Show', 'cityo' ),
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );
        $this->add_control(
            'autoplay',
            [
                'label'         => esc_html__( 'Autoplay', 'cityo' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'cityo' ),
                'label_off'     => esc_html__( 'No', 'cityo' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'         => esc_html__( 'Infinite Loop', 'cityo' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'cityo' ),
                'label_off'     => esc_html__( 'No', 'cityo' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'pagination_white',
            [
                'label' => esc_html__( 'Pagination Style White', 'cityo' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Default', 'cityo' ),
                'label_off' => esc_html__( 'White', 'cityo' ),
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );
        $this->add_control(
            'link_more',
            [
                'label' => esc_html__( 'Link Read More', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter url', 'cityo' ),
            ]
        );
        $this->add_control(
            'text_more',
            [
                'label' => esc_html__( 'Text Read More', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter Read More Text', 'cityo' ),
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
        global $apus_cityo_listing_type;
        $settings = $this->get_settings();

        extract( $settings );

        $card_style = 'grid-'.$apus_cityo_listing_type;
        $category_slugs = !empty($category_slugs) ? array_map('trim', explode(',', $category_slugs)) : array();
        $region_slugs = !empty($region_slugs) ? array_map('trim', explode(',', $region_slugs)) : array();
        
        $args = array(
            'get_by' => $get_by,
            'post_per_page' => $number,
            'categories' => $category_slugs,
            'regions' => $region_slugs,
        );
        $loop = cityo_get_listings($args);
        if($columns >= 4){
            $smalldesktop = 'data-smalldesktop=3';
            $desktop = 'data-desktop=4';
        }else{
            $smalldesktop = 'data-smalldesktop='.$columns;
            $desktop = 'data-desktop='.$columns;
        }
        ?>
        <div class="widget widget-listing style-<?php echo esc_attr($layout_type) ?> <?php echo esc_attr($el_class); ?> <?php echo esc_attr($show_nav ? 'show-nav' : ''); ?>">
            <?php if ( !empty($title) ): ?>
                <h2 class="widget-title">
                    <?php echo wp_kses_post($title); ?>
                </h2>
            <?php endif; ?>
            <div class="widget-content">
                <?php if ($layout_type == 'carousel') { ?>
                    <?php if ($loop->have_posts()): ?>
                        <div class="slick-carousel <?php echo esc_attr($columns < $loop->post_count?'':'hidden-dots'); ?> <?php echo esc_attr(($pagination_white == true)?'pagination_white':''); ?>" <?php echo esc_attr($desktop.' '.$smalldesktop); ?> data-items="<?php echo esc_attr($columns); ?>" data-medium="2" data-smallmedium="2" data-extrasmall="1" data-pagination="<?php echo esc_attr($show_pagination ? 'true' : 'false'); ?>" data-nav="<?php echo esc_attr($show_nav ? 'true' : 'false'); ?>" data-autoplay="<?php echo esc_attr($autoplay ? 'true' : 'false'); ?>" data-loop="<?php echo esc_attr($infinite_loop ? 'true' : 'false'); ?>">
                            <?php while ( $loop->have_posts() ): $loop->the_post(); global $post; ?>
                                <div class="item">
                                    <?php get_template_part( 'job_manager/loop/'.$card_style); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                <?php } elseif ($layout_type == 'grid') { ?>
                    <div class="row">
                        <?php $count = 1; while ( $loop->have_posts() ): $loop->the_post(); global $post; ?>
                            <div class="full-smallest col-xs-12 col-sm-6 col-md-<?php echo esc_attr(12/$columns);?> <?php echo esc_attr($count%$columns == 1 ? ' md-clearfix ':''); echo esc_attr($count%2 == 1 ? ' sm-clearfix xs-clearfix':''); ?>">
                                <?php get_template_part( 'job_manager/loop/'.$card_style); ?>
                            </div>
                        <?php $count++; endwhile; ?>
                    </div>
                <?php } ?>

            </div>
            <?php if ( !empty($link_more) ): ?>
                <div class="wrapper-more text-center">
                    <?php if ( !empty($text_more) ) {?>
                        <a class="btn btn-theme" href="<?php echo esc_url($link_more); ?>"><?php echo wp_kses_post($text_more); ?></a>
                    <?php }else{?>
                        <a class="btn btn-theme" href="<?php echo esc_url($link_more); ?>"><?php echo esc_html__('See More Events','cityo'); ?></a>
                    <?php } ?>
                </div>
            <?php endif; ?>
        </div>
        <?php wp_reset_postdata();

    }

}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Event_Listings );