<?php
/*
return [
	'default' => 'mongodb',
	'connections' => [
		'mongodb' => [
			'driver' => 'mongodb',
			'host' => env('DB_HOST', 'localhost'),
			'port' => env('DB_PORT', 27017),
			'database' => env('DB_DATABASE'),
			'username' => env('DB_USERNAME'),
			'password' => env('DB_PASSWORD'),
			'options' => [
				'database' => 'admin' // sets the authentication database required by mongo 3
			]
		],
	],
	‘migrations’ => ‘migrations’,
];
*/
return  [
	'default' => 'pgsql',
	
	'connections' => [
		'pgsql' => [
			'driver'    => 'pgsql',
			'host'      => env('DB_HOST', 'localhost'),
			'database'  => env('DB_DATABASE', ''),
			'username'  => env('DB_USERNAME', ''),
			'password'  => env('DB_PASSWORD', ''),
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
			'strict'    => false,
		],
		
		'mongodb' => array(
			'driver'   => 'mongodb',
			'host'     => env('MONGODB_HOST', 'localhost'),
			'port'     => env('MONGODB_PORT', 27017),
			'username' => env('MONGODB_USERNAME', ''),
			'password' => env('MONGODB_PASSWORD', ''),
			'database' => env('MONGODB_DATABASE', ''),
			'options' => array(
				'db' => env('MONGODB_AUTHDATABASE', '') //Sets the auth DB
			)
		),
	],
];
