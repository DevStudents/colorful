<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Utils;

class Helper
{

    /**
	 * Bind this object to callback.
	 * @param Closure $callback
	 * @param object $object
	 * @return boolean
	 *
	 */

	public static function bind(&$callback, $object)
	{
		if(is_callable($callback))
		{
			$bind = @$callback->bindTo($object);
			if($bind !== null && $bind !== false)
			{
				$callback = $bind;
				return true;
			}
		}

		return false;
	}

	/**
	 * Get callback from array.
	 * @param array $array
	 * @return mixed
	 *
	 */

	public static function getCallbackFromArray($array)
	{
		if(count($array) == 2)
		{
			$class = $array[0];
			$classMethod = $array[1];

			if(class_exists($class))
			{
				$obj = new $class();
				if(method_exists($obj, $classMethod))
				{
					$reflection = new \ReflectionMethod($obj, $classMethod);
					$closure = $reflection->getClosure($obj);

					if(is_callable($closure))
						return $closure;
				}
			}
		}

		return false;
	}
}
