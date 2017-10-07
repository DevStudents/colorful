<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL;

final class Globals
{

	/**
	 * Environment modes.
	 * @var array
	 * 
	 */
	
	public static $ENVIRONMENT_MODES = [

		'd' => 'DEVELOPMENT',
		'p' => 'PRODUCTION'

	];

	/**
	 * Available HTTP methods.
	 * @var array
	 * 
	 */
	
	public static $HTTP_METHODS = [

		'GET', 'POST', 'PUT', 'PATCH', 'DELETE'

	];

	/**
	 * Setup required fields.
	 * @var array
	 * 
	 */
	
	public static $SETUP_REQUIRED_FIELDS = [

		'secret' => [
			'type' => 'string',
			'message' => 'This is a secret key. It is used by frameworks to encode different methods. For example, the authorization system.'
		]

	];
}