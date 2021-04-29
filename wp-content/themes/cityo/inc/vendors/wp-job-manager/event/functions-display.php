<?php


function cityo_display_listing_event_countdown( $post ) {
	$start_date = get_post_meta($post->ID, '_job_start_date', true);
	if ( !empty($start_date) ) {
		$time = strtotime($start_date);
		?>
		<div class="listing-countdown">
			<div class="apus-countdown" data-time="timmer"
	         data-date="<?php echo date('m',$time).'-'.date('d',$time).'-'.date('Y',$time).'-'. date('H',$time) . '-' . date('i',$time) . '-' .  date('s',$time) ; ?>">
	    	</div>
		</div>
		<?php
	}
}


function cityo_display_listing_event_month_day( $post ) {
	$start_date = get_post_meta($post->ID, '_job_start_date', true);
	if ( !empty($start_date) ) {
		$start_date = strtotime($start_date);
		?>
		<div class="listing-date">
			<?php echo date_i18n( 'M ', $start_date ); ?>
			<span class="day"><?php echo date_i18n( '/ d', $start_date ); ?></span>
		</div>
		<?php
	}
}

function cityo_display_listing_event_start_time( $post ) {
	$start_date = get_post_meta($post->ID, '_job_start_date', true);
	if ( !empty($start_date) ) {
		$start_date = strtotime($start_date);
		?>
		<div class="listing-date">
			<i class="flaticon-event"></i>
			<?php echo date_i18n( get_option('time_format'), $start_date ); ?>
		</div>
		<?php
	}
}


function cityo_display_listing_event_start_date( $post ) {
	$start_date = get_post_meta($post->ID, '_job_start_date', true);
	if ( !empty($start_date) ) {
		$start_date = strtotime($start_date);
		?>
		<div class="listing-date">
			<i class="flaticon-event"></i>
			<?php echo date_i18n( get_option('date_format'), $start_date ).' - '. date_i18n( get_option('time_format'), $start_date ); ?>
		</div>
		<?php
	}
}

function cityo_display_listing_event_finish_date( $post ) {
	$finish_date = get_post_meta($post->ID, '_job_finish_date', true);
	if ( !empty($finish_date) ) {
		$finish_date = strtotime($finish_date);
		?>
		<div class="listing-date">
			<i class="flaticon-eventr"></i>
			<?php echo date_i18n( get_option('date_format'), $finish_date ).' - '. date_i18n( get_option('time_format'), $finish_date ); ?>
		</div>
		<?php
	}
}

function cityo_display_listing_event_preview($post) {
	?>
	<div class="listing-btn-wrapper listing-preview-wrapper">
		<a href="#preview-<?php echo esc_attr($post->ID); ?>" class="listing-preview" data-id="<?php echo esc_attr($post->ID); ?>" title="<?php esc_attr_e('Preview', 'cityo'); ?>"><i class="flaticon-zoom-in"></i></a>
	</div>
	<?php
}

// Event: hook loop grid
add_action('cityo-listings-grid-event-logo', 'cityo_display_listing_logo_image', 10, 1);

add_action('cityo-listings-grid-event-flags', 'cityo_display_listing_event_month_day', 10, 1);
add_action('cityo-listings-grid-event-flags', 'cityo_display_listing_review', 20, 1);
add_action('cityo-listings-grid-event-flags', array( 'Cityo_Bookmark', 'display_bookmark_btn'), 30, 1);
add_action('cityo-listings-grid-event-flags', 'cityo_display_listing_event_preview', 30, 1);

add_action('cityo-listings-grid-event-title-below', 'cityo_display_listing_location', 20, 1);
add_action('cityo-listings-grid-event-title-below', 'cityo_display_listing_event_start_date', 30, 1);



// Event: hook loop list
add_action('cityo-listings-list-event-logo', 'cityo_display_listing_logo_image', 10, 1);

add_action('cityo-listings-list-event-flags', 'cityo_display_listing_event_month_day', 10, 1);
add_action('cityo-listings-list-event-flags', 'cityo_display_listing_review', 20, 1);
add_action('cityo-listings-list-event-flags', 'cityo_display_listing_card_btn', 21, 1);

add_action('cityo-listings-list-event-title-below', 'cityo_display_listing_location', 20, 1);
add_action('cityo-listings-list-event-title-below', 'cityo_display_listing_event_start_date', 30, 1);
add_action('cityo-listings-list-event-title-below', 'cityo_display_listing_phone', 31, 1);


// Event: Preview
add_action('cityo-listings-preview-event-logo', 'cityo_display_listing_logo_image', 10, 1);

add_action('cityo-listings-preview-event-flags', 'cityo_display_listing_event_month_day', 10, 1);
add_action('cityo-listings-preview-event-flags', 'cityo_display_listing_review', 20, 1);
add_action('cityo-listings-preview-event-flags', array( 'Cityo_Bookmark', 'display_bookmark_btn'), 30, 1);
add_action('cityo-listings-preview-event-flags', 'cityo_display_listing_event_preview', 30, 1);

add_action('cityo-listings-preview-event-title-below', 'cityo_display_listing_location', 20, 1);
add_action('cityo-listings-preview-event-title-below', 'cityo_display_listing_event_start_date', 30, 1);


// Event: Listing single
add_action('cityo-event-single-listing-header-logo', 'cityo_display_listing_logo_image', 10, 1);

add_action('cityo-event-single-listing-header-title', 'cityo_listing_title', 10, 1);

add_action('cityo-event-single-listing-header-title-bellow', 'cityo_listing_tagline', 10, 1);

add_action('cityo-event-single-listing-header-metas', 'cityo_display_listing_all_categories', 10, 1);
add_action('cityo-event-single-listing-header-metas', 'cityo_display_listing_phone', 20, 1);
add_action('cityo-event-single-listing-header-metas', 'cityo_display_listing_location', 30, 1);


add_action('cityo-event-single-listing-header-right', 'cityo_display_listing_review', 10, 1);
add_action('cityo-event-single-listing-header-right', array('Cityo_Bookmark', 'display_bookmark_btn'), 20, 1);
add_action('cityo-event-single-listing-header-right', 'cityo_listing_review_btn', 30, 1);
add_action('cityo-event-single-listing-header-right', 'cityo_listing_single_socials_share', 40, 1);
