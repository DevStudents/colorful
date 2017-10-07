<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Collections;
use sintloer\COLORFUL\Router\Route;

class Routes
{

	/**
	 * Routes storage.
	 * @var array
	 * 
	 */
	
	private static $_routes = [];

	/**
	 * Add route to storage.
	 * @param Route $route
	 * @return mixed
	 * 
	 */
	
	public static function add(Route $route)
	{
		self::$_routes[$route->getMethod()][$route->getPath()] = $route->getCallback();
	}

	/**
	 * Get all routes from storage.
	 * @return array
	 * 
	 */
	
	public static function all()
	{
		return self::$_routes;
	}
}