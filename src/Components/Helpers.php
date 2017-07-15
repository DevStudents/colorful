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
 * Helpers component.
 * 
 */

class Helpers
{

	/**
	 * Generate hash.
	 * @param string $code
	 * @return int
	 * 
	 */
	
	public static function hash($str = '')
	{
		if(empty($str))
			$str = self::random(rand(10, 20));

		return sha1(md5($str . sha1(self::random(20))));
	}

	/**
	 * Generate hash.
	 * @param int $length
	 * @return string
	 * 
	 */
	
	public static function random($length)
	{
		$chars = 'qwertyuiopasdfghjklzxcvbnm1234567890';
		$charsLengthMinusOne = strlen($chars) - 1;

		$str = '';
		for($i = 1; $i <= $length; $i++)
			$str .= $chars[rand(0, $charsLengthMinusOne)];

		return $str;
	}

}