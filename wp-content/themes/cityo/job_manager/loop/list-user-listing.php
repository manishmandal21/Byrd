<div class="my-listing-item-wrapper job_listing ">
	<div class="flex-middle">
		<?php
		if ( has_post_thumbnail( $job->ID ) ) {
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
					<?php echo trim($job->post_title); ?>
				<?php endif; ?>
			</h3>
			<?php cityo_listing_tagline($job); ?>
			<?php cityo_display_listing_location($job); ?>
			<?php cityo_display_listing_phone($job); ?>
		</div>
	</div>
</div>