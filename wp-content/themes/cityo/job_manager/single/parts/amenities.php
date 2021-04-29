<?php
global $post;
$terms = get_the_terms($post->ID, 'job_listing_amenity');

if ( ! is_wp_error( $terms ) && ( is_array( $terms ) || is_object( $terms ) ) ):
?>
	<div id="listing-amenities" class="listing-amenities widget">
		<h2 class="widget-title">
			<span><?php esc_html_e('Listing Amenities', 'cityo'); ?></span>
		</h2>
		
		<div class="box-inner">
			<ul class="listing-amenity-list">
				<?php foreach ( $terms as $term ) {
					$icon = cityo_listing_category_icon($term);
				?>
					<li>
						<a href="<?php echo esc_url(get_term_link($term->term_id, 'job_listing_amenity')); ?>">
							<?php if (!empty($icon)) { ?>
								<span class="left-inner">
									<span class="amenity-icon">
										<?php echo trim($icon); ?>
									</span>
								</span>
							<?php } ?>
							<span class="amenity-title"><?php echo trim($term->name); ?></span>
						</a>
					</li>
				<?php } ?>

				<?php do_action('cityo-single-listing-amenities', $post); ?>
			</ul>
		</div>
	</div>
<?php endif; ?>