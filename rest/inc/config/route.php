<?php
$route_conf =  array(
	'group1' => array(
			'/demo'=>array(
					'class'=>'DemoHandlers',
					'method'=>'test'
			),
			'/democache'=>array(
					'class'=>'DemoHandlers',
					'method'=>'test2'
			),
			'/demos' => array(
					'class'=>'DemoHandlers',
					'method'=>'test3'
			)
	),
	'group2' => array(
		'/kkk' => array(
					'class'=>'user',
					'method'=>'test'
		),
	)
);