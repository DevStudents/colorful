<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Event;

use sintloer\COLORFUL\Http\Request;
use sintloer\COLORFUL\Http\Response;

class Caller
{

	/**
	 * Listeners storage.
	 * @var array
	 * 
	 */
	
	private static $_listeners = [];

	/**
	 * Request object storage.
	 * @var Request
	 * 
	 */
	
	private static $_request;

	/**
	 * Response object storage.
	 * @var Response
	 * 
	 */
	
	private static $_response;

	/**
	 * Run method.
	 * @param array $listeners
	 * @param array $objects
	 * @return mixed
	 * 
	 */
	
	public static function init($listeners, $objects)
	{
		if(!is_array($listeners) || !($objects[0] instanceof Request) || !($objects[1] instanceof Response))
			return false;

		self::$_request = $objects[0];
		self::$_response = $objects[1];

		foreach($listeners as $name => $callback)
			self::$_listeners[$name] = $callback;
	}

	/**
	 * Run method.
	 * @param array $listeners
	 * 
	 */
	
	public static function run($name)
	{
		if(isset(self::$_listeners[$name]) && is_callable(self::$_listeners[$name]))
		{
			(self::$_listeners[$name])(
					self::$_request,
					self::$_response
				);
		}
	}
}