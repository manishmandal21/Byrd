<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Posts extends Elementor\Widget_Base {

	public function get_name() {
        return 'cityo_posts';
    }

	public function get_title() {
        return esc_html__( 'Apus Posts', 'cityo' );
    }
    
	public function get_categories() {
        return [ 'cityo-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Posts', 'cityo' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'cityo' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'cityo' ),
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
            'number',
            [
                'label' => esc_html__( 'Number', 'cityo' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'description' => esc_html__( 'Number posts to display', 'cityo' ),
                'default' => 4
            ]
        );
        
        $this->add_control(
            'order_by',
            [
                'label' => esc_html__( 'Order by', 'cityo' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'cityo'),
                    'date' => esc_html__('Date', 'cityo'),
                    'ID' => esc_html__('ID', 'cityo'),
                    'author' => esc_html__('Author', 'cityo'),
                    'title' => esc_html__('Title', 'cityo'),
                    'modified' => esc_html__('Modified', 'cityo'),
                    'rand' => esc_html__('Random', 'cityo'),
                    'comment_count' => esc_html__('Comment count', 'cityo'),
                    'menu_order' => esc_html__('Menu order', 'cityo'),
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Sort order', 'cityo' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'cityo'),
                    'ASC' => esc_html__('Ascending', 'cityo'),
                    'DESC' => esc_html__('Descending', 'cityo'),
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'blog_style',
            [
                'label' => esc_html__( 'Blog Style', 'cityo' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'grid_item_v2' => esc_html__('Style 1', 'cityo'),
                    'grid_item_v3' => esc_html__('Style 2', 'cityo')
                ),
                'default' => 'grid_item_v2'
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default' => 'large',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'cityo' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid', 'cityo'),
                    'carousel' => esc_html__('Carousel', 'cityo'),
                    'special' => esc_html__('Special', 'cityo'),
                ),
                'default' => 'grid'
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'cityo' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'default' => 4,
                'condition' => [
                    'layout_type' => ['grid', 'carousel'],
                ]
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_special', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default' => 'large',
                'separator' => 'none',
                'condition' => [
                    'layout_type' => 'special',
                ],
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



        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Tyles', 'cityo' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'cityo' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'cityo' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->add_control(
            'post_title_color',
            [
                'label' => esc_html__( 'Post Title Color', 'cityo' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .post .title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Post Title Typography', 'cityo' ),
                'name' => 'post_title_typography',
                'selector' => '{{WRAPPER}} .post .title a',
            ]
        );

        $this->add_control(
            'post_excerpt_color',
            [
                'label' => esc_html__( 'Post Excerpt Color', 'cityo' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .post .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Post Excerpt Typography', 'cityo' ),
                'name' => 'post_excerpt_typography',
                'selector' => '{{WRAPPER}} .post .description',
            ]
        );

        $this->add_control(
            'post_tag_color',
            [
                'label' => esc_html__( 'Post Tag Color', 'cityo' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .post .tags' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Post Tag Typography', 'cityo' ),
                'name' => 'post_tag_typography',
                'selector' => '{{WRAPPER}} .post .tags',
            ]
        );

        $this->add_control(
            'post_readmore_color',
            [
                'label' => esc_html__( 'Post Read More Color', 'cityo' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .post .readmore' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Post Read More Typography', 'cityo' ),
                'name' => 'post_readmore_typography',
                'selector' => '{{WRAPPER}} .post .readmore',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        $category_slugs = !empty($category_slugs) ? array_map('trim', explode(',', $category_slugs)) : array();

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $number,
            'orderby' => $order_by,
            'order' => $order,
        );
        if ( !empty($category_slugs) && is_array($category_slugs) ) {
            $args['tax_query'] = array(
                array(
                'taxonomy'      => 'category',
                'field'         => 'slug',
                'terms'         => $category_slugs,
                'operator'      => 'IN'
            ));
        }
        $blog_style = !empty($blog_style) ? $blog_style : 'grid_item_v2';
        $loop = new WP_Query($args);
        if ( $loop->have_posts() ) {
            if ( $image_size == 'custom' ) {
                
                if ( $image_custom_dimension['width'] && $image_custom_dimension['height'] ) {
                    $thumbsize = $image_custom_dimension['width'].'x'.$image_custom_dimension['height'];
                } else {
                    $thumbsize = 'full';
                }
            } else {
                $thumbsize = $image_size;
            }
            
            if ( $image_special_size == 'custom' ) {
                if ( $image_special_custom_dimension['width'] && $image_special_custom_dimension['height'] ) {
                    $special_thumbsize = $image_special_custom_dimension['width'].'x'.$image_special_custom_dimension['height'];
                } else {
                    $special_thumbsize = 'full';
                }
            } else {
                $special_thumbsize = $image_special_size;
            }

            set_query_var( 'thumbsize', $thumbsize );
            ?>
            <div class="widget-blogs widget <?php echo esc_attr($layout_type); ?> <?php echo esc_attr($el_class); ?>">
                <?php if ( $title ) { ?>
                    <h2 class="widget-title"><?php echo wp_kses_post($title); ?></h2>
                <?php } ?>
                <div class="widget-content">
                    <?php if ( $layout_type == 'carousel' ): ?>
                        <div class="slick-carousel <?php echo esc_attr( ( $loop->post_count <= $columns ) ? 'hidden-dots' : '111' ); ?>" data-items="<?php echo esc_attr($columns); ?>" data-smallmedium="2" data-extrasmall="1" data-pagination="true" data-nav="false">
                            <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
                                <div class="item">
                                    <?php get_template_part( 'template-posts/loop/'.$blog_style); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php elseif ( $layout_type == 'special' ): ?>
                        <div class="layout-blog style-grid">
                            <div class="row">
                                <?php $i = 0; while ( $loop->have_posts() ) : $loop->the_post();
                                    if ( $i == 0 ) {
                                        $bcol = 6;
                                        set_query_var( 'thumbsize', $special_thumbsize );
                                    } else {
                                        $bcol = 3;
                                        set_query_var( 'thumbsize', $thumbsize );
                                    }
                                ?>
                                    <div class="col-sm-<?php echo esc_attr($bcol); ?> col-xs-12">
                                        <?php get_template_part( 'template-posts/loop/'.$blog_style ); ?>
                                    </div>
                                <?php $i++; endwhile; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php $bcol = 12/$columns; ?>
                        <div class="layout-blog style-grid">
                            <div class="row">
                                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                    <div class="col-md-<?php echo esc_attr($bcol); ?> col-sm-6 col-xs-12">
                                        <?php get_template_part( 'template-posts/loop/'.$blog_style ); ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
            <?php
        }

    }

}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Posts );