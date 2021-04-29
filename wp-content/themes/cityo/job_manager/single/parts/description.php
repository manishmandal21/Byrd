<?php
global $post;
?>
<div id="listing-description" class="job_description" itemprop="description">
	<h2 class="widget-title">
		<span><?php esc_html_e('Description', 'cityo'); ?></span>
	</h2>
	<div class="box-inner">
		<?php
			$obj = WP_Job_Manager_Post_Types::instance();
			remove_filter( 'the_content', array( $obj, 'job_content' ) );
			the_content();
		?>

		<?php do_action('cityo-single-listing-description', $post); ?>
	</div>
</div>