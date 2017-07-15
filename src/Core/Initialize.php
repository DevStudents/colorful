<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Core;

/**
 * Initialize class.
 * 
 */

class Initialize
{

	/**
	 * Constructor of Initialize class.
	 * @param string $env
	 * @return void
	 * 
	 */

	public function __construct($env)
	{
		$envTypes = ['DEVELOPMENT', 'PRODUCTION'];

		if(!in_array($env, $envTypes))
			Error::show('You need to configure ENV.', 1001);

		switch($env)
		{
			case 'DEVELOPMENT':
				error_reporting(E_ALL);
				break;

			case 'PRODUCTION':
				error_reporting(0);
				break;
		}

		$request = new Request();
		$router = new Router($request->getAction());
	}

}