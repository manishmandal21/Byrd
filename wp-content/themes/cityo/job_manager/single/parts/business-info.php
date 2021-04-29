<?php
global $post;
// get our custom meta
$location = get_post_meta( get_the_ID(), '_job_location', true);

$phone = get_post_meta( get_the_ID(), '_job_phone', true);
$email = get_post_meta( get_the_ID(), '_job_email', true);
$website = get_post_meta( get_the_ID(), '_job_website', true);
?>

<div id="listing-business-info" class="listing-business-info widget">
	<h2 class="widget-title">
		<span><?php esc_html_e('Business Info', 'cityo'); ?></span>

		<?php
			$location = get_the_job_location( $post );
			if ( $location ) {
				?>
				<a class="map-direction direction-map pull-right" href="<?php echo esc_url( 'http://maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ) ; ?>" target="_blank">
					<i class="far fa-hand-point-right"></i>
					<?php esc_html_e('Get Directions', 'cityo'); ?>
				</a>
				<?php
			}
		?>
	</h2>
	<div class="box-inner">
		
		<div id="apus-listing-map-sidebar" class="apus-single-listing-map" style="width: 100%; height: 300px;"></div>

		<ul class="business-info">
			<?php
			if ( $location ) { ?>
				<li>
					<span class="text-label"><i class="flaticon-placeholder"></i></span>
					<?php 
						if ( $location ) {
							echo apply_filters( 'the_job_location_map_link', '<a class="google_map_link" href="' . esc_url( 'https://maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ) . '" target="_blank">' . esc_html( strip_tags( $location ) ) . '</a>', $location, $post );
						} else {
							echo wp_kses_post( apply_filters( 'the_job_location_anywhere_text', esc_html__( 'Anywhere', 'cityo' ) ) );
						}
					?>
				</li>
				<?php
			} ?>
			<?php
			if ( ! empty( $phone ) ) : ?>
				<li>
					<span class="text-label"><i class="flaticon-call"></i></span>
					<a class="listing--phone" href="tel:<?php echo trim($phone); ?>" itemprop="telephone"><?php echo trim($phone); ?></a>
				</li>
			<?php endif;

			if ( ! empty( $email ) ) : ?>
				<li>
					<span class="text-label"><i class="flaticon-mail"></i></span>
					<a class="listing--email" href="mailto:<?php echo trim($email); ?>" itemprop="email"><?php echo trim($email); ?></a>
				</li>
			<?php endif;
			
			if ( ! empty($website) ) {
				$website_pure = preg_replace('#^https?://#', '', rtrim(esc_url($website),'/'));
				?>
					<li>
						<span class="text-label"><i class="flaticon-tap"></i></span>
						<a class="listing--website" href="<?php echo esc_url( $website ); ?>" itemprop="url" target="_blank" rel="nofollow"><?php echo trim($website_pure); ?></a>
					</li>
			<?php } ?>
		</ul>
		
		<?php do_action('cityo-single-listing-contact', $post); ?>

		<!-- social icons -->
		<?php

		$socials = get_post_meta( get_the_ID(), '_job_socials', true);
		if ( !empty($socials) ) {
		?>
			<h5 class="title-follow"><?php esc_html_e('Follow Us', 'cityo'); ?></h5>
			<ul class="social-icons">
				<?php foreach ($socials as $social) {
						if ( isset($social['network_url']) ) {
					?>
						<li><a href="<?php echo esc_url($social['network_url']); ?>" class="<?php echo esc_attr( substr($social['network'],7,4) ); ?>" target="_blank"><i class="<?php echo esc_attr(strtolower($social['network'])); ?>"></i></a></li>
					<?php } ?>
				<?php } ?>
			</ul>
		<?php } ?>
	</div>
	<!-- form contact -->
</div>