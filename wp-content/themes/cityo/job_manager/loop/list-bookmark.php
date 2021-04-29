<div class="my-listing-item-wrapper job_listing ">
	<div class="row flex-middle-sm">
		<div class="col-md-8 col-sm-9 col-xs-12">
			<div class="flex-middle">
				<?php if ( has_post_thumbnail( $job->ID ) ) {
				?>
					<div class="listing-image">
						<div class="listing-image-inner">
							<?php cityo_display_listing_cover_image('cityo-image-mylisting', true, $job); ?>
							<?php cityo_display_listing_review($job); ?>
						</div>
					</div>
				<?php } ?>
				<div class="listing-content">
					<h3 class="listing-title">
						<?php if ( $job->post_status == 'publish' ) : ?>
							<a href="<?php echo get_permalink( $job->ID ); ?>"><?php echo trim($job->post_title); ?></a>
						<?php else : ?>
							<?php echo trim($job->post_title); ?> <small>(<?php the_job_status( $job ); ?>)</small>
						<?php endif; ?>
					</h3>
					<?php cityo_listing_tagline($job); ?>
					<?php cityo_display_listing_location($job); ?>
					<?php cityo_display_listing_phone($job); ?>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-3 col-xs-12 ali-right">
			<div class="right-inner">
				<a class="view-detail" href="<?php echo get_permalink( $job->ID ); ?>"><i class="flaticon-view-1"></i><?php echo esc_html_e('View Listing','cityo'); ?></a>
				<?php if ( !isset($remove_action) || $remove_action ) { ?>
				<div class="actions-deleted">
					<a href="#remove-bookmark" class="apus-bookmark-remove btn-action no-padding" data-id="<?php echo esc_attr($job->ID); ?>"><i class="flaticon-dustbin"></i><?php esc_html_e('Remove', 'cityo'); ?></a>
				</div>			
				<?php } ?>
			</div>
		</div>
	</div>			
</div>