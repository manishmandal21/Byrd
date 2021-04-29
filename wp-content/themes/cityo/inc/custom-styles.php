<?php
if ( !function_exists ('cityo_custom_styles') ) {
	function cityo_custom_styles() {
		ob_start();	
		?>

			<?php
				$main_font = cityo_get_config('main_font');
				$main_font = isset($main_font['font-family']) ? $main_font['font-family'] : false;
			?>
			<?php if ( $main_font ): ?>
				/* Main Font */
				body
				{
					font-family: 
					<?php echo '\'' . $main_font . '\','; ?> 
					sans-serif;
				}
			<?php endif; ?>
			
			<?php
				$heading_font = cityo_get_config('heading_font');
				$heading_font = isset($heading_font['font-family']) ? $heading_font['font-family'] : false;
			?>
			<?php if ( $heading_font ): ?>
				/* Heading Font */
				h1, h2, h3, h4, h5, h6, .widget-title,.widgettitle
				{
					font-family:  <?php echo '\'' . $heading_font . '\','; ?> sans-serif;
				}			
			<?php endif; ?>
			

			/* check main color */ 
			<?php if ( cityo_get_config('main_color') != "" ) : ?>
				/* seting border color main */
				.btn-app:hover,
				.claim-listing-form .form-control:focus,
				.subwoo-inner:hover,
				.btn-white:hover,
				.box-banner3,
				.job_search_form .select2-container.select2-container--open .select2-selection--single, .job_search_form .select2-container--default.select2-container--open .select2-selection--single,
				.woocommerce #respond input#submit:hover, .woocommerce #respond input#submit:active, .woocommerce a.button:hover, .woocommerce a.button:active, .woocommerce button.button:hover, .woocommerce button.button:active, .woocommerce input.button:hover, .woocommerce input.button:active,
				.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,
				form.cart .single_add_to_cart_button:hover,
				.tabs-v1 .nav-tabs li:focus > a:focus, .tabs-v1 .nav-tabs li:focus > a:hover, .tabs-v1 .nav-tabs li:focus > a, .tabs-v1 .nav-tabs li:hover > a:focus, .tabs-v1 .nav-tabs li:hover > a:hover, .tabs-v1 .nav-tabs li:hover > a, .tabs-v1 .nav-tabs li.active > a:focus, .tabs-v1 .nav-tabs li.active > a:hover, .tabs-v1 .nav-tabs li.active > a,
				.product-block:hover .add-cart .added_to_cart, .product-block:hover .add-cart .button,
				.select2-container.select2-container--focus .select2-selection--multiple, .select2-container.select2-container--focus .select2-selection--single, .select2-container.select2-container--open .select2-selection--multiple, .select2-container.select2-container--open .select2-selection--single, .select2-container--default.select2-container--focus .select2-selection--multiple, .select2-container--default.select2-container--focus .select2-selection--single, .select2-container--default.select2-container--open .select2-selection--multiple, .select2-container--default.select2-container--open .select2-selection--single,
				.fields-filter .form-control:focus, .fields-filter select:focus,
				.job_filters .price_slider_wrapper .ui-slider-handle, .job_filters .search_distance_wrapper .ui-slider-handle,
				#back-to-top:active, #back-to-top:hover,
				.slick-carousel .slick-dots li.slick-active,
				.slick-carousel .slick-dots li,
				.border-theme
				{
					border-color: <?php echo esc_html( cityo_get_config('main_color') ) ?>;
				}

				/* seting background main */
				div.job_listings .job-manager-pagination ul li a.current, div.job_listings .job-manager-pagination ul li span.current,
				div.job_listings .job-manager-pagination ul li a:hover, div.job_listings .job-manager-pagination ul li span:hover,
				.megamenu > li > a:hover, .megamenu > li > a:active, .megamenu > li > a:focus,
				.megamenu > li.active > a, .megamenu > li:hover > a,
				.listing-contract,
				.price_slider_wrapper .ui-slider-handle,
				.price_slider_wrapper .ui-widget-header,
				.listing-tag-list a:hover, .listing-tag-list a:focus,
				.box-banner3,
				.widget-user-packages table > thead,
				.widget-nav-menu.st_icon li:hover > a, .widget-nav-menu.st_icon li.active > a,
				.subwoo-inner:hover .button-action .button,
				.btn-white:hover,
				.box-banner2::before,
				.cart_totals,
				.woocommerce #respond input#submit:hover, .woocommerce #respond input#submit:active, .woocommerce a.button:hover, .woocommerce a.button:active, .woocommerce button.button:hover, .woocommerce button.button:active, .woocommerce input.button:hover, .woocommerce input.button:active,
				.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,
				form.cart .single_add_to_cart_button,
				.apus-woocommerce-product-gallery-wrapper .woocommerce-product-gallery__trigger,
				.product-block .add-cart .added_to_cart, .product-block .add-cart .button,
				.apus-pagination a:hover,
				.entry-tags-list a:focus, .entry-tags-list a:hover,
				.apus-pagination span.current, .apus-pagination a.current,
				.tagcloud a:focus, .tagcloud a:hover,
				.read-more::before,
				.leaflet-marker-icon > div > span::after,
				.job_filters .price_slider_wrapper .ui-slider-handle, .job_filters .search_distance_wrapper .ui-slider-handle,
				.job_filters .price_slider_wrapper .ui-slider-range, .job_filters .search_distance_wrapper .ui-slider-range,
				.apus-top-cart .mini-cart .count,
				.slick-carousel .slick-arrow:hover, .slick-carousel .slick-arrow:active, .slick-carousel .slick-arrow:focus,
				.slick-carousel .slick-dots li.slick-active button,
				#back-to-top:active, #back-to-top:hover
				{
					background: <?php echo esc_html( cityo_get_config('main_color') ) ?>;
				}
				/* setting color*/
				.post-navigation .navi,
				.post-navigation .meta-nav,
				.show-filter2.active, .show-filter2:hover,
				div.job_listings .job-manager-pagination ul li a.prev i, div.job_listings .job-manager-pagination ul li a.next i, div.job_listings .job-manager-pagination ul li span.prev i, div.job_listings .job-manager-pagination ul li span.next i,
				.apus-bookmark-add:hover,
				.apus-bookmark-not-login:hover,
				.apus-bookmark-added:hover,
				.listing-preview:hover,
				.user-account a:hover, .user-account a:focus,
				div.job_listing .listing-image .apus-bookmark-added,
				.header-top-job .entry-header a:hover, .header-top-job .entry-header a:focus,
				.header-tabs-wrapper ul li a:hover, .header-tabs-wrapper ul li a:active,
				div.my-listing-item-wrapper .right-inner, div.my-listing-item-wrapper .right-inner a,
				.box-banner3:hover .category-icon,.box-banner3:focus .category-icon,
				.megamenu .dropdown-menu li.current-menu-item > a, .megamenu .dropdown-menu li.open > a, .megamenu .dropdown-menu li.active > a,
				.megamenu .dropdown-menu li > a:hover, .megamenu .dropdown-menu li > a:active,
				.widget-features-box.style1 .features-box-image, .widget-features-box.style1 .features-box-image a,
				#apus-header .job_search_form .btn-search-header:hover, #apus-header .job_search_form .btn-search-header:focus,
				.woocommerce table.shop_table th.product-subtotal, .woocommerce table.shop_table td.product-subtotal,
				form.cart .single_add_to_cart_button:hover,
				.product-block:hover .add-cart .added_to_cart, .product-block:hover .add-cart .button,
				.apus-pagination span.prev i, .apus-pagination span.next i, .apus-pagination a.prev i, .apus-pagination a.next i,
				.widget_pages ul > li:hover > a, .widget_meta ul > li:hover > a, .widget_archive ul > li:hover > a, .widget_categories ul > li:hover > a,
				.header-top-job.style-white .entry-header a.apus-bookmark-added, .header-top-job.style-white .entry-header a:hover, .header-top-job.style-white .entry-header a:focus,
				.listing-menu-prices-list h5 span,
				.listing-main-content .listing-hours-inner1 .listing-day.current, .listing-main-content .listing-hours-inner1 .listing-day.current .day,
				.header-tabs-wrapper ul li.active > a,
				.listing-price_range .wrapper-price .listing-price-range.active,
				#listing-hours .widget-title .listing-time.closed,
				.review-avg,.listing-amenity-list li a:hover, .listing-amenity-list li a:hover .amenity-icon,.apus-single-listing .direction-map i,
				.apus-single-listing .direction-map.active, .apus-single-listing .direction-map:hover,
				.sidebar-detail-job .listing-day.current .day,
				.select2-container .select2-results__option--highlighted[aria-selected], .select2-container .select2-results__option--highlighted[data-selected], .select2-container--default .select2-results__option--highlighted[aria-selected], .select2-container--default .select2-results__option--highlighted[data-selected],
				.job_filters .job_tags label.active, .job_filters .job_amenities label.active,
				.slick-carousel .slick-arrow,
				a:hover, a:focus,
				.woocommerce-MyAccount-navigation li.is-active > a
				{
					color: <?php echo esc_html( cityo_get_config('main_color') ) ?>;
				}
				.tt-highlight,
				.highlight, .apus-bookmark-added,
				.text-theme{
					color: <?php echo esc_html( cityo_get_config('main_color') ) ?> !important;
				}
				.widget-testimonials .item.slick-current .testimonials-item .description,
				.bg-theme
				{
					background: <?php echo esc_html( cityo_get_config('main_color') ) ?> !important;
				}
				.pin-st1 {
					fill: <?php echo esc_html( cityo_get_config('main_color') ) ?> !important;
				}
				.job_search_form input:focus{
					-webkit-box-shadow: 0 -2px 0 0 <?php echo esc_html( cityo_get_config('main_color') ) ?> inset;
					box-shadow: 0 -2px 0 0 <?php echo esc_html( cityo_get_config('main_color') ) ?> inset;
				}
			<?php endif; ?>


			/* second color theme */
			<?php if ( cityo_get_config('second_color') != "" && cityo_get_config('main_color') != "" ) : ?>
				.widget-team .team-item::before,
				.box-banner1:after{
					background-image: radial-gradient( farthest-corner at 100% 0, <?php echo esc_html( cityo_get_config('second_color') ) ?>, <?php echo esc_html( cityo_get_config('main_color') ) ?> 70%);
					background-image: -webkit-radial-gradient( farthest-corner at 100% 0, <?php echo esc_html( cityo_get_config('second_color') ) ?>, <?php echo esc_html( cityo_get_config('main_color') ) ?> 70%);
				}
				.box-banner5:after{
					background-image: radial-gradient( farthest-corner at 100% 0, <?php echo esc_html( cityo_get_config('main_color') ) ?>, <?php echo esc_html( cityo_get_config('second_color') ) ?> 80%);
					background-image: -webkit-radial-gradient( farthest-corner at 100% 0, <?php echo esc_html( cityo_get_config('main_color') ) ?>, <?php echo esc_html( cityo_get_config('second_color') ) ?> 80%);
				}
			<?php endif; ?>	


			/* button for theme */
			<?php if ( cityo_get_config('button_color') != "" ) : ?>
				.newsletter .submit-maill,
				.btn-theme, .btn-white.btn-outline:hover, .btn-white.btn-outline:active{
					background: <?php echo esc_html( cityo_get_config('button_color') ) ?>;
					border-color:<?php echo esc_html( cityo_get_config('button_color') ) ?>;
				}
				.btn-theme.btn-outline{
					color:<?php echo esc_html( cityo_get_config('button_color') ) ?>;
					border-color:<?php echo esc_html( cityo_get_config('button_color') ) ?>;
				}
				.listing-products-booking .wc-bookings-booking-form-button.button{
					background: <?php echo esc_html( cityo_get_config('button_color') ) ?> !important;
					border-color:<?php echo esc_html( cityo_get_config('button_color') ) ?> !important;
				}
			<?php endif; ?>

			<?php if ( cityo_get_config('button_hover_color') != "" ) : ?>
				.newsletter .submit-maill:hover,
				.btn-theme:focus,
				.btn-theme:active,
				.btn-theme:hover{
					background: <?php echo esc_html( cityo_get_config('button_hover_color') ) ?>;
					border-color:<?php echo esc_html( cityo_get_config('button_hover_color') ) ?>;
				}

				.btn-theme.btn-outline:active,
				.btn-theme.btn-outline:focus,
				.btn-theme.btn-outline:hover{
					border-color:<?php echo esc_html( cityo_get_config('button_hover_color') ) ?>;
					color:#fff;
					background-color:<?php echo esc_html( cityo_get_config('button_hover_color') ) ?>;
				}
				.listing-products-booking .wc-bookings-booking-form-button.button:hover,.listing-products-booking .wc-bookings-booking-form-button.button:focus{
					background: <?php echo esc_html( cityo_get_config('button_hover_color') ) ?> !important;
					border-color:<?php echo esc_html( cityo_get_config('button_hover_color') ) ?>  !important;
				}
			<?php endif; ?>


			/* Woocommerce Breadcrumbs */
			<?php if ( cityo_get_config('breadcrumbs') == "0" ) : ?>
			.woocommerce .woocommerce-breadcrumb,
			.woocommerce-page .woocommerce-breadcrumb
			{
				display:none;
			}
			<?php endif; ?>

	<?php
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) {
			if (!empty($line)) {
				$new_lines[] = trim($line);
			}
		}
		
		return implode($new_lines);
	}
}