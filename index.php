<?php

require __DIR__ . '/vendor/autoload.php';

use sintloer\COLORFUL\Creation;
use sintloer\COLORFUL\Components\Request;
use sintloer\COLORFUL\Components\Response;
use sintloer\COLORFUL\Components\Store;
use sintloer\COLORFUL\Components\Database;
use sintloer\COLORFUL\Components\View;
use sintloer\COLORFUL\Components\Auth;
use sintloer\COLORFUL\Components\Helpers;

(new Creation('DEVELOPMENT'))

/* SET CONFIGURATION */

->config([

	'secret' => '4dca5c48abaed0f53aef24d9b6b5a9e0e1401f3f',

	'databases' => [
		'first' => [
			'driver' => 'mysql',
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'name' => 'sintloer',
			'prefix' => ''
		],
		'second' => [
			'driver' => 'mysql',
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'name' => 'sintloer',
			'prefix' => ''
		]
	],

	'views' => [
		'directory' => __DIR__ . '/views',
		'cacheDirectory' => __DIR__ . '/views/_cache',
		'extension' => 'v'
	]

])

/* INITIALIZE METHOD */

->initialize(function() {

	Store::save([
			'Database' => Database::get('first'),
		]);
})

/* ROUTES */

->get('/', function() {

	Response::display(View::load('home'));

	/*Response::json([
			'asdasd' => 10,
			'html' => View::load('siema')
		]);*/
})

/* EVENTS */

->when('404', function() {

	Response::error('404', 404);
})

/* FINISH METHOD */

->finish(function() {

	Database::closeAll();
});