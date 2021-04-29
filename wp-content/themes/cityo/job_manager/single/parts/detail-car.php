<?php
global $post;

$contract = get_post_meta( $post->ID, '_job_contract', true);
$condition = get_post_meta( $post->ID, '_job_condition', true);
$year = get_post_meta( $post->ID, '_job_year', true);
$nb_of_door = get_post_meta( $post->ID, '_job_nb_of_door', true);
$max_passengers = get_post_meta( $post->ID, '_job_max_passengers', true);
$fuel_type = get_post_meta( $post->ID, '_job_fuel_type', true);
$fuel_per_100 = get_post_meta( $post->ID, '_job_fuel_per_100', true);
$mileage = get_post_meta( $post->ID, '_job_mileage', true);
$interior_color = get_post_meta( $post->ID, '_job_interior_color', true);
$exterior_color = get_post_meta( $post->ID, '_job_exterior_color', true);
$transmission = get_post_meta( $post->ID, '_job_transmission', true);
$displacement = get_post_meta( $post->ID, '_job_displacement', true);

$brands = '';
$terms = get_the_terms( $post->ID, 'job_listing_category' );
if ( ! is_wp_error( $terms ) && ( is_array( $terms ) || is_object( $terms ) ) ) {
	foreach ($terms as $term) {
		$brands .= '<a href="'.get_term_link($term).'">'.$term->name.'</a>';
	}
}


$model = '';
$terms = get_the_terms( $post->ID, 'job_listing_type' );
if ( ! is_wp_error( $terms ) && ( is_array( $terms ) || is_object( $terms ) ) ) {
	foreach ($terms as $term) {
		$model .= '<a href="'.get_term_link($term).'">'.$term->name.'</a>';
	}
}

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

			<?php if ( ! empty( $condition ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Condition', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($condition); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $brands ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Brand', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($brands); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $model ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Model', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($model); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $year ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Manufacturer Year', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($year); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $nb_of_door ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Number of door', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($nb_of_door); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $max_passengers ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Max Passengers', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($max_passengers); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $fuel_type ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Fuel Type', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($fuel_type); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $fuel_per_100 ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Fuel per 100km', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($fuel_per_100); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $mileage ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Mileage', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($mileage); ?> <?php echo cityo_get_config('listing_distance_unit', 'ft'); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $interior_color ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Interior Color', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($interior_color); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $exterior_color ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Exterior Color', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($exterior_color); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $transmission ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Transmission', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($transmission); ?></span>
				</li>
			<?php } ?>

			<?php if ( ! empty( $displacement ) ) { ?>
				<li>
					<span class="text-label"><?php esc_html_e('Displacement', 'cityo'); ?></span>
					<span class="text-value"><?php echo trim($displacement); ?></span>
				</li>
			<?php } ?>

			<?php do_action('cityo-single-listing-car-detail', $post); ?>
		</ul>
		
	</div>
	<!-- form contact -->
</div>