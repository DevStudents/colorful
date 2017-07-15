<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Components;
use sintloer\COLORFUL\Core;

/**
 * Store component.
 * 
 */

class Store
{

	/**
	 * Data of store.
	 * @var array
	 * 
	 */

	private static $_data = [];

	/**
	 * Save object to store.
	 * @param array|string $name
	 * @param null|string $value
	 * @return void
	 * 
	 */

	public static function save($name, $value = null)
	{
		if(is_array($name))
		{
			foreach($name as $key => $value)
			{
				if(is_callable($value))
					self::$_data[$key] = $value();
				else
					self::$_data[$key] = $value;
			}
		}
		else
		{
			if(is_callable($value))
				self::$_data[$name] = $value();
			else
				self::$_data[$name] = $value;
		}
	}

	/**
	 * Get object from store.
	 * @param string $name
	 * @return object|boolean
	 * 
	 */

	public static function get($name)
	{
		if(self::has($name))
			return self::$_data[$name];

		Core\Error::show('Not found object: "' . $name . '" in Store.');
		return false;
	}

	/**
	 * Check that exists key in static $_data.
	 * @param string $name
	 * @return boolean
	 * 
	 */

	public static function has($name)
	{
		if(isset(self::$_data[$name]))
			return true;

		return false;
	}

	/**
	 * Check that store data is empty.
	 * @return boolean
	 * 
	 */

	public static function empty()
	{
		if(count(self::$_data) == 0)
			return true;

		return false;
	}
}