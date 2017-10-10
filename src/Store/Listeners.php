<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Store;
use sintloer\COLORFUL\Event\Listener;

class Listeners
{

	/**
	 * Listeners storage.
	 * @var array
	 *
	 */

	private static $_listeners = [];

	/**
	 * Save method.
	 * @param Listener $listener
	 * @return boolean
	 *
	 */

	public static function add(Listener $listener)
	{
		self::$_listeners[$listener->getName()] = $listener->getCallback();
		return true;
	}

	/**
	 * Get all from listeners storage.
	 * @return array
	 *
	 */

	public static function all()
	{
		return self::$_listeners;
	}
}
