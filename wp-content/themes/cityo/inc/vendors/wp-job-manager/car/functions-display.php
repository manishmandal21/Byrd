<?php

function cityo_display_listing_car_contract($post) {
	$contract = get_post_meta($post->ID, '_job_contract', true);
	if ( !empty($contract) ) {
		?>
		<div class="listing-contract"><?php echo trim($contract); ?></div>
		<?php
	}
}

function cityo_display_listing_car_metas($post) {
	$year = get_post_meta($post->ID, '_job_year', true);
	$fuel_type = get_post_meta($post->ID, '_job_fuel_type', true);
	$transmission = get_post_meta($post->ID, '_job_transmission', true);
	$mileage = get_post_meta($post->ID, '_job_mileage', true);
	if ( $year || $fuel_type || $transmission || $mileage ) {
		?>
		<ul class="car-metas">
			<?php if ( ! empty( $year ) ) { ?>
                <li>
                    <span><?php echo esc_html($year); ?></span>
                </li>
            <?php } ?>
            <?php if ( ! empty( $fuel_type ) ) { ?>
                <li>
                    <span><?php echo esc_html($fuel_type); ?></span>
                </li>
            <?php } ?>
            <?php if ( ! empty( $transmission ) ) { ?>
                <li>
                    <span><?php echo esc_html($transmission); ?></span>
                </li>
            <?php } ?>
            <?php if ( ! empty( $mileage ) ) { ?>
                <li>
                    <span><?php echo esc_html($mileage); ?> <?php echo cityo_get_config('listing_distance_unit', 'ft'); ?></span>
                </li>
            <?php } ?>
		</ul>
		<?php
	}
}

function cityo_listing_display_car_price($post) {
	$price = get_post_meta($post->ID, '_job_price', true);
	$prefix = get_post_meta( $post->ID, '_job_price_prefix', true );
	$suffix = get_post_meta( $post->ID, '_job_price_suffix', true );
	if ( $price ) {
		$price_html = cityo_listing_display_price($price, false);
		$price_html = '<span class="price-main">'.$price_html.'</span>';

		if ( ! empty( $prefix ) ) {
			$price_html = '<span class="price-prefix">'. $prefix . '</span> '.$price_html;
		}

		if ( ! empty( $suffix ) ) {
			$price_html =  $price_html . '<span class="price-suffix"> ' . $suffix. '</span>';
		}
		?>
		<div class="listing-price">
			<?php echo wp_kses_post($price_html); ?>
		</div>
		<?php
	}
}


// Car: hook loop grid
add_action('cityo-listings-grid-car-flags', 'cityo_listing_display_car_price', 10, 1);
add_action('cityo-listings-grid-car-flags', 'cityo_display_listing_card_btn', 20, 1);
add_action('cityo-listings-grid-car-flags', 'cityo_display_listing_first_category', 30, 1);
add_action('cityo-listings-grid-car-flags', 'cityo_display_listing_car_metas', 40, 1);

add_action('cityo-listings-grid-car-title-below', 'cityo_display_listing_location', 10, 1);


// Car: hook loop list
add_action('cityo-listings-list-car-flags', 'cityo_listing_display_car_price', 10, 1);
add_action('cityo-listings-list-car-flags', 'cityo_display_listing_card_btn', 20, 1);
add_action('cityo-listings-list-car-flags', 'cityo_display_listing_first_category', 30, 1);
add_action('cityo-listings-list-car-flags', 'cityo_display_listing_car_metas', 40, 1);

add_action('cityo-listings-list-car-title-below', 'cityo_listing_tagline', 10, 1);
add_action('cityo-listings-list-car-title-below', 'cityo_display_listing_location', 10, 1);
add_action('cityo-listings-list-car-title-below', 'cityo_display_listing_phone', 30, 1);


// Car: Preview
add_action('cityo-listings-preview-car-flags', 'cityo_listing_display_car_price', 10, 1);
add_action('cityo-listings-preview-car-flags', 'cityo_display_listing_card_bookmark_btn', 20, 1);
add_action('cityo-listings-preview-car-flags', 'cityo_display_listing_first_category', 30, 1);
add_action('cityo-listings-preview-car-flags', 'cityo_display_listing_car_metas', 40, 1);

add_action('cityo-listings-preview-car-title-below', 'cityo_display_listing_location', 10, 1);



// Car: Listing single
add_action('cityo-car-single-listing-header-logo', 'cityo_display_listing_logo_image', 10, 1);

add_action('cityo-car-single-listing-header-title', 'cityo_listing_title', 10, 1);
add_action('cityo-car-single-listing-header-title', 'cityo_display_listing_car_contract', 20, 1);

add_action('cityo-car-single-listing-header-title-bellow', 'cityo_listing_tagline', 10, 1);

add_action('cityo-car-single-listing-header-metas', 'cityo_display_listing_all_types', 10, 1);
add_action('cityo-car-single-listing-header-metas', 'cityo_display_listing_phone', 20, 1);
add_action('cityo-car-single-listing-header-metas', 'cityo_display_listing_location', 30, 1);


add_action('cityo-car-single-listing-header-right', 'cityo_display_listing_review', 10, 1);
add_action('cityo-car-single-listing-header-right', array('Cityo_Bookmark', 'display_bookmark_btn'), 20, 1);
add_action('cityo-car-single-listing-header-right', 'cityo_listing_review_btn', 30, 1);
add_action('cityo-car-single-listing-header-right', 'cityo_listing_single_socials_share', 40, 1);

add_action('cityo-car-single-listing-nav-right', 'cityo_listing_display_car_price', 10, 1);