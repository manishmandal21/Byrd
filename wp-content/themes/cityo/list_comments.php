<?php

$GLOBALS['comment'] = $comment;
$add_below = '';

?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

	<div class="the-comment">
		<?php if(get_avatar($comment)){ ?>
			<div class="avatar">
				<?php echo get_avatar($comment->user_id, 75); ?>
			</div>
		<?php } ?>
		<div class="comment-box">
			<div class="comment-author meta">
				<div class="info-meta-comment clearfix">
					<div class="pull-left inner-left">
						<h3 class="title-author"><?php echo get_comment_author_link() ?></h3>
						<div class="date"><?php printf(esc_html__('%1$s', 'cityo'), get_comment_date()) ?></div>
					</div>
					<div class="pull-right action">
						<?php edit_comment_link('<i class="flaticon-eraser"></i>'.esc_html__('Edit', 'cityo'),'  ','') ?>
						<?php comment_reply_link(array_merge( $args, array( 'reply_text' => '<i class="flaticon-consulting-message"></i>'.esc_html__(' Reply', 'cityo'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
					</div>
				</div>
			</div>
			<div class="comment-text">
				<?php if ($comment->comment_approved == '0') : ?>
				<em><?php esc_html_e('Your comment is awaiting moderation.', 'cityo') ?></em>
				<br />
				<?php endif; ?>
				<?php comment_text() ?>
			</div>
		</div>
	</div>
</li>