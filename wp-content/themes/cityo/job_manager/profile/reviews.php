<?php
if ( !class_exists('Cityo_Bookmark') ) {
	return;
}
global $apus_author;

$args = array( 'user_id' => $apus_author->ID );
$comments = cityo_get_review_comments( $args );
$number = cityo_get_config('user_profile_reviews_number', 25);
$max_page = ceil(count($comments)/$number);
$page = !empty($_GET['cpage']) ? $_GET['cpage'] : 1;
echo '<ul class="list-reviews">';
	wp_list_comments(array(
		'per_page' => $number,
		'page' => $page,
		'reverse_top_level' => false,
		'callback' => 'cityo_my_review'
	), $comments);
echo '</ul>';

$pargs = array(
	'base' => add_query_arg( 'cpage', '%#%' ),
	'format' => '',
	'total' => $max_page,
	'current' => $page,
	'echo' => true,
	'add_fragment' => ''
);
cityo_paginate_links( $pargs );
?>