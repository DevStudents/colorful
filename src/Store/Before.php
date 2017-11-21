<?php

/**
 * COLORFULframework
 * @author sintloer <contact@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Store;
use Closure;

class Before
{

	/**
	 * Callback store.
	 * @var Closure
	 *
	 */

	private static $_before = null;

	/**
	 * Set callback.
	 * @param Closure $callback
	 * @return boolean
	 *
	 */

	public static function set(Closure $callback)
	{
		self::$_before = $callback;
		return true;
	}

	/**
	 * Get callback.
	 * @return mixed
	 *
	 */

	public static function get()
	{
		return self::$_before;
	}

	/**
	 * Check if callback exists.
	 * @return boolean
	 *
	 */

	public static function has()
	{
		return self::$_before !== null;
	}
}
