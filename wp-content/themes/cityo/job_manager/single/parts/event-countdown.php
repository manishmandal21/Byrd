<?php
global $post;
$start_date = get_post_meta($post->ID, '_job_start_date', true);
if ( !empty($start_date) ) {
	?>
	<div id="listing-event-countdown" class="listing-event-countdown widget">
		<h2 class="widget-title">
			<span><?php esc_html_e('Event starts in', 'cityo'); ?></span>
		</h2>
		<div class="box-inner">
			<?php
			if ( function_exists('cityo_display_listing_event_countdown') ) {
				cityo_display_listing_event_countdown($post);
			}
			?>

			<?php do_action('cityo-single-listing-event-countdown', $post); ?>
		</div>
	</div>
	<?php
}