<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Execution;

use sintloer\COLORFUL\Http\Request;
use sintloer\COLORFUL\Http\Response;
use sintloer\COLORFUL\Store;
use sintloer\COLORFUL\Router;
use sintloer\COLORFUL\Event;

class Runner
{

	/**
	 * After executed flag.
	 * @var boolean
	 *
	 */

	private static $_executed = false;

	/**
	 * Start method.
	 * This execute all of framework.
	 *
	 */

	public static function start()
	{
		$request = new Request();
		$response = new Response();

		Event\Caller::init(
				Store\Listeners::all(),
				[ $request, $response ]
			);

		$router = Router\Parser::run(
						$request,
						Store\Routes::all()
					);

		if($router === false)
			Event\Caller::run(
					Store\Events::LACK
				);
		else
		{
			Event\Caller::run(
					Store\Events::FOUND
				);

			$beforeCallback = Store\Before::get();
			if(is_callable($beforeCallback))
				$beforeCallback(
						$request,
						$response
					);

			if(is_callable($router))
			{
				if(version_compare(PHP_VERSION, '5.6.0', '>='))
					$router($request, $response, ...array_values($request->params));
				else
					$router($request, $response);
			}

			$afterCallback = Store\After::get();
			if(is_callable($afterCallback))
				$afterCallback(
						$request,
						$response
					);
		}

		self::$_executed = true;
	}

	/**
	 * Get after executed flag.
	 * @return boolean
	 *
	 */

	public static function executed()
	{
		return self::$_executed === true;
	}
}
