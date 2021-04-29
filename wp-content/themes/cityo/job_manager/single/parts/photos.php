<?php
global $post;
$photos = cityo_get_listing_gallery( $post->ID );
if ( ! empty( $photos ) ) :
	?>
	<div id="listing-photos" class="photos-wrapper widget">
		<h3 class="widget-title"><?php esc_html_e( 'Photos', 'cityo' ); ?></h3>
		
		<div class="listing-photos box-inner">
			<div class="slick-carousel slick-carousel-gallery-main" data-carousel="slick" data-items="1" data-smallmedium="1" data-extrasmall="1" data-margin="0" data-verysmall="1" data-pagination="false" data-nav="true" data-slickparent="true">
				<?php $i = 1; foreach ($photos as $thumb_id): ?>
					<?php
					$image_full = wp_get_attachment_image_src( $thumb_id, 'full' );
					$image_full_url = isset($image_full[0]) ? $image_full[0] : '';
					if ($image_full_url) {
					?>	<div class="item">
							<a class="photo-gallery-item" href="<?php echo esc_url($image_full_url); ?>">
								<?php echo trim(cityo_get_attachment_thumbnail($thumb_id, '700x450')); ?>
							</a>
						</div>
					<?php } ?>
				<?php $i++; endforeach; ?>
			</div>

			<div class="slick-carousel slick-carousel-gallery-thumbnail" data-carousel="slick" data-items="6" data-smallmedium="5" data-extrasmall="5" data-smallest='5' data-pagination="false" data-nav="false" data-asnavfor=".slick-carousel-gallery-main" data-slidestoscroll="1" data-focusonselect="true">
	            <?php foreach ($photos as $thumb_id): ?>
	            	<div class="item">
						<?php
						if ( !empty($thumb_id) ) {
						?>
							<?php echo trim(cityo_get_attachment_thumbnail($thumb_id, 'cityo-thumb-small')); ?>
						<?php } ?>
					</div>
				<?php endforeach; ?>
	        </div>
		</div>
	</div>
<?php endif; ?>