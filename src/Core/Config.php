<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Core;

/**
 * It's a config class.
 * 
 */

class Config
{

	/**
	 * Required config fields.
	 * @var array
	 * 
	 */
	
	private static $_required = [
		'secret'
	];

	/**
	 * Data of config.
	 * @var array
	 * 
	 */
	
	private static $_data = [];

	/**
	 * Set values to static $_data.
	 * @param array|string $data
	 * @param null|string $value
	 * @return void
	 * 
	 */

	public static function set($data, $value = null)
	{
		if(is_array($data))
			self::$_data = array_merge(self::$_data, $data);
		else
			self::$_data[$data] = $value;

		foreach(self::$_required as $field)
		{
			if(!isset(self::$_data[$field]))
			{
				if($field !== $data && !isset(self::$_data[$field]))
					Error::show('You need to configure fields: <b>' . implode('</b>, <b>', self::$_required) . '</b>', 1002, [
							'fields' => self::$_required
						]);
			}
		}
	}

	/**
	 * Get value from static $_data.
	 * @param string $str
	 * @return string
	 * 
	 */

	public static function get($str)
	{
		$parts = explode('.', $str);

		if(count($parts) == 0)
			return '';

		$tmp = null;
		foreach($parts as $k)
		{
			if($tmp === null)
				if(isset(self::$_data[$k]))
					$tmp = self::$_data[$k];
				else
					return '';
			else
				if(isset($tmp[$k]))
					$tmp = $tmp[$k];
				else
					return '';
		}

		return $tmp;
	}

}