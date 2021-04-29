<?php
global $post;
?>
<div <?php job_listing_class('job-grid-style job-grid-place'); ?> <?php echo trim(cityo_display_map_data($post)); ?>>

	<div class="listing-image">
		<?php cityo_display_listing_cover_image('cityo-card-image'); ?>
		<?php do_action( 'cityo-listings-grid-place-flags', $post ); ?>
	</div>
	<div class="bottom-grid">
		<div class="listing-content flex-middle clearfix">
			<?php do_action( 'cityo-listings-grid-place-logo', $post ); ?>
			<div class="listing-content-inner">
				<?php do_action( 'cityo-listings-grid-place-title-above', $post ); ?>
				<h3 class="listing-title">
					<a href="<?php the_job_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
				<?php do_action( 'cityo-listings-grid-place-title-below', $post ); ?>
			</div>
		</div>
		<div class="listing-content-bottom flex-middle clearfix">
			<?php do_action( 'cityo-listings-grid-place-metas', $post ); ?>
		</div>
	</div>
</div>