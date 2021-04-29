<article id="post-<?php the_ID(); ?>" <?php post_class('detail-listing-car detail-listing-car-v1 apus-single-listing-wrapper'); ?> <?php echo trim(cityo_display_map_data($post)); ?>>
	
	<?php
	global $post;
	$attach_id = get_post_thumbnail_id( $post->ID );
	$style = '';
	if ( !empty($attach_id) ) {
		$img = wp_get_attachment_image_src($attach_id, 'cityo-image-full');
		if ( !empty($img[0]) ) {
			$style = 'style="background-image:url('.$img[0].')"';
		}
	}
	?>
	<div class="header-gallery-wrapper header-top-job style-white" <?php echo trim($style); ?>>
		<?php get_template_part( 'job_manager/single/parts/header-car' ); ?>
	</div>
	<?php
		$block_contents = array();
	?>
	<div class="panel-affix-wrapper">
		<div class="header-tabs-wrapper panel-affix">
			<div class="container flex-middle">
				<div class="header-tabs-nav">
					<ul class="nav">
						<?php
						$contents = cityo_get_content_sort();
						$default_contents = cityo_get_default_blocks_content();
						if ( !empty($contents) ) {
							foreach ($contents as $key => $title) {
								$content = trim(cityo_listing_display_part($key));
								if ( !empty($content) ) {
									$block_contents[$key] = $content;
									?>
									<li>
										<a href="#listing-<?php echo esc_attr($key); ?>">
											<?php if ( !empty($default_contents[$key]) ) {
												echo esc_html($default_contents[$key]);
											} else {
												echo esc_html($title);
											} ?>
										</a>
									</li>
									<?php
								}
							}
						}
						?>
					</ul>
				</div>
				<div class="ali-right">
					<?php do_action('cityo-car-single-listing-nav-right', $post) ?>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="entry-listing-content">
			<?php
			$job_manager = $GLOBALS['job_manager'];
			
			ob_start();

			do_action( 'job_content_start' );
			
			get_job_manager_template( 'single/content-default.php', array('block_contents' => $block_contents) );

			do_action( 'job_content_end' );

			$content = ob_get_clean();


			echo apply_filters( 'job_manager_single_job_content', $content, $post );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cityo' ),
				'after'  => '</div>',
			) ); ?>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->