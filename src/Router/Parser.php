<?php

/**
 * COLORFULframework
 * @author sintloer <contact@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Router;

use sintloer\COLORFUL\Store;
use sintloer\COLORFUL\Http\Request;

class Parser
{

	/**
	 * Parse process.
	 * @param Request $request
	 * @param array $routes
	 * @return mixed
	 *
	 */

	public static function run(Request $request, $routes)
	{
		if(!is_array($routes))
			return false;

		$requestAction = $request->action();
		$actionSegments = explode('/', rtrim($requestAction, '/') . '/');
		$actionSegments[0] = '/';
		$countOfActionSegments = count($actionSegments);

		$requestMethod = $request->method();

		$found = false;
		$params = [];

		if(!isset($routes[$requestMethod]))
			return false;

		foreach($routes[$requestMethod] as $path => $callback)
		{
			if($path === $requestAction)
				return $callback;

			$pathSegments = explode('/', $path);
			$pathSegments[0] = '/';
			$countOfPathSegments = count($pathSegments);

			if($countOfActionSegments !== $countOfPathSegments)
				continue;

			for($i = 0; $i < $countOfPathSegments; $i++)
			{
				if(!empty($pathSegments[$i]) && $pathSegments[$i][0] === ':')
				{
					$name = $pathSegments[$i];
					$value = $actionSegments[$i];

					if(strpos($name, '|') !== false)
					{
						$nameSegments = explode('|', $name);
						if(count($nameSegments) !== 2)
						{
							$found = false;
							break;
						}

						if(gettype($value) !== $nameSegments[1])
						{
							$found = false;
							break;
						}

						$name = $nameSegments[0];
					}

					$name = ltrim($name, ':');
					$params[$name] = $value;
					$found = true;
				}
				else
				{
					if($pathSegments[$i] !== $actionSegments[$i])
					{
						$found = false;
						break;
					}
					else
						$found = true;
				}
			}

			if($found === true)
			{
				if(count($params) > 0)
				{
					foreach($params as $key => $value)
						$request->params[$key] = $value;
				}

				return $callback;
			}

			$params = [];
		}

		return false;
	}
}
