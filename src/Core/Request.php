<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Core;

/**
 * Request class.
 * 
 */

class Request
{

	/**
	 * URL action.
	 * @var string
	 * 
	 */

	private static $_action;

	/**
	 * Input data array.
	 * @var array
	 * 
	 */

	private static $_input = [];

	/**
	 * Request method.
	 * @var string
	 * 
	 */

	private static $_method;

	/**
	 * Constructor of Request class.
	 * 
	 */

	public function __construct()
	{
		self::$_action = $_GET['ACTION'] ?? null;
		self::$_input = json_decode(file_get_contents('php://input') ?? null, true);
		self::$_method = self::getRequestMethod();
	}

	/**
	 * Return action.
	 * @return string
	 * 
	 */

	public static function getAction()
	{
		return self::$_action;
	}

	/**
	 * Return input data.
	 * @return array
	 * 
	 */

	public static function getInput()
	{
		return self::$_input;
	}

	/**
	 * Get request method.
	 * @return string
	 * 
	 */

	public static function getRequestMethod()
	{
		if(self::$_method)
			return self::$_method;

		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Get request header.
	 * @return string|boolean
	 * 
	 */

	public static function getHeader($name)
	{
		if(isset($_SERVER['HTTP_' . $name]))
			return $_SERVER['HTTP_' . $name];

		return false;
	}

}