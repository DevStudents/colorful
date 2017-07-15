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
 * Response component.
 * 
 */

class Response
{

	/**
	 * Response error flag.
	 * @var boolean
	 * 
	 */

	private static $_error = false;

	/**
	 * Set HTTP response code.
	 * @param string $code
	 * @return int
	 * 
	 */

	public static function setCode($code)
	{
		http_response_code($code);
	}

	/**
	 * Set HTTP response header.
	 * @param string $name
	 * @param null|string $value
	 * @return void
	 * 
	 */

	public static function setHeader($name, $value = null)
	{
		if(is_array($name))
		{
			foreach($name as $key => $value)
				header($key . ': ' . $value);
		}

		header($name . ': ' . $value);
		return self;
	}

	/**
	 * Display JSON data.
	 * @param array $data
	 * @param int $code HTTP code
	 * @return boolean|null
	 * 
	 */

	public static function json($data, $code = 200, $type = 'application/json')
	{
		if($code !== null)
			self::setCode($code);

		header('Content-Type: ' . $type);
		echo json_encode($data);

		exit();
	}

	/**
	 * Display HTML.
	 * @param string $data
	 * @return boolean|null
	 * 
	 */

	public static function display($str)
	{
		if($str !== false)
			echo $str;

		exit();
	}

	/**
	 * Redirect response.
	 * @param string $url
	 * @return boolean|null
	 * 
	 */

	public static function redirect($url)
	{
		self::setCode(303);
		header('Location: ' . $url);
		exit();
	}

	/**
	 * Response error.
	 * @param string $msg
	 * @param int $code
	 * @return boolean|null
	 * 
	 */

	public static function error($msg, $code = 500)
	{
		self::json([
				'error' => true,
				'message' => $msg
			], $code);
	}
}