<?php


// Place: hook loop grid
add_action('cityo-listings-grid-place-logo', 'cityo_display_listing_logo_image', 10, 1);

add_action('cityo-listings-grid-place-flags', 'cityo_display_listing_review', 30, 1);

add_action('cityo-listings-grid-place-title-below', 'cityo_listing_tagline', 10, 1);
add_action('cityo-listings-grid-place-title-below', 'cityo_display_listing_location', 20, 1);
add_action('cityo-listings-grid-place-title-below', 'cityo_display_listing_phone', 30, 1);


add_action('cityo-listings-grid-place-metas', 'cityo_listings_grid_place_metas_before', 8, 1);
add_action('cityo-listings-grid-place-metas', 'cityo_display_listing_first_category', 10, 1);
add_action('cityo-listings-grid-place-metas', 'cityo_display_time_status', 20, 1);
add_action('cityo-listings-grid-place-metas', 'cityo_listings_grid_place_metas_after', 21, 1);

add_action('cityo-listings-grid-place-metas', 'cityo_display_listing_card_btn', 40, 1);


// Place: hook loop list
add_action('cityo-listings-list-place-flags', 'cityo_display_listing_review', 20, 1);

add_action('cityo-listings-list-place-logo', 'cityo_display_listing_logo_image', 10, 1);

add_action('cityo-listings-list-place-title-below', 'cityo_listing_tagline', 10, 1);
add_action('cityo-listings-list-place-title-below', 'cityo_display_listing_location', 20, 1);
add_action('cityo-listings-list-place-title-below', 'cityo_display_listing_phone', 30, 1);

add_action('cityo-listings-list-place-metas', 'cityo_listings_list_place_metas_before', 8, 1);
add_action('cityo-listings-list-place-metas', 'cityo_display_listing_first_category', 10, 1);
add_action('cityo-listings-list-place-metas', 'cityo_display_time_status', 20, 1);
add_action('cityo-listings-list-place-metas', 'cityo_listings_list_place_metas_after', 21, 1);
add_action('cityo-listings-list-place-metas', 'cityo_display_listing_card_btn', 40, 1);



// Place: preview
add_action('cityo-listings-preview-place-logo', 'cityo_display_listing_logo_image', 10, 1);

add_action('cityo-listings-preview-place-flags', 'cityo_display_listing_review', 30, 1);

add_action('cityo-listings-preview-place-title-below', 'cityo_listing_tagline', 10, 1);
add_action('cityo-listings-preview-place-title-below', 'cityo_display_listing_location', 20, 1);
add_action('cityo-listings-preview-place-title-below', 'cityo_display_listing_phone', 30, 1);


add_action('cityo-listings-preview-place-metas', 'cityo_listings_grid_place_metas_before', 8, 1);
add_action('cityo-listings-preview-place-metas', 'cityo_display_listing_first_category', 10, 1);
add_action('cityo-listings-preview-place-metas', 'cityo_display_time_status', 20, 1);
add_action('cityo-listings-preview-place-metas', 'cityo_listings_grid_place_metas_after', 21, 1);

add_action('cityo-listings-preview-place-metas', 'cityo_display_listing_card_bookmark_btn', 40, 1);


// Place: Listing single
add_action('cityo-place-single-listing-header-logo', 'cityo_display_listing_logo_image', 10, 1);

add_action('cityo-place-single-listing-header-title', 'cityo_listing_title', 10, 1);

add_action('cityo-place-single-listing-header-title-bellow', 'cityo_listing_tagline', 10, 1);

add_action('cityo-place-single-listing-header-metas', 'cityo_display_listing_all_categories', 10, 1);
add_action('cityo-place-single-listing-header-metas', 'cityo_display_listing_phone', 20, 1);
add_action('cityo-place-single-listing-header-metas', 'cityo_display_listing_location', 30, 1);


add_action('cityo-place-single-listing-header-right', 'cityo_display_listing_review', 10, 1);
add_action('cityo-place-single-listing-header-right', array('Cityo_Bookmark', 'display_bookmark_btn'), 20, 1);
add_action('cityo-place-single-listing-header-right', 'cityo_listing_review_btn', 30, 1);
add_action('cityo-place-single-listing-header-right', 'cityo_listing_single_socials_share', 40, 1);
