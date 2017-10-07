<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Router;
use Closure;

class Route
{

	/**
	 * Route method.
	 * @var string
	 * 
	 */
	
	private $_method;

	/**
	 * Route path.
	 * @var string
	 * 
	 */
	
	private $_path;

	/**
	 * Route callback.
	 * @var Closure
	 * 
	 */
	
	private $_callback;

	/**
	 * Constructor.
	 * @param string $method
	 * @param string $path
	 * @param Closure $callback
	 * 
	 */
	
	public function __construct($method, $path, Closure $callback)
	{
		$this->_method = $method;
		$this->_path = $path;
		$this->_callback = $callback;
	}

	/**
	 * Get method.
	 * @return string
	 * 
	 */

	public function getMethod()
	{
		return $this->_method;
	}

	/**
	 * Get path.
	 * @return string
	 * 
	 */

	public function getPath()
	{
		return $this->_path;
	}

	/**
	 * Get callback.
	 * @return Closure
	 * 
	 */

	public function getCallback()
	{
		return $this->_callback;
	}
}