<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL;

use sintloer\COLORFUL\Failure;
use sintloer\COLORFUL\Execution;
use sintloer\COLORFUL\Store;
use sintloer\COLORFUL\Router;
use sintloer\COLORFUL\Event;

class Creation
{

	/**
	 * COLORFULframework version.
	 * @var string
	 *
	 */

	const VERSION = '0.1.0';

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
		if(!in_array($env, $modes))
		{
			return Failure\Message::show('You need to set the environment mode.', 1001, [
					'modes' => $modes
				]);
		}

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

	/**
	 * This is initialize handler for callback.
	 * It's executed after application start.
	 * @param Closure $callback
	 * @return mixed
	 *
	 */

	public function before($callback)
	{
		if(Store\Callbacks\Before::has())
			return false;

		if(is_array($callback))
		{
			$callbackFromArray = $this->_getCallbackFromArray($callback);
			if($callbackFromArray !== false)
				$callback = $callbackFromArray;
		}

		if(!is_callable($callback))
			return Failure\Message::show('Your before() method call returns an failure. Check your syntax.', 1002);

		Store\Callbacks\Before::set($callback);
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
		if(Store\Callbacks\After::has())
			return false;

		if(is_array($callback))
		{
			$callbackFromArray = $this->_getCallbackFromArray($callback);
			if($callbackFromArray !== false)
				$callback = $callbackFromArray;
		}

		if(!is_callable($callback))
			return Failure\Message::show('Your after() method call returns an failure. Check your syntax.', 1003);

		Store\Callbacks\After::set($callback);
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
				$callbackFromArray = $this->_getCallbackFromArray($callback);
				if($callbackFromArray !== false)
					$callback = $callbackFromArray;
			}

			if(gettype($name) !== 'string' || !is_callable($callback))
				return Failure\Message::show('Your when() method call returns an failure. Check your syntax.', 1004);

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
						$callbackFromArray = $this->_getCallbackFromArray($callback);
						if($callbackFromArray !== false)
							$callback = $callbackFromArray;
					}

					if(gettype($path) !== 'string' || !is_callable($callback))
					{
						if($bySimpleMethod)
							return Failure\Message::show('Your '. strtolower($method) .'() method call returns an failure. Check your syntax.', 1005, [
									'method' => $method
								]);
						else
							return Failure\Message::show('Your routes() method call returns an failure. Check your syntax.', 1006, [
									'methods' => $httpMethods
								]);
					}

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

		return $this;
	}

	/**
	 * Add routes by call to name of HTTP methods function.
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 *
	 */

	public function __call($name, $arguments)
	{
		$name = strtoupper($name);
		if(in_array($name, self::$HTTP_METHODS))
		{
			if(count($arguments) == 2)
				$this->routes(
						[ $name => [ $arguments[0] => $arguments[1] ] ],
						false,
						true
					);
		}
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

		if(!Failure\Message::has())
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

	/**
	 * Get callback from array.
	 * @param array $array
	 * @return mixed
	 *
	 */

	private function _getCallbackFromArray($array)
	{
		if(count($array) == 2)
		{
			$class = $array[0];
			$classMethod = $array[1];

			if(class_exists($class))
			{
				$obj = new $class();
				if(method_exists($obj, $classMethod))
				{
					$reflection = new \ReflectionMethod($obj, $classMethod);
					$closure = $reflection->getClosure($obj);

					if(is_callable($closure))
						return $closure;
				}
			}
		}

		return false;
	}
}
