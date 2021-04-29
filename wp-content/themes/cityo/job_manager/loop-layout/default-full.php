<?php 
	$sidebar_position = cityo_get_archive_layout();
?>
<div class="apus-grid-layout apus-default-full-layout style-grid apus-listing-warpper <?php echo esc_attr(($sidebar_position == 'main')?'only_main':'has-sidebar'); ?>">
	<div class="row no-margin">
		<?php echo trim($html_content); ?>
	</div>
</div>