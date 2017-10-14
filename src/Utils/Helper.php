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
}
