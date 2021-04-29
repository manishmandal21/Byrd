<?php
global $post;
$items_data = get_post_meta( $post->ID, '_job_event_speakers', true );

$event_speakers = cityo_listing_event_speakers($items_data);
if ( !empty($event_speakers) ):
?>
	<div id="listing-event-speakers" class="listing-event-speakers widget">
		<h2 class="widget-title">
			<span><?php esc_html_e('Event Speakers', 'cityo'); ?></span>
		</h2>
		<div class="box-inner">
			<?php
				echo trim($event_speakers);
			?>

			<?php do_action('cityo-single-listing-event-speakers', $post); ?>
		</div>
	</div>
<?php endif; ?>