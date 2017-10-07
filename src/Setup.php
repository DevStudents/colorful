<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL;
use sintloer\COLORFUL\Framework;
use sintloer\COLORFUL\Exceptions\Failure as FailureException;

class Setup
{

	/**
	 * Data storage.
	 * @var array
	 * 
	 */
	
	private static $_data = [];

	/**
	 * Initialize method.
	 * @param array $data
	 * 
	 */
	
	public static function init($data)
	{
		self::$_data = array_merge(self::$_data, $data);
	}

	/**
	 * Get value from Setup. If not exists return $defaultValue.
	 * @param string $str
	 * @param mixed $defaultValue (optional)
	 * @return mixed
	 * 
	 */
	
	public static function get($str, $defaultValue = '')
	{
		$parts = explode('.', $str);
		if(count($parts) === 0)
			return $defaultValue;

		$tmp = null;
		foreach($parts as $part)
		{
			if($tmp === null)
			{
				if(!isset(self::$_data[$part]))
					return $defaultValue;

				$tmp = self::$_data[$part];
			}
			else
			{
				if(!isset($tmp[$part]))
					return $defaultValue;

				$tmp = $tmp[$part];
			}
		}

		return $tmp;
	}
}