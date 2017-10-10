<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Failure;
use sintloer\COLORFUL\Creation;

class Template
{

	/**
	 * Display Failure.
	 * @param string $message
	 * @param string $code
	 * @return boolean
	 *
	 */

	public static function display($message, $code, $reports, $helper)
	{
		$data = [
			'icon' => base64_encode(file_get_contents(__DIR__ . '/../../assets/images/icon.png')),
			'brand' => base64_encode(file_get_contents(__DIR__ . '/../../assets/images/brand.png')),
			'github' => base64_encode(file_get_contents(__DIR__ . '/../../assets/images/github.png')),
			'version' => Creation::VERSION,
			'code' => $code,
			'reports' => $reports,
			'message' => $message,
			'helper' => $helper
		];

		$path = __DIR__ . '/../../assets/failures/template.html';
		if(is_file($path) && is_readable($path))
		{
			ob_clean();
			ob_start();
			require $path;
			$content = ob_get_clean();

			$match = preg_match_all('/\{\{(.+)\}\}/U', $content, $matches, PREG_SET_ORDER);
			if($match && count($matches) > 0)
			{
				foreach($matches as $match)
				{
					$replace = $match[0];
					$name = trim($match[1]);

					$value = $data[$name] ? $data[$name] : '...';
					$content = str_replace($replace, $value, $content);
				}
			}

			if(!defined('PHPUNIT'))
				echo $content;
				
			return true;
		}
		else
		{
			echo 'COLORFULframework Failure: ' . $message;
			return false;
		}
	}
}
