<?php

function cityo_child_enqueue_styles() {
	wp_enqueue_style( 'cityo-child-style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'cityo_child_enqueue_styles', 100 );