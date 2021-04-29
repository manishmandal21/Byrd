<?php
global $post;
$video = get_post_meta($post->ID, '_job_video', true);
if ($video) {
	?>
	<div id="listing-video" class="listing-video widget">
		<h2 class="widget-title">
			<span><?php esc_html_e('Video', 'cityo'); ?></span>
		</h2>
		<?php cityo_listing_video($post); ?>
	</div>
	<?php
}
?>