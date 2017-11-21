<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL;

use sintloer\COLORFUL\Execution;
use sintloer\COLORFUL\Store;
use sintloer\COLORFUL\Router;
use sintloer\COLORFUL\Event;
use sintloer\COLORFUL\Utils;

class Creation
{

	/**
	 * COLORFULframework version.
	 * @var string
	 *
	 */

	const VERSION = '0.3.3';

	/**
	 * Environment modes.
	 * @var array
	 *
	 */

	public static $ENVIRONMENT_MODES = [

		'd' => 'DEVELOPMENT',
		'p' => 'PRODUCTION'

	];

	/**
	 * Available HTTP methods.
	 * @var array
	 *
	 */

	public static $HTTP_METHODS = [

		'GET', 'POST', 'PUT', 'PATCH', 'DELETE'

	];

	/**
	 * Current environment mode.
	 * @var string
	 *
	 */

	public static $ENV;

	/**
	 * Creation constructor.
	 * It sets environment mode for framework.
	 * @param string $env (optional)
	 *
	 */

	public function __construct($env = null)
	{
		if(!empty(self::$ENV))
			return false;

		$modes = self::$ENVIRONMENT_MODES;
		if(in_array($env, $modes))
		{
			switch($env)
			{
				case $modes['d']:
					ini_set('display_errors', 'on');
					error_reporting(E_ALL);
					break;

				case $modes['p']:
					ini_set('display_errors', 'off');
					error_reporting(0);
					break;
			}

			self::$ENV = $env;
		}
	}

	/**
	 * This is initialize handler for callback.
	 * It's executed after application start.
	 * @param Closure $callback
	 * @return mixed
	 *
	 */

	public function before($callback)
	{
		if(Store\Before::has() && !defined('PHPUNIT'))
			return false;

		if(is_array($callback))
		{
			$callbackFromArray = Utils\Helper::getCallbackFromArray($callback);
			if($callbackFromArray !== false)
				$callback = $callbackFromArray;
		}

		if(is_callable($callback))
			Store\Before::set($callback);

		return $this;
	}

	/**
	 * This is finish handler for callback.
	 * It's executed before application stop.
	 * @param Closure $callback
	 * @return mixed
	 *
	 */

	public function after($callback)
	{
		if(Store\After::has() && !defined('PHPUNIT'))
			return false;

		if(is_array($callback))
		{
			$callbackFromArray = Utils\Helper::getCallbackFromArray($callback);
			if($callbackFromArray !== false)
				$callback = $callbackFromArray;
		}

		if(is_callable($callback))
			Store\After::set($callback);

		return $this;
	}


	/**
	 * Add event listener/listeners.
	 * @param string $name
	 * @param mixed $callback (optional)
	 * @return mixed
	 *
	 */

	public function when($name, $callback = null)
	{
		$result = [];
		if(is_array($name))
		{
			foreach($name as $key => $value)
				$result[$key] = $value;
		}
		else
			$result[$name] = $callback;

		foreach($result as $name => $callback)
		{
			if(is_array($callback))
			{
				$callbackFromArray = Utils\Helper::getCallbackFromArray($callback);
				if($callbackFromArray !== false)
					$callback = $callbackFromArray;
			}

			if(gettype($name) === 'string' && is_callable($callback))
				Store\Listeners::add(
						new Event\Listener(
								$name, $callback
							)
					);
		}

		return $this;
	}

	/**
	 * Add routes by array.
	 * @param array $data
	 * @param mixed $group (optional)
	 * @param boolean $bySimpleMethod (optional)
	 * @return mixed
	 *
	 */

	public function routes($data, $group = false, $bySimpleMethod = false)
	{
		if(!is_array($data))
			return false;

		$httpMethods = self::$HTTP_METHODS;
		foreach($data as $methods => $routes)
		{
			$methods = explode(',', strtoupper($methods));
			if(count($methods) === 0)
				break;

			foreach($methods as $method)
			{
				$method  = trim($method);
				if(!in_array($method, $httpMethods))
					continue;

				foreach($routes as $path => $callback)
				{
					if(is_array($callback))
					{
						$callbackFromArray = Utils\Helper::getCallbackFromArray($callback);
						if($callbackFromArray !== false)
							$callback = $callbackFromArray;
					}

					if(gettype($path) === 'string' && is_callable($callback))
					{
						if($path[0] !== '/')
							$path = '/' . $path;

						if($group !== false && gettype($group) === 'string')
						{
							if($group[0] !== '/')
								$group = '/' . $group;

							$path = $group . $path;
						}

						Store\Routes::add(
							new Router\Route(
									$method, $path, $callback
								)
							);
					}
				}
			}
		}

		return $this;
	}

	/**
	 * Add routes by call to name of HTTP methods function.
	 * @param string $name
	 * @param array $arguments
	 * @return boolean
	 *
	 */

	public function __call($name, $arguments)
	{
		$name = strtoupper($name);
		if(in_array($name, self::$HTTP_METHODS))
		{
			if(count($arguments) == 2)
			{
				$result = $this->routes(
						[ $name => [ $arguments[0] => $arguments[1] ] ],
						false,
						true
					);

				if($result === false)
					return false;
			}
		}

		return $this;
	}

	/**
	 * Run method.
	 * It's starting COLORFULframework execution.
	 * @return mixed
	 *
	 */

	public function run()
	{
		if(Execution\Runner::executed())
			return false;

		Execution\Runner::start();
		return true;
	}

	/**
	 * Creation destructor.
	 *
	 */

	public function __destruct()
	{
		$this->run();
	}
}
