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
 * It's a error class.
 * 
 */

class Error
{

	/**
	 * Message of error.
	 * @var string
	 * 
	 */

	private static $_msg;

	/**
	 * Example of error.
	 * @var string
	 * 
	 */

	private static $_exampleNumber;
	
	/**
	 * Show error.
	 * @param string $msg
	 * @param string $exampleNumber
	 * @param array $data
	 * @return boolean
	 * 
	 */

	public static function show($msg, $exampleNumber = '', $data = [])
	{
		$trace = debug_backtrace();
		$reports = '';
		if(isset($trace[1]))
		{
			if(isset($trace[1]['class']) && !empty($trace[1]['class']))
				$reports = $trace[1]['class'];
		}

		if(isset($exampleNumber) && !empty($exampleNumber))
			$exampleNumber = (string) $exampleNumber;

		$example = '';

		if(!empty($exampleNumber))
		{
			$examplePath = __DIR__ . '/../Examples/' . $exampleNumber;		
			if(is_readable($examplePath))
			{
				ob_start();

				if(is_array($data) && count($data) > 0)
					extract($data);

				require $examplePath;
				$example = ob_get_clean();
			}
		}
		

		$logo = base64_encode(@file_get_contents(__DIR__ . '/../../COLORFUL.png'));
		$icon = base64_encode(@file_get_contents(__DIR__ . '/../../icon.png'));

		$html = '<!DOCTYPE html>
			<html>
				<head>
					<meta charset="UTF-8">
					<link rel="icon" href="data:image/png;base64,'. $icon .'">
					<title>COLORFUL Error</title>
					<style>
						* { box-sizing: border-box; }
						html, body { margin: 0; padding: 0; }
						body { background-color: #fff; font-family: Tahoma, Arial; color: #1b1b1b; font-size: 17px; }
						section { padding: 15px; }
						header { text-align: center; background-color: black; padding: 30px; }
						section h3 { margin: 0; margin-top: 29px; }
						section .reports { margin-top: -1px; }
						header .version { width: 198px; font-size: 12px; position: absolute; top: 0; left: 50%; text-align: right; margin: 60px 0 0 -36px; color: #fff; }
						h4 { width: 100%; border: 0; border-bottom: 2px solid #1b1b1b; padding-bottom: 5px; text-transform: uppercase; }
						pre { font-family: Tahoma; }
					</style>
				</head>
				<body>
					<header>
						<a href="https://github.com/sintloer/COLORFUL-framework" target="_blank"><img src="data:image/png;base64,'. $logo .'" alt="COLORFULframework"></a>
						<div class="version">ver. ' . Creation::VERSION . '</div>
					</header>
					<section class="error">
						<h3>An error occured' . (!empty($exampleNumber) ? ': #' . $exampleNumber : '') . '</h3>
						<div class="reports">Reports: '. $reports .'</div>
					</section>
					
					<section class="m">
						<h4>Message</h4>
						<p>'. $msg .'</p>
					</section>';

					if(!empty($example))
					{
						$match = preg_match_all('/!\[(.*?)\]/', $example, $matches, PREG_SET_ORDER);
						if($match && isset($matches))
						{
							foreach($matches as $match)
							{
								$toReplace = $match[0];
								$value = $match[1];

								$value = strtoupper(str_replace(' ', '_', $value));
								$example = str_replace($toReplace, $value, $example);
							}
						}
						
						$html .= '
						<section class="e">
							<h4>Example</h4>
							<pre>'. $example .'</pre>
						</section>
						';
					}
					
				$html .= '
				</body>
			</html>';

		self::$_msg = $msg;
		self::$_exampleNumber = $exampleNumber;

		echo $html;
		exit();
		return false;
	}

	/**
	 * Get message of error.
	 * @return string
	 * 
	 */
	
	public static function getMessage()
	{
		return self::$_msg;
	}

	/**
	 * Get message of error.
	 * @return string
	 * 
	 */
	
	public static function getNumber()
	{
		return self::$_errorNumber;
	}
}