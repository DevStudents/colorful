<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Failure;

class Helper
{

	/**
	 * Load Failure helper.
	 * @param string $code
	 * @param array $data
	 * @return string
	 * 
	 */
	
	public static function load($code, $data = [])
	{
		$helperPath = __DIR__ . '/../../assets/failures/' . $code;
		if(is_file($helperPath) && is_readable($helperPath))
		{
			ob_start();

			if(is_array($data))
					extract($data);

			require $helperPath;
			$content = ob_get_clean();

			$match = preg_match_all('/(\@|\#)\((.+)\)/U', $content, $matches, PREG_SET_ORDER);
			if($match && count($matches) > 0)
			{
				foreach($matches as $match)
				{
					$replace = $match[0];
					$char = $match[1];
					$value = $match[2];

					$splitValue = explode(' ', $value);
					$countSplitValue = count($splitValue);

					$newValue = '';
					switch($char)
					{
						case '#':

							$newValue = strtoupper(
									str_replace(' ', '_', $value)
								);

							break;

						case '@':

							for($i = 0; $i < $countSplitValue; $i++)
							{
								$value = strtolower($splitValue[$i]);

								if($i == 0)
									$newValue .= $value;
								else
									$newValue .= ucfirst($value);
							}

							break;
					}

					$content = str_replace($replace, $newValue, $content);
				}
			}

			$content = str_replace(
					[ '----' ], [ '<h3>OTHERWISE</h3>' ],
					$content
				);

			return $content;
		}
		else
			return 'None for this failure.';
	}
}