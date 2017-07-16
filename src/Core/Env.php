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

class Env
{

	/**
	 * Allowed environment modes.
	 * @var string
	 * 
	 */
	
	private static $_env = [
		'DEVELOPMENT',
		'PRODUCTION'
	];

	/**
	 * Environment mode
	 * @var string
	 * 
	 */
	
	private static $_mode = 'DEVELOPMENT';

	/**
	 * Set environment mode
	 * @param string $mode
	 * @return void
	 * 
	 */

	public static function set($mode)
	{
		if(in_array($mode, self::$_env))
			self::$_mode = $mode;
	}

	/**
	 * Set environment mode
	 * @return string
	 * 
	 */

	public static function get()
	{
		return self::$_mode;
	}
}