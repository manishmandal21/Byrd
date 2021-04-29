<?php
global $apus_cityo_listing_type;
$sidebar_position = cityo_get_archive_layout();

$layout = cityo_get_listing_archive_version();
$layouts = cityo_get_listing_all_half_map_version();
$sidebar = cityo_get_listings_sidebar_configs();

$wrapper_class = 'col-md-4 col-xs-12 '.$sidebar['class'];
if ( $layout == 'default-full' ) {
	$wrapper_class = 'col-lg-2 no-padding col-md-3 '.$sidebar['class'];
}
if ( $sidebar_position == 'main' ) {
	$wrapper_class = 'col-xs-12';
}
if ( in_array($layout, $layouts) || ($layout == 'default' && $sidebar_position == 'main') ) {
	$wrapper_class = '';
}

$filter_order = cityo_get_listing_sortby_default();
$atts['atts'] = $atts;
$atts['keywords'] = $keywords;
$atts['filter_version'] = 'v1';
if ( $apus_cityo_listing_type == 'car' ) {
	$atts['categories_label'] = esc_html__('Filter by brand', 'cityo');
	$atts['categories_class'] = 'categories_brand';
	$atts['types_label'] = esc_html__('Filter by model', 'cityo');
}
if ( !empty($wrapper_class) ) {
	?>
	<div class="<?php echo esc_attr($wrapper_class); ?>">
	<?php
}
?>
	<div class="wrapper-filters1 filter-v1 clearfix">
			<?php
			$layout = cityo_get_listing_archive_version();
			$layouts = cityo_get_listing_all_half_map_version();

			if( in_array($layout, $layouts)) { ?>
				<div class="mobile-groups-button hidden-lg hidden-md clearfix text-center">
				<button class=" btn btn-sm btn-theme btn-view-map" type="button"><i class="far fa-map"></i> <?php esc_html_e( 'Map View', 'cityo' ); ?></button>
				<button class=" btn btn-sm btn-theme  btn-view-listing hidden-sm hidden-xs" type="button"><i class="fas fa-list"></i> <?php esc_html_e( 'Listing View', 'cityo' ); ?></button>
				</div>
			<?php } ?>
		<span class="show-filter show-filter1 hidden-lg btn btn-xs btn-theme">
			<i class="fas fa-sliders-h"></i>
		</span>
		<form class="job_filters job_filters-location">
			<?php
			$display_mode = cityo_get_listing_display_mode();
			$listing_columns = cityo_get_listing_item_columns();
			?>
			<input type="hidden" name="filter_display_mode" value="<?php echo esc_attr($display_mode); ?>">
			<input type="hidden" name="filter_listing_columns" value="<?php echo esc_attr($listing_columns); ?>">
			<input id="input_filter_order" type="hidden" name="filter_order" value="<?php echo trim($filter_order); ?>">
			<div class="filter-inner search_jobs">
				<?php do_action( 'job_manager_job_filters_start', $atts ); ?>
				<div class="fields-filter list-inner-full">
					<?php do_action( 'job_manager_job_filters_search_jobs_start', $atts ); ?>
					
					<?php
						// car, real estate
						
						get_job_manager_template( 'filter-fields/keyword.php', $atts );

						if ( cityo_get_config('listing_filter_show_contract') ) {
							get_job_manager_template( 'filter-fields/contract.php', $atts );
						}
						// car
						if ( cityo_get_config('listing_filter_show_condition') ) {
							get_job_manager_template( 'filter-fields/condition.php', $atts );
						}

						// all types
						if ( get_option( 'job_manager_enable_categories' ) && cityo_get_config('listing_filter_show_categories') && $show_categories && get_terms( array( 'taxonomy' => 'job_listing_category' ) ) ) {
							get_job_manager_template( 'filter-fields/categories.php', $atts );
						}
						if ( get_option( 'job_manager_enable_types' ) && cityo_get_config('listing_filter_show_types') ) {
							get_job_manager_template( 'filter-fields/types.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_regions') ) {
							get_job_manager_template( 'filter-fields/regions.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_location') ) {
							get_job_manager_template( 'filter-fields/location.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_location') && cityo_get_config('listing_filter_show_distance') ) {
							get_job_manager_template( 'filter-fields/distance.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_price_range') ) {
							get_job_manager_template( 'filter-fields/price_range.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_price_slider') ) {
							get_job_manager_template( 'filter-fields/price_slider.php', $atts );
						}

						// event
						if ( cityo_get_config('listing_filter_show_date') ) {
							get_job_manager_template( 'filter-fields/event_date.php', $atts );
						}

						// car
						if ( cityo_get_config('listing_filter_show_fuel_type') ) {
							get_job_manager_template( 'filter-fields/fuel_type.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_exterior_color') ) {
							get_job_manager_template( 'filter-fields/exterior_color.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_interior_color') ) {
							get_job_manager_template( 'filter-fields/interior_color.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_year') ) {
							get_job_manager_template( 'filter-fields/year.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_mileage') ) {
							get_job_manager_template( 'filter-fields/mileage.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_transmission') ) {
							get_job_manager_template( 'filter-fields/transmission.php', $atts );
						}

						// real estate
						if ( cityo_get_config('listing_filter_show_rooms') ) {
							get_job_manager_template( 'filter-fields/rooms.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_beds') ) {
							get_job_manager_template( 'filter-fields/beds.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_baths') ) {
							get_job_manager_template( 'filter-fields/baths.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_garages') ) {
							get_job_manager_template( 'filter-fields/garages.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_home_area') ) {
							get_job_manager_template( 'filter-fields/home_area.php', $atts );
						}
						if ( cityo_get_config('listing_filter_show_lot_area') ) {
							get_job_manager_template( 'filter-fields/lot_area.php', $atts );
						}
						
						// all types
						if ( cityo_get_config('listing_filter_show_amenities') ) {
							get_job_manager_template( 'filter-fields/amenities.php', $atts );
						}
					?>
					
					<div class="submit-filter">
						<button class="btn btn-theme btn-filter" type="button"><?php esc_html_e( 'Filter', 'cityo' ); ?></button>
					</div>

					<div class="listing-search-result-filter"></div>
					
					<?php do_action( 'job_manager_job_filters_search_jobs_end', $atts ); ?>
				</div>

				<?php do_action( 'job_manager_job_filters_end', $atts ); ?>

				<?php if ( is_tax('job_listing_tag') ) {
					global $wp_query;
					$term =	$wp_query->queried_object;
				?>
					<input type="hidden" value="<?php echo esc_attr($term->slug); ?>" name="filter_job_tag[]">
				<?php } ?>
			</div>
		</form>
	</div>
	<?php do_action( 'job_manager_job_filters_after', $atts ); ?>

	<?php if ( $layout == 'default' || $layout == 'default-full' ) { ?>
		<?php if ( is_active_sidebar( $sidebar['sidebar'] ) ): ?>
	  		<aside class="sidebar" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	   			<?php dynamic_sidebar( $sidebar['sidebar'] ); ?>
	   		</aside>
   		<?php endif; ?>
   	<?php } ?>

<?php
if ( !empty($wrapper_class) ) {
	?>
	</div>
	<?php
}	