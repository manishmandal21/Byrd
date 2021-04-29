<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;

$url = '';
if ( !empty($comment->user_id) ) {
	$data = get_userdata( $comment->user_id );
	$url = cityo_get_user_url($comment->user_id, $data->user_nicename);
}

$enable_like = cityo_get_config('listing_review_enable_like_review', true);
$enable_dislike = cityo_get_config('listing_review_enable_dislike_review', true);
$enable_love = cityo_get_config('listing_review_enable_love_review', true);
$enable_reply = cityo_get_config('listing_review_enable_reply_review', true);
$enable_edit = cityo_get_config('listing_review_enable_user_edit_his_review', true);

?>
<li itemprop="review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="the-comment">
		<div class="avatar">
			<?php if ( !empty($url) ) { ?>
				<a href="<?php echo esc_url($url); ?>">
			<?php } ?>
				<?php echo get_avatar( $comment->user_id, '75', '' ); ?>
			<?php if ( !empty($url) ) { ?>
				</a>
			<?php } ?>
		</div>
		<div class="comment-box">
			<div class="comment-author meta">
				<div class="info-meta-comment clearfix">
					<div class="pull-left">
						<h3 class="title-author">
							<?php if ( !empty($url) ) { ?>
								<a href="<?php echo esc_url($url); ?>">
							<?php } ?>
								<?php comment_author(); ?>
							<?php if ( !empty($url) ) { ?>
								</a>
							<?php } ?>
						</h3> 
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<span class="meta"><em><?php esc_html_e( 'Your comment is awaiting approval', 'cityo' ); ?></em></span>
						<?php else : ?>
							<span class="date">
								<time itemprop="datePublished" datetime="<?php echo get_comment_date( get_option('date_format') ); ?>"><?php echo get_comment_date( get_option('date_format') ); ?></time>
							</span>
						<?php endif; ?>
					</div>
					<?php if ( cityo_listing_review_rating_enable() ) {
						$rating = get_comment_meta( $comment->comment_ID, '_apus_rating_avg', true );
						if ( $rating > 0 ) {
							$rating_mode = cityo_get_config('listing_review_mode', 10);
						?>
							<div class="pull-right">
								<div class="star-rating " title="<?php echo sprintf( esc_attr__( 'Rated %d out of %d', 'cityo' ), $rating, $rating_mode ) ?>">
									<?php cityo_display_listing_review_html($rating, $rating_mode); ?>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
			<div class="comment-text">
				<div class="description">
					<?php comment_text(); ?>
				</div>
				<?php echo Cityo_Attachments::displayAttachment(); ?>
			</div>
			<div id="comment-reply-wrapper-<?php comment_ID(); ?>" class="comment-actions">
				<div id="comment-actions-<?php comment_ID(); ?>" class="clearfix">
					<div class="pull-left">
						<?php if ( $enable_like ) {
							$count = intval( get_comment_meta( $comment->comment_ID, '_apus_like', true ) );
							$check = cityo_check_comment_like_user($comment->comment_ID);
							?>
							<a href="#like-commnent-<?php comment_ID(); ?>" class="comment-like <?php echo esc_attr($check ? 'active' : ''); ?>" data-id="<?php comment_ID(); ?>"><i class="<?php echo esc_attr($check ? 'fas fa-thumbs-up' : 'far fa-thumbs-up'); ?>"></i> <?php echo trim($count); ?></a>
						<?php } ?>

						<?php if ( $enable_dislike ) {
							$count = intval( get_comment_meta( $comment->comment_ID, '_apus_dislike', true ) );
							$check = cityo_check_comment_dislike_user($comment->comment_ID);
							?>
							<a href="#dislike-commnent-<?php comment_ID(); ?>" class="comment-dislike <?php echo esc_attr($check ? 'active' : ''); ?>" data-id="<?php comment_ID(); ?>" ><i class="<?php echo esc_attr($check ? 'fas fa-thumbs-down' : 'far fa-thumbs-down'); ?>"></i> <?php echo trim($count); ?></a>
						<?php } ?>

						<?php if ( $enable_love ) {
							$count = intval( get_comment_meta( $comment->comment_ID, '_apus_love', true ) );
							$check = cityo_check_comment_love_user($comment->comment_ID);
							?>
							<a href="#love-commnent-<?php comment_ID(); ?>" class="comment-love <?php echo esc_attr($check ? 'active' : ''); ?>" data-id="<?php comment_ID(); ?>"><i class="<?php echo esc_attr($check ? 'fas fa-heart' : 'far fa-heart'); ?>"></i> <?php echo trim($count); ?></a>
						<?php } ?>
					</div>
					<div class="pull-right">
						<?php if ( $enable_reply ) { ?>
							<?php comment_reply_link(array_merge( $args, array(
								'reply_text' => '<i class="flaticon-consulting-message"></i> '.esc_html__('Reply', 'cityo'),
								'add_below' => 'comment-reply-wrapper',
								'depth' => 1,
								'max_depth' => $args['max_depth']
							))) ?>
						<?php } ?>

						<?php if ( $enable_edit && cityo_check_is_review_owner($comment) ) { ?>
							<a href="javascript:void(0);" class="comment-edit-link cityo-edit-comment" data-id="<?php comment_ID(); ?>"><i class="flaticon-eraser"></i> <?php esc_html_e('Edit', 'cityo'); ?></a>
						<?php } ?>
					</div>

				</div>
			</div>
		</div>
	</div>
</li>