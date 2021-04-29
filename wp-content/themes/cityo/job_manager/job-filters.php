<?php wp_enqueue_script( 'wp-job-manager-ajax-filters' ); ?>

<?php
	do_action( 'job_manager_job_filters_before', $atts );
	$atts['atts'] = $atts;
	$atts['keywords'] = $keywords;

	$sidebar_position = cityo_get_archive_layout();
	$layout = cityo_get_listing_archive_version();
	$filter_layout = 'v1';
	if ( $layout == 'half-map-v2' ) {
		$filter_layout = 'v2';
	}
?>
<?php get_job_manager_template( 'job-filters-'.$filter_layout.'.php', $atts ); ?>
