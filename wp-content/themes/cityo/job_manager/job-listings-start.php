<?php
$sidebar_position = cityo_get_archive_layout();

$layout = cityo_get_listing_archive_version();
$layouts = cityo_get_listing_all_half_map_version();
$class = 'col-md-8 col-xs-12';
if ( $layout == 'default-full' ) {
	$class = 'col-lg-10 no-padding col-md-9 col-xs-12';
}
if ( $sidebar_position == 'main' ) {
	$class = 'col-xs-12';
}
if ( in_array($layout, $layouts) ) {
	$class = '';
}
$class_result = 8;
if($layout == 'default' && $sidebar_position == 'main') {
	$class_result = 4;
}
?>
<div class="<?php echo esc_attr($class); ?> main-results">
	<div class="main-content-listings">
		<?php
		global $wp_query;
		$term =	$wp_query->queried_object;
		$show_title = cityo_get_config('listing_show_cat_title', 0);
		$show_des = cityo_get_config('listing_show_cat_description', 0);
		
		if ( isset($term->taxonomy) && $term->taxonomy == 'job_listing_category' && ($show_title || $show_des) ) { ?>
			
			<div class="listings-cat-description">
				<?php if ( $show_title ) { ?>
					<h2 class="cat-title"><?php echo trim($term->name); ?></h2>
				<?php } ?>
				<?php if ( $show_des ) { ?>
					<div class="description"><?php echo trim($term->description); ?></div>
				<?php } ?>
			</div>
		<?php } ?>

		<div class="listing-action clearfix">
			<div class="row flex-middle">
				<div class="col-xs-6 col-md-<?php echo esc_attr($class_result); ?>">
					<div class="listing-search-result"><div class="results"><?php esc_html_e('0 Results Found', 'cityo'); ?></div></div>
				</div>

				<?php if($layout == 'default' && $sidebar_position == 'main') {?>
					<div class="col-md-4 text-center visible-lg visible-md">
						<span class="show-filter2 ">
							<i class="fas fa-sliders-h" aria-hidden="true"></i><?php echo esc_html__('Search Filters','cityo') ?>
						</span>
					</div>
				<?php } ?>
				<div class="col-xs-6 col-md-4 text-right">
					<?php
						$options = array(
							'default' => esc_html__( 'Default Order', 'cityo' ),
							'date-desc' => esc_html__( 'Newest First', 'cityo' ),
							'date-asc' => esc_html__( 'Oldest First', 'cityo' ),
							'rating-desc' => esc_html__( 'Highest Rating', 'cityo' ),
							'rating-asc' => esc_html__( 'Lowest Rating', 'cityo' ),
							'random' => esc_html__( 'Random', 'cityo' ),
						);
						$default = cityo_get_listing_sortby_default();
					?>
					<div class="listing-orderby">
						<select name="filter_order" autocomplete="off" placeholder="<?php esc_attr_e( 'Sort By', 'cityo' ); ?>">
							<?php foreach ( $options as $id => $option ) : ?>
								<option value="<?php echo esc_attr( $id ); ?>" <?php echo trim($id == $default ? 'selected="selected"' : ''); ?>><?php echo esc_html( $option ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="job_listings job_listings_cards clearfix row loading">