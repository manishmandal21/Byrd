<?php
global $apus_author;
$posts_per_page = cityo_get_config('user_profile_listing_number', 25);
$args = array(
	'post_type'           => 'job_listing',
	'post_status'         => array( 'publish' ),
	'ignore_sticky_posts' => 1,
	'posts_per_page'      => $posts_per_page,
	'offset'              => ( max( 1, get_query_var('paged') ) - 1 ) * $posts_per_page,
	'orderby'             => 'date',
	'order'               => 'desc',
	'author'              => $apus_author->ID
);

$jobs_query = new WP_Query;
$jobs = $jobs_query->query( $args );
$max_num_pages = $jobs_query->max_num_pages;
?>

<div id="job-manager-job-dashboard">
	<div class="job-manager-jobs listing-user clearfix">
		<?php if ( ! $jobs ) : ?>
			<div class="text-warning">
				<?php esc_html_e( 'You do not have any active listings.', 'cityo' ); ?>
			</div>
		<?php else :?>
			<div class="box-list-2">
				<?php foreach ( $jobs as $job ) { ?>
					<?php get_job_manager_template( 'job_manager/loop/list-user-listing.php', array('job' => $job) ); ?>
				<?php } ?>
				<?php get_job_manager_template( 'pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>