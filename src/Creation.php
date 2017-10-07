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
use sintloer\COLORFUL\Collections;
use sintloer\COLORFUL\Router;
use sintloer\COLORFUL\Event;

class Creation
{

	/**
	 * COLORFULframework version.
	 * @var string
	 * 
	 */
	
	const VERSION = '0.0.1';

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

		$modes = Globals::$ENVIRONMENT_MODES;
		if(!in_array($env, $modes))
		{
			return Failure\Message::show('You need to set the environment mode.', 1004, [
					'modes' => $modes
				]);
		}

		switch($env)
		{
			case $modes['d']:
				error_reporting(E_ALL);
				break;

			case $modes['p']:
				error_reporting(0);
				break;
		}

		self::$ENV = $env;
	}

	/**
	 * Method for set up COLORFULframework.
	 * @param array $data
	 * @return mixed
	 * 
	 */

	public function setup($data)
	{
		$requiredFields = Globals::$SETUP_REQUIRED_FIELDS;
		foreach($requiredFields as $field => $info)
		{
			if(!is_array($data) || !isset($data[$field]) || gettype($data[$field]) !== $info['type'])
			{
				return Failure\Message::show('You must complete the required fields in the setup() method.', 1008, [
						'fields' => $requiredFields
					]);
			}
		}

		Setup::init($data);
		return $this;
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
		if(Execution\Callbacks\Before::has())
			return false;

		if(!is_callable($callback))
			return Failure\Message::show('Your before() method call returns an failure. Check your syntax.', 1012);

		Execution\Callbacks\Before::set($callback);
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
		if(Execution\Callbacks\After::has())
			return false;

		if(!is_callable($callback))
			return Failure\Message::show('Your after() method call returns an failure. Check your syntax.', 1016);

		Execution\Callbacks\After::set($callback);
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
			if(gettype($name) !== 'string' || !is_callable($callback))
				return Failure\Message::show('Your when() method call returns an failure. Check your syntax.', 1020);

			Collections\Listeners::add(
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

		$httpMethods = Globals::$HTTP_METHODS;
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
					if(gettype($path) !== 'string' || !is_callable($callback))
					{
						if($bySimpleMethod)
							return Failure\Message::show('Your '. strtolower($method) .'() method call returns an failure. Check your syntax.', 1028, [
									'method' => $method
								]);
						else
							return Failure\Message::show('Your routes() method call returns an failure. Check your syntax.', 1024, [
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

					Collections\Routes::add(
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
		if(in_array($name, Globals::$HTTP_METHODS))
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
}