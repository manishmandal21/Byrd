<?php
    wp_enqueue_script( 'isotope-pkgd', get_template_directory_uri().'/js/isotope.pkgd.min.js', array( 'jquery', 'imagesloaded' ) );
    $columns = cityo_get_config('blog_columns', 1);
	$bcol = floor( 12 / $columns );
	set_query_var( 'thumbsize', 'full' );
?>
<div class="row">
	<div class="isotope-items" data-isotope-duration="400">
	    <?php while ( have_posts() ) : the_post(); ?>
	        <div class="isotope-item col-md-<?php echo esc_attr($bcol); ?>">
	            <?php get_template_part( 'template-posts/loop/grid_item_v3'); ?>
	        </div>
	    <?php endwhile; ?>
    </div>
</div>