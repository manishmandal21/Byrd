<div id="apus-header-mobile" class="header-mobile hidden-lg clearfix">
    <div class="container">
        <div class="row flex-middle">
            <div class="col-xs-7 left-inner">
                <div class="flex-middle">
                    <div class="active-mobile">
                        <button data-toggle="offcanvas" class="btn btn-sm btn-offcanvas offcanvas" type="button">
                           <i class="ti-align-left" aria-hidden="true"></i>
                        </button>
                    </div>
                    <?php
                        $logo = cityo_get_config('media-mobile-logo');
                    ?>
                    <?php if( isset($logo['url']) && !empty($logo['url']) ): ?>
                        <div class="logo">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                                <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="logo logo-theme">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                                <img src="<?php echo esc_url( get_template_directory_uri().'/images/logo-white.png'); ?>" alt="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
                            </a>
                        </div>
                    <?php endif; ?>
                </div> 
            </div>
            <div class="col-xs-5">
                <div class="flex-middle">
                    <div class="ali-right">
                        <?php if ( cityo_get_config('show_search_form', true) && cityo_is_wp_job_manager_activated() ) { ?>
                            <span class="btn-search-mobile">
                                <i class="flaticon-magnifying-glass"></i>
                            </span>
                        <?php } ?>
                        <?php
                        if ( cityo_get_config('show_mini_cart', true) && cityo_is_woocommerce_activated() ) {
                            
                            ?>
                                <div class="apus-top-cart cart">
                                    <a class="dropdown-toggle mini-cart" href="#" title="<?php esc_attr_e('View your shopping cart', 'cityo'); ?>">
                                        <i class="flaticon-shopping-basket"></i>
                                        <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                        <span class="total-minicart hidden"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="widget_shopping_cart_content">
                                            <?php woocommerce_mini_cart(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                        ?>

                        <?php
                        if ( cityo_get_config('show_login_register', true) ) {
                            if ( is_user_logged_in() ) {
                            $user_id = get_current_user_id();
                            $user = get_userdata( $user_id );
                            ?>
                                <div class="setting-account">
                                    <div class="profile-menus">
                                        <div class="profile-avarta"><?php echo get_avatar($user_id, 30); ?></div>
                                    </div>
                                    <div class="user-account">
                                        <ul class="user-log">
                                            <?php
                                                $menu_nav = 'myaccount-menu';
                                                if ( ! empty( $user->roles ) && is_array( $user->roles ) && Cityo_Apus_Userinfo::check_role_employee($user->roles) ) {
                                                    $menu_nav = 'myaccount-owner-menu';
                                                }
                                                if ( has_nav_menu( $menu_nav ) ) {
                                                    ?>
                                                    <li>
                                                        <?php
                                                            $args = array(
                                                                'theme_location'  => $menu_nav,
                                                                'menu_class'      => 'list-line',
                                                                'fallback_cb'     => '',
                                                                'walker' => new Cityo_Nav_Menu()
                                                            );
                                                            wp_nav_menu($args);
                                                        ?>
                                                    </li>
                                                    <?php
                                                } 
                                            ?>
                                            <li class="last"><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>"><i class="ti-power-off"></i><?php esc_html_e('Log out ','cityo'); ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="account-login">
                                    <ul class="login-account">
                                        <li class="icon-log"><a href="#apus_login_forgot_tab" class="apus-user-login wel-user"><i class="flaticon-in"></i></a></li>
                                    </ul>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ( cityo_get_config('show_search_form', true) && cityo_is_wp_job_manager_activated() ) { ?>
        <div class="widget-header-listingsearch listingsearch-mobile">
            <form class="job_search_form js-search-form" action="<?php echo cityo_get_listings_page_url(); ?>" method="get" role="search">
                <?php
                    $has_search_menu = false;
                    if ( has_nav_menu( 'suggestions_search' ) )  {
                        $has_search_menu = true;
                    }
                ?>
                <div class="search-field-wrapper  search-filter-wrapper <?php echo esc_attr($has_search_menu ? 'has-suggestion' : ''); ?>">
                    <input class="search-field form-control radius-0" autocomplete="off" type="text" name="search_keywords" placeholder="<?php esc_attr_e( 'What are you looking for?', 'cityo' ); ?>" value="<?php the_search_query(); ?>"/>
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
    <?php } ?>
</div>
<div class="over-dark-header"></div>