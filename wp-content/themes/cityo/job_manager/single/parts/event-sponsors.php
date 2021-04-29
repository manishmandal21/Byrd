<?php
global $post;
$items_data = get_post_meta( $post->ID, '_job_event_sponsors', true );

$event_sponsors = cityo_listing_event_sponsors($items_data);
if ( !empty($event_sponsors) ):
?>
	<div id="listing-event-sponsors" class="listing-event-sponsors widget">
		<h2 class="widget-title">
			<span><?php esc_html_e('Event Sponsors', 'cityo'); ?></span>
		</h2>
		<div class="box-inner">
			<?php
				echo trim($event_sponsors);
			?>

			<?php do_action('cityo-single-listing-event-sponsors', $post); ?>
		</div>
	</div>
<?php endif; ?>