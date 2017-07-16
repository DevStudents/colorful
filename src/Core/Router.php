<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Core;

/**
 * Router class.
 * 
 */

class Router
{

	/**
	 * Routes array.
	 * @var array
	 * 
	 */

	private static $_routes = [];

	/**
	 * This variable say to have been found matched route.
	 * If found then it's accepts true value.
	 * @var boolean
	 * 
	 */

	private static $_finded = false;

	/**
	 * Constructor of Router class.
	 * This starts Request class.
	 * 
	 */

	public function __construct()
	{
		
	}

	/**
	 * Handle for GET Router request.
	 * @param string $test
	 * @param function $callback
	 * @return void
	 * 
	 */

	public static function get($test, $callback)
	{
		self::_addRoute('GET', $test, $callback);
	}

	/**
	 * Handle for POST Router request.
	 * @param string $test
	 * @param function $callback
	 * @return void
	 * 
	 */

	public static function post($test, $callback)
	{
		self::_addRoute('POST', $test, $callback);
	}

	/**
	 * Handle for PUT Router request.
	 * @param string $test
	 * @param function $callback
	 * @return void
	 * 
	 */

	public static function put($test, $callback)
	{
		self::_addRoute('PUT', $test, $callback);	
	}

	/**
	 * Handle for DELETE Router request.
	 * @param string $test
	 * @param function $callback
	 * @return void
	 * 
	 */

	public static function delete($test, $callback)
	{
		self::_addRoute('DELETE', $test, $callback);
	}

	/**
	 * Add route.
	 * @param string $method
	 * @param string $test
	 * @param function $callback
	 * @return void
	 * 
	 */

	private static function _addRoute($method, $test, $callback)
	{
		self::$_routes[]
	}

	/**
	 * This method starts parse process (parse() method) and calls to $callback if is callable.
	 * @param string $method
	 * @param string $test
	 * @param function $callback
	 * @return void
	 * 
	 */

	private static function _run($method, $test, $callback)
	{
		if(Request::getRequestMethod() === $method && self::$_finded === false)
		{
			if(self::_parse($test))
			{
				if(Executor::run($callback, self::$_requestParams) === true)
				{
					Event::remove('404');
					self::$_finded = true;
				}
				else
					Error::show('You need to give a callable argument.', 1003, [
							'method' => $method
						]);
			}
			else
				Event::register('404');
		}
	}

	/**
	 * This method match route ($test) for URL (parts).
	 * @param string $test
	 * @return boolean
	 * 
	 */

	private static function _parse($test)
	{
		if($test === '/' . self::$_parts[0])
			return true;

		$confirmed = false;
		
		$routeExplode = explode('/', $test);

		if(isset($routeExplode[0]))
			unset($routeExplode[0]);

		$routeExplode = array_values($routeExplode);

		$routeExplodeCount = count($routeExplode);
		$partsCount = count(self::$_parts);

		if($routeExplodeCount != $partsCount)
			return false;

		$i = 0;
		foreach($routeExplode as $part)
		{
			if(empty(self::$_parts[$i]))
				return false;

			if(strpos($part, ':') !== false)
			{
				$paramValue = self::$_parts[$i];
				self::$_requestParams[] = $paramValue;
				$confirmed = true;
			}
			else
			{
				if($part != self::$_parts[$i])
					return false;
				else
				{
					$confirmed = true;
				}
			}

			$i++;
		}

		if($confirmed === true)
			return true;

		return false;
	}
}