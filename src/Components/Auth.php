<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Components;
use sintloer\COLORFUL\Core;
use Firebase\JWT\JWT;

/**
 * Auth component.
 * 
 */

class Auth
{

	/**
	 * Data of token.
	 * @var array
	 * 
	 */

	private static $_data = [];

	/**
	 * Generate JWT token.
	 * @param $a [<description>]
	 * @return string
	 * 
	 */

	public static function token($data, $time = 600)
	{
		if($secret = Core\Config::get('secret'))
		{
			if(is_int($time))
				$data['_TIME'] = time() + $time;

			return JWT::encode($data, $secret);
		}

		return false;
	}

	/**
	 * Verify JWT token.
	 * @return boolean
	 * 
	 */

	public static function verify()
	{
		if($secret = Core\Config::get('secret'))
		{
			$token = Core\Request::getHeader('Authorization');
			if($token === false)
				return false;

			$data = (array) JWT::decode($token, $secret, ['HS256']);
			if(isset($data['_TIME']) && $data['_TIME'] >= time())
			{
				unset($data['_TIME']);
				self::$_data = $data;
				return true;
			}
		}
		
		return false;
	}

	/**
	 * Get token data from $_data.
	 * @return array
	 * 
	 */

	public static function data()
	{
		return self::$_data;
	}
}