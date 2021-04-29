<?php
$post_id = $_GET['listing_id'];
global $post;
$post = get_post($post_id);

?>
<div class="quickview-wrapper job_listing quickview-event job-grid-style job-grid-event" <?php echo trim(cityo_display_map_data($post)); ?>>
	
	<div class="row no-margin">
		<div class="col-sm-6 no-padding">
			<div class="preview-content-wrapper">
				<div class="preview-content-inner">
					<div class="listing-image">
						<div class="p-relative">
							<?php cityo_display_listing_cover_image('medium_large'); ?>
							<?php do_action( 'cityo-listings-preview-event-flags', $post ); ?>
						</div>
					</div>

					<div class="bottom-grid">
						<div class="listing-content clearfix">
							<div class="listing-content-inner">
								<?php do_action( 'cityo-listings-preview-event-title-above', $post ); ?>
								<div class="listing-title-wrapper">
									<?php do_action( 'cityo-listings-preview-event-logo', $post ); ?>
									<h3 class="listing-title"><a href="<?php echo esc_url(get_permalink($post_id)); ?>"><?php echo get_the_title($post_id); ?></a></h3>
								</div>
								<?php do_action( 'cityo-listings-preview-event-title-below', $post ); ?>
							</div>
						</div>
					</div>
					
					<?php if(get_post_field('post_content', $post_id)){ ?>
						<div class="description ">
							<h3 class="title-des"><?php esc_html_e( 'Description', 'cityo' ); ?></h3>
							<?php echo apply_filters('the_content', get_post_field('post_content', $post_id) ); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-sm-6 no-padding ">
			<div id="apus-preview-listing-map" class="apus-preview-listing-map"></div>
		</div>
	</div>
</div>