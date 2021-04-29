<?php
global $post;
?>
<div <?php job_listing_class('job-grid-style job-grid-event'); ?> <?php echo trim(cityo_display_map_data($post)); ?>>

	<div class="listing-image">
		<div class="p-relative">
			<?php cityo_display_listing_cover_image('cityo-card-image'); ?>
			<?php do_action( 'cityo-listings-grid-event-flags', $post ); ?>
		</div>
	</div>
	<div class="bottom-grid">
		<div class="listing-content clearfix">
			<div class="listing-content-inner">
				<?php do_action( 'cityo-listings-grid-event-title-above', $post ); ?>
				<div class="listing-title-wrapper">
					<?php do_action( 'cityo-listings-grid-event-logo', $post ); ?>
					<h3 class="listing-title">
						<a href="<?php the_job_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
				</div>
				<?php do_action( 'cityo-listings-grid-event-title-below', $post ); ?>
			</div>
		</div>
	</div>
</div>