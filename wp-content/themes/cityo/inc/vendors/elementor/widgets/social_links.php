<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Cityo_Elementor_Social_Links extends Widget_Base {

	public function get_name() {
        return 'cityo_social_links';
    }

	public function get_title() {
        return esc_html__( 'Apus Social Links', 'cityo' );
    }

    public function get_icon() {
        return 'fa fa-share-square-o';
    }

	public function get_categories() {
        return [ 'cityo-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'cityo' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__( 'Social Title', 'cityo' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Social Title' , 'cityo' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'social_icon',
            [
                'label' => __( 'Icon', 'cityo' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'social',
                'label_block' => true,
                'default' => [
                    'value' => 'fab fa-facebook-f',
                    'library' => 'fa-brands',
                ],
                'recommended' => [
                    'fa-brands' => [
                        'android',
                        'apple',
                        'behance',
                        'bitbucket',
                        'codepen',
                        'delicious',
                        'deviantart',
                        'digg',
                        'dribbble',
                        'elementor',
                        'facebook',
                        'flickr',
                        'foursquare',
                        'free-code-camp',
                        'github',
                        'gitlab',
                        'globe',
                        'google-plus',
                        'houzz',
                        'instagram',
                        'jsfiddle',
                        'linkedin',
                        'medium',
                        'meetup',
                        'mixcloud',
                        'odnoklassniki',
                        'pinterest',
                        'product-hunt',
                        'reddit',
                        'shopping-cart',
                        'skype',
                        'slideshare',
                        'snapchat',
                        'soundcloud',
                        'spotify',
                        'stack-overflow',
                        'steam',
                        'stumbleupon',
                        'telegram',
                        'thumb-tack',
                        'tripadvisor',
                        'tumblr',
                        'twitch',
                        'twitter',
                        'viber',
                        'vimeo',
                        'vk',
                        'weibo',
                        'weixin',
                        'whatsapp',
                        'wordpress',
                        'xing',
                        'yelp',
                        'youtube',
                        '500px',
                    ],
                    'fa-solid' => [
                        'envelope',
                        'link',
                        'rss',
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __( 'Link', 'cityo' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'is_external' => 'true',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'https://your-link.com', 'cityo' ),
            ]
        );

        $this->add_control(
            'social_icon_list',
            [
                'label' => __( 'Social Icons', 'cityo' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'social_icon' => [
                            'value' => 'fab fa-facebook',
                            'library' => 'fa-brands',
                        ],
                    ],
                    [
                        'social_icon' => [
                            'value' => 'fab fa-twitter',
                            'library' => 'fa-brands',
                        ],
                    ],
                    [
                        'social_icon' => [
                            'value' => 'fab fa-google-plus',
                            'library' => 'fa-brands',
                        ],
                    ],
                ],
                'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social, true, migrated, true ) }}}',
            ]
        );
        
        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'cityo' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'cityo' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'cityo' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'cityo' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'cityo' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Normal', 'cityo'),
                ),
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


        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Title', 'cityo' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => esc_html__( 'Color', 'cityo' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .social a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label' => esc_html__( 'Color Hover', 'cityo' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .social a:hover, {{WRAPPER}} .social a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );
        $migration_allowed = Icons_Manager::is_migration_allowed();

        if ( !empty($socials) ) {

            ?>
            <div class="widget-social <?php echo esc_attr($el_class.' '.$style); ?>">
                <ul class="social list-inline">
                    <?php
                        foreach ( $settings['social_icon_list'] as $index => $item ) {
                            $migrated = isset( $item['__fa4_migrated']['social_icon'] );
                            $is_new = empty( $item['social'] ) && $migration_allowed;
                            $social = '';

                            // add old default
                            if ( empty( $item['social'] ) && ! $migration_allowed ) {
                                $item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
                            }

                            if ( ! empty( $item['social'] ) ) {
                                $social = str_replace( 'fa fa-', '', $item['social'] );
                            }

                            if ( ( $is_new || $migrated ) && 'svg' !== $item['social_icon']['library'] ) {
                                $social = explode( ' ', $item['social_icon']['value'], 2 );
                                if ( empty( $social[1] ) ) {
                                    $social = '';
                                } else {
                                    $social = str_replace( 'fa-', '', $social[1] );
                                }
                            }
                            if ( 'svg' === $item['social_icon']['library'] ) {
                                $social = '';
                            }

                            $link_key = 'link_' . $index;

                            $this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

                            if ( $item['link']['is_external'] ) {
                                $this->add_render_attribute( $link_key, 'target', '_blank' );
                            }

                            if ( $item['link']['nofollow'] ) {
                                $this->add_render_attribute( $link_key, 'rel', 'nofollow' );
                            }
                            ?>
                            <li>
                                <a <?php echo trim($this->get_render_attribute_string( $link_key )); ?>>
                                    <?php
                                    if ( $is_new || $migrated ) {
                                        Icons_Manager::render_icon( $item['social_icon'] );
                                    } else { ?>
                                        <i class="<?php echo esc_attr( $item['social'] ); ?>"></i>
                                    <?php } ?>
                                </a>
                            </li>
                        <?php } ?>
                </ul>
            </div>
            <?php
        }
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Cityo_Elementor_Social_Links );