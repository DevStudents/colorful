<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Nextines;

class Cookie
{

	/**
	 * Set cookie.
	 * @param string $name
	 * @param mixed $value (optional)
	 * @param int $time (optional)
	 * @return boolean
	 * 
	 */
	
	public static function set($name, $value = '', $time = 0)
	{
		return setcookie($name, $value, $time, '/');
	}

	/**
	 * Get cookie.
	 * @param string $name
	 * @return boolean
	 * 
	 */
	
	public static function get($name)
	{
		if(self::has($name))
			return $_COOKIE[$name];
	}

	/**
	 * Remove cookie.
	 * @param string $name
	 * @return boolean
	 * 
	 */
	
	public static function remove($name)
	{
		if(self::has($name))
			self::set($name, '', -1);

		return false;
	}

	/**
	 * Check if cookie exists.
	 * @param string $name
	 * @return boolean
	 * 
	 */
	
	public static function has($name)
	{
		if(isset($_COOKIE[$name]))
			return true;

		return false;
	}
}