<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Core;
use sintloer\COLORFUL\Creation;

/**
 * Error class.
 * 
 */

class Error
{
	
	/**
	 * Display COLORFUL Error method.
	 * @param string $msg
	 * @param string $exampleNumber
	 * @param array $data
	 * @return boolean
	 * 
	 */

	public static function show($msg, $exampleNumber = '', $data = [])
	{
		$exampleNumber = (string) $exampleNumber;

		$reports = self::_getReportsClass(debug_backtrace());
		$example = self::_getExample($exampleNumber, $data);
		$logo = base64_encode(@file_get_contents(__DIR__ . '/../../COLORFUL.png'));
		$icon = base64_encode(@file_get_contents(__DIR__ . '/../../icon.png'));
		$version = Creation::VERSION;

		ob_start();
		require(__DIR__ . '/Error/Template.php');
		$template = ob_get_clean();

		echo $template;
		exit();
		return false;
	}

	/**
	 * Get reports class name.
	 * @param array $trace
	 * @return string
	 * 
	 */

	private static function _getReportsClass($trace)
	{
		if(isset($trace[1]))
		{
			if(isset($trace[1]['class']) && !empty($trace[1]['class']))
				return $trace[1]['class'];
		}

		return 'Unknown';
	}

	/**
	 * Get reports class name.
	 * @param string $exampleNumber
	 * @param array $data
	 * @return string|boolean
	 * 
	 */

	private static function _getExample($exampleNumber, $data)
	{
		$path = __DIR__ . '/Error/Examples/' . $exampleNumber;
		if(is_readable($path))
		{
			ob_start();

			if(is_array($data) && count($data) > 0)
				extract($data);

			require $path;
			return ob_get_clean();
		}

		return false;
	}
}