<?php
global $post;
?>
<div id="listing-maps" class="listing-map">
	<h2 class="widget-title">
		<span><?php esc_html_e('Maps', 'cityo'); ?></span>
	</h2>
	<div class="box-inner p-relative">
		<div class="top-nav">
			<a href="#maps" class="direction-map top-nav-map active"><i class="fas fa-map"></i> <?php esc_html_e('Map', 'cityo'); ?></a>
			<?php if ( cityo_get_config('listing_map_style_type') == 'default' ) { ?>
				<a href="#maps-street" class="direction-map top-nav-street-view"><i class="fas fa-street-view"></i> <?php esc_html_e('Street View', 'cityo'); ?></a>
			<?php } ?>
			<?php
				$location = get_the_job_location( $post );
				if ( $location ) {
					?>
					<a class="map-direction direction-map" href="<?php echo esc_url( 'http://maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ) ; ?>" target="_blank">
						<i class="far fa-hand-point-right"></i>
						<?php esc_html_e('Get Directions', 'cityo'); ?>
					</a>
					<?php
				}
			?>
		</div>
		<div id="apus-listing-map" class="apus-single-listing-map"></div>
		
		<?php if ( cityo_get_config('listing_map_style_type') == 'default' ) { ?>
			<div id="apus-listing-map-street-view" class="apus-single-listing-map-street-view"></div>
		<?php } ?>

		<?php do_action('cityo-single-listing-maps', $post); ?>
	</div>
</div>