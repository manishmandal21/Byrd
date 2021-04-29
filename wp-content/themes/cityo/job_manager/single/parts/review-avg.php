<?php
global $post;
if ( !cityo_listing_review_rating_enable() ) {
	return;
}
$ratings_avg = get_post_meta($post->ID, '_average_ratings', true);

$rating_avg = get_post_meta($post->ID, '_average_rating', true);
$rating_mode = cityo_get_config('listing_review_mode', 10);
$rating_categories = cityo_listing_review_categories();

if ( !empty( $rating_avg ) || !empty($ratings_avg) ) :
	?>
	<div class="review-avg-wrapper widget">
		<h2 class="widget-title">
			<span><?php esc_html_e('Rating Average', 'cityo'); ?></span>
		</h2>
		<div class="box-inner">
			<div class="rating-avg-wrapper text-theme clearfix">
				<div class="rating-avg"><?php echo trim($rating_avg); ?></div>
				<div class="rating-after">
					<div class="rating-mode">/<?php echo trim($rating_mode); ?></div>
					<div class="rating-text"><?php esc_html_e('Average', 'cityo'); ?></div>
				</div>
			</div>
			<?php if ( $ratings_avg && $rating_categories ) { ?>
				<div class="ratings-avg-wrapper">
					<?php foreach ($rating_categories as $key => $val) { ?>
						<div class="ratings-avg-item">
							<div class="rating-label"><?php echo esc_html($val['title']); ?></div>
							<?php if ( !empty($ratings_avg[$key]) ) { ?>
								<div class="rating-value text-theme"><?php echo esc_html($ratings_avg[$key]); ?></div>
							<?php } ?>
						</div>
						
					<?php } ?>
				</div>
			<?php } ?>

			<?php do_action('cityo-single-listing-review-avg', $post); ?>
		</div>
	</div>
<?php endif; ?>
