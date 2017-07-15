<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Core;

/**
 * Class for store events.
 * 
 */

class Event
{

	/**
	 * Array of events.
	 * @var string
	 * 
	 */
	
	public static $_events = [];

	/**
	 * Add event to $_events array.
	 * @param string $name
	 * @return object
	 * 
	 */
	
	public static function register($name)
	{
		//if(!isset(self::$_events[$name]))
			self::$_events[$name] = true;
	}

	/**
	 * Remove event to $_events array.
	 * @param string $name
	 * @return void
	 * 
	 */
	
	public static function remove($name)
	{

		if(self::has($name))
			unset(self::$_events[$name]);
	}

	/**
	 * Check that event has exists and can be used.
	 * @param string $name
	 * @return boolean
	 * 
	 */

	public static function check($name)
	{

		if(self::has($name) && self::$_events[$name] === true)
		{
			unset(self::$_events[$name]);
			return true;
		}

		return false;
	}

	/**
	 * Check that event has in static $_events array.
	 * @param string $name
	 * @return boolean
	 * 
	 */

	public static function has($name)
	{

		if(isset(self::$_events[$name]))
			return true;

		return false;
	}

}