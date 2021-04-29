<?php
global $post;

$layout_version = cityo_get_listing_archive_version();
$columns = cityo_get_listing_item_columns();
$bcol_md = 12/$columns;
$bcol_sm = ($columns >= 2) ? 6 : 12;
$item_stype = cityo_get_listing_item_style();
$sidebar_position = cityo_get_archive_layout();
$clear = $columns;
if($layout_version == 'default-full' && $sidebar_position != 'main' && $columns >= 3){
	$bcol_md = 6;
	$clear = 2;
}
$class = 'lg-clear-'.$columns.' md-clear-'.$clear.' col-lg-'.(12/$columns).' col-md-'.$bcol_md.' col-sm-'.$bcol_sm.' col-xs-12';
if ( $item_stype == 'list' ) {
	$class = 'col-md-12 col-sm-12';
}
?>
<div class="<?php echo esc_attr($class); ?>	">
	<?php get_template_part( 'job_manager/loop/'.$item_stype ); ?>
</div>