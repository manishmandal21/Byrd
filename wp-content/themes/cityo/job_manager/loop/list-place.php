<?php
global $post;
?>
<div <?php job_listing_class('job-list-style job-list-place'); ?> <?php echo trim(cityo_display_map_data($post)); ?>>

	<div class="flex-middle row">
		<div class="col-xs-4 col-sm-5">
		<div class="listing-image">
			<?php cityo_display_listing_cover_image('cityo-list-image'); ?>
			<?php do_action( 'cityo-listings-list-place-flags', $post ); ?>
			<?php do_action( 'cityo-listings-list-place-logo', $post ); ?>
		</div>
		</div>
		<div class="col-xs-8 col-sm-7">
			<div class="inner-right">
				<div class="listing-content flex-middle clearfix">
					<div class="listing-content-inner">
						<?php do_action( 'cityo-listings-list-place-title-above', $post ); ?>
						<h3 class="listing-title">
							<a href="<?php the_job_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<?php do_action( 'cityo-listings-list-place-title-below', $post ); ?>
					</div>
				</div>
				<div class="listing-content-bottom flex-middle clearfix">
					<?php do_action( 'cityo-listings-list-place-metas', $post ); ?>
				</div>
			</div>
		</div>
	</div>
</div>