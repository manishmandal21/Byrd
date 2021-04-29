<?php

$path_dir = get_template_directory() . '/inc/samples/data/';
$path_uri = get_template_directory_uri() . '/inc/samples/data/';

$demo_datas = array();
if ( is_dir($path_dir) ) {
	$demo_datas = array(
		'home-place'               => array(
			'data_dir'      => $path_dir . 'home-place',
			'title'         => esc_html__( 'Place Demo', 'cityo' ),
		),
		'home-event'               => array(
			'data_dir'      => $path_dir . 'home-event',
			'title'         => esc_html__( 'Event Demo', 'cityo' ),
		),
		'home-real-estate'  => array(
			'data_dir'      => $path_dir . 'home-real-estate',
			'title'         => esc_html__( 'Real Estate Demo', 'cityo' ),
		),
		'home-car'  => array(
			'data_dir'      => $path_dir . 'home-car',
			'title'         => esc_html__( 'Car Demo', 'cityo' ),
		)
	);
}

$import_steps = array(
	'first_settings' => 'content',
	'content' => 'widgets',
	'widgets' => 'settings',
	'settings' => 'done'
);