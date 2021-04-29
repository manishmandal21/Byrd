<?php
global $post;
$floors = get_post_meta($post->ID, '_job_floor_plans', true);

if ( ! empty( $floors ) ) :
?>
<div id="listing-floor-plans" class="listing-floor-plans widget">
	<h2 class="widget-title">
		<span><?php esc_html_e('Floor Plans', 'cityo'); ?></span>
	</h2>
	
	<div class="box-inner">
		<div class="slick-carousel" data-carousel="slick" data-items="1" data-smallmedium="1" data-extrasmall="1" data-smallest="1" data-pagination="false" data-nav="true">
			<?php foreach ($floors as $img): ?>
				
				
				<a class="photo-item" href="<?php echo esc_url($img); ?>">
					<img src="<?php echo esc_url($img); ?>" alt="<?php esc_attr_e('Floor Plans', 'cityo'); ?>">
				</a>

			<?php endforeach; ?>

			<?php do_action('cityo-single-listing-floor-plans', $post); ?>
		</div>
	</div>
</div>
<?php endif; ?>