<?php

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
		
		'mongodb' => [
			'driver'   => 'mongodb',
			'host'     => env('MONGODB_HOST', 'localhost'),
			'port'     => env('MONGODB_PORT', 27017),
			'username' => env('MONGODB_USERNAME', ''),
			'password' => env('MONGODB_PASSWORD', ''),
			'database' => env('MONGODB_DATABASE', ''),
			'options' => [
				'db' => env('MONGODB_AUTHDATABASE', '')
			],
		],
	],
];
