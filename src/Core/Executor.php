<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Core;
use sintloer\COLORFUL\Core\Http\Request;
use sintloer\COLORFUL\Core\Router;

/**
 * Executor class.
 * 
 */

class Executor
{

	/**
	 * Request instance.
	 * @var object
	 * 
	 */
	
	private $_request;

	/**
	 * Router instance.
	 * @var object
	 * 
	 */
	
	private $_router;

	/**
	 * Executor constructor.
	 * @param object $router
	 * @return void
	 * 
	 */

	public function __construct(Request $request, Router $router)
	{
		$this->_request = $request;
		$this->_router = $router;
	}

	/**
	 * Execute router callback.
	 * @param function $callback
	 * @param array $callback
	 * @return boolean
	 * 
	 */

	public function exec($callback, $params)
	{
		/*if(is_callable($callback))
		{
			$callback(...array_values(self::_params));
			return true;
		}

		return false;*/
	}
}