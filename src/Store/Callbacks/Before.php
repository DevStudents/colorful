<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Store\Callbacks;
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
	 *
	 */

	public static function set(Closure $callback)
	{
		self::$_before = $callback;
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
