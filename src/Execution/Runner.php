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
use sintloer\COLORFUL\Collections;
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
				Collections\Listeners::all(),
				[ $request, $response ]
			);

		$router = Router\Parser::run(
						$request,
						Collections\Routes::all()
					);

		$beforeCallback = Callbacks\Before::get();
		if(is_callable($beforeCallback))
			$beforeCallback(
					$request,
					$response
				);

		if($router === false)
			Event\Caller::run(
					Event\Events::LACK
				);
		else
		{
			if(is_callable($router))
			{
				if(version_compare(PHP_VERSION, '5.6.0', '>='))
					$router($request, $response, ...array_values($request->params));
				else
					$router($request, $response);
			}
		}

		$afterCallback = Callbacks\After::get();
		if(is_callable($afterCallback))
			$afterCallback(
					$request,
					$response
				);

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