<?php
get_header();

$sidebar_configs = cityo_get_blog_layout_configs();

cityo_render_breadcrumbs();
?>
<section id="main-container" class="main-content content-space <?php echo apply_filters('cityo_blog_content_class', 'container');?>">
	<?php cityo_before_content( $sidebar_configs ); ?>
	<div class="row">
		<?php cityo_display_sidebar_left( $sidebar_configs ); ?>
		<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
			<div id="primary" class="content-area">
				<div id="content" class="site-content single-post" role="main">
					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();

							/*
							 * Include the post format-specific template for the content. If you want to
							 * use this in a child theme, then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
							get_template_part( 'template-posts/single/_single' );
						// End the loop.
						endwhile;
					?>
				</div><!-- #content -->
			</div><!-- #primary -->
		</div>

		<?php cityo_display_sidebar_right( $sidebar_configs ); ?>
		
	</div>
</section>
<?php get_footer(); ?>