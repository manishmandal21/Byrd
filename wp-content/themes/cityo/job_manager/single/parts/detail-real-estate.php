<?php
global $post;

$rooms = get_post_meta( $post->ID, '_job_rooms', true);
$beds = get_post_meta( $post->ID, '_job_beds', true);
$baths = get_post_meta( $post->ID, '_job_baths', true);
$garages = get_post_meta( $post->ID, '_job_garages', true);
$home_area = get_post_meta( $post->ID, '_job_home_area', true);
$lot_demensions = get_post_meta( $post->ID, '_job_lot_demensions', true);
$lot_area = get_post_meta( $post->ID, '_job_lot_area', true);
$year_built = get_post_meta( $post->ID, '_job_year_built', true);
$contract = get_post_meta( $post->ID, '_job_contract', true);
$regions = cityo_listing_regions($post);

?>

<div id="listing-detail" class="listing-detail widget">
	<h2 class="widget-title">
		<span><?php esc_html_e('Detail', 'cityo'); ?></span>
	</h2>
	<div class="box-inner">
		<ul>
			<?php if ( ! empty( $contract ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Contract', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($contract); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $regions ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Location', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($regions); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $year_built ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Year Built', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($year_built); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $rooms ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Rooms', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($rooms); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $beds ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Beds', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($beds); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $baths ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Baths', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($baths); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $garages ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Garages', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($garages); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $home_area ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Home Area', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($home_area); ?> <?php echo cityo_get_config('listing_area_unit', 'sqft'); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $lot_demensions ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Lot Demensions', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($lot_demensions); ?> <?php echo cityo_get_config('listing_distance_unit', 'ft'); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $lot_area ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Lot Area', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($lot_area); ?> <?php echo cityo_get_config('listing_area_unit', 'sqft'); ?></span>
				</li>
			<?php } ?>

			<?php do_action('cityo-single-listing-real-estate-detail', $post); ?>

		</ul>
		
	</div>
	<!-- form contact -->
</div>