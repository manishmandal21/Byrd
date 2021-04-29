<?php
global $post;
$items_data = get_post_meta( $post->ID, '_job_event_schedule', true );

$event_schedule = cityo_listing_event_schedule($items_data);
if ( !empty($event_schedule) ):
?>
	<div id="listing-event-schedule" class="listing-event-schedule widget">
		<h2 class="widget-title">
			<span><?php esc_html_e('Event Schedule', 'cityo'); ?></span>
		</h2>
		<div class="box-inner">
			<?php
				echo trim($event_schedule);
			?>

			<?php do_action('cityo-single-listing-event-schedule', $post); ?>
		</div>
	</div>
<?php endif; ?>