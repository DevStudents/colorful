<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Core;

/**
 * Executor class.
 * 
 */

class Executor
{

	/**
	 * Execute router callback.
	 * @param function $callback
	 * @param array $callback
	 * @return boolean
	 * 
	 */

	public static function run($callback, $params)
	{
		if(is_callable($callback))
		{
			$callback(...array_values($params));
			return true;
		}

		return false;
	}
}