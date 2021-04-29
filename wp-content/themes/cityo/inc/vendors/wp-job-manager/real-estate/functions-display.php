<?php

function cityo_display_listing_real_estate_contract($post) {
	$contract = get_post_meta($post->ID, '_job_contract', true);
	if ( !empty($contract) ) {
		?>
		<div class="listing-contract"><?php echo trim($contract); ?></div>
		<?php
	}
}

function cityo_display_listing_real_estate_metas($post) {
	$rooms = get_post_meta($post->ID, '_job_rooms', true);
	$beds = get_post_meta($post->ID, '_job_beds', true);
	$baths = get_post_meta($post->ID, '_job_baths', true);
	$area = get_post_meta($post->ID, '_job_lot_area', true);
	$garages = get_post_meta($post->ID, '_job_garages', true);
	if ( $beds || $baths || $area || $garages ) {
		?>
		<div class="property-box-meta">
			<?php if ( ! empty( $rooms ) ) { ?>
                <div class="field-item">
                    <?php echo esc_html__('Rooms:', 'cityo'); ?>
                    <span><?php echo esc_html($rooms); ?></span>
                </div>
            <?php } ?>
			<?php if ( ! empty( $beds ) ) { ?>
                <div class="field-item">
                    <?php echo esc_html__('Beds:', 'cityo'); ?>
                    <span><?php echo esc_html($beds); ?></span>
                </div>
            <?php } ?>
            <?php if ( ! empty( $baths ) ) { ?>
                <div class="field-item">
                    <?php echo esc_html__('Baths:', 'cityo'); ?>
                    <span><?php echo esc_html($baths); ?></span>
                </div>
            <?php } ?>
            <?php if ( ! empty( $area ) ) { ?>
                <div class="field-item">
                    <?php echo esc_html__('Area:', 'cityo'); ?>
                    <span><?php echo esc_html($area); ?> <?php echo cityo_get_config('listing_area_unit', 'sqft'); ?></span>
                </div>
            <?php } ?>
            <?php if ( ! empty( $garages ) ) { ?>
                <div class="field-item">
                    <?php echo esc_html__('Garages:', 'cityo'); ?>
                    <span><?php echo esc_html($garages); ?></span>
                </div>
            <?php } ?>
		</div>
		<?php
	}
}

function cityo_display_listing_real_estate_author($post) {
	$author_id = $post->post_author;
	$userdata = get_userdata( $author_id );
	if ( !empty($userdata->display_name) ) {
		?>
		<div class="listing-author">
			<i class="flaticon-user"></i>
			<span><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo wp_kses_post($userdata->display_name); ?></a></span>
		</div>
		<?php
	}
}

function cityo_display_listing_real_estate_post_time($post) {
	$time = strtotime($post->post_date);
	?>
	<div class="listing-publish-date ali-right">
		<i class="flaticon-event"></i>
		<span><?php echo human_time_diff($time, current_time('timestamp')); ?></span>
	</div>
	<?php
}

function cityo_listing_display_real_estate_price($post) {
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

// Real Estate: hook loop grid
add_action('cityo-listings-grid-real-estate-flags', 'cityo_listing_display_real_estate_price', 10, 1);
add_action('cityo-listings-grid-real-estate-flags', 'cityo_display_listing_card_btn', 20, 1);
add_action('cityo-listings-grid-real-estate-flags', 'cityo_display_listing_real_estate_contract', 30, 1);

add_action('cityo-listings-grid-real-estate-title-below', 'cityo_display_listing_location', 10, 1);
add_action('cityo-listings-grid-real-estate-title-below', 'cityo_display_listing_real_estate_metas', 20, 1);

add_action('cityo-listings-grid-real-estate-metas', 'cityo_display_listing_real_estate_author', 10, 1);
add_action('cityo-listings-grid-real-estate-metas', 'cityo_display_listing_real_estate_post_time', 20, 1);


// Real Estate: hook loop list
add_action('cityo-listings-list-real-estate-flags', 'cityo_listing_display_real_estate_price', 10, 1);
add_action('cityo-listings-list-real-estate-flags', 'cityo_display_listing_card_btn', 20, 1);
add_action('cityo-listings-list-real-estate-flags', 'cityo_display_listing_real_estate_contract', 30, 1);

add_action('cityo-listings-list-real-estate-title-below', 'cityo_display_listing_location', 10, 1);
add_action('cityo-listings-list-real-estate-title-below', 'cityo_display_listing_real_estate_metas', 20, 1);
add_action('cityo-listings-list-real-estate-title-below', 'cityo_display_listing_phone', 21, 1);

add_action('cityo-listings-list-real-estate-metas', 'cityo_display_listing_real_estate_author', 10, 1);
add_action('cityo-listings-list-real-estate-metas', 'cityo_display_listing_real_estate_post_time', 20, 1);


// Real Estate: Preview
add_action('cityo-listings-preview-real-estate-flags', 'cityo_listing_display_real_estate_price', 10, 1);
add_action('cityo-listings-preview-real-estate-flags', 'cityo_display_listing_card_bookmark_btn', 20, 1);
add_action('cityo-listings-preview-real-estate-flags', 'cityo_display_listing_real_estate_contract', 30, 1);

add_action('cityo-listings-preview-real-estate-title-below', 'cityo_display_listing_location', 10, 1);
add_action('cityo-listings-preview-real-estate-title-below', 'cityo_display_listing_real_estate_metas', 20, 1);

add_action('cityo-listings-preview-real-estate-metas', 'cityo_display_listing_real_estate_author', 10, 1);
add_action('cityo-listings-preview-real-estate-metas', 'cityo_display_listing_real_estate_post_time', 20, 1);


// Real Estate: Listing single
add_action('cityo-real-estate-single-listing-header-logo', 'cityo_display_listing_logo_image', 10, 1);

add_action('cityo-real-estate-single-listing-header-title', 'cityo_listing_title', 10, 1);
add_action('cityo-real-estate-single-listing-header-title', 'cityo_display_listing_real_estate_contract', 20, 1);

add_action('cityo-real-estate-single-listing-header-title-bellow', 'cityo_listing_tagline', 10, 1);

add_action('cityo-real-estate-single-listing-header-metas', 'cityo_display_listing_all_types', 10, 1);
add_action('cityo-real-estate-single-listing-header-metas', 'cityo_display_listing_phone', 20, 1);
add_action('cityo-real-estate-single-listing-header-metas', 'cityo_display_listing_location', 30, 1);


add_action('cityo-real-estate-single-listing-header-right', 'cityo_display_listing_review', 10, 1);
add_action('cityo-real-estate-single-listing-header-right', array('Cityo_Bookmark', 'display_bookmark_btn'), 20, 1);
add_action('cityo-real-estate-single-listing-header-right', 'cityo_listing_review_btn', 30, 1);
add_action('cityo-real-estate-single-listing-header-right', 'cityo_listing_single_socials_share', 40, 1);

add_action('cityo-real-estate-single-listing-nav-right', 'cityo_listing_display_real_estate_price', 10, 1);
