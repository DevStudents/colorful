<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL;

/**
 * Creation COLORFULframework class.
 * 
 */

class Creation
{

	/**
	 * COLORFUL version.
	 * @var string
	 * 
	 */
	
	const VERSION = '0.2.0';

	/**
	 * Creation constructor.
	 * @param string $mode
	 * @return void
	 * 
	 */
	
	public function __construct($mode)
	{
		
	}

	/**
	 * Adding data to Config.
	 * @param array $config
	 * @return object
	 * 
	 */

	public function config($config)
	{
		
		return $this;
	}

	/**
	 * Help method to init any actions before start routing.
	 * @param function $callback
	 * @return object|boolean
	 * 
	 */

	public function before($callback)
	{
		
		return $this;
	}

	/**
	 * GET method.
	 * @param string $test
	 * @param function $callback
	 * @return object|boolean
	 * 
	 */
	
	public function get($test, $callback)
	{
		

		return $this;
	}

	/**
	 * POST method.
	 * @param string $test
	 * @param function $callback
	 * @return object|boolean
	 * 
	 */

	public function post($test, $callback)
	{
		

		return $this;
	}

	/**
	 * PUT method.
	 * @param string $test
	 * @param function $callback
	 * @return object|boolean
	 * 
	 */

	public function put($test, $callback)
	{
		

		return $this;
	}

	/**
	 * DELETE method.
	 * @param string $test
	 * @param function $callback
	 * @return object|boolean
	 * 
	 */

	public function delete($test, $callback)
	{
		

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
		

		return $this;
	}

	/**
	 * Finish method.
	 * @param function $callback
	 * @return null|boolean
	 * 
	 */

	public function after($callback)
	{
		
		return $this;
	}

	/**
	 * Creation destructor.
	 * @return void
	 * 
	 */
	
	public function __destruct()
	{
		
	}
}