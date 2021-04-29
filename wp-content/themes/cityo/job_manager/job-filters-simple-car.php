<?php
/**
 * The template for displaying the WP Job Manager Filters on the front page hero
 *
 * @package Cityo
 */

$show_categories = true;
if ( ! get_option( 'job_manager_enable_categories' ) ) {
	$show_categories = false;
}
$show_types = true;
if ( ! get_option( 'job_manager_enable_types' ) ) {
	$show_types = false;
}

$atts = apply_filters( 'job_manager_ouput_jobs_defaut', array(
    'per_page' => get_option( 'job_manager_per_page' ),
    'orderby' => 'featured',
    'order' => 'DESC',
    'show_categories' => $show_categories,
    'show_tags' => false,
    'categories' => true,
    'selected_category' => false,
    'job_types' => false,
    'location' => false,
    'keywords' => false,
    'selected_job_types' => false,
    'show_category_multiselect' => false,
    'selected_region' => false
) );

$classes = '';
if ( isset($enable_autocompleate_search) && $enable_autocompleate_search ) {
    wp_enqueue_script( 'handlebars', get_template_directory_uri() . '/js/handlebars.min.js', array(), null, true);
    wp_enqueue_script( 'typeahead-jquery', get_template_directory_uri() . '/js/typeahead.jquery.js', array('jquery', 'handlebars'), null, true);
    $classes = 'apus-autocompleate-input';
}
?>

<?php do_action( 'job_manager_job_filters_before', $atts ); ?>


<?php

$contracts = array();
$contract_field = cityo_get_field_options('job_contract');
if ( !empty($contract_field['options']) ) {
    $contracts = $contract_field['options'];
}

?>
<ul class="nav nav-tabs">
    <?php $i=0; foreach ($contracts as $key => $title) {
    	if ( empty($key) ) {
	        continue;
	    }
	?>
    	<li class="<?php echo esc_attr($i ==0 ? 'active' : ''); ?>">
    		<a data-toggle="tab" href="#search-car-tab-<?php echo esc_attr($i); ?>"><?php echo esc_html($title); ?></a>
    	</li>
	<?php $i++; } ?>
</ul>
<div class="tab-content">
	<?php $count=0; $i=0; foreach ($contracts as $key => $title) {
		if ( empty($key) ) {
	        continue;
	    }
	    $count++;
		?>
		<div id="search-car-tab-<?php echo esc_attr($i); ?>" class="tab-pane fade in <?php echo esc_attr($i ==0 ? 'active' : ''); ?>">
			<form class="job_search_form  js-search-form" action="<?php echo cityo_get_listings_page_url(); ?>" method="get" role="search">

			<?php if ( ! get_option('permalink_structure') ) {
				//if the permalinks are not activated we need to put the listings page id in a hidden field so it gets passed
				$listings_page_id = get_option( 'job_manager_jobs_page_id', false );
				//only do this in case we do have a listings page selected
				if ( false !== $listings_page_id ) {
					echo '<input type="hidden" name="p" value="' . $listings_page_id . '">';
				}
			} ?>

			<?php do_action( 'job_manager_job_filters_start', $atts ); ?>

			<div class="search_jobs clearfix search_jobs--frontpage">

				<?php do_action( 'job_manager_job_filters_search_jobs_start', $atts ); ?>
				<input type="hidden" name="search_contract" value="<?php echo esc_attr($key); ?>"/>
				<div class="flex-middle-md row-30 clearfix">
        			<!-- keywords -->
            		<?php if ( !empty($settings['search_'.$count.'_keyword']) && $settings['search_'.$count.'_keyword'] ) { ?>
						<div class="search-field-wrapper  search-filter-wrapper">
							<input class="search-field <?php echo esc_attr($classes); ?>" autocomplete="off" type="text" name="search_keywords" placeholder="<?php esc_attr_e( 'What are you looking for?', 'cityo' ); ?>" value="<?php the_search_query(); ?>"/>
						</div>
					<?php } ?>

					<!-- categories -->
					<?php if ( !empty($settings['search_'.$count.'_category']) && $settings['search_'.$count.'_category'] && true === $show_categories && cityo_get_config('listing_filter_show_categories') ) { ?>
				        <div class="search_categories  search-filter-wrapper">
				        	<div class="search_categories_inner">
				            	<?php job_manager_dropdown_categories( array( 'taxonomy' => 'job_listing_category', 'hierarchical' => 1, 'show_option_all' => esc_html__( 'Filter by brand', 'cityo' ), 'placeholder' => esc_html__( 'Filter by brand', 'cityo' ), 'name' => 'search_categories', 'orderby' => 'name', 'multiple' => false, 'hide_empty'  => false ) ); ?>
				            </div>
				        </div>
			        <?php } ?>

			        <!-- types -->
					<?php if ( !empty($settings['search_'.$count.'_type']) && $settings['search_'.$count.'_type'] && true === $show_types && cityo_get_config('listing_filter_show_types') ) { ?>
				        <div class="search_types  search-filter-wrapper">
				        	<?php job_manager_dropdown_categories( array( 'taxonomy' => 'job_listing_type', 'hierarchical' => 1, 'show_option_all' => esc_html__( 'Filter by model', 'cityo' ), 'placeholder' => esc_html__( 'Filter by model', 'cityo' ), 'name' => 'job_type_select', 'orderby' => 'name', 'multiple' => false, 'hide_empty' => false ) ); ?>
				        </div>
			        <?php } ?>


			        <!-- price -->
					<?php if ( !empty($settings['search_'.$count.'_price']) && $settings['search_'.$count.'_price'] && cityo_get_config('listing_filter_show_price_slider') ) { ?>
				        <?php get_job_manager_template( 'filter-fields/price_slider.php', $atts ); ?>
			        <?php } ?>

					<!-- region -->
					<?php if ( !empty($settings['search_'.$count.'_region']) && $settings['search_'.$count.'_region'] && cityo_get_config('listing_filter_show_regions') ) { ?>
						<div class="search_location search-filter-wrapper">
							<?php job_manager_dropdown_categories( array( 'taxonomy' => 'job_listing_region', 'hierarchical' => 1, 'show_option_all' => esc_html__( 'Filter by region', 'cityo' ), 'placeholder' => esc_html__( 'Filter by region', 'cityo' ), 'name' => 'job_region_select', 'orderby' => 'name', 'multiple' => false, 'hide_empty' => false ) ); ?>
						</div>
					<?php } ?>

					<!-- location -->
					<?php if ( !empty($settings['search_'.$count.'_location']) && $settings['search_'.$count.'_location'] && cityo_get_config('listing_filter_show_location') ) { ?>
						<div class="search_location search-filter-wrapper">
							<input type="text" name="search_location" placeholder="<?php esc_attr_e( 'Location', 'cityo' ); ?>" id="search_location<?php echo esc_attr(cityo_get_config('listing_filter_show_distance') ? '_distance' : ''); ?>" />
							<span class="clear-location"><i class="ti-close"></i></span>
							<?php if ( cityo_get_config('listing_filter_show_distance') ) { ?>
								<span class="loading-me"></span>
								<span class="find-me"><?php get_template_part( 'images/icon/location' ); ?></span>
								<input type="hidden" name="search_lat" />
								<input type="hidden" name="search_lng" />
							<?php } ?>
						</div>
					<?php } ?>

					<div class="submit">
						<button class="search-submit btn btn-block btn-theme" name="submit">
							<?php esc_html_e( 'Search', 'cityo' ); ?>
						</button>
					</div>

				</div>
					<?php do_action( 'job_manager_job_filters_search_jobs_end', $atts ); ?>

			</div>
			<div class="filters_end">
				<?php do_action( 'job_manager_job_filters_end', $atts ); ?>
			</div>

			</form>
			
    	</div>
	<?php  $i++; } ?>
		
</div>
	

<?php do_action( 'job_manager_job_filters_after', $atts ); ?>