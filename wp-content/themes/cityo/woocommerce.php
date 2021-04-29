<?php
get_header();
$sidebar_configs = cityo_get_woocommerce_layout_configs();
$checktab = cityo_get_config('product_single_layout',1);
?>
<?php do_action( 'cityo_woo_template_main_before' ); ?>

<section id="main-container" class="main-content <?php echo apply_filters('cityo_woocommerce_content_class', 'container');?>">
	<?php cityo_before_content( $sidebar_configs ); ?>
	<div class="row">

		<?php cityo_display_sidebar_left( $sidebar_configs ); ?>

		<div id="main-content" class="archive-shop col-xs-12 <?php echo esc_attr($sidebar_configs['main']['class']).' '.(($checktab == "main") ? "": "detailsidebar"); ?>">

			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					<?php  woocommerce_content(); ?>
					
				</div><!-- #content -->
			</div><!-- #primary -->
		</div><!-- #main-content -->
		
		<?php cityo_display_sidebar_right( $sidebar_configs ); ?>
		
	</div>
</section>
<?php

get_footer();