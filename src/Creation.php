<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL;

/**
 * It's a "main" class of the COLORFULframework.
 * 
 */

class Creation
{

	/**
	 * Version number.
	 * @var string
	 * 
	 */
	
	const VERSION = '0.2.0';

	/**
	 * Configured flag.
	 * @var boolean
	 * 
	 */
	
	private $_configured = false;

	/**
	 * Initialize autoload, set environment type and load basic components.
	 * @param string $env
	 * @return void
	 * 
	 */
	
	public function __construct($env)
	{
		new Core\Initialize($env);
	}

	/**
	 * Adding data to Config object by static method.
	 * @param array $configs
	 * @return object
	 * 
	 */

	public function config($configs)
	{
		Core\Config::set($configs);
		$this->_configured = true;

		return $this;
	}

	/**
	 * Help method to init any actions before start routing.
	 * @param function $callback
	 * @return object|boolean
	 * 
	 */

	public function initialize($callback)
	{
		if(!$this->_isConfigured())
			return false;

		if(is_callable($callback))
			$res = $callback();

		return $this;
	}

	/**
	 * Router GET method.
	 * @param string $test
	 * @param function $callback
	 * @return object|boolean
	 * 
	 */
	
	public function get($test, $callback)
	{
		if(!$this->_isConfigured())
			return false;

		Core\Router::get($test, $callback);
		return $this;
	}

	/**
	 * Router POST method.
	 * @param string $test
	 * @param function $callback
	 * @return object|boolean
	 * 
	 */

	public function post($test, $callback)
	{
		if(!$this->_isConfigured())
			return false;

		Core\Router::post($test, $callback);
		return $this;
	}

	/**
	 * Router PUT method.
	 * @param string $test
	 * @param function $callback
	 * @return object|boolean
	 * 
	 */

	public function put($test, $callback)
	{
		if(!$this->_isConfigured())
			return false;

		Core\Router::put($test, $callback);
		return $this;
	}

	/**
	 * Router DELETE method.
	 * @param string $test
	 * @param function $callback
	 * @return object|boolean
	 * 
	 */

	public function delete($test, $callback)
	{
		if(!$this->_isConfigured())
			return false;

		Core\Router::delete($test, $callback);
		return $this;
	}

	/**
	 * Event listener.
	 * @param string $name
	 * @param function $callback
	 * @return object|boolean
	 * 
	 */

	public function when($name, $callback)
	{
		if(!$this->_isConfigured())
			return false;

		if(Core\Event::check($name))
		{
			if(is_callable($callback))
				$callback();
		}

		return $this;
	}

	/**
	 * Finish method.
	 * @param function $callback
	 * @return null|boolean
	 * 
	 */

	public function finish($callback)
	{
		if(!$this->_isConfigured())
			return false;

		if(is_callable($callback))
			$callback();
	}

	/**
	 * Check if configured.
	 * @return boolean
	 * 
	 */

	public function _isConfigured()
	{
		if($this->_configured === true)
			return true;
		else
			Core\Error::show('First you need to call the config() method. Later you can call the rest.', 1000);
	}
}