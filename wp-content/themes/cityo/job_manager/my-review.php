<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;
$rating = intval( get_comment_meta( $comment->comment_ID, '_apus_rating_avg', true ) );
$listing = get_post($comment->comment_post_ID);
$rating_mode = cityo_get_config('listing_review_mode', 10);
?>
<li itemprop="review" class="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?>>

	<div class="the-comment">
		<div class="comment-box">
			<div class="comment-heading">
				<div class="clearfix">
					<h3 class="title-job"><span class="title-slogan"><?php esc_html_e('Your review on', 'cityo'); ?></span> <a href="<?php echo esc_url(get_permalink($listing)); ?>"><?php echo esc_attr($listing->post_title); ?></a></h3>
					<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf(esc_attr__( 'Rated %d out of 5', 'cityo' ), $rating ) ?>">
						<?php cityo_display_listing_review_html($rating, $rating_mode); ?>
					</div>
				</div>

				<?php
				$enable_edit = cityo_get_config('listing_review_enable_user_edit_his_review', true);
				if ( $enable_edit && cityo_check_is_review_owner($comment) ) { ?>
					<div class="comment-actions">
						<a href="javascript:void(0);" class="comment-edit-link cityo-edit-comment" data-id="<?php echo esc_attr($comment->comment_ID); ?>"><i class="flaticon-eraser"></i> <?php esc_html_e('Edit', 'cityo'); ?></a>
					</div>
				<?php } ?>

				<div class="info-meta">
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<span class="meta"><em><?php esc_html_e( 'Your comment is awaiting approval', 'cityo' ); ?></em></span>
					<?php else : ?>
						<span class="meta">
							<time itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php echo get_comment_date( 'd M, Y' ); ?></time>
						</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="description"><?php comment_text(); ?></div>
		</div>
	</div>
</li>