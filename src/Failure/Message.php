<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Failure;

class Message
{

	/**
	 * Failure exists flag.
	 * @var boolean
	 *
	 */

	private static $_has = false;

	/**
	 * Constructor of Failure show.
	 * @param string $message
	 * @param int $code
	 * @param array $data
	 * @return mixed
	 *
	 */

	public static function show($message, $code = 0, $data = [])
	{
		self::$_has = true;

		if(gettype($code) === 'int')
			$code = (string) $code;

		if(!defined('PHPUNIT'))
		{
			$reports = Reports::get(debug_backtrace());
			$helper = Helper::load($code, $data);

			if(gettype($message) === 'string')
				Template::display($message, $code, $reports, $helper);

			exit();
		}
		else
			return false;
	}

	/**
	 * Check if failure exists.
	 * @return boolean
	 *
	 */

	public static function has()
	{
		return self::$_has === true;
	}
}
