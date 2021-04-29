<?php
global $post;
$photos = cityo_get_listing_gallery( $post->ID );
if ( ! empty( $photos ) ) :
?>
	<div class="container-fluid no-padding">
		<div class="entry-featured-carousel gallery-listing">
			<div class="slick-carousel" data-carousel="slick" data-items="4" data-smallmedium="3" data-extrasmall="3" data-margin="0" data-smallest="2" data-pagination="false" data-nav="true">
				<?php foreach ($photos as $thumb_id): ?>
					
					<?php
					$image_full = wp_get_attachment_image_src( $thumb_id, 'full' );
					$image_full_url = isset($image_full[0]) ? $image_full[0] : '';
					if ($image_full_url) {
					?>
						<a class="photo-gallery-item" href="<?php echo esc_url($image_full_url); ?>">
							<?php echo cityo_get_attachment_thumbnail($thumb_id, 'cityo-image-gallery'); ?>
							<span class="click-view">
								<span class="flaticon-magnifying-glass"></span>
							</span>
						</a>
					<?php } ?>

				<?php endforeach; ?>

				<?php do_action('cityo-single-listing-gallery', $post); ?>
			</div>
		</div>
	</div>
<?php endif; ?>