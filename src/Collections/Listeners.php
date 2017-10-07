<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Collections;
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
	 * @return mixed
	 * 
	 */
	
	public static function add(Listener $listener)
	{
		self::$_listeners[$listener->getName()] = $listener->getCallback();
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