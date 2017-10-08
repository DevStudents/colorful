<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Store\Callbacks;
use Closure;

class After
{

	/**
	 * Callback store.
	 * @var Closure
	 *
	 */

	private static $_after = null;

	/**
	 * Set callback.
	 * @param Closure $callback
	 *
	 */

	public static function set(Closure $callback)
	{
		self::$_after = $callback;
	}

	/**
	 * Get callback.
	 * @return mixed
	 *
	 */

	public static function get()
	{
		return self::$_after;
	}

	/**
	 * Check if callback exists.
	 * @return boolean
	 *
	 */

	public static function has()
	{
		return self::$_after !== null;
	}
}
